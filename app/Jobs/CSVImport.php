<?php

namespace App\Jobs;

use App\Services\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

abstract class CSVImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ids;
    protected $table;
    protected $service;

    /**
     * CSVUpload constructor.
     * @param $ids
     * @param Service $service
     * @param $table
     */
    public function __construct($ids, Service $service, $table)
    {
        $this->ids = $ids;
        $this->service = $service;
        $this->table = $table;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        if (!$this->table) {
            throw new \Exception('Database table name is missing.');
        }

        $values = DB::table('tmp_upload')
            ->where('table', '=', $this->table)
            ->whereIn('id', $this->ids)
            ->whereNull('status')
            ->get();

        foreach ($values as $value) {
            $response = $this->service->upload(json_decode($value->attr));
            if (empty($response)) {
                DB::table('tmp_upload')->where('id', $value->id)->delete();
            } else {
                DB::table('tmp_upload')->where('id', $value->id)->update([
                    'status' => 'failed',
                    'error_message' => json_encode($response)
                ]);
            }
        }
    }
}
