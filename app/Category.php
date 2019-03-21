<?php

namespace App;

use App\Collections\AdvertCollection;
use App\Collections\CategoryCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property AdvertCollection $adverts
 *
 * Class Category
 * @package App
 */
class Category extends Model
{
    public $table = 'categories';

    public $fillable = [
        'name',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
    ];

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     *
     * @return CategoryCollection
     */
    public function newCollection(array $models = [])
    {
        return new CategoryCollection($models);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adverts()
    {
        return $this->hasMany(Advert::class);
    }

    /**
     * @return array
     */
    public function toBasicArray()
    {
        $data = (new CategoryCollection([$this]))
            ->toBasicArray();

        if (empty($data[0])) {
            return [];
        }

        return $data[0];
    }

    /**
     * @return array
     */
    public function toDetailsArray()
    {
        $data = (new CategoryCollection([$this]))
            ->toDetailsArray();

        if (empty($data[0])) {
            return [];
        }

        return $data[0];
    }
}
