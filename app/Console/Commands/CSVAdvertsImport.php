<?php

namespace App\Console\Commands;

use App\Services\AdvertService;

/**
 * Class CSVAdvertsImport
 * @package App\Console\Commands
 */
class CSVAdvertsImport extends CSVImport
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:upload_adverts {fileName : The name of the file located in the directory "/storage/files"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload a CSV file of Adverts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('adverts');
        $this->setQueue("\App\Jobs\CSVAdvertsImport");
        $this->setService(new AdvertService());

        $header = [
            'id',
            'title',
            'description',
            'price',
            'category_id',
            'user_id',
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
        if (empty($record['title'])) {
            $errorMessage = "Advert missing title.";
        } elseif (empty($record['description'])) {
            $errorMessage = "Advert missing description.";
        } elseif (empty($record['price'])) {
            $errorMessage = "Advert missing price.";
        } elseif (empty($record['category_id'])) {
            $errorMessage = "Advert missing category_id.";
        } elseif (empty($record['user_id'])) {
            $errorMessage = "Advert missing user_id.";
        }

        if ($errorMessage) {
            return false;
        }

        return true;
    }
}
