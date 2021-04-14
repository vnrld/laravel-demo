<?php
declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface CrudRepositoryContract
 * @package App\Contracts
 */
interface CrudRepositoryContract
{
    /**
     * @param Model $model
     * @return Model
     */
    public function create(Model $model): Model;

    /**
     * @param string $id
     * @return Model|null
     */
    public function read(string $id): ?Model;

    /**
     * @param Model $model
     * @return Model
     */
    public function update(Model $model): Model;

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;
}
