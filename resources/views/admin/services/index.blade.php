    @extends('layouts.admin')

    @section('title', 'Manage Services')

    @section('content')
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">Service Management</h2>
                <p class="mt-1.5 text-sm text-gray-500">Manage the services offered at your locations.</p>
            </div>

            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.services.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Service
                </a>
            </div>
        </div>

        <div class="mt-8">
            @if($services->isEmpty())
                <div class="py-20 text-center bg-white border border-gray-200 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-800">No Services Found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by adding your first service.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($services as $service)
                        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl transition hover:shadow-lg">
                            <div class="flex flex-col flex-1 p-6">
                                <h3 class="text-xl font-bold text-gray-900">{{ $service->name }}</h3>
                                <p class="mt-2 text-sm text-gray-500">Duration: {{ $service->duration }} minutes</p>
                                <p class="mt-4 text-2xl font-semibold text-indigo-600">₱{{ number_format($service->price, 2) }}</p>

                                <div class="flex-grow"></div>

                                <div class="flex items-center gap-2 mt-6">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-red-700 bg-red-100 border border-transparent rounded-md hover:bg-red-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($services->hasPages())
                    <div class="mt-8">
                        {{ $services->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
    @endsection
    
