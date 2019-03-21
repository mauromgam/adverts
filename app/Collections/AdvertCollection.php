<?php

namespace App\Collections;

use App\Advert;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AdvertCollection
 * @package App\Collections
 * @method Advert first(callable $callback = null, $default = null)
 */
class AdvertCollection extends Collection implements CollectionInterface
{
    /**
     * @return array
     */
    public function toBasicArray(): array
    {
        return $this->map(function (Advert $advert) {
            return [
                'id'          => $advert->id,
                'title'       => $advert->title,
                'description' => $advert->description,
            ];
        })->all();
    }

    /**
     * @return array
     */
    public function toDetailsArray(): array
    {
        return $this->map(function (Advert $advert) {
            return [
                'id'          => $advert->id,
                'title'       => $advert->title,
                'description' => $advert->description,
                'price'       => $advert->price,
                'category'    => $advert->category->toBasicArray(),
                'user'        => $advert->user->toBasicArray(),
            ];
        })->all();
    }
}
