<?php

namespace App\Providers;

use App\Repositories\Contracts\Auth\Email\AuthorizationEmailRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Output\NullOutput;
use BeyondCode\LaravelWebSockets\Server\Logger\WebsocketsLogger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(WebsocketsLogger::class, static function () {
            return (new WebsocketsLogger(new NullOutput()))->enable(false);
        });

        $this->app->bind(AuthorizationEmailRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
