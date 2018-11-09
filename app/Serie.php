<?php

namespace App;

use App\Interfaces\RateableInterface;
use App\Traits\Posterable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Serie
 * @package App
 */
class Serie extends Model implements RateableInterface
{
    use Posterable;
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
}
