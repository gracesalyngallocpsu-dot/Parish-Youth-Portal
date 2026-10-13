<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $activities = Activity::published()->upcoming()->take(3)->get();
        $announcements = Announcement::published()->latestFirst()->take(3)->get();

        return view('home', compact('activities', 'announcements'));
    }
}
