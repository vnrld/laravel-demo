<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryContract;
use App\Exceptions\User\NotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserRepositoryContract
{

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
     */
    public function read(string $id): ?Model
    {
        return User::find($id);
    }

    /**
     * @param Model $model
     * @return Model
     * @throws NotFoundException
     */
    public function update(Model $model): Model
    {
        $user = User::find($model->id);

        if ($user === null) {
            throw new NotFoundException('User ' . $model->id . ' not found!');
        }

        $model->save();
        return $model;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return (bool)User::destroy($id);
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
