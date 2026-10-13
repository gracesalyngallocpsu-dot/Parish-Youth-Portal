<x-admin-layout title="Edit Announcement">
    <div class="max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
        <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}">
            @csrf
            @method('PUT')
            @include('admin.announcements.partials.form', ['announcement' => $announcement])

            <div class="mt-8 flex items-center gap-3">
                <x-primary-button>Save changes</x-primary-button>
                <a href="{{ route('admin.announcements.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
