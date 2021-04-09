<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Exceptions\Validation\ApiValidationException;
use App\Http\Requests\BaseFormRequest;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests\User
 *
 * @method string getId();
 * @method string getName();
 * @method string getEmail();
 * @method string getPassword();
 * @method string getRememberToken();
 */
class UpdateUserRequest extends BaseFormRequest
{
    protected string $exceptionClass = ApiValidationException::class;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|uuid',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'password' => 'nullable|string',
            'remember_token' => 'nullable'
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
            'id.required' => 'The request needs an id, none given!'
        ];
    }



}
