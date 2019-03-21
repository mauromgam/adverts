<?php

namespace App\Jobs;

use App\Services\UserService;

class CSVUsersImport extends CSVImport
{
    /**
     * CSVUsersImport constructor.
     * @param $ids
     * @param UserService $service
     * @param string $table
     */
    public function __construct($ids, UserService $service, $table = 'users')
    {
        parent::__construct($ids, $service, $table);
    }
}
