<?php

namespace App\Console\Commands;

use App\Services\Service;
use App\Traits\CsvHelpersTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

abstract class CSVImport extends Command
{
    use CsvHelpersTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    /**
     * The array of header's name
     *
     * @var array
     */
    protected $header;

    /**
     * The database table that the data will be inserted into
     *
     * @var string
     */
    protected $table;

    /**
     * The queue class path that will be used to set up the Jobs
     *
     * @var string
     */
    protected $queue;

    /**
     * The service object responsible for the import
     *
     * @var Service
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $header
     */
    protected function setHeader($header) {
        $this->header = $header;
    }

    /**
     * @param string $table
     */
    protected function setTable($table) {
        $this->table = $table;
    }

    /**
     * @param string $queue
     */
    protected function setQueue($queue) {
        $this->queue = $queue;
    }

    /**
     * @param string $service
     */
    protected function setService($service) {
        $this->service = $service;
    }

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        if (!$this->header) {
            throw new \Exception('Missing headers.');
        }

        if (!$this->table) {
            throw new \Exception('Missing database table name.');
        }

        if (!$this->queue) {
            throw new \Exception('Missing queue class path.');
        }

        if (!$this->service) {
            throw new \Exception('Missing service object.');
        }

        $relativePathName = storage_path('files');
        $fileName = $this->argument('fileName');

        $this->line('<info>Initializing Import</info>');

        $this->line("<info>File:</info> $relativePathName/$fileName");

        try {
            $csv = $this->parseCSVFile($fileName, $relativePathName, $this->header, 25000);
            $records = $csv->getRecords();
            $i = 1;
            $date = date('Y-m-d H:i:s');

            $lastId = DB::select("
                SELECT 
                    `AUTO_INCREMENT` 
                FROM 
                    INFORMATION_SCHEMA.TABLES 
                WHERE TABLE_NAME = 'tmp_upload'
            ");
            $lastId = $lastId[0]->AUTO_INCREMENT;
            foreach ($records as $offset => $record) {
                $status = null;
                $errorMessage = null;

                if (!$this->validateData($record, $errorMessage)) {
                    $status = 'failed';
                }

                $attr[] = [
                    'attr'          => json_encode($record),
                    'table'         => $this->table,
                    'created_at'    => $date,
                    'status'        => $status,
                    'error_message' => $errorMessage,
                ];
                if ($i > 2000) {
                    $this->line('<info>Inserting 2000...</info>');
                    DB::table('tmp_upload')->insert($attr);
                    unset($attr);
                    $i = 1;
                }
                $i++;
            }
            if (isset($attr)) {
                $this->line('<info>Inserting ' . count($attr) . '...</info>');
                DB::table('tmp_upload')->insert($attr);
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $this->line('<error>' . $e->getMessage() . '</error>');
            return;
        }
        $value = floor($csv->count()/500);
        if ($value > 0) {
            $remainder = $csv->count()%($value*500);
            for ($i = 1; $i < ($value+1); $i++) {
                $ids = range($lastId, $lastId+500);
                $this->queue::dispatch($ids, $this->service)->onQueue('csvUpload');
                $lastId = $lastId+501;
            }
            if ($remainder > 0) {
                $ids = range($lastId, $lastId+$remainder);
                $this->queue::dispatch($ids, $this->service)->onQueue('csvUpload');
            }
        } else {
            $ids = range($lastId, $lastId+$csv->count());
            $this->queue::dispatch($ids, $this->service)->onQueue('csvUpload');
        }

        $this->line('<info>The End.</info>');
    }

    /**
     * @param $record
     * @return bool
     */
    protected function validateData($record, &$errorMessage)
    {
        return true;
    }
}
