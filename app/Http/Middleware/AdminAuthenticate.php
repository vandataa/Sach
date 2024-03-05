<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 2)) {
            return $next($request);
        } else if (!Auth::check()) {
            return redirect()->route('login');
        } else {
            $error = 'Bạn không có quuyền truy cập vào trang Admin';
            return redirect()->route('login')->withErrors(['error' => $error])->with('error', $error);
        }
        // return $next($request);
    }
}
