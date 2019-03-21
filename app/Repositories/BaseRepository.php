<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class BaseRepository implements RepositoryInterface
{
    const ITEMS_PER_PAGE = 50;

    protected $model;

    /**
     * BaseRepository constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }


    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed|null
     */
    public function findWithoutFail($id, $columns = ['*']): ?Model
    {
        try {
            return $this->model->find($id, $columns);
        } catch (\Exception $e) {
            \Log::error($e);

            return null;
        }
    }

    /**
     * @param Request $request
     * @param array $columns
     * @param array $sort
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(Request $request, $columns = ['*'], $sort = []): LengthAwarePaginator
    {
        $page = isset($request->page) ? $request->page : 1;
        $model = $this->model->select($columns);

        if (!empty($sort)) {
            foreach ($sort as $column => $direction) {
                if (is_numeric($column)) {
                    $column = $direction;
                    $direction = 'ASC';
                }
                $model = $model->orderBy($column, $direction);
            }
        }

        $results = $model
            ->paginate($request->get('page_size') ?? self::ITEMS_PER_PAGE, ['*'], 'page', $page);
        $this->transformBasicCollection($results);

        return $results;
    }

    /**
     * @param LengthAwarePaginator $paginatedResults
     */
    public function transformBasicCollection(LengthAwarePaginator &$paginatedResults): void
    {
        $collection = $paginatedResults->getCollection();
        $arrayCollection = Collection::make($collection->toBasicArray());
        $paginatedResults->setCollection($arrayCollection);
    }
}
