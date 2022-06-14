<?php

namespace App\Console\Commands;

use App\Events\BroadcastEvent;
use App\Jobs\PingJob;
use App\Jobs\UserCreatedJob;
use App\Models\User;
use Illuminate\Console\Command;

class PingJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:job';

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
    public function handle(): int
    {

        PingJob::dispatch();
        UserCreatedJob::dispatch(User::query()->inRandomOrder()->first());
        $this->info('Job ran successfuly');

        return 0;
    }
}
