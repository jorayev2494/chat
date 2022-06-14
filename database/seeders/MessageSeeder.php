<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\ChatStatus;
use App\Models\Message;
use App\Models\MessageSee;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        /** @var Collection $chatStatuses */
        $chatStatuses = ChatStatus::all();
        /** @var Collection $users */
        $users = User::all();

        /** @var User $user */
        foreach ($users as $key => $user) {
            /** @var Collection $chatUsers */
            $chatUser = $users->random(1)->first();

            if ($user->id == $chatUser->id) {
                continue;
            }

            /** @var ChatStatus $chatStatus */
            $chatStatus = $chatStatuses->random(1)->first();
          
            // Create a Chat
            /** @var Chat $chat */
            $chat = $chatStatus->chats()->create(['user_id' => $user->id]);
            
            // Add members in the Chat
            $chat->members()->attach([$user->id, $chatUser->id]);
            
            // Create Messages
            $chat->messages()->saveMany(
                $user->chats()->saveMany(
                    Message::factory(random_int(2, 10))->create()->each(
                        static function (Message $mess) use($user, $chat): void {
                            $mess->see()->save(
                                $chat->messagesSees()->make(
                                    $user->messagesSees()->make(
                                        MessageSee::factory()->make()->toArray()
                                    )->toArray()
                                )
                            );
                        }
                    )
                )
            );
        }
    }
}
