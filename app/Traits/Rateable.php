<?php


namespace App\Traits;


use App\Rating;

/**
 * Trait Rateable
 * @package App\Traits
 */
trait Rateable
{
    /**
     * @return mixed
     */
    public function rating()
    {
        return $this->morphOne(Rating::class, 'rateable')->where('user_id', auth()->id())->withDefault([
            'rating' => 0
        ]);
    }

    public function scopeRated()
    {
        return $this->morphMany(Rating::class, 'rateable')->whereRateableType(self::class);
    }
}
