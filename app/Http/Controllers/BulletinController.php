<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    public function index()
    {
        $bulletins = Bulletin::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('bulletins.index', compact('bulletins'));
    }

    public function show(Bulletin $bulletin)
    {
        if (!$bulletin->is_active) {
            abort(404);
        }

        return view('bulletins.show', compact('bulletin'));
    }
}
