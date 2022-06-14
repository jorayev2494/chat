<?php

namespace App\Console\Commands;

use App\Events\BroadcastEvent;
use App\Models\User;
use Illuminate\Console\Command;

class PingWebSocketCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:ws';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(User $user): int
    {
        // dd(
        //     __METHOD__,
        //     $user
        // );

        $num = random_int(1, 9);

        for ($i = 0; $i < $num; $i++) {            
            BroadcastEvent::broadcast("ping:ws: {$num} => " . $i);
        }
        // $this->info('WS sent successfuly');

        return 0;
    }
}
