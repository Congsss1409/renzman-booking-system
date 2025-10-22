@extends('layouts.admin')

@section('title', 'Services Management')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Services <span class="text-teal-500">Management</span></h1>
            <p class="text-gray-500 mt-1">Add, edit, or remove the services you offer.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-6 rounded-full shadow-lg transition-transform transform hover:scale-105 whitespace-nowrap">
            + ADD SERVICE
        </a>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($services as $service)
            <div class="bg-stone-50 rounded-2xl p-6 text-center shadow-lg border hover:shadow-xl transition-shadow duration-300 flex flex-col h-full">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $service->name }}</h3>
                    <p class="text-gray-500 mb-2 text-sm">{{ $service->description }}</p>
                    <p class="font-semibold text-teal-500">Duration: {{ $service->duration }} mins</p>
                    <p class="text-4xl font-bold text-gray-800 my-4">₱{{ number_format($service->price, 2) }}</p>
                </div>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:justify-center sm:gap-2">
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="w-full sm:flex-1 font-semibold bg-cyan-400 text-white py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105">EDIT</a>
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="delete-form w-full sm:flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="w-full font-semibold bg-red-500 text-white py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 delete-button">DELETE</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p class="font-bold text-lg">No services found.</p>
                <p>Click the "Add Service" button to get started.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-8">
        {{ $services->links() }}
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
                        didOpen: () => { Swal.showLoading(); }
                    });
                    form.submit();
                }
            })
        });
    });
});
</script>
@endpush
