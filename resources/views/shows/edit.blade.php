@extends('layout')

@section('title', 'Edit Show/Movie')

@section('content')
    <a href="{{ route('shows.index') }}" class="btn btn-primary">Back</a>

    <h1 class="mt-4">Edit Show</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            Please fix the errors below.
        </div>
    @endif

    <form action="{{ route('shows.update', $show) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" value="{{ old('title', $show->title) }}"
                class="form-control @error('title') is-invalid @enderror">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Genre</label>
            <input type="text" name="genre" value="{{ old('genre', $show->genre) }}"
                class="form-control @error('genre') is-invalid @enderror">
            @error('genre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-control @error('type') is-invalid @enderror">
                <option value="show" {{ old('type', $show->type ?? '') == 'show' ? 'selected' : '' }}>Show</option>
                <option value="movie" {{ old('type', $show->type ?? '') == 'movie' ? 'selected' : '' }}>Movie</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Image URL</label>
            <input type="text" name="image_url" value="{{ old('image_url', $show->image_url) }}"
                class="form-control @error('image_url') is-invalid @enderror">
            @error('image_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $show->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection
