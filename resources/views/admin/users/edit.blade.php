
@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit User</h1>
            <p class="text-gray-500 mt-1">Update the account details for {{ $user->name }}.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 whitespace-nowrap">
            &larr; Back to List
        </a>
    </div>

    @if($errors->any())<div class="p-4 bg-red-100 text-red-800 mb-4">Please fix the errors below.</div>@endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            @error('name')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            @error('email')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold">Password (leave blank to keep)</label>
                <input type="password" name="password" class="w-full mt-1 p-3 border border-gray-300 rounded-lg">
                @error('password')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full mt-1 p-3 border border-gray-300 rounded-lg">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold">Role</label>
            <select name="role" class="w-full mt-1 p-3 border border-gray-300 rounded-lg">
                <option value="admin" {{ (old('role', $user->role) === 'admin') ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('admin.users.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">Cancel</a>
            <button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">Save Changes</button>
        </div>
    </form>
</div>
@endsection

