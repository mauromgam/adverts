<?php

namespace App\Services;

/**
 * Class AdvertService
 * @package App\Services
 */
interface Service
{
    /**
     * Saves a CSV file content in the Database prior to process it
     *
     * @param $csv
     * @return array
     */
    public function upload($csv);
}
