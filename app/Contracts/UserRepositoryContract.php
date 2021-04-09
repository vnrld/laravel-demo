<?php
declare(strict_types=1);

namespace App\Contracts;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


interface UserRepositoryContract extends CrudRepositoryContract
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    public function findByEmail(string $email): ?Model;
}
