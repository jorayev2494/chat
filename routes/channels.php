<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('broadcast-event', static fn (User $user, int $id): bool => true);

Broadcast::channel('chat.{chat_id}', static function (User $user, $chatId): bool {
    return true;
});

Broadcast::channel('chat.messages_see.{chat_id}', static function (User $user, int $chatId): bool {
    return true;
});

Broadcast::channel('chat_user.{user_id}', static function (User $user, int $userId): bool {
    return true;
});
