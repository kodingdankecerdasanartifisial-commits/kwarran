<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lpk;
use App\Models\Post;
use App\Models\Category;

class LpkController extends Controller
{
    public function index()
    {
        $lpk = Lpk::where('slug', 'lpk')->first();
        if (!$lpk) {
            abort(404, 'LPK page not setup yet.');
        }

        $category = Category::where('slug', 'lpk')->first();
        $posts = collect();
        if ($category) {
            $posts = Post::where('category_id', $category->id)->where('is_published', true)->latest()->take(6)->get();
        }

        // Finanace data (most recent)
        $finances = \App\Models\Finance::latest()->take(10)->get();
        
        // Agendas
        $agendas = \App\Models\LpkAgenda::where('lpk_id', $lpk->id)->where('is_public', true)->orderBy('date', 'asc')->get();

        return view('lpk.show', compact('lpk', 'posts', 'finances', 'agendas'));
    }
}
