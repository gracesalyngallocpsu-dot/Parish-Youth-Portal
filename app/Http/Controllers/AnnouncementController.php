<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::published()->latestFirst()->paginate(9);

        return view('announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement): View
    {
        abort_unless($announcement->is_published, 404);

        return view('announcements.show', compact('announcement'));
    }
}
