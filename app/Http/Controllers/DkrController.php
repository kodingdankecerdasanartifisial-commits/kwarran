<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dkr;
use App\Models\Post;
use App\Models\Category;

class DkrController extends Controller
{
    public function index()
    {
        $dkr = Dkr::first();
        if (!$dkr) {
            abort(404, 'DKR page not setup yet.');
        }

        $category = Category::where('name', 'DKR')->first();
        $posts = collect();
        if ($category) {
            $posts = Post::where('category_id', $category->id)->where('is_published', true)->latest()->take(6)->get();
        }

        $albums = \App\Models\DkrAlbum::where('dkr_id', $dkr->id)->with('photos')->latest()->get();
        $agendas = \App\Models\DkrAgenda::where('dkr_id', $dkr->id)->where('is_public', true)->where('date', '>=', now()->toDateString())->orderBy('date', 'asc')->get();

        return view('dkr.show', compact('dkr', 'posts', 'albums', 'agendas'));
    }

    public function showAlbum($slug)
    {
        $album = \App\Models\DkrAlbum::with('photos')->where('slug', $slug)->firstOrFail();
        return view('dkr.album_show', compact('album'));
    }
}
