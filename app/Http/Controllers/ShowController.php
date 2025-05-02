<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShowController extends Controller
{
    public function index(Request $request)
    {
        $query = Show::withCount('favorites');

        //search bar
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('genre', 'like', '%' . $request->search . '%');
            });
        }

        //filtering
        if ($request->filled('type') && in_array($request->type, ['movie', 'show'])) {
            $query->where('type', $request->type);
        }

        // sorting options
        switch ($request->sort) {
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_favorited':
                $query->orderBy('favorites_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $shows = $query->get();

        return view('shows.index', compact('shows'));
    }



    public function show(Show $show)
    {
        $show->load([
            'comments' => function ($query) {
                $query->latest();
            },
            'comments.user',
            'favorites'
        ]);
        return view('shows.show', compact('show'));
    }

    public function create(Request $request)
    {
        $prefill = null;
        
        //using API as first option
        if ($request->filled('search')) {
            $response = Http::get('http://www.omdbapi.com/', [
                'apikey' => env('OMDB_API_KEY'),
                't' => $request->search,
            ]);

            if ($response->ok() && $response['Response'] === 'True') {
                $prefill = [
                    'title' => $response['Title'],
                    'description' => $response['Plot'],
                    'genre' => $response['Genre'],
                    'image_url' => $response['Poster'] !== 'N/A' ? $response['Poster'] : null,
                    'type' => strtolower($response['Type']) === 'movie' ? 'movie' : 'show',
                ];
            }
        }

        return view('shows.create', compact('prefill'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image_url' => 'nullable|url',
            'genre' => 'nullable|max:100',
            'type' => 'required|in:movie,show',
        ]);

        Show::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'genre' => $request->genre,
            'type' => $request->type,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('home')->with('success', 'Show/Movie created successfully!');
    }

    public function edit(Show $show)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $show); 
        return view('shows.edit', compact('show'));
    }

    public function update(Request $request, Show $show)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $show);
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image_url' => 'nullable|url',
            'genre' => 'nullable|max:100',
            'type' => 'required|in:movie,show',
        ]);

        $show->update($request->only('title', 'description', 'image_url', 'genre', 'type'));

        return redirect()->route('shows.show', $show)->with('success', 'Show/Movie updated successfully!');
    }

    public function destroy(Show $show)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $show);
        $show->delete();

        return redirect()->route('home')->with('success', 'Show/Movie deleted successfully.');
    }
}
