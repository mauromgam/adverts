<?php

namespace App\Jobs;

use App\Services\AdvertService;

class CSVAdvertsImport extends CSVImport
{
    /**
     * CSVAdvertsImport constructor.
     * @param $ids
     * @param AdvertService $service
     * @param string $table
     */
    public function __construct($ids, AdvertService $service, $table = 'adverts')
    {
        parent::__construct($ids, $service, $table);
    }
}
