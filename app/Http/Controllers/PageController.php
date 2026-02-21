<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function show(Page $page)
    {
        if (!$page->is_published && !auth()->check()) {
            abort(404);
        }
        
        return view('pages.show', [
            'page' => $page,
            'use_two_columns' => true, // ensure pages render in two-column layout with sidebar
        ]);
    }
}
