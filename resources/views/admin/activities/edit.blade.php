<x-admin-layout title="Edit Activity">
    <div class="max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
        <form method="POST" action="{{ route('admin.activities.update', $activity) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.activities.partials.form', ['activity' => $activity])

            <div class="mt-8 flex items-center gap-3">
                <x-primary-button>Save changes</x-primary-button>
                <a href="{{ route('admin.activities.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
