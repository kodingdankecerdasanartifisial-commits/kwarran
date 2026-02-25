<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permissions): Response
    {
        $permissionArray = explode(',', $permissions);
        $hasAccess = false;

        foreach ($permissionArray as $perm) {
            $perm = trim($perm);
            if ($request->user() && ($request->user()->hasPermission($perm) || $request->user()->role === $perm)) {
                $hasAccess = true;
                break;
            }

            // FIX: Izinkan role 'dkr' untuk mengakses halaman dengan permission 'posts'
            if ($request->user() && $request->user()->role === 'dkr' && $perm === 'posts') {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}
