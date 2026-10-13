<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Activity;
use Illuminate\Http\RedirectResponse;

class RegistrationController extends Controller
{
    public function store(StoreRegistrationRequest $request, Activity $activity): RedirectResponse
    {
        abort_unless($activity->is_published, 404);

        $activity->registrations()->create($request->validated());

        return redirect()
            ->route('activities.show', $activity)
            ->with('success', 'Your registration has been received. See you there!');
    }
}
