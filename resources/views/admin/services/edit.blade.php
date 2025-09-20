@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Service</h1>
            <p class="text-gray-500 mt-1">Update the details for {{ $service->name }}.</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 whitespace-nowrap">
            &larr; Back to List
        </a>
    </div>

    <!-- Edit Service Form -->
    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">Service Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="e.g., Full Body Massage">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-gray-600 mb-2">Description (Optional)</label>
            <textarea id="description" name="description" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="A brief description of the service...">{{ old('description', $service->description) }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-600 mb-2">Price (₱)</label>
                <input type="number" id="price" name="price" value="{{ old('price', $service->price) }}" required step="0.01" min="0" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="e.g., 500.00">
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="duration" class="block text-sm font-semibold text-gray-600 mb-2">Duration (minutes)</label>
                <input type="number" id="duration" name="duration" value="{{ old('duration', $service->duration) }}" required min="1" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="e.g., 60">
                @error('duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('admin.services.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">Cancel</a>
            <button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">Update Service</button>
        </div>
    </form>
</div>
@endsection
