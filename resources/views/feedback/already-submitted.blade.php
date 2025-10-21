@extends('layouts.app')

@section('title', 'Feedback Submitted')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white shadow rounded-lg p-8 text-center">
        <h1 class="text-2xl font-bold text-teal-600 mb-4">Thank you!</h1>
        <p class="text-gray-600">We already received your feedback for this booking. We appreciate you taking the time to help us improve.</p>
        <div class="mt-6">
            <a href="/" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md">Return to home</a>
        </div>
    </div>
</div>
@endsection
