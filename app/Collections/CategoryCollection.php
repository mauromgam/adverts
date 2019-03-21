<?php

namespace App\Collections;

use App\Category;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CategoryCollection
 * @package App\Collections
 * @method Category first(callable $callback = null, $default = null)
 */
class CategoryCollection extends Collection implements CollectionInterface
{
    /**
     * @return array
     */
    public function toBasicArray(): array
    {
        return $this->map(function (Category $category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        })->all();
    }

    /**
     * Right now we have the same data on both toBasicArray and toDetailsArray,
     * however this interface can be really helpful with larger amounts of data
     *
     * @return array
     */
    public function toDetailsArray(): array
    {
        return $this->map(function (Category $category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        })->all();
    }
}
