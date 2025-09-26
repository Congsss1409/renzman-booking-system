
@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Users <span class="text-teal-500">Management</span></h1>
            <p class="text-gray-500 mt-1">Add, edit, or remove admin users. Therapist management is separate.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-6 rounded-full shadow-lg transition-transform transform hover:scale-105 whitespace-nowrap">
            + ADD USER
        </a>
    </div>

    @if(session('success'))<div class="p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>@endif

    <!-- Users Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($users as $user)
            <div class="bg-stone-50 rounded-2xl p-6 text-center shadow-lg border hover:shadow-xl transition-shadow duration-300">
                <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=FFFFFF&background=059669&size=128' }}" alt="{{ $user->name }}" class="w-24 h-24 mx-auto rounded-full mb-4 object-cover border-4 border-white shadow-md">
                <p class="text-xl font-bold text-gray-800">{{ $user->name }}</p>
                <p class="font-semibold text-teal-500">{{ ucfirst($user->role ?? 'user') }}</p>
                <p class="text-gray-500 mt-2 text-sm">{{ $user->email }}</p>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="{{ route('admin.users.edit', $user) }}" class="font-semibold bg-cyan-400 text-white py-2 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">EDIT</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">
                        @csrf
                        <button type="button" class="font-semibold bg-red-500 text-white py-2 px-8 rounded-full shadow-md transition-transform transform hover:scale-105 delete-button">DELETE</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p class="font-bold text-lg">No users found.</p>
                <p>Click the "Add User" button to get started.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-8">
        {{ $users->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#14b8a6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    // submit form via POST with CSRF token
                    form.submit();
                }
            })
        });
    });
});
</script>
@endpush
