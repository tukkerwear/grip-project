<div class="row">
    <div class="col">
        <h2 class="mt-5">{{$title}}</h2>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card-deck">
            @foreach($series AS $serie)
                @include('series._list-item', ['serie' => $serie])
            @endforeach
        </div>
    </div>
</div>
