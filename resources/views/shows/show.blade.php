@extends('layout')

@section('title', $show->title)

@section('content')
    <div>
        <a href="{{ route('shows.index') }}" class="btn btn-primary">Back</a>
        <h1 class="mt-4">
            {{ $show->title }}
            @auth
                @if ($show->favorites->contains('user_id', auth()->id()))
                    <span>⭐</span>
                @endif
            @endauth
        </h1>


        @if ($show->image_url)
            <div class="text-center">
                <img src="{{ $show->image_url }}" alt="{{ $show->title }}" class="img-fluid mb-3"
                    style="max-height: 400px; width: auto; object-fit: cover;">
            </div>
        @endif

        <p><strong>Genre:</strong> {{ $show->genre ?? 'N/A' }}</p>
        <p>{{ $show->description }}</p>
        <p><strong></strong> {{ $show->favorites->count() }}
            favorities⭐</p>

        @auth
            @if ($show->favorites->contains('user_id', auth()->id()))
                <form action="{{ route('favorites.destroy', $show) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-secondary mb-3">❌ Unfavorite</button>
                </form>
            @else
                <form action="{{ route('favorites.store', $show) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning mb-3">⭐ Favorite</button>
                </form>
            @endif
        @endauth

        @can('update', $show)
            <a href="{{ route('shows.edit', $show) }}" class="btn btn-secondary mb-3">Edit</a>
        @endcan

        @can('delete', $show)
            <form action="{{ route('shows.destroy', $show) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mb-3">Delete Show</button>
            </form>
        @endcan


        <hr>

        <h3>Comments</h3>

        @auth
            <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="show_id" value="{{ $show->id }}">

                <div class="mb-3">
                    <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="3"
                        placeholder="Leave a comment...">{{ old('body') }}</textarea>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
        @else
            <p><a href="{{ route('login') }}">Login</a> to post a comment.</p>
        @endauth

        @if ($show->comments->count())
            @foreach ($show->comments as $comment)
                <div class="mb-3 p-3 border rounded" id="comment-box-{{ $comment->id }}">
                    <small class="text-muted">{{ $comment->user->name }} •
                        {{ $comment->created_at->diffForHumans() }}</small>

                    <div class="d-flex justify-content-between align-items-start" id="comment-body-{{ $comment->id }}">
                        <p class="mb-0 me-2 flex-grow-1">{{ $comment->body }}</p>

                        <div class="d-flex gap-1">
                            @can('update', $comment)
                                <button onclick="toggleEdit({{ $comment->id }})" class="btn btn-sm btn-outline-secondary"
                                    title="Edit">✏️</button>
                            @endcan

                            @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">🗑️</button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    @can('update', $comment)
                        <form id="comment-form-{{ $comment->id }}" action="{{ route('comments.update', $comment) }}"
                            method="POST" class="mb-2 d-none mt-2">
                            @csrf
                            @method('PUT')
                            <textarea name="body" class="form-control mb-2" rows="2">{{ $comment->body }}</textarea>
                            <button type="submit" class="btn btn-sm btn-success">💾 Save</button>
                        </form>
                    @endcan
                </div>
            @endforeach
        @else
            <p>No comments yet. Be the first!</p>
        @endif
    </div>


    @push('scripts')
        <script>
            function toggleEdit(commentId) {
                const form = document.getElementById(`comment-form-${commentId}`);
                const body = document.getElementById(`comment-body-${commentId}`);

                if (form.classList.contains('d-none')) {
                    form.classList.remove('d-none');
                    body.classList.add('d-none');
                } else {
                    form.classList.add('d-none');
                    body.classList.remove('d-none');
                }
            }
        </script>
    @endpush

@endsection
