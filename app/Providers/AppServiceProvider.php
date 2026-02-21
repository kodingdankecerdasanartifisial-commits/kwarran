<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Share menus to all views
        view()->composer('*', function ($view) {
            $view->with('publicMenus', \App\Models\Menu::whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('order')
                ->with(['children' => function($query) {
                    $query->where('is_active', true)->orderBy('order');
                }])
                ->get());
        });

        // Provide data to the sidebar view: popular posts and active widgets
        view()->composer('layouts.sidebar', function ($view) {
            $popularPosts = \App\Models\Post::where('is_published', true)
                ->orderBy('views', 'desc')
                ->take(6)
                ->get();

            $sidebarWidgets = [];
            if (class_exists(\App\Models\SidebarWidget::class)) {
                $sidebarWidgets = \App\Models\SidebarWidget::where('is_active', true)
                    ->orderBy('order')
                    ->get();
            }

            $visitorStats = [];
            if (class_exists(\App\Http\Controllers\Admin\VisitorController::class)) {
                $visitorStats = \App\Http\Controllers\Admin\VisitorController::getWidgetStats();
            }

            $view->with('popularPosts', $popularPosts)
                 ->with('sidebarWidgets', $sidebarWidgets)
                 ->with('visitorStats', $visitorStats);
        });
    }
}
