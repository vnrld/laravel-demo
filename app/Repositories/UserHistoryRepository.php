<?php


namespace App\Repositories;


use App\Contracts\UserHistoryRepositoryContract;
use App\Models\UserHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserHistoryRepository implements UserHistoryRepositoryContract
{

    /**
     * @param Model $model
     * @return Model
     */
    public function create(Model $model): Model
    {
        $model->saveQuietly();
        return $model;
    }

    /**
     * @param string $id
     * @return Model|null
     */
    public function read(string $id): ?Model
    {
        return UserHistory::find($id);
    }

    /**
     * @param Model $model
     * @return Model
     */
    public function update(Model $model): Model
    {
        // the update won't be used
        return $model;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return (bool)UserHistory::destroy($id);
    }

    /**
     * @param string $userId
     * @return Collection
     */
    public function getHistoryForUser(string $userId): Collection
    {
        return UserHistory::where('user_id', '=', $userId)->all();
    }
}
