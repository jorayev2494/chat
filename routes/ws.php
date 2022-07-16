<?php

use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;

// namespace BeyondCode\LaravelWebSockets\Server\Router;
WebSocketsRouter::echo();
WebSocketsRouter::webSocket('/my-websocket', \App\Http\Controllers\WS\MyCustomWebSocketHandler::class);

// dd(
//     resolve('websockets.router')
// );