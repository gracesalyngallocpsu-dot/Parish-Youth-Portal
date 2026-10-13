<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Registration;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'activities' => Activity::count(),
            'upcoming' => Activity::published()->upcoming()->count(),
            'registrations' => Registration::count(),
            'announcements' => Announcement::count(),
        ];

        $recentRegistrations = Registration::with('activity')->latest()->take(5)->get();
        $nextActivities = Activity::published()->upcoming()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'nextActivities'));
    }
}
