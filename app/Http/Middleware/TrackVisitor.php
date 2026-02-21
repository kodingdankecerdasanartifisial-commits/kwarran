<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Don't track admin requests or AJAX/Internal
        if (!$request->is('admin*') && !$request->ajax()) {
            $ip = $request->ip();
            $country = 'Indonesia'; // Default
            $countryCode = 'ID';

            // Only lookup if not localhost
            if ($ip !== '127.0.0.1' && $ip !== '::1') {
                try {
                    $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode");
                    if ($response->successful() && $response->json('status') === 'success') {
                        $country = $response->json('country');
                        $countryCode = $response->json('countryCode');
                    }
                } catch (\Exception $e) {
                    // Fail silently
                }
            }

            Visitor::create([
                'ip_address' => $ip,
                'country' => $country,
                'country_code' => $countryCode,
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
            ]);
        }

        return $next($request);
    }
}
