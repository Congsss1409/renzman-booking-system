{{-- resources/views/feedback/already-submitted.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-2xl text-center">
    <div class="bg-white p-8 sm:p-12 rounded-2xl shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Feedback Already Submitted</h1>
        <p class="text-gray-600 text-lg mb-8">Thank you, but it looks like you have already left feedback for this appointment.</p>
        <a href="/" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
            Back to Homepage
        </a>
    </div>
</div>
@endsection
