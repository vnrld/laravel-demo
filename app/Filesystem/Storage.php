<?php

declare(strict_types=1);

namespace App\Filesystem;

use Illuminate\Filesystem\Filesystem;

class Storage extends Filesystem
{
    public function __construct(string $disk = null) {

        if ($disk === null) {
            $disk = 'local';
        }

        $this->disk($disk);
    }

    public function disk(string $disk) {
        return \Illuminate\Support\Facades\Storage::disk($disk);
    }
}
