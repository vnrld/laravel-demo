<?php
declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface CrudRepositoryContract
{
    public function create(Model $model): Model;

    public function read(string $id): ?Model;

    public function update(Model $model): Model;

    public function delete(string $id): bool;
}
