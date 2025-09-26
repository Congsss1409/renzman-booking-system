@extends('layouts.admin')

@section('title', 'Edit Branch')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-10 rounded-2xl shadow-lg">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Branch</h1>
            <p class="text-gray-500 mt-1">Update the image for <span class="font-semibold">{{ $branch->name }}</span>.</p>
        </div>
        <a href="{{ route('admin.branches.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 whitespace-nowrap">
            &larr; Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.branches.update', $branch) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div x-data="{ imagePreview: '{{ $branch->image_url ?? asset('images/branch-placeholder.svg') }}' }" class="grid grid-cols-1 sm:grid-cols-3 gap-8 items-start">
            <div class="col-span-1 flex justify-center sm:justify-start">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <img :src="imagePreview" alt="Current image preview" class="w-44 h-44 rounded-lg object-cover border-4 border-white shadow-md">
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="image" class="block text-sm font-semibold text-gray-600 mb-3">Change Branch Image</label>
                <input type="file" id="image" name="image" accept="image/*"
                    @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                    class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-teal-50 file:text-teal-700
                        hover:file:bg-teal-100">
                @error('image')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror

                <div class="mt-6 flex flex-wrap items-center gap-4">
                    <button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-6 rounded-full shadow-lg transition-transform transform hover:scale-105">Upload Image</button>
                    <a href="{{ route('admin.branches.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-6 rounded-full shadow-md">Cancel</a>
                </div>

                @if($branch->image_url)
                    <div class="mt-6">
                        <form id="removeImageForm" action="{{ route('admin.branches.remove-image', $branch) }}" method="POST">
                            @csrf
                            <button type="button" id="removeImageButton" class="font-semibold bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded-full shadow">Remove Image</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const removeBtn = document.getElementById('removeImageButton');
    if (removeBtn) {
        removeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Remove image?',
                text: "This will delete the image from storage.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, remove it'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('removeImageForm').submit();
                }
            })
        });
    }
});
</script>
@endpush

@endsection
