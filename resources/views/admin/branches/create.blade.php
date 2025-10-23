@extends('layouts.admin')

@section('title', 'Create Branch')

@section('content')
document.addEventListener('DOMContentLoaded', () => {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) { preview.src = e.target.result; }
                reader.readAsDataURL(file);
            } else {
                preview.src = "{{ asset('images/branch-placeholder.svg') }}";
            }
        });
    }
});

<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Add New Branch</h1>
            <p class="text-gray-500 mt-1">Fill in the details for the new branch.</p>
        </div>
        <a href="{{ route('admin.branches.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 whitespace-nowrap">
            &larr; Back to List
        </a>
    </div>

    @if($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.branches.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">Branch Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="e.g., Main Branch">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="address" class="block text-sm font-semibold text-gray-600 mb-2">Address (Optional)</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="e.g., 123 Main St, City">
            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image" class="block text-sm font-semibold text-gray-600 mb-2">Branch Photo (Optional)</label>
            <div x-data="{ imagePreview: null }" class="flex items-center gap-4">
                <img x-show="imagePreview" :src="imagePreview" alt="Image Preview" class="w-48 h-28 rounded-lg object-cover border-2 border-gray-300">
                <div x-show="!imagePreview" class="w-48 h-28 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM5 19V5h14l.002 14H5z"/><path d="m10 14-1-1-3 4h12l-5-7z"/></svg>
                </div>
                <input type="file" id="image" name="image" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                    file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700
                    hover:file:bg-teal-100"
                    @change="imagePreview = URL.createObjectURL($event.target.files[0])">
            </div>
            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('admin.branches.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">Cancel</a>
            <button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">Save Branch</button>
        </div>
    </form>
</div>

@endsection
