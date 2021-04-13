<?php
declare(strict_types=1);

namespace App\Contracts;

interface ExceptionRendererContract
{
    /**
     * @return mixed
     */
    public function render();
}
