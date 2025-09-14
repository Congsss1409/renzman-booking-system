@extends('layouts.admin')

@section('title', 'Edit Therapist')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-2xl mx-auto">
        <!-- Page Header -->
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">Edit Therapist</h2>
                <p class="mt-1.5 text-sm text-gray-500">Update the details for "{{ $therapist->name }}".</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="mt-8 bg-white border border-gray-200 rounded-xl shadow-sm">
            <form action="{{ route('admin.therapists.update', $therapist) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Therapist Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $therapist->name) }}" required
                               class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('name') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch</label>
                        <select name="branch_id" id="branch_id" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select a branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $therapist->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Update Profile Image</label>
                        <div class="flex items-center gap-4 mt-1">
                            @if ($therapist->image)
                                <img class="object-cover w-16 h-16 rounded-full" src="{{ Illuminate\Support\Facades\Storage::url($therapist->image) }}" alt="{{ $therapist->name }}">
                            @else
                                <div class="flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            <input type="file" name="image" id="image"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        @error('image') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-6 mt-6 border-t border-gray-200 flex items-center justify-end gap-x-3">
                    <a href="{{ route('admin.therapists.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">
                        Update Therapist
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
