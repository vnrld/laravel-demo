<?php
declare(strict_types=1);

namespace App\Contracts;


use Illuminate\Database\Eloquent\Collection;

interface UserHistoryRepositoryContract extends CrudRepositoryContract
{
    public function getHistoryForUser(string $userId): Collection;
}
