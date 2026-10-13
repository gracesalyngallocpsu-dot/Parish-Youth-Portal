@php
    $startsValue = old('starts_at', optional($activity->starts_at)->format('Y-m-d\TH:i'));
    $endsValue = old('ends_at', optional($activity->ends_at)->format('Y-m-d\TH:i'));
    $publishedChecked = old('is_published', $activity->exists ? $activity->is_published : true);
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <x-input-label for="title" value="Title" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $activity->title)" required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-parish-500 focus:ring-parish-500" required>{{ old('description', $activity->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="location" value="Location" />
        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $activity->location)" />
        <x-input-error :messages="$errors->get('location')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="starts_at" value="Starts at" />
        <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="mt-1 block w-full" :value="$startsValue" required />
        <x-input-error :messages="$errors->get('starts_at')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="ends_at" value="Ends at (optional)" />
        <x-text-input id="ends_at" name="ends_at" type="datetime-local" class="mt-1 block w-full" :value="$endsValue" />
        <x-input-error :messages="$errors->get('ends_at')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="image" value="Cover image (optional)" />
        <input id="image" name="image" type="file" accept="image/*"
               class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-parish-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-parish-700 hover:file:bg-parish-100">
        <x-input-error :messages="$errors->get('image')" class="mt-2" />

        @if ($activity->image_url)
            <img src="{{ $activity->image_url }}" alt="Current image" class="mt-3 h-32 w-auto rounded-lg ring-1 ring-slate-200">
        @endif
    </div>

    <div class="sm:col-span-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_published" value="1" @checked($publishedChecked)
                   class="rounded border-gray-300 text-parish-600 shadow-sm focus:ring-parish-500">
            <span class="text-sm font-medium text-slate-700">Publish this activity</span>
        </label>
    </div>
</div>
