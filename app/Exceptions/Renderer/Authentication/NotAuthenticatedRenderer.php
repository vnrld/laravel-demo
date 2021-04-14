<?php
declare(strict_types=1);

namespace App\Exceptions\Renderer\Authentication;

use App\Contracts\ExceptionRendererContract;
use App\Exceptions\User\NotAuthenticatedException;
use Illuminate\Http\JsonResponse;
use Px\Framework\Http\Responder\Response;
use Illuminate\Http\Response as BaseResponse;

class NotAuthenticatedRenderer implements ExceptionRendererContract
{
    private NotAuthenticatedException $authenticatedException;

    /**
     * iNotAuthenticatedRenderer constructor.
     * @param NotAuthenticatedException $authenticatedException
     */
    public function __construct(NotAuthenticatedException $authenticatedException)
    {
        $this->authenticatedException = $authenticatedException;
    }

    /**
     * @return JsonResponse|BaseResponse
     */
    public function render() {

        $message = $this->authenticatedException->getMessage();

        switch ($this->authenticatedException->getCode()) {
            case NotAuthenticatedException::API:
                $response = new Response();
                $response->setSuccess(false);
                $response->setCode(Response::HTTP_FORBIDDEN);
                $response->setMessage(0, [], $message);
                return $response->json();
                break;
            case NotAuthenticatedException::WEB:
                return new BaseResponse($message, Response::HTTP_FORBIDDEN);
                break;
        }
    }
}
