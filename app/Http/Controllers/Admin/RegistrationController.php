<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $activityId = $request->query('activity');

        $registrations = Registration::with('activity')
            ->when($activityId, fn ($q) => $q->where('activity_id', $activityId))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $activities = Activity::orderBy('title')->get(['id', 'title']);

        return view('admin.registrations.index', compact('registrations', 'activities', 'activityId'));
    }

    public function export(Request $request): StreamedResponse
    {
        $activityId = $request->query('activity');

        $registrations = Registration::with('activity')
            ->when($activityId, fn ($q) => $q->where('activity_id', $activityId))
            ->latest()
            ->get();

        $filename = 'registrations-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($registrations) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Activity', 'Name', 'Email', 'Phone', 'Notes', 'Registered At']);

            foreach ($registrations as $registration) {
                fputcsv($out, [
                    $registration->activity?->title,
                    $registration->name,
                    $registration->email,
                    $registration->phone,
                    $registration->notes,
                    $registration->created_at->toDateTimeString(),
                ]);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function destroy(Registration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()
            ->route('admin.registrations.index')
            ->with('success', 'Registration removed.');
    }
}
