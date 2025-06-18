<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $requiredRole
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $requiredRole)
    {
        $currentRole = session('user_role');

        // Jika belum login atau role tidak cocok, arahkan ke halaman sesuai role atau login
        if (!$currentRole) {
            return redirect()->route('login');
        }

        if ($currentRole !== $requiredRole) {
            // Arahkan ke dashboard yang sesuai dengan role-nya
            if ($currentRole === 'Operator') {
                return redirect()->route('operator.dashboard');
            } elseif ($currentRole === 'Administrator') {
                return redirect()->route('admin.dashboard');
            }

            // Tambahkan role lain jika ada
        }

        return $next($request);
    }
}
