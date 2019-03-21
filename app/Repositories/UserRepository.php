<?php

namespace App\Repositories;

use App\User;

class UserRepository extends BaseRepository
{
    /**
     * Configure the Model
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * BaseRepository constructor.
     * @param $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
