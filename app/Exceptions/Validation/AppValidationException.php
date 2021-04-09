<?php
declare(strict_types=1);

namespace App\Exceptions\Validation;

use Illuminate\Contracts\Validation\Validator;
use Throwable;

abstract class AppValidationException extends \Exception
{
    protected Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
        parent::__construct($this->prepareMessage(), $this->prepareCode(), $this->preparePrevious());
    }

    public function isJson(): bool {
        return false;
    }

    protected function prepareMessage(): string
    {
        return $this->validator->errors()->toJson();
    }

    protected function prepareCode(): int
    {
        return 0;
    }

    protected function preparePrevious(): ?Throwable
    {
        return null;
    }
}
