<?php

namespace App\Collections;

use App\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserCollection
 * @package App\Collections
 * @method User first(callable $callback = null, $default = null)
 */
class UserCollection extends Collection implements CollectionInterface
{
    /**
     * @return array
     */
    public function toBasicArray(): array
    {
        return $this->map(function (User $user) {
            return [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'is_enabled' => $user->is_enabled,
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
        return $this->map(function (User $user) {
            return [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'is_enabled' => $user->is_enabled,
                'adverts'    => $user->adverts->toBasicArray()
            ];
        })->all();
    }
}
