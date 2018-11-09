<?php


namespace App\Traits;


/**
 * Trait Posterable
 * @package App\Traits
 */
trait Posterable
{
    /**
     * @return mixed
     */
    public function posters()
    {
        return $this->morphMany('App\Poster', 'posterable');
    }
}
