<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{route('pages.index')}}">{{config('app.name')}}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05"
                aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="#">Watchlist</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Favourites</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Rated series</a></li>
            </ul>

            <ul class="navbar-nav ml-auto">
                @if(auth()->guest())
                    <li class="nav-item">
                        <a class="nav-link">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Login</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" id="user" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">{{auth()->user()->name}}</a>
                        <div class="dropdown-menu" aria-labelledby="user">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

