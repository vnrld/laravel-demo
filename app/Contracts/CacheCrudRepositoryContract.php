<?php
declare(strict_types=1);

namespace App\Contracts;

interface CacheCrudRepositoryContract
{
    /**
     * @param string $id
     * @param $value
     * @param int $seconds
     * @return bool
     */
    public function create(string $id, $value, int $seconds): bool;

    /**
     * @param string $id
     * @return mixed
     */
    public function read(string $id);

    /**
     * @param string $id
     * @param $value
     * @param int $seconds
     * @return bool
     */
    public function update(string $id, $value, int $seconds): bool;

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;
}
