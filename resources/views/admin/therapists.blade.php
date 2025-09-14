@extends('layouts.admin')

@section('title', 'Manage Therapists')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">Therapist Management</h2>
            <p class="mt-1.5 text-sm text-gray-500">Add, edit, or remove therapists from your team.</p>
        </div>

        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.therapists.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Therapist
            </a>
        </div>
    </div>

    <!-- Therapist Cards Grid -->
    <div class="mt-8">
        @if($therapists->isEmpty())
            <div class="py-20 text-center bg-white border border-gray-200 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962A3 3 0 013 10.5V12a9 9 0 0118 0v-1.5a3 3 0 01-3-3H6a3 3 0 01-3 3v1.5a3 3 0 013 3m12-9.75a3 3 0 01-3-3H6a3 3 0 01-3 3v1.5a3 3 0 013 3" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-800">No Therapists Found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by adding your first therapist.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($therapists as $therapist)
                    <div class="flex flex-col text-center bg-white border border-gray-200 rounded-xl shadow-sm transition hover:shadow-lg">
                        <div class="flex-shrink-0">
                            @if ($therapist->image)
                                <img class="object-cover w-full h-48 rounded-t-xl" src="{{ Illuminate\Support\Facades\Storage::url($therapist->image) }}" alt="{{ $therapist->name }}">
                            @else
                                <!-- Placeholder SVG Avatar -->
                                <div class="flex items-center justify-center w-full h-48 bg-gray-100 rounded-t-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col flex-1 p-4">
                            <h3 class="text-lg font-bold text-gray-900">{{ $therapist->name }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $therapist->branch->name }}</p>

                            <div class="flex-grow"></div> <!-- Pushes actions to the bottom -->

                            <div class="flex items-center justify-center gap-2 mt-4">
                                <a href="{{ route('admin.therapists.edit', $therapist) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                    Edit
                                </a>
                                <form action="{{ route('admin.therapists.destroy', $therapist) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this therapist? This action cannot be undone.');" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-red-700 bg-red-100 border border-transparent rounded-md hover:bg-red-200">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($therapists->hasPages())
                <div class="mt-8">
                    {{ $therapists->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
