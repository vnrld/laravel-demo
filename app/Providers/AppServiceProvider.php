<?php
declare(strict_types=1);

namespace App\Providers;

use App\Contracts\CacheCrudRepositoryContract;
use App\Contracts\UserHistoryRepositoryContract;
use App\Contracts\UserRepositoryContract;
use App\Repositories\CacheRepository;
use App\Repositories\UserHistoryRepository;
use App\Repositories\UserRepository;
use App\Services\CognitoService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\LogManager;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use Px\Framework\AWS\Cognito\Cognito;
use Px\Framework\Cache\Cache;
use Px\Framework\Http\Responder\Messaging\Messages;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        $this->app->bind(CacheCrudRepositoryContract::class, static function (Application $app) {
            return new CacheRepository($app->make('cache'));
        });

        $this->app->bind(UserRepositoryContract::class, static function(Application $app) {
            return new UserRepository($app->make(CacheCrudRepositoryContract::class));
        });

        $this->app->bind(UserHistoryRepositoryContract::class, static function() {
            return new UserHistoryRepository();
        });

        $this->app->singleton(Messages::class, static function() {
            return new Messages();
        });

        $this->app->singleton(CognitoService::class, static function(Application $app) {
            return new CognitoService(config('auth.cognito'), $app->make(LogManager::class));
        });

    }
}
