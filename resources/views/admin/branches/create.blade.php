@extends('layouts.admin')

@section('title', 'Create Branch')

@section('content')
<div class="container mx-auto p-4">
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Add New Branch</h1>

        @if($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.branches.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" class="mt-1 block w-full border-gray-200 rounded" value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Address</label>
                <input type="text" name="address" class="mt-1 block w-full border-gray-200 rounded" value="{{ old('address') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Image (optional)</label>
                <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full">
                <img id="preview" src="{{ asset('images/branch-placeholder.svg') }}" alt="Preview" class="mt-4 w-40 h-32 object-cover rounded" />
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.branches.index') }}" class="mr-2 inline-block px-4 py-2 rounded bg-gray-200">Cancel</a>
                <button class="px-6 py-2 rounded bg-cyan-500 text-white font-semibold">Create Branch</button>
            </div>
        </form>
    </div>
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
                preview.src = "{{ asset('images/branch-placeholder.svg') }}";
            }
        });
    }
});
</script>
@endpush
