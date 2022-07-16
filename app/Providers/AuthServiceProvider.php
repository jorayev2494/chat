<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
        // Passport::routes(
        //     null, [
        //         'prefix' => 'api/oauth'
        //     ]
        // );

        // Auth::viaRequest('broadcast-auth',function ($request) {
        //     dd(
        //         __METHOD__,
        //         $request->toArray()
        //     );
        //     // $client = User::where('auth_token',$request->header('auth-token'))->first();
        //     return true;
        // });
        
        // Personal access client created successfully.
        // Client ID: 3
        // Client secret: hOi7xDQ3Nb0DvkdOC2KgfGe6YtE01O4jKdpdGynS

        // Password grant client created successfully.
        // Client ID: 4
        // Client secret: iyIT8SLR70ZQmAk6SZRQEe1NqUG2fhSVxa6qZ4zv
    }
}
