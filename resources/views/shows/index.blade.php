@extends('layout')

@section('title', 'All Entertainmnent')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Anime, Movies & TV Shows</h1>

        @auth
            <a href="{{ route('shows.create') }}" class="btn btn-success">+ Add Content</a>
        @endauth
    </div>

    {{-- searching, filtering, sorting --}}
    <form method="GET" action="{{ route('shows.index') }}" class="mb-4 d-flex flex-wrap gap-3 align-items-end">
        <div>
            <label class="form-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                placeholder="Title or Genre">
        </div>

        <div>
            <label class="form-label">Sort By</label>
            <select name="sort" class="form-control">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Recently Added</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title A–Z</option>
                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title Z–A</option>
                <option value="most_favorited" {{ request('sort') == 'most_favorited' ? 'selected' : '' }}>
                    Most Favorited
                </option>
            </select>
        </div>


        <div>
            <label class="form-label">Type</label>
            <select name="type" class="form-control">
                <option value="">All</option>
                <option value="show" {{ request('type') == 'show' ? 'selected' : '' }}>Show</option>
                <option value="movie" {{ request('type') == 'movie' ? 'selected' : '' }}>Movie</option>
            </select>
        </div>


        <div>
            <button type="submit" class="btn btn-primary">Sort/Filter</button>
        </div>
    </form>

    {{-- originally for testing, but now it displays an appropriate message --}}
    @auth
        <p class="text-muted">Hi {{ auth()->user()->name }}! What's your next watch?</p>
    @endauth

    @guest
        <p class="text-muted">Login to save your favorites!</p>
    @endguest

    {{-- displaying all the movies and shows --}}
    @if ($shows->count())
        <div class="row">
            @foreach ($shows as $show)
                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="max-width: 300px; height: 450px; margin: auto;">
                        @if ($show->image_url)
                            <img src="{{ $show->image_url }}" class="card-img-top" alt="{{ $show->title }}"
                                style="height: 180px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title d-flex justify-content-between align-items-center">
                                {{ $show->title }}
                                <span class="badge bg-secondary">{{ ucfirst($show->type) }}</span>
                            </h5>
                            <small class="text-muted">{{ $show->favorites_count }} ⭐</small>
                            <p class="card-text">{{ Str::limit($show->description, 80) }}</p>
                            <a href="{{ route('shows.show', $show) }}" class="btn btn-primary mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>None yet, be the first to add one!</a></p>
    @endif
@endsection
