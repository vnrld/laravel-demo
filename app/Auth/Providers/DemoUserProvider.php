<?php

declare(strict_types=1);

namespace App\Auth\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Px\Framework\Auth\Users\Laravel\Cognito\User;

class DemoUserProvider extends \Px\Framework\Auth\Providers\Laravel\Cognito\UserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     *
     * @return Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (($credentials[0] ?? '') === 'demo' && ($credentials[1] ?? '') === 'demo') {
            return new User(['sub' => 'demo-id-uuid-33333', 'email' => 'demo@laraveldemo.tld', 'username' => 'demo_user_123', 'name' => 'Demo User 1']);
        }

        return null;
    }

}
