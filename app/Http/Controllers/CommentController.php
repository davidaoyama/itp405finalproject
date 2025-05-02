<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'show_id' => 'required|exists:shows,id',
            'body' => 'required|max:1000',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'show_id' => $request->show_id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Comment posted!');
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $request->validate([
            'body' => 'required|max:1000',
        ]);

        $comment->update([
            'body' => $request->body,
        ]);

        return back()->with('success', 'Comment updated!');
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
