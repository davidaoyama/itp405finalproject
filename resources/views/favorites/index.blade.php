@extends('layout')

@section('title', 'My Favorites')

@section('content')

    <a href="{{ route('shows.index') }}" class="btn btn-primary">Back</a>

    <h1 class="mb-4 mt-4">My Favorites</h1>

    @if ($favorites->isEmpty())
        <p>You haven't favorited anything yet! Go browse!</p>
    @else
        <div class="row">
            @foreach ($favorites as $favorite)
                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="max-width: 300px; height: 450px; margin: auto;">
                        @if ($favorite->show->image_url)
                            <img src="{{ $favorite->show->image_url }}" class="card-img-top" alt="{{ $favorite->show->title }}"
                                style="height: 180px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $favorite->show->title }}</h5>
                            <p class="card-text">{{ Str::limit($favorite->show->description, 100) }}</p>
                            <p class="text-muted small">
                                Favorited {{ $favorite->created_at->diffForHumans() }}
                            </p>
                            <a href="{{ route('shows.show', $favorite->show) }}" class="btn btn-primary mb-2">View
                                Details</a>

                            <form action="{{ route('favorites.destroy', $favorite->show) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">Remove Favorite</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
