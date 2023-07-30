<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (Auth::guard('teacher')->check()) {
            // Usuario ya está autenticado como teacher, redirigir al dashboard del teacher
            return redirect()->route('teacher_dashboard');
        }

        if (Auth::guard('student')->check()) {
            // Usuario ya está autenticado como student, redirigir al dashboard del student
            return redirect()->route('student_dashboard');
        }

        return $next($request);
    }
}
