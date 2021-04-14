<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Exceptions\Validation\WebValidationException;
use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory as ValidatorContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BaseFormRequest extends FormRequest
{
    protected ValidatorContract $validationFactory;

    protected string $exceptionClass = WebValidationException::class;

    public function prepareForValidation()
    {
        if ($this->getValidatorInstance()->fails()) {
            $this->throwValidationException();
        }
    }

    public function getValidatorInstance(): Validator
    {
        $this->validationFactory = Container::getInstance()->make(ValidatorContract::class);
        return $this->validationFactory->make($this->all(), $this->rules(), $this->messages());
    }

    public function rules(): array
    {
        return [];
    }

    protected function throwValidationException(): void
    {
        throw new $this->exceptionClass($this->getValidatorInstance());
    }

    public function validated()
    {
        $this->prepareForValidation();
        return true;
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
