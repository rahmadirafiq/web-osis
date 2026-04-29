<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestCustom {
    public function handle(Request $request, Closure $next) {
        if (session('siswa_id')) return redirect('/siswa/dashboard');
        if (session('admin_id')) return redirect('/admin/dashboard');
        return $next($request);
    }
}