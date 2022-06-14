<?php

namespace App\Services;

use App\Events\CreateMessageEvent;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Media;
use App\Models\Message;
use App\Models\User;
use App\Repositories\ChatRepository;
use App\Traits\FileTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Log;

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
        return $this->repository->getUserChats($user->id);
    }

    /**
     * @param array $data
     * @return Chat
     */
    public function store(User $user, array $data): Message
    {
        if (array_key_exists('user_id', $data)) {
            $toUser = User::find($data['user_id']);

            $toUserChats = $toUser->chats()->where('status_id', 1)->pluck('chat_id')->toArray();
            
            ['id' => $data['chat_id']] = $user->chats()->wherePivotIn('chat_id', $toUserChats)
                                ->where('status_id', 1)
                                ->firstOr(
                                    ['*'],
                                    static function () use($user, $data): Chat {
                                        $cChatData['status_id'] = array_key_exists('status_id', $data) ? $data['status_id'] : 1;
                                        /** @var Chat $cChat */
                                        $cChat = $user->myChats()->create($cChatData);
                                        $chatMembers = [
                                            $data['user_id'],
                                            $user->id
                                        ];
                                        $cChat->members()->attach($chatMembers);
                                        unset($data['user_id']);

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

        CreateMessageEvent::broadcast($user, MessageResource::make($result));

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
                        'user:id,first_name,last_name,email',
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