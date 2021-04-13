<?php

namespace App\Exceptions;

use App\Exceptions\Renderer\Authentication\NotAuthenticatedRenderer;
use App\Exceptions\Renderer\Validation\ValidationRenderer;
use App\Exceptions\User\NotAuthenticatedException;
use App\Exceptions\Validation\AppValidationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //

        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     *
     * @return JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|RedirectResponse
     * @throws BindingResolutionException
     */
    public function render($request, Throwable $e)
    {
        switch (get_class($e)) {
            case $e instanceof AppValidationException:
                $renderer = new ValidationRenderer($request, $e);
                return $renderer->render();
            case NotAuthenticatedException::class:
                $renderer = new NotAuthenticatedRenderer($e);
                return $renderer->render();
                break;
            default:
                return parent::render($request, $e);
        }
    }
}
