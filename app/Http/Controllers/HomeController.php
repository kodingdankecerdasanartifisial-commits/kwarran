<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Event;
use App\Models\DigitalBanner;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Sliders
        $sliders = Slider::where('is_active', true)->orderBy('order')->get();
        
        // 2. Latest Posts (General)
        $allLatest = Post::with('category')
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();

        // Column 1: Main featured post (Latest 1)
        $mainPost = $allLatest->first();

        // Column 2: Stacked news (Next 8)
        $stackedPosts = $allLatest->slice(1, 8);

        // Column 3: Popular & Agenda
        $popularPosts = Post::where('is_published', true)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $agendas = Event::where('is_active', true)
            ->whereDate('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        // 4. News by Categories
        $categorySections = Category::with(['posts' => function($query) {
                $query->where('is_published', true)
                    ->orderBy('published_at', 'desc')
                    ->take(4);
            }])
            ->whereHas('posts', function($query) {
                $query->where('is_published', true);
            })
            ->where('slug', '!=', 'agenda') // Exclude agenda category from general news loop if it's special
            ->get();

        // 5. Digital Banners
        $digitalBanners = DigitalBanner::where('is_active', true)->orderBy('order')->get();

        return view('home', [
            'sliders' => $sliders,
            'mainPost' => $mainPost,
            'stackedPosts' => $stackedPosts,
            'popularPosts' => $popularPosts,
            'agendas' => $agendas,
            'latestPosts' => $allLatest->take(10), // For newsflash
            'categorySections' => $categorySections,
            'digitalBanners' => $digitalBanners,
            'otherPosts' => $allLatest->slice(9, 12), // Display up to 12 more posts at the bottom
            //'sidebarWidgets' => not used (feature removed)
        ]);
    }
}
