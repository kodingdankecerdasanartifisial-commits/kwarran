<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function index()
    {
        // Stats Overview
        $totalViews = Visitor::count();
        $todayViews = Visitor::whereDate('created_at', Carbon::today())->count();
        $uniqueVisitors = Visitor::distinct('ip_address')->count('ip_address');
        $todayUnique = Visitor::whereDate('created_at', Carbon::today())->distinct('ip_address')->count('ip_address');
        
        // Online visitors (last 5 minutes)
        $onlineVisitors = Visitor::where('created_at', '>=', Carbon::now()->subMinutes(5))
            ->distinct('ip_address')
            ->count('ip_address');

        // Chart Data: Last 7 days
        $chartData = Visitor::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top Countries
        $topCountries = Visitor::select('country', 'country_code', DB::raw('count(distinct ip_address) as unique_visitors'))
            ->groupBy('country', 'country_code')
            ->orderBy('unique_visitors', 'desc')
            ->take(10)
            ->get();

        // Recent Logs
        $logs = Visitor::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.visitors.index', compact(
            'totalViews', 'todayViews', 'uniqueVisitors', 'todayUnique', 
            'onlineVisitors', 'chartData', 'logs', 'topCountries'
        ));
    }

    /**
     * Helper for sidebar widget data
     */
    public static function getWidgetStats()
    {
        return [
            'today' => Visitor::whereDate('created_at', Carbon::today())->distinct('ip_address')->count('ip_address'),
            'yesterday' => Visitor::whereDate('created_at', Carbon::yesterday())->distinct('ip_address')->count('ip_address'),
            'total' => Visitor::distinct('ip_address')->count('ip_address'),
            'online' => Visitor::where('created_at', '>=', Carbon::now()->subMinutes(5))->distinct('ip_address')->count('ip_address')
        ];
    }
}
