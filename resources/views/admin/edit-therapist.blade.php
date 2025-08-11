{{-- resources/views/admin/edit-therapist.blade.php --}}
@extends('layouts.admin')

@section('header', 'Edit Therapist')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Details for {{ $therapist->name }}</h2>

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Please correct the following errors:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.therapists.update', $therapist) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Therapist Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $therapist->name) }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
                <label for="branch_id" class="block text-sm font-medium text-gray-700">Transfer to Branch</label>
                <select name="branch_id" id="branch_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id', $therapist->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Upload New Photo</label>
                <div class="mt-2 flex items-center">
                    <img src="{{ $therapist->image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($therapist->name) . '&color=FFFFFF&background=059669' }}" alt="Current photo" class="h-16 w-16 rounded-full object-cover mr-4">
                    <input type="file" name="image" id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
                <p class="text-xs text-gray-500 mt-1">Leave blank to keep the current photo.</p>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.therapists.index') }}" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                Update Therapist
            </button>
        </div>
    </form>
</div>
@endsection