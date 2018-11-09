<?php

namespace App;

use App\Interfaces\RateableInterface;
use App\Traits\Rateable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable, Rateable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * @param RateableInterface $model
     * @param int $rating
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function rate(RateableInterface $model, int $rating)
    {
        return $this->ratings()->updateOrCreate(
            [
                'rateable_id' => $model->id,
                'rateable_type' => get_class($model),
                'user_id' => $this->id,
            ],
            [
                'user_id' => $this->id,
                'rating' => $rating,
                'rateable_id' => $model->id,
                'rateable_type' => get_class($model),
            ]);
    }


    /**
     * @param RateableInterface $model
     * @return mixed
     */
    public function ratingsForType(RateableInterface $model)
    {
        return $this->ratings()->ofType(get_class($model));
    }

    /**
     * @param RateableInterface $model
     * @return
     */
    public function ratingFor(RateableInterface $model)
    {
        return $this->ratings()->for($model)->first();
    }
}
