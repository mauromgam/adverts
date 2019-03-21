<?php

namespace App\Repositories;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function findWithoutFail($id, $columns = ['*']): ?Model;
    public function transformBasicCollection(LengthAwarePaginator &$paginatedResults): void;
    public function getAllPaginated(Request $request, $columns = ['*'], $sort = []): LengthAwarePaginator;
}
