@extends('layouts.booking')

@section('content')
<div class="text-center py-10">
    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
        <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <h2 class="text-3xl font-bold text-gray-800">Booking Confirmed!</h2>
    <p class="text-gray-600 mt-2 max-w-md mx-auto">Thank you for your booking. A confirmation email with all the details has been sent to your email address.</p>
    <div class="mt-8">
        <a href="{{ route('landing') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Back to Homepage
        </a>
    </div>
</div>
@endsection
