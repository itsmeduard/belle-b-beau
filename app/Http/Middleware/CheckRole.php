<?php
namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        abort_if($role == 'admin' && auth()->user()->role != 1, 403);

//        abort_if($role == 'superadmin' && Auth::user()->role != 3, 403);

        return $next($request);
    }
}
