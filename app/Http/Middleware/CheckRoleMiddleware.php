<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role, $roles)) {
            return response()->json([
                'message' => 'Yetkiniz olmayan bir alana erişmeye çalışıyorsunuz, Lütfen yetkiniz dahilindeki alanlara erişim sağlayın.',
                'code' => 403
            ], 403);
        }

        return $next($request);
    }
}
