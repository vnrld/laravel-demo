<?php
declare(strict_types=1);

namespace App\Exceptions\Validation;

use Px\Framework\Http\Responder\Response;

class ApiValidationException extends AppValidationException
{
    public function isJson(): bool
    {
        return true;
    }

    public function prepareCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
