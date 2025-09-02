@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">
    
    {{-- Left Column: Information Panel --}}
    <div class="w-full md:w-1/3 bg-emerald-700 text-white p-8 flex flex-col justify-center">
        <div>
            <h1 class="text-3xl font-bold mb-4">Schedule Your Session</h1>
            <p class="text-emerald-100 mb-6">
                Select your desired date and time. Our system shows only the available slots for your chosen therapist and service.
            </p>
            <div class="border-t border-emerald-500 pt-6 space-y-4 text-emerald-200">
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">✓</span>
                    <span>Branch & Service</span>
                </div>
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">✓</span>
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

    {{-- Right Column: Main Content --}}
    <div class="w-full md:w-2/3 bg-white p-8 lg:p-12 overflow-y-auto">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Step 3: Select Date & Time with {{ $therapist->name }}</h2>
            
            <form action="{{ route('booking.store.step-three') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" name="booking_date" id="booking_date" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 transition" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Available Times</label>
                        <div id="time-slots" class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                            <p class="col-span-full text-sm text-gray-500">Please select a date to see available times.</p>
                        </div>
                        <input type="hidden" name="booking_time" id="booking_time" required>
                        @error('booking_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-10 flex justify-between items-center border-t pt-6">
                    <a href="{{ route('booking.create.step-two') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        &larr; Back to Therapists
                    </a>
                    <button type="submit" id="submit-button" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-700 transition-colors shadow-md disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                        Next: Your Details &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('booking_date');
        const timeSlotsContainer = document.getElementById('time-slots');
        const hiddenTimeInput = document.getElementById('booking_time');
        const submitButton = document.getElementById('submit-button');
        let selectedTimeButton = null;

        const serviceId = "{{ $booking->service_id }}";

        dateInput.addEventListener('change', function () {
            const selectedDate = this.value;
            if (!selectedDate) return;

            timeSlotsContainer.innerHTML = '<p class="col-span-full text-center py-4">Loading times...</p>';
            hiddenTimeInput.value = '';
            submitButton.disabled = true;
            if (selectedTimeButton) {
                selectedTimeButton.classList.remove('bg-emerald-700', 'text-white');
            }

            fetch(`/api/therapists/{{ $therapist->id }}/availability/${selectedDate}/${serviceId}`)
                .then(response => response.json())
                .then(unavailableSlots => { // API now returns all unavailable slots
                    timeSlotsContainer.innerHTML = '';
                    let availableSlotFound = false;

                    // Generate all hourly slots
                    for (let hour = 8; hour < 21; hour++) {
                        const time24 = `${String(hour).padStart(2, '0')}:00`;
                        const displayTime = new Date(`1970-01-01T${time24}:00`).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                        
                        // Check if the slot is in the unavailable list
                        const isUnavailable = unavailableSlots.includes(time24);
                        
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.textContent = displayTime;
                        button.dataset.time = displayTime;
                        button.dataset.time24 = time24;

                        if (isUnavailable) {
                            button.disabled = true;
                            button.className = 'py-2 px-2 rounded-lg text-sm font-medium bg-gray-200 text-gray-400 cursor-not-allowed';
                        } else {
                            availableSlotFound = true;
                            button.className = 'py-2 px-2 rounded-lg text-sm font-medium bg-emerald-100 text-emerald-800 hover:bg-emerald-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500';
                        }
                        
                        timeSlotsContainer.appendChild(button);
                    }

                    if (!availableSlotFound) {
                        timeSlotsContainer.innerHTML = '<p class="col-span-full text-sm text-gray-500">No available time slots for this day.</p>';
                    }

                    disablePastTimes();
                });
        });

        timeSlotsContainer.addEventListener('click', function(e) {
            if (e.target.tagName === 'BUTTON' && !e.target.disabled) {
                if (selectedTimeButton) {
                    selectedTimeButton.classList.remove('bg-emerald-700', 'text-white');
                    selectedTimeButton.classList.add('bg-emerald-100', 'text-emerald-800');
                }
                selectedTimeButton = e.target;
                selectedTimeButton.classList.add('bg-emerald-700', 'text-white');
                selectedTimeButton.classList.remove('bg-emerald-100', 'text-emerald-800');
                
                hiddenTimeInput.value = selectedTimeButton.dataset.time;
                submitButton.disabled = false;
            }
        });

        function disablePastTimes() {
            const todayString = new Date().toLocaleDateString('en-CA');
            if (dateInput.value === todayString) {
                const now = new Date();
                const currentTime = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
                
                timeSlotsContainer.querySelectorAll('button').forEach(button => {
                    if (button.dataset.time24 < currentTime && !button.disabled) {
                        button.disabled = true;
                        button.className = 'py-2 px-2 rounded-lg text-sm font-medium bg-gray-200 text-gray-400 cursor-not-allowed';
                    }
                });
            }
        }
    });
</script>
@endsection