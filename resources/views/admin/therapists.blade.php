{{-- resources/views/admin/therapists.blade.php --}}
@extends('layouts.admin')

@section('header', 'Manage Therapists')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Therapist Roster</h2>
        
        <form action="{{ route('admin.therapists.index') }}" method="GET" class="flex-grow md:max-w-md">
            <div class="flex">
                <input type="text" name="search" class="w-full p-2 border border-gray-300 rounded-l-lg focus:ring-emerald-500 focus:border-emerald-500" placeholder="Search by name..." value="{{ request('search') }}">
                <button type="submit" class="bg-gray-800 text-white p-2 rounded-r-lg hover:bg-emerald-700">Search</button>
            </div>
        </form>

        <a href="{{ route('admin.therapists.create') }}" class="bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors shadow-md w-full md:w-auto text-center">
            + New Therapist
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Photo</th>
                    
                    {{-- Sortable Name Header --}}
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">
                        <a href="{{ route('admin.therapists.index', ['sort_by' => 'name', 'sort_order' => ($sortBy == 'name' && $sortOrder == 'asc' ? 'desc' : 'asc')]) }}">
                            Name
                            @if ($sortBy == 'name')
                                <span>{{ $sortOrder == 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    
                    {{-- Sortable Branch Header --}}
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">
                        <a href="{{ route('admin.therapists.index', ['sort_by' => 'branch', 'sort_order' => ($sortBy == 'branch' && $sortOrder == 'asc' ? 'desc' : 'asc')]) }}">
                            Assigned Branch
                            @if ($sortBy == 'branch')
                                <span>{{ $sortOrder == 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>

                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($therapists as $therapist)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <img src="{{ $therapist->image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($therapist->name) . '&color=FFFFFF&background=059669' }}" alt="Photo of {{ $therapist->name }}" class="h-12 w-12 rounded-full object-cover">
                        </td>
                        <td class="py-3 px-4 font-semibold">{{ $therapist->name }}</td>
                        <td class="py-3 px-4">{{ $therapist->branch->name ?? 'Not Assigned' }}</td>
                        <td class="py-3 px-4 flex items-center space-x-4">
                            <a href="{{ route('admin.therapists.edit', $therapist) }}" class="text-blue-500 hover:text-blue-700 font-semibold">Edit</a>
                            <form action="{{ route('admin.therapists.destroy', $therapist) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this therapist? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">No therapists found for your search.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
