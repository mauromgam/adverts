<?php

namespace App\Jobs;

use App\Services\CategoryService;

class CSVCategoriesImport extends CSVImport
{
    /**
     * CSVCategoriesImport constructor.
     * @param $ids
     * @param CategoryService $service
     * @param string $table
     */
    public function __construct($ids, CategoryService $service, $table = 'categories')
    {
        parent::__construct($ids, $service, $table);
    }
}
