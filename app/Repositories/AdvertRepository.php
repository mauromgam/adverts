<?php

namespace App\Repositories;

use App\Advert;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class AdvertRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     * @param $model
     */
    public function __construct(Advert $model)
    {
        parent::__construct($model);
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model(): string
    {
        return Advert::class;
    }

    /**
     * @param Request $request
     * @param array $columns
     * @param array $sort
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(Request $request, $columns = ['*'], $sort = []): LengthAwarePaginator
    {
        if (empty($sort)) {
            $sort = [
                'title' => 'ASC',
            ];
        }

        return parent::getAllPaginated($request, $columns, $sort);
    }
}
