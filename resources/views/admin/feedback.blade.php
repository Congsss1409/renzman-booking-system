@extends('layouts.admin')

@section('title', 'Client Feedback')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">Client Feedback</h2>
            <p class="mt-1.5 text-sm text-gray-500">Review ratings and comments submitted by your clients.</p>
        </div>
    </div>

    <div class="mt-8">
        @if (session('success'))
            <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if($feedbacks->isEmpty())
            <div class="py-20 text-center bg-white border border-gray-200 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-800">No Feedback Yet</h3>
                <p class="mt-1 text-sm text-gray-500">Client feedback will appear here once submitted.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($feedbacks as $feedback)
                    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                        <div class="flex flex-col sm:flex-row items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center flex-wrap">
                                    <p class="font-bold text-gray-900">{{ $feedback->client_name }}</p>
                                    <span class="mx-2 text-gray-300 hidden sm:block">&bull;</span>
                                    <p class="text-sm text-gray-600 mt-1 sm:mt-0 w-full sm:w-auto">for <span class="font-medium">{{ $feedback->service->name }}</span> with <span class="font-medium">{{ $feedback->therapist->name }}</span></p>
                                </div>
                                <div class="flex items-center mt-1">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 {{ $i < $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                @if($feedback->feedback)
                                <blockquote class="mt-4 italic text-gray-700 bg-gray-50 p-4 rounded-lg border-l-4 border-gray-200">
                                    "{{ $feedback->feedback }}"
                                </blockquote>
                                @endif
                            </div>

                            @if ($feedback->rating == 5 && !empty($feedback->feedback))
                                <div class="flex-shrink-0 sm:ml-6 mt-4 sm:mt-0 w-full sm:w-auto text-left sm:text-right">
                                    <form action="{{ route('admin.feedback.toggle', $feedback) }}" method="POST">
                                        @csrf
                                        <label for="show-{{ $feedback->id }}" class="flex items-center sm:justify-end cursor-pointer">
                                            <span class="mr-3 text-sm font-medium text-gray-700">Show on Landing</span>
                                            <div class="relative">
                                                <input type="checkbox" id="show-{{ $feedback->id }}" class="sr-only peer" onchange="this.form.submit()" {{ $feedback->show_on_landing ? 'checked' : '' }}>
                                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                            </div>
                                        </label>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <p class="mt-4 text-xs text-right text-gray-400">
                            Booked on {{ $feedback->start_time->format('M d, Y') }}
                        </p>
                    </div>
                @endforeach
            </div>

            @if ($feedbacks->hasPages())
                <div class="mt-8">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

