<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin) {

            return view('dashboard', [
                'totalReports' => Report::count(),
                'pendingReports' => Report::where('status_id', 1)->count(),
                'resolvedReports' => Report::where('status_id', 2)->count(),
                'rejectedReports' => Report::where('status_id', 3)->count(),
                'recentReports' => Report::with('status')
                    ->latest()
                    ->take(5)
                    ->get()
            ]);
        } else {

            return view('dashboard', [
                'userReportsCount' => Report::where('user_id', Auth::id())->count(),
                'userPendingReports' => Report::where('user_id', Auth::id())->where('status_id', 1)->count(),
                'userResolvedReports' => Report::where('user_id', Auth::id())->where('status_id', 2)->count(),
                'recentReports' => Report::with('status')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->take(5)
                    ->get()
            ]);
        }
    }
}