<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
  /**
   * Handle an incoming request.
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (!Auth::check() || !Auth::user()->is_admin) {
      return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
    }
    return $next($request);
  }
}
