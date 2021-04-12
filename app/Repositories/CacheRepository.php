<?php


namespace App\Repositories;

use App\Contracts\CacheCrudRepositoryContract;
use Illuminate\Cache\CacheManager;

class CacheRepository implements CacheCrudRepositoryContract
{
    private CacheManager $store;

    public function __construct(CacheManager $store)
    {
        $this->store = $store;
    }


    /**
     * @param string $id
     * @param $value
     * @param int $seconds
     * @return bool
     */
    public function create(string $id, $value, int $seconds): bool
    {
        return $this->store->add($id, $value, $seconds);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function read(string $id)
    {
        return $this->store->get($id);
    }

    /**
     * @param string $id
     * @param $value
     * @param int $seconds
     * @return bool
     */
    public function update(string $id, $value, int $seconds): bool
    {
        $this->store->delete($id);
        return $this->store->put($id, $value, $seconds);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->store->forget($id);
    }
}
