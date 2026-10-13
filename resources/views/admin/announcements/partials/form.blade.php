@php
    $publishedChecked = old('is_published', $announcement->exists ? $announcement->is_published : true);
    $publishedAtValue = old('published_at', optional($announcement->published_at)->format('Y-m-d\TH:i'));
@endphp

<div class="grid gap-5">
    <div>
        <x-input-label for="title" value="Title" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $announcement->title)" required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="body" value="Body" />
        <textarea id="body" name="body" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-parish-500 focus:ring-parish-500" required>{{ old('body', $announcement->body) }}</textarea>
        <x-input-error :messages="$errors->get('body')" class="mt-2" />
    </div>

    <div class="sm:max-w-xs">
        <x-input-label for="published_at" value="Publish date (optional)" />
        <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1 block w-full" :value="$publishedAtValue" />
        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
    </div>

    <div>
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_published" value="1" @checked($publishedChecked)
                   class="rounded border-gray-300 text-parish-600 shadow-sm focus:ring-parish-500">
            <span class="text-sm font-medium text-slate-700">Publish this announcement</span>
        </label>
    </div>
</div>
