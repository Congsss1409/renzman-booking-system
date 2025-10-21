@extends('layouts.app')

@section('title', 'Share Feedback')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white shadow rounded-lg p-8">
        <h1 class="text-2xl font-bold text-teal-600 mb-4">We'd love your feedback</h1>
        <p class="text-gray-600 mb-6">Hi {{ $booking->client_name }}, please rate your recent experience and leave an optional comment.</p>

        <form action="{{ route('feedback.store', $booking->feedback_token) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Rating</label>
                <select name="rating" required class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">Select rating</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Feedback (optional)</label>
                <textarea name="feedback" rows="5" class="mt-1 block w-full border-gray-300 rounded-md"></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md">Submit Feedback</button>
                <a href="/" class="text-sm text-gray-500">Skip for now</a>
            </div>
        </form>
    </div>
</div>
@endsection
