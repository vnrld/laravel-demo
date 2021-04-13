<?php

namespace App\Providers;

use App\Auth\Guards\DemoGuard;
use App\Auth\Providers\DemoUserProvider;
use App\Services\CognitoService;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Px\Framework\Auth\Users\Laravel\Cognito\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * @var CognitoService $cognitoService
         */
        $cognitoService = $this->app->make(CognitoService::class);
        $demoUserProvider = new DemoUserProvider($cognitoService->getConnector(), User::class);

        Auth::provider('demo', function ($app) use ($demoUserProvider) {
            return $demoUserProvider;
        });
        
        $this->app['auth']->extend(
            'demo',
            static function (Application $app) use ($demoUserProvider){
                return new DemoGuard($demoUserProvider);

            }
        );
    }
}
