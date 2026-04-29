<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSiswa {
    public function handle(Request $request, Closure $next) {
        if (!session('siswa_id')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        return $next($request);
    }
}