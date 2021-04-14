<?php

namespace App\Http\Requests\Validation\Rules\File;

use Illuminate\Contracts\Validation\Rule;

class FileRequestDiskRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return array_key_exists($value, config('filesystems.disks'));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute has to be one of ' . implode(', ', array_keys(config('filesystems.disks'))) . '.';
    }
}
