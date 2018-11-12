<?php


namespace App\Http\Controllers;


use App\Serie;

/**
 * Class PageController
 * @package App\Http\Controllers
 */
class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $seriesRecentlyCreated = Serie::recentlyAdded(3)->with(['posters', 'rating'])->get();
        $seriesRecentlyUpdated = Serie::recentlyUpdated(3)->with('posters', 'rating')->get();

        return view('pages.index', compact('seriesRecentlyCreated', 'seriesRecentlyUpdated'));
    }
}
