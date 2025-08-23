<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $userPermissions = session('user_permissions', []);

        if (!in_array($permission, $userPermissions)) {
            Log::warning('Unauthorized access attempt', [
                'user' => $request->user() ? $request->user()->email : 'unknown',
                'permission' => $permission,
            ]);
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}