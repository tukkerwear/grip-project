<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Serie;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $episode = Episode::first();

        auth()->user()->rate(Serie::first(), 4);
        auth()->user()->ratingsForType(new Episode)->get();

        return view('welcome');

//        dd(  );
    }
}
