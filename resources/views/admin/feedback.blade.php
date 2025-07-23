{{-- resources/views/admin/feedback.blade.php --}}
@extends('layouts.admin')

@section('header', 'Client Feedback')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Submitted Reviews</h2>
    
    <div class="space-y-6">
        @forelse ($feedbacks as $feedback)
            <div class="border rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold text-lg">{{ $feedback->client_name }}</p>
                        <p class="text-sm text-gray-500">
                            For: {{ $feedback->service->name }} with {{ $feedback->therapist->name }} at {{ $feedback->branch->name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Date: {{ $feedback->start_time->format('F j, Y') }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-1 text-yellow-400 text-xl">
                        @for ($i = 0; $i < $feedback->rating; $i++)
                            <span>&#9733;</span>
                        @endfor
                        @for ($i = $feedback->rating; $i < 5; $i++)
                            <span class="text-gray-300">&#9733;</span>
                        @endfor
                    </div>
                </div>
                @if ($feedback->feedback)
                    <div class="mt-4 text-gray-700 bg-gray-50 p-3 rounded-md">
                        <p>{{ $feedback->feedback }}</p>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-center text-gray-500 py-8">No feedback has been submitted yet.</p>
        @endforelse
    </div>
</div>
@endsection
