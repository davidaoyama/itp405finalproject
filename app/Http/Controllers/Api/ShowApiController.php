<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Show;
use Illuminate\Http\Request;

class ShowApiController extends Controller
{
    public function index()
    {
        return Show::withCount('favorites')->get();
    }

    public function show(Show $show)
    {
        return $show->load(['comments.user', 'favorites']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image_url' => 'nullable|url',
            'genre' => 'nullable|max:100',
            'type' => 'required|in:movie,show',
        ]);

        $show = Show::create([
            ...$validated,
            'user_id' => auth()->id() ?? 1
        ]);

        return response()->json($show, 201);
    }

    public function update(Request $request, Show $show)
    {
        $show->update($request->only('title', 'description', 'image_url', 'genre', 'type'));

        return response()->json($show);
    }

    public function destroy(Show $show)
    {
        $show->delete();
        return response()->noContent();
    }
}

?>