{{-- resources/views/admin/create-therapist.blade.php --}}
@extends('layouts.admin')

@section('header', 'Add New Therapist')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">New Therapist Details</h2>

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

    <form action="{{ route('admin.therapists.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Therapist Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
                <label for="branch_id" class="block text-sm font-medium text-gray-700">Assign to Branch</label>
                <select name="branch_id" id="branch_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                    <option value="" disabled selected>Select a Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Upload Photo (Optional)</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.therapists.index') }}" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                Add Therapist
            </button>
        </div>
    </form>
</div>
@endsection
