<?php
declare(strict_types=1);

namespace App\Http\Requests\Cognito;

use App\Exceptions\Validation\ApiValidationException;
use App\Http\Requests\Route\RouteRequest;

class ListUserPoolsRequest extends RouteRequest
{
    protected array $routeParams = ['max_results'];

    protected string $exceptionClass = ApiValidationException::class;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'max_results' => 'required|int'
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
            'max_results.required' => 'The max results is required.'
        ];
    }

    /**
     * @return int
     */
    public function getMaxResults(): int
    {
        return (int)$this->getParam('max_results', 0);
    }

}
