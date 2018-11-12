<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Serie;
use Illuminate\Http\Request;

/**
 * Class SerieRatingController
 * @package App\Http\Controllers\Api
 */
class SerieRatingController extends Controller
{
    /**
     * @param Request $request
     * @param Serie $serie
     */
    public function update(Request $request, Serie $serie)
    {
        auth()->user()->rate($serie, $request->get('rating', 0));
    }
}
