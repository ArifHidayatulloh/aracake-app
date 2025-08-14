<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(!Auth::check()){
            return redirect('login');
        }

        $user = Auth::user();
       // Konversi string peran dari rute ke objek Enum
        $enumRoles = array_map(fn($role) => UserRole::from($role), $roles);

        if (!in_array($user->role, $enumRoles)) {
            // Jika peran tidak sesuai, arahkan ke halaman utama atau halaman lain yang Anda tentukan
            return redirect('/');
        }

        return $next($request);
    }
}
