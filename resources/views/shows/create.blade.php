@extends('layout')

@section('title', 'Add New Show/Movie')

@section('content')
    <a href="{{ route('shows.index') }}" class="btn btn-primary">Back</a>

    <h1 class="mt-4">Add New Show/Movie</h1>

    {{-- search bar --}}
    <form method="GET" action="{{ route('shows.create') }}" class="mb-4">
        <label class="form-label">Search OMDb by title</label>
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="e.g., Spirited Away"
                value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </div>
    </form>

    {{-- form to create the show/movie entry --}}
    <div class="row mb-4">
        <div class="col-md-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    Please fix the errors below.
                </div>
            @endif

            <form action="{{ route('shows.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ old('title', $prefill['title'] ?? '') }}"
                        class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Genre</label>
                    <input type="text" name="genre" value="{{ old('genre', $prefill['genre'] ?? '') }}"
                        class="form-control @error('genre') is-invalid @enderror">
                    @error('genre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control @error('type') is-invalid @enderror">
                        <option value="show" {{ old('type', $prefill['type'] ?? '') == 'show' ? 'selected' : '' }}>Show
                        </option>
                        <option value="movie" {{ old('type', $prefill['type'] ?? '') == 'movie' ? 'selected' : '' }}>Movie
                        </option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Image URL</label>
                    <input type="text" name="image_url" value="{{ old('image_url', $prefill['image_url'] ?? '') }}"
                        class="form-control @error('image_url') is-invalid @enderror">
                    @error('image_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $prefill['description'] ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Add it!</button>
            </form>
        </div>

        {{-- entry image loading --}}
        <div class="col-md-4 text-center">
            <label class="form-label d-block">Poster Preview</label>
            <div class="rounded shadow-sm mb-3"
                style="width: 100%; max-width: 300px; height: 400px; background-color: #ccc; margin: auto; position: relative; overflow: hidden;">
                @php
                    $img = old('image_url', $prefill['image_url'] ?? '');
                @endphp
                @if ($img)
                    <img src="{{ $img }}" alt="Poster preview"
                        style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                @endif
            </div>
        </div>
    </div>
@endsection
