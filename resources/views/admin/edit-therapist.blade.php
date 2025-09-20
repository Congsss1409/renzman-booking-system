@extends('layouts.admin')

@section('title', 'Edit Therapist')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Therapist</h1>
            <p class="text-gray-500 mt-1">Update the details for {{ $therapist->name }}.</p>
        </div>
        <a href="{{ route('admin.therapists.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 whitespace-nowrap">
            &larr; Back to List
        </a>
    </div>

    <!-- Edit Therapist Form -->
    <form action="{{ route('admin.therapists.update', $therapist->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Therapist Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">Therapist Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $therapist->name) }}" required
                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                   placeholder="e.g., Jane Doe">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Branch -->
        <div>
            <label for="branch_id" class="block text-sm font-semibold text-gray-600 mb-2">Branch</label>
            <select id="branch_id" name="branch_id" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 appearance-none bg-white">
                <option value="" disabled>Select a branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id', $therapist->branch_id) == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
            @error('branch_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image" class="block text-sm font-semibold text-gray-600 mb-2">Change Therapist Photo (Optional)</label>
            <div x-data="{ imagePreview: '{{ $therapist->image_url ? $therapist->image_url . '?v=' . $therapist->updated_at->timestamp : '' }}' }" class="flex items-center gap-4">
                <img :src="imagePreview" alt="Current or new image preview" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300" x-show="imagePreview">
                 <div x-show="!imagePreview" class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                </div>
                <input type="file" id="image" name="image" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-teal-50 file:text-teal-700
                    hover:file:bg-teal-100"
                    @change="imagePreview = URL.createObjectURL($event.target.files[0])">
            </div>
             @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Form Actions -->
        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('admin.therapists.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">
                Cancel
            </a>
            <button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">
                Update Therapist
            </button>
        </div>
    </form>
</div>
@endsection

