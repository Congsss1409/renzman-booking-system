@extends('layouts.admin')

@section('title', 'Branches Management')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Branches <span class="text-teal-500">Management</span></h1>
            <p class="text-gray-500 mt-1">Add, edit, or manage your branches and their images.</p>
        </div>
        <a href="{{ route('admin.branches.create') }}" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-6 rounded-full shadow-lg transition-transform transform hover:scale-105 whitespace-nowrap">
            + ADD BRANCH
        </a>
    </div>

    <!-- Branches Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($branches as $branch)
            <div class="bg-stone-50 rounded-2xl p-6 text-center shadow-lg border hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                <div>
                    <img src="{{ $branch->image_url ?? asset('images/branch-placeholder.jpg') }}" alt="{{ $branch->name }}" class="w-32 h-32 mx-auto rounded-lg mb-4 object-cover border-4 border-white shadow-md">
                    <h3 class="text-xl font-bold text-gray-800">{{ $branch->name }}</h3>
                    <p class="text-gray-500 mb-2 text-sm">{{ $branch->address ?? 'Address not set' }}</p>
                </div>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="{{ route('admin.branches.edit', $branch) }}" class="font-semibold bg-cyan-400 text-white py-2 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">EDIT IMAGE</a>
                    <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this branch?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-semibold bg-red-500 hover:bg-red-600 text-white py-2 px-8 rounded-full shadow-md transition-transform transform hover:scale-105 ml-2">DELETE</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p class="font-bold text-lg">No branches found.</p>
                <p>Seed some branches or create them from the database.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-8">
        {{ $branches->links() }}
    </div>
</div>
@endsection
