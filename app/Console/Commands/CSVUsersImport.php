<?php

namespace App\Console\Commands;

use App\Services\UserService;

/**
 * Class CSVUsersImport
 * @package App\Console\Commands
 */
class CSVUsersImport extends CSVImport
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:upload_users {fileName : The name of the file located in the directory "/storage/files"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload a CSV file of Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('users');
        $this->setQueue("\App\Jobs\CSVUsersImport");
        $this->setService(new UserService());

        $header = [
            'id',
            'username',
            'email',
            'created_At',
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
        if (empty($record['username'])) {
            $errorMessage = "User missing username.";
        } elseif (empty($record['email'])) {
            $errorMessage = "User missing email.";
        }

        if ($errorMessage) {
            return false;
        }

        return true;
    }
}
