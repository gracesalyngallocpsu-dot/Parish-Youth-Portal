<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->query('filter') === 'past' ? 'past' : 'upcoming';

        $activities = Activity::published()
            ->when($filter === 'past', fn ($q) => $q->past(), fn ($q) => $q->upcoming())
            ->paginate(9)
            ->withQueryString();

        return view('activities.index', compact('activities', 'filter'));
    }

    public function show(Activity $activity): View
    {
        abort_unless($activity->is_published, 404);

        $activity->loadCount('registrations');

        return view('activities.show', compact('activity'));
    }
}
