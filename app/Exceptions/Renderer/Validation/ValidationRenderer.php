<?php

declare(strict_types=1);

namespace App\Exceptions\Renderer\Validation;

use App\Contracts\ExceptionRendererContract;
use App\Exceptions\Validation\AppValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Px\Framework\Http\Responder\Response;

class ValidationRenderer implements ExceptionRendererContract
{
    private Request $request;

    private AppValidationException $validationException;

    public function __construct(AppValidationException $validationException)
    {
        $this->validationException = $validationException;
    }

    /**
     * @return JsonResponse|Response
     * @throws \JsonException
     */
    public function render()
    {
        return $this->validationException->isJson() ? $this->renderJsonResponse() : $this->renderHtmlResponse();
    }

    protected function renderHtmlResponse(): Response
    {
        return new Response($this->validationException->getMessage());
    }

    protected function renderJsonResponse(): JsonResponse
    {
        $errors = ['errors' => json_decode($this->validationException->getMessage(), true, 512, JSON_THROW_ON_ERROR)];

        $response = new Response();
        $response->setSuccess(false);
        $response->setMessage($this->validationException->getCode(), [], 'API Validation Errors');
        $response->setContent($errors);
        return $response->json();
    }

}
