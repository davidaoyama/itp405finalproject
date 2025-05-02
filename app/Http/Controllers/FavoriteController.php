<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Show;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()->with('show')->latest()->get();
        return view('favorites.index', compact('favorites'));
    }

    public function store(Show $show)
    {
        $show->favorites()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Added to favorites!');
    }

    public function destroy(Show $show)
    {
        $show->favorites()->where('user_id', auth()->id())->delete();

        return back()->with('success', 'Removed from favorites.');
    }
}
