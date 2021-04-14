<?php
declare(strict_types=1);

namespace App\Http\Requests\File;

use App\Exceptions\Validation\ApiValidationException;
use App\Http\Requests\BaseFormRequest;
use App\Http\Requests\Validation\Rules\File\FileRequestDiskRule;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class FileRequest extends BaseFormRequest
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
            'disk' => ['required', new FileRequestDiskRule()],
            'file_name' => 'required|string',
            'save_path' => 'nullable|string',
            'contents' => 'nullable|string'
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
            'file_name.required' => 'The file name should be a correct path to the file'
        ];
    }

    /**
     * @return Filesystem
     */
    public function getDisk(): Filesystem
    {
        return Storage::disk($this->input('disk'));
    }

    public function getFilename() : string
    {
        return $this->input('file_name', '');
    }

    public function getContents(): string
    {
        return (string)$this->input('contents', '');
    }

    public function getDriver(): string
    {
        return config(sprintf('filesystems.disks.%s.driver', $this->input('disk', '')));
    }

    public function getSavePath(): string
    {
        return $this->input('save_path', '');
    }

    public function isInS3(): bool
    {
        return $this->getDriver() === 's3';
    }

}
