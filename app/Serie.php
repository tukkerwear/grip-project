<?php

namespace App;

use App\Interfaces\RateableInterface;
use App\Traits\Posterable;
use App\Traits\Rateable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Serie
 * @package App
 */
class Serie extends Model implements RateableInterface
{
    use Posterable, Rateable;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * @return mixed
     */
    public function getDefaultPosterAttribute()
    {
        return $this->posters->first();
    }

    /**
     * @param $query
     * @param $quantity
     * @return mixed
     */
    public function scopeRecentlyAdded($query, $quantity)
    {
        return $query->orderByDesc('created_at')->take($quantity);
    }

    /**
     * @param $query
     * @param $quantity
     * @return mixed
     */
    public function scopeRecentlyUpdated($query, $quantity)
    {
        return $query->orderByDesc('updated_at')->take($quantity);
    }
}
