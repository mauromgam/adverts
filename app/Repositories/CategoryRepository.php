<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * Configure the Model
     *
     * @return string
     */
    public function model(): string
    {
        return Category::class;
    }

    /**
     * BaseRepository constructor.
     * @param $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
