<?php

namespace App\WS;

use BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManagers\ArrayChannelManager;
use Illuminate\Http\Request;
use Ratchet\ConnectionInterface;

class ChannelManager extends ArrayChannelManager {
    public function getUserFromRequest(ConnectionInterface $conn): Request
    {
        return resolve(Request::class);
    }
}