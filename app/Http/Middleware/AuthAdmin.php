<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAdmin {
    public function handle(Request $request, Closure $next) {
        if (!session('admin_id')) {
            return redirect('/login')->with('error', 'Silakan login sebagai admin.');
        }
        return $next($request);
    }
}