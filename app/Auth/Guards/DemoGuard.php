<?php
declare(strict_types=1);

namespace App\Auth\Guards;

use Illuminate\Contracts\Auth\Authenticatable;;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

class DemoGuard implements Guard
{
    private bool $isAuthenticated = false;

    private ?Authenticatable $user;

    private UserProvider $provider;

    public function __construct(UserProvider $userProvider)
    {
        $this->provider = $userProvider;
    }

    public function attempt(array $credentials = [], $remember = false)
    {
        $this->isAuthenticated = $this->validate($credentials);
        return $this->isAuthenticated;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return $this->isAuthenticated;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->user->isLoggedIn();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id()
    {
        return $this->user->getAuthIdentifier();
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $this->user = $this->provider->retrieveByCredentials($credentials);
        return $this->user instanceof Authenticatable;
    }

    /**
     * Set the current user.
     *
     * @param Authenticatable $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }
}
