<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Exceptions\Validation\WebValidationException;
use Illuminate\Contracts\Validation\Factory as ValidatorContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BaseFormRequest extends FormRequest
{
    protected ValidatorContract $validationFactory;

    protected string $exceptionClass = WebValidationException::class;

    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null,
        ValidatorContract $validationFactory
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->validationFactory = $validationFactory;
    }

    public function prepareForValidation()
    {
        $this->validator = $this->validationFactory->make($this->all(), $this->rules(), $this->messages());

        if ($this->validator->fails()) {
            $this->throwValidationException();
        }
    }

    public function rules(): array
    {
        return [];
    }

    protected function throwValidationException(): void
    {
        throw new $this->exceptionClass($this->validator);
    }

    public function __call($method, $parameters) {

        if (strpos($method, 'get') !== false) {

            $key = Str::snake(preg_replace('/^get/', '', $method));
            $fields = array_keys($this->rules());

            if (in_array($key, $fields, true)) {
                return $this->input($key, '');
            }
        }


        return parent::__call($method, $parameters);
    }

}
