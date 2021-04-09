<?php
declare(strict_types=1);

namespace App\Exceptions\Validation;

use Px\Framework\Http\Responder\Response;

class WebValidationException extends AppValidationException
{
    public function prepareCode(): int
    {
        return Response::HTTP_OK;
    }
}
