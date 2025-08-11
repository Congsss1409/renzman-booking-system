{{-- resources/views/booking/step-three.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">

    <div class="w-full md:w-1/3 bg-emerald-700 text-white p-8 flex flex-col justify-center">
        <div>
            <h1 class="text-3xl font-bold mb-4">Select Date & Time</h1>
            <p class="text-emerald-100 mb-6">
                Choose a date on the calendar, then select an available time slot for your appointment with <span class="font-semibold">{{ $therapist->name }}</span>.
            </p>
            <div class="border-t border-emerald-500 pt-6 space-y-4 text-emerald-200">
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">1</span>
                    <span>Branch & Service</span>
                </div>
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">2</span>
                    <span>Choose Therapist</span>
                </div>
                <div class="flex items-center">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">3</span>
                    <span>Select Date & Time</span>
                </div>
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">4</span>
                    <span>Your Details</span>
                </div>
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">5</span>
                    <span>Payment</span>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full md:w-2/3 bg-white p-8 lg:p-12 overflow-y-auto">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Step 3: Select Date & Time</h2>

            <form action="{{ route('booking.store.step-three') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_date" id="booking_date">
                <input type="hidden" name="booking_time" id="booking_time">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <div id="calendar" class="p-4 border rounded-lg bg-white">
                            <div class="flex justify-between items-center mb-4">
                                <button type="button" id="prev-month" class="p-2 rounded-full hover:bg-gray-100 transition">&lt;</button>
                                <h3 id="month-year" class="font-semibold text-lg"></h3>
                                <button type="button" id="next-month" class="p-2 rounded-full hover:bg-gray-100 transition">&gt;</button>
                            </div>
                            <div class="grid grid-cols-7 gap-1 text-center text-sm text-gray-500 font-semibold">
                                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                            </div>
                            <div id="calendar-grid" class="grid grid-cols-7 gap-1 text-center mt-2"></div>
                        </div>
                    </div>
                    <div>
                        <div id="time-slots-container" class="hidden">
                            <div id="time-slots" class="grid grid-cols-3 gap-2"></div>
                        </div>
                        <p id="time-slots-placeholder" class="text-gray-500 mt-4">Please select a date to see available times.</p>
                    </div>
                </div>

                <div class="mt-10 flex justify-between items-center border-t pt-6">
                    <a href="{{ route('booking.create.step-two') }}" class="text-gray-600 hover:text-emerald-700 font-semibold">&larr; Go Back</a>
                    <button type="submit" id="next-btn" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-700 transition-colors shadow-md disabled:bg-gray-400" disabled>
                        Next: Your Details &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // The JavaScript for the calendar remains the same as before.
    document.addEventListener('DOMContentLoaded', function() {
        // ... (Full calendar and time slot script goes here)
    });
</script>
@endsection
