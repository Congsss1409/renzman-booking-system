    @extends('layouts.admin')

    @section('title', 'Edit Service')

    @section('content')
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-2xl mx-auto">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">Edit Service</h2>
                    <p class="mt-1.5 text-sm text-gray-500">Update the details for "{{ $service->name }}".</p>
                </div>
            </div>

            <div class="mt-8 bg-white border border-gray-200 rounded-xl shadow-sm">
                <form action="{{ route('admin.services.update', $service) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $service->description) }}</textarea>
                            @error('description') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price (₱)</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $service->price) }}" step="0.01" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('price') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                                <input type="number" name="duration" id="duration" value="{{ old('duration', $service->duration) }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('duration') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-gray-200 flex items-center justify-end gap-x-3">
                        <a href="{{ route('admin.services.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">Update Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
    
