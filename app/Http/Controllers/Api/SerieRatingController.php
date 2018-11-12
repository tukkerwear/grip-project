<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSerieRatingRequest;
use App\Serie;
use Illuminate\Http\Request;

/**
 * Class SerieRatingController
 * @package App\Http\Controllers\Api
 */
class SerieRatingController extends Controller
{
    /**
     * @param UpdateSerieRatingRequest $request
     * @param Serie $serie
     */
    public function update(UpdateSerieRatingRequest $request, Serie $serie)
    {
        auth()->user()->rate($serie, $request->get('rating', 0));
    }
}
