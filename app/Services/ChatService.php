<?php

namespace App\Services;

use App\Events\CreateMessageEvent;
use App\Exceptions\Api\Chat\ChatAlreadyCreatedException;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Media;
use App\Models\Message;
use App\Models\User;
use App\Repositories\ChatRepository;
use App\Traits\FileTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

class ChatService
{

    use FileTrait;

    public function __construct(
        private ChatRepository $repository
    )
    {
        
    }

    /**
     * @param integer|null $id
     * @return SupportCollection
     */
    public function getChats(?int $id): SupportCollection
    {
        /** @var Chat $fChat */
        $fChat = $this->repository->find($id);

        return $fChat->messages()
                    ->with([
                        'user'
                    ])
                    ->get();
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getUserChats(User $user): Collection
    {
        /** @var Collection $chats */
        $chats = $this->repository->getUserChats($user->id);

        return $chats->each(static function (Chat $chat): void {
            // $chat->setAttribute('last_message', $chat->messages->first());
            // $chat->setAttribute('last_message', $chat->messages->toArray());
            // $chat->unsetRelation('messages');
        });
    }

    /**
     * @param User $user
     * @param array $data
     * @return Message
     */
    public function create(User $user, array $data): Message
    {
        if (array_key_exists('user_id', $data)) {
            /** @var User $toUser */
            $toUser = User::find($data['user_id']);
            $toUserChats = $toUser->chats()->where('status_id', 1)->pluck('chat_id')->toArray();

            /** @var Chat $foundChat */
            $foundChat = $user->chats()->wherePivotIn('chat_id', $toUserChats)
                                       ->where('status_id', 1)
                                       ->first();

            if (! is_null($foundChat)) {
                throw new ChatAlreadyCreatedException();
            }

            DB::beginTransaction();

            $createMessage = null;
            try {
                $chatData['status_id'] = array_key_exists('status_id', $data) ? $data['status_id'] : 1;
                /** @var Chat $createdChat */
                $createdChat = $user->myChats()->create($chatData);
                $createdChat->members()->attach([$user->id, $toUser->id]);

                unset($data['user_id']);

                /** @var Message $createMessage */
                $createMessage = $user->messages()->create(array_merge($data, ['chat_id' => $createdChat->id]));
                $this->uploadMedias($createMessage, $data);
            } catch (\Throwable $th) {
                DB::rollBack();
                dd(
                    __METHOD__,
                    $th
                );
            }

            DB::commit();            

            $createMessage->loadMissing([
                'user:id,first_name,last_name,email',
                'medias',
                'see'
            ]);

            // CreateMessageEvent::broadcast($user, MessageResource::make($result))->toOthers();

            return $createMessage;
        }
    }

    /**
     * @param array $data
     * @return Chat
     */
    public function store(User $user, array $data): Message
    {
        if (array_key_exists('user_id', $data)) {
            /** @var User $toUser */
            $toUser = User::find($data['user_id']);
            $toUserChats = $toUser->chats()->where('status_id', 1)->pluck('chat_id')->toArray();
            
            ['id' => $data['chat_id']] = $user->chats()
                                            ->wherePivotIn('chat_id', $toUserChats)
                                            ->where('status_id', 1)
                                            ->firstOr(
                                                ['*'],
                                                static function () use($user, $toUser, $data): Chat {
                                                    $cChatData['status_id'] = array_key_exists('status_id', $data) ? $data['status_id'] : 1;
                                                    /** @var Chat $cChat */
                                                    $cChat = $user->myChats()->create($cChatData);
                                                    $chatMembers = [
                                                        $data['user_id'],
                                                        $user->id
                                                    ];
                                                    $cChat->members()->attach($chatMembers);
                                                    unset($data['user_id']);

                                                    $toUser->chats()->attach($cChat->id);

                                                    return $cChat;
                                                }
                                            )
                                            ->toArray();
        }

        /** @var Message $result */
        $result = $user->messages()->create($data);
        $this->uploadMedias($result, $data);

        $result->loadMissing([
            'user:id,first_name,last_name,email',
            'medias',
            'see'
        ]);

        // CreateMessageEvent::broadcast($user, MessageResource::make($result))->toOthers();

        return $result;
    }

    /**
     * @param User $user
     * @param integer $id
     * @return Collection
     */
    public function show(User $user, int $id): Collection
    {
        /** @var Chat $fChat */
        $fChat = $this->repository->find($id);

        return $fChat->messages()
                    ->with([
                        'user:id,first_name,last_name,avatar,email',
                        'medias',
                        'see'
                    ])
                    ->orderBy('id')
                    ->get();
    }

    /**
     * @param User $user
     * @param integer $id
     * @param array $data
     * @return Message
     */
    public function update(User $user, int $id, array $data): Message
    {
        $fMessage = Message::query()->findOrFail($id);

        if (array_key_exists('deleted_medias', $data)) {
            $fDeletedMedias = Media::query()->whereIn('id', $data['deleted_medias'])->get();
            $this->deleteMedias($fDeletedMedias);
        }

        $fMessage->update($data);
        $this->uploadMedias($fMessage, $data);

        return $fMessage->loadMissing([
            'user:id,first_name,last_name,email',
            'medias',
            'see'
        ]);
    }

    /**
     * @param User $user
     * @param integer $id
     * @return void
     */
    public function delete(User $user, int $id): void
    {
        /** @var Message $fMessage */
        $fMessage = Message::query()->with('medias')->findOrFail($id);

        if ($fMessage->medias) {
            $this->deleteMedias($fMessage->getRelationValue('medias'));
        }

        $fMessage->delete();
    }


    /**
     * @return SupportCollection
     */
    public function chats(): SupportCollection
    {
        return $this->repository->getChats();
    }

    /**
     * @param array $data
     * @return void
     */
    private function uploadMedias(Message $message, iterable $data): void
    {
        if(array_key_exists('medias', $data)) {
            foreach ($data['medias'] as $key => $media) {
                $uploadedMedias[$key] = $this->uploadFile("/chats/{$message->chat_id}/medias", $media);
            }

            if (count($uploadedMedias)) {
                $message->medias()->createMany($uploadedMedias);
            }
        }
    }

    /**
     * @param SupportCollection $medias
     * @return void
     */
    private function deleteMedias(SupportCollection $medias): void
    {
        $medias->each(function (Media $media): void {
            $this->deleteFile($media->path, $media->name);
            $media->delete();
        });
    }
}