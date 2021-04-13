<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Exceptions\Validation\ApiValidationException;
use App\Http\Requests\Route\RouteRequest;

class SaveDateToFileRequest extends RouteRequest
{
    protected array $routeParams = ['disk'];

    protected string $exceptionClass = ApiValidationException::class;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|uuid'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id.required' => 'The id has to be an UUID'
        ];
    }

    /**
     * @return string
     */
    public function getDisk(): string
    {
        return $this->getParam('disk', '');
    }

}
