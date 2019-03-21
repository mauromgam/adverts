<?php

namespace App\Services;

use App\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Validator;

/**
 * Class CategoryService
 * @package App\Services
 */
class CategoryService implements Service
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

        $categoryArray = [
            'name' => $csv->name,
        ];

        try {
            $validator = Validator::make((array)$csv, Category::$rules);
            $validator->validate();

            /** Category|null|true $category */
            if ($category = Category::where('name', $csv->name)->first()) {
                \Log::error("Category already exists - Category ID: " . $category->id);
                $log['errors'][] = 'Category already exists';
            } else {
                $category = Category::create($categoryArray);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \Log::error("data: ", $categoryArray);
            $log['errors'][] = $e->getMessage();
        }

        return $log;
    }
}
