<?php

namespace App\Http\Controllers\WS;

use App\Models\User;
use App\Services\ChatService;
use App\WS\ChannelManager;
use BeyondCode\LaravelWebSockets\Apps\App;
use BeyondCode\LaravelWebSockets\Dashboard\DashboardLogger;
// use BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManager;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use BeyondCode\LaravelWebSockets\WebSockets\WebSocketHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SplObjectStorage;
use stdClass;

class MyCustomWebSocketHandler extends WebSocketHandler implements MessageComponentInterface
{

    private SplObjectStorage $clients;

    public function __construct(ChannelManager $channelManager)
    {

        // Log::info(
        //     'WS Constructor: ',
        //     [
        //         'Constructor result: ' => (array) $request->headers
        //     ]
        // );

        parent::__construct($channelManager);

        $this->clients = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $connection)
    {


        // $this->clients->attach($connection);
        
        
        // parent::onOpen($connection);

        // TODO: Implement onOpen() method.
        $request = resolve(Request::class);
        Log::info(
            'WS onOpen: ',
            [
                'Constructor result: ' => (array) $request->headers,
                'connection' => $connection,
                'channelManager' => $this->channelManager->getUserFromRequest($connection),
                'PHP_SERVER' => $_SERVER
            ]
        );

        /**
         * Find the app by using the header
         * and then reconstruct the PusherBroadcaster
         * using our own app selection.
         */
        // $app = App::findById('laravel_rdb');

        // $socketId = sprintf('%d.%d', random_int(1, 1000000000), random_int(1, 1000000000));
        // $connection->socketId = $socketId;
        // $connection->app = App::findById('laravel_rdb');

        Log::info('onOpen', ['open' => $connection]);
    }
    
    public function onClose(ConnectionInterface $connection)
    {
        // parent::onClose($connection);

        // TODO: Implement onClose() method.
        /** @var Request $request */

        // Log::info('onClose', ['close' => $connection->close(), 'send' => $connection->send(['error' => 'errorData'])]);
        Log::info('onClose');
    }

    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        // parent::onError($connection, $e);

        // TODO: Implement onError() method.
        // dd(
        //     __METHOD__,
        //     $connection,
        //     $e
        // );
        

        Log::info('onError', [
                                'close' => $connection,
                                'getMessage' => $e->getMessage(),
                                // 'channelManager' => $this->channelManager
                            ]);

        Log::info('onError2');

    }

    public function onMessage(ConnectionInterface $connection, MessageInterface $msg)
    {
        $msgObject = (object) json_decode($msg->getPayload(), true);
        // parent::onMessage($connection, $msg);

        // TODO: Implement onMessage() method.

        /** @var Request $request */
        $request = resolve(Request::class);
        $bearerToken = $msgObject->token;
        Log::info(
            'WS onMessage: ',
            [
                'Constructor result: ' => (array) $request->headers,
                'channelManager' => $this->channelManager->getUserFromRequest($connection),
                'OnMessage PHP_SERVER' => $_SERVER,
                // 'req: ', $request->auth,
                // "headers" => $request->headers->set('authorization', $bearerToken),
                "getUser" => $request->getUser(),
                "user" => $request->user(),
                "Auth User" => auth()->user(),
            ]
        );

        /** @var ChatService $chatService */
        // $chatService = resolve(ChatService::class);
        // $user = User::find(1);
        // $chatService->store($user, json_decode($msg->getPayload(), true)['data']);

        // Log::info('onMessage', ['getContents' => $msg->getContents(), 'getPayload' => $msg->getPayload()]);
        Log::info('onMessage', [
            // 'request' => request()->user('api')->toArray(),
            'authCheck' => auth()->check(),
            'connection' => $connection,
            'msg' => $msg->getContents(),
            'getPayload' => $msg->getPayload(),
            'count' => $msg->count(),
            'c jsonContent' => gettype(json_decode($msg->getContents())),
            'c jsonContent2' => gettype(json_decode($msg->getContents(), true)),
            'c jsonContent3' => gettype(json_encode($msg->getContents())),
            'c jsonContent4' => gettype(json_decode($msg->getContents(), 1)),
            'c jsonContent5' => gettype($msg->getContents()),
            'c jsonContent6' => gettype((array) $msg->getContents()),
            'request headers' => (array) $request->headers,
            'msgObject' => $msgObject
            // 'c jsonContent7' => json_decode($msg->getContents(), true)['data'],
        ]);
    }
}