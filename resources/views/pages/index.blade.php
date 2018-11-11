@extends('layouts.default')


@section('content')

    @if(auth()->guest())
        <div class="jumbotron">
            <h1>Welcome to {{config('app.name')}}</h1>
            <p class="lead">Keep track of all your series and find new gems to watch!</p>
            <a href="{{route('register')}}" class="btn btn-primary btn-lg">Sign up to get started</a>
        </div>
    @else
        <div class="jumbotron">
            <h1>{{auth()->user()->name}}, welcome back to {{config('app.name')}}.</h1>
        </div>
    @endif

    @include('series._list', ['title' => 'Recently added series', 'series' => $seriesRecentlyCreated])
    @include('series._list', ['title' => 'Recently updated series', 'series' => $seriesRecentlyUpdated])

@endsection
