<?php

namespace App\Console\Commands;

use App\Services\CategoryService;

/**
 * Class CSVCategoriesImport
 * @package App\Console\Commands
 */
class CSVCategoriesImport extends CSVImport
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:upload_categories {fileName : The name of the file located in the directory "/storage/files"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload a CSV file of Categories';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('categories');
        $this->setQueue("\App\Jobs\CSVCategoriesImport");
        $this->setService(new CategoryService());

        $header = [
            'id',
            'name',
        ];
        $this->setHeader($header);
    }

    /**
     * @param $record
     * @param $errorMessage
     * @return bool
     */
    protected function validateData($record, &$errorMessage)
    {
        if (empty($record['name'])) {
            $errorMessage = "Category missing name.";
        }

        if ($errorMessage) {
            return false;
        }

        return true;
    }
}
