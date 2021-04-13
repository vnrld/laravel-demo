<?php

namespace App\Http\Middleware;

use App\Exceptions\User\NotAuthenticatedException;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class ApiAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param Request $request
     * @param  array  $guards
     * @return void
     *
     * @throws AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = ['demo'];
        }

        foreach ($guards as $guard) {

            $this->auth->guard($guard)->attempt([$request->input('client_id'), $request->input('client_secret')]);

            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated($request, $guards);
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param Request $request
     * @param  array  $guards
     * @return void
     *
     * @throws NotAuthenticatedException
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new NotAuthenticatedException('Wrong client_id or client_secret', NotAuthenticatedException::API);
    }

}
