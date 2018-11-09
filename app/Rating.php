<?php

namespace App;

use App\Exceptions\InvalidRatingException;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rating
 * @package App
 */
class Rating extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'rating',
        'user_id',
        'rateable_id',
        'rateable_type',
    ];

    /**
     *
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($rating) {
            if ($rating->rating < 1 || $rating->rating > 5) {
                throw new InvalidRatingException(sprintf("%s does not fall in the range of 1-5", $rating->rating));
            }
        });
    }

    /**
     * @param $query
     * @param string $type
     * @return mixed
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('rateable_type', $type);
    }

    /**
     * @param $query
     * @param Model $model
     * @return mixed
     */
    public function scopeFor($query, Model $model)
    {
        return $query->where('rateable_id', $model->id)->limit(1);
    }
}
