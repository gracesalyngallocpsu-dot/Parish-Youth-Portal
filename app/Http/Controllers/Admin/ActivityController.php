<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreActivityRequest;
use App\Http\Requests\Admin\UpdateActivityRequest;
use App\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $activities = Activity::withCount('registrations')
            ->when($request->query('q'), fn ($q, $term) => $q->where('title', 'like', "%{$term}%"))
            ->orderByDesc('starts_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.activities.index', compact('activities'));
    }

    public function create(): View
    {
        return view('admin.activities.create', ['activity' => new Activity]);
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Activity::generateSlug($data['title']);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('activities', 'public');
        }

        unset($data['image']);

        Activity::create($data);

        return redirect()
            ->route('admin.activities.index')
            ->with('success', 'Activity created successfully.');
    }

    public function edit(Activity $activity): View
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Activity::generateSlug($data['title'], $activity->id);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            if ($activity->image_path) {
                Storage::disk('public')->delete($activity->image_path);
            }

            $data['image_path'] = $request->file('image')->store('activities', 'public');
        }

        unset($data['image']);

        $activity->update($data);

        return redirect()
            ->route('admin.activities.index')
            ->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        if ($activity->image_path) {
            Storage::disk('public')->delete($activity->image_path);
        }

        $activity->delete();

        return redirect()
            ->route('admin.activities.index')
            ->with('success', 'Activity deleted.');
    }
}
