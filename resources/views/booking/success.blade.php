{{-- resources/views/booking/success.blade.php --}}
@extends('layouts.app')

@section('content')
{{-- This wrapper will ensure the content fills the screen height, pushing the footer down --}}
<div class="flex items-center justify-center" style="min-height: calc(100vh - 144px);"> 
    {{-- 144px is the combined height of the header (80px) and footer (64px) --}}
    
    <div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-2xl text-center">
        <div class="bg-white p-8 sm:p-12 rounded-2xl shadow-lg">
            <div class="mx-auto bg-emerald-100 rounded-full h-20 w-20 flex items-center justify-center mb-6">
                <svg class="h-12 w-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Booking Confirmed!</h1>
            <p class="text-gray-600 text-lg mb-8">Thank you for scheduling your appointment with us. A confirmation email has been sent to you. We look forward to seeing you!</p>
            <a href="/" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                Back to Homepage
            </a>
        </div>
    </div>

</div>
@endsection
