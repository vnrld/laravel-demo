<?php

namespace App\Repositories;

use App\Contracts\CacheCrudRepositoryContract;
use App\Contracts\UserRepositoryContract;
use App\Exceptions\User\NotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserRepositoryContract
{
    private CacheCrudRepositoryContract $cacheRepository;

    public function __construct(CacheCrudRepositoryContract $cacheRepository)
    {
        $this->cacheRepository = $cacheRepository;
    }

    /**
     * @param Model $model
     * @return Model
     */
    public function create(Model $model): Model
    {
        $model->save();
        return $model;
    }

    /**
     * @param string $id
     * @return Model|null
     * @throws NotFoundException
     */
    public function read(string $id): ?Model
    {
        $cacheKey = 'user_' . $id;

        $user = $this->cacheRepository->read($cacheKey);

        if ($user === null) {
            $user = User::find($id);
            if ($user === null) {
                throw new NotFoundException('User ' . $id . ' not found!');
            }
            $this->cacheRepository->create($cacheKey, $user, 3600);
        }

        return $user;
    }

    /**
     * @param Model $model
     * @return Model
     * @throws NotFoundException
     */
    public function update(Model $model): Model
    {
        $userId = $model->id;

        $user = User::find($userId);

        if ($user === null || (!$user instanceof $model)) {
            throw new NotFoundException('User ' . $userId . ' not found!');
        }

        $modelAttributes = $model->toArray();

        foreach ($modelAttributes as $attribute => $value) {
            if ($user->isFillable($attribute)) {
                $user->setAttribute($attribute, $value);
            }
        }

        $user->save();
        return $user;
    }

    /**
     * @param string $id
     * @return bool
     * @throws NotFoundException
     */
    public function delete(string $id): bool
    {
        if ($this->read($id)) {
            return (bool)User::destroy($id);
        }

        return false;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return User::all();
    }

    public function findByEmail(string $email): ?Model
    {
        return User::where('email', '=', $email)->first();
    }

}
