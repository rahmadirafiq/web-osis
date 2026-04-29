<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogController extends Controller {
    public function index(Request $request) {
        $q = ActivityLog::query();
        if ($request->role)   $q->where('role', $request->role);
        if ($request->action) $q->where('action','like',"%{$request->action}%");
        $logs = $q->orderByDesc('created_at')->paginate(25)->withQueryString();
        return view('admin.logs', compact('logs'));
    }
}