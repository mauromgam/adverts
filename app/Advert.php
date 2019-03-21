<?php

namespace App;

use App\Collections\AdvertCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $title
 * @property string $description
 * @property string $price
 * @property string $category_id
 * @property string $user_id
 * @property Category $category
 * @property User $user
 *
 * Class Advert
 * @package App
 */
class Advert extends Model
{
    public $table = 'adverts';

    public $fillable = [
        'title',
        'description',
        'price',
        'category_id',
        'user_id',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|double',
        'category_id' => 'required|exists:categories,id',
        'user_id' => 'required|exists:users,id',
    ];

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     *
     * @return AdvertCollection
     */
    public function newCollection(array $models = [])
    {
        return new AdvertCollection($models);
    }

    /**
     * @return array
     */
    public function toDetailsArray()
    {
        $data = (new AdvertCollection([$this]))
            ->toDetailsArray();

        if (empty($data[0])) {
            return [];
        }

        return $data[0];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
