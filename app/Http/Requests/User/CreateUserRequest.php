<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Exceptions\Validation\ApiValidationException;
use App\Http\Requests\BaseFormRequest;

/**
 * Class CreateUserRequest
 * @package App\Http\Requests\User
 *
 * @method string getName()
 * @method string getEmail()
 * @method string getPassword()
 * @method string getRememberToken()
 */
class CreateUserRequest extends BaseFormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|max:255',
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
            'name.required' => 'The name should be provided',
            'email.required' => 'Please provide a correct e-mail address',
            'password.required' => 'Please provide a password'
        ];
    }



}
