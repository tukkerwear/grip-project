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
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable')->where('user_id', auth()->id());
    }

    public function scopeRated()
    {
        return $this->morphMany(Rating::class, 'rateable')->whereRateableType(self::class);
    }
}
