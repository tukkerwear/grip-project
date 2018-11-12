<?php

namespace App;

use App\Interfaces\RateableInterface;
use App\Traits\Posterable;
use App\Traits\Rateable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Episode
 * @package App
 */
class Episode extends Model implements RateableInterface
{
    use Posterable, Rateable;

    /**
     * @var array
     */
    protected $touches = ['serie'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }
}
