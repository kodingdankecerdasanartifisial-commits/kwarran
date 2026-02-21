<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gudep;

class GudepController extends Controller
{
    public function index()
    {
        $gudeps = Gudep::where('is_active', true)->orderBy('name')->get();
        return view('gudep.index', compact('gudeps'));
    }

    public function show($slug)
    {
        $gudep = Gudep::where('slug', $slug)->firstOrFail();
        return view('gudep.show', compact('gudep'));
    }
}
