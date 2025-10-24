@extends('layouts.admin')

@section('title', 'Create Branch')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Add New Branch</h1>
            <p class="text-gray-500 mt-1">Fill in the details to add a new branch to your business.</p>
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

    <!-- Add Branch Form -->
    <form action="{{ route('admin.branches.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Branch Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">Branch Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                   placeholder="e.g., Main Branch">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="block text-sm font-semibold text-gray-600 mb-2">Address</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                   placeholder="e.g., 123 Main St, City">
            @error('address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image" class="block text-sm font-semibold text-gray-600 mb-2">Branch Photo (Optional)</label>
            <div class="flex items-center gap-4">
                <img id="preview" src="{{ asset('images/branch-placeholder.jpg') }}" alt="Preview" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                <input type="file" id="image" name="image" accept="image/*"
                       class="block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-teal-50 file:text-teal-700
                       hover:file:bg-teal-100">
            </div>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('admin.branches.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">
                Cancel
            </a>
            <button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">
                Create Branch
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
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
                preview.src = "{{ asset('images/branch-placeholder.jpg') }}";
            }
        });
    }
});
</script>
@endpush

@push('scripts')
<script>
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
                preview.src = "{{ asset('images/branch-placeholder.jpg') }}";
            }
        });
    }
});
</script>
@endpush
