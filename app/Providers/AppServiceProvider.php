<?php
declare(strict_types=1);

namespace App\Providers;

use App\Contracts\UserHistoryRepositoryContract;
use App\Contracts\UserRepositoryContract;
use App\Repositories\UserHistoryRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
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

        $this->app->bind(UserRepositoryContract::class, static function() {
            return new UserRepository();
        });

        $this->app->bind(UserHistoryRepositoryContract::class, static function() {
            return new UserHistoryRepository();
        });

        $this->app->singleton(Messages::class, static function() {
            return new Messages();
        });

    }
}
