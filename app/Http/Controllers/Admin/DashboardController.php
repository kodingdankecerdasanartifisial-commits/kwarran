<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts' => \App\Models\Post::count(),
            'categories' => \App\Models\Category::count(),
            'pages' => \App\Models\Page::count(),
            'users' => \App\Models\User::count(),
            'gudeps' => \App\Models\Gudep::count(),
            'total_members' => \App\Models\Gudep::sum('male_members_count') + \App\Models\Gudep::sum('female_members_count'),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
