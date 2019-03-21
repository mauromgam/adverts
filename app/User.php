<?php

namespace App;

use App\Collections\AdvertCollection;
use App\Collections\UserCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property boolean $is_enabled
 * @property AdvertCollection $adverts
 *
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_enabled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     *
     * @return UserCollection
     */
    public function newCollection(array $models = [])
    {
        return new UserCollection($models);
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
    ];

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
        $data = (new UserCollection([$this]))
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
        $data = (new UserCollection([$this]))
            ->toDetailsArray();

        if (empty($data[0])) {
            return [];
        }

        return $data[0];
    }
}
