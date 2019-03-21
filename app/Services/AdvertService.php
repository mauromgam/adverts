<?php

namespace App\Services;

use App\Advert;

/**
 * Class AdvertService
 * @package App\Services
 */
class AdvertService implements Service
{
    /**
     * Saves a CSV file content in the Database prior to process it
     *
     * @param $csv
     * @return array
     */
    public function upload($csv)
    {
        $log = [];

        $advertArray = [
            'title' => $csv->title,
            'description' => $csv->description,
            'price' => $csv->price,
            'category_id' => $csv->category_id,
            'user_id' => $csv->user_id,
        ];

        try {
            /** Advert|null|true $advert */
            if ($advert = Advert::where('title', $csv->title)->first()) {
                \Log::error("Advert already exists - Advert ID: " . $advert->id);
                $log['errors'][] = 'Advert already exists';
            } else {
                $advert = Advert::create($advertArray);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \Log::error("data: ", $advertArray);
            $log['errors'][] = $e->getMessage();
        }

        return $log;
    }
}
