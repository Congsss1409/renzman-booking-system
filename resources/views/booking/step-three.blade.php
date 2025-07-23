{{-- resources/views/booking/step-three.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-4xl">
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">

        <h1 class="text-2xl sm:text-3xl font-bold text-center text-emerald-700 mb-2">Step 3: Select Date & Time</h1>
        <p class="text-center text-gray-600 mb-8">
            You are booking with: <span class="font-semibold">{{ $therapist->name }}</span>
        </p>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Please correct the following errors:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking.store.step-three') }}" method="POST">
            @csrf
            <input type="hidden" name="booking_date" id="booking_date">
            <input type="hidden" name="booking_time" id="booking_time">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Calendar -->
                <div>
                    <h2 class="text-xl font-semibold mb-3 text-gray-700">Choose a Date</h2>
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

                <!-- Time Slots -->
                <div>
                    <h2 class="text-xl font-semibold mb-3 text-gray-700">Choose a Time</h2>
                    <div id="time-slots-container" class="hidden">
                        <div id="time-slots" class="grid grid-cols-3 gap-2"></div>
                    </div>
                    <p id="time-slots-placeholder" class="text-gray-500 mt-4">Please select a date to see available times.</p>
                </div>
            </div>

            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('booking.create.step-two') }}" class="text-gray-600 hover:text-emerald-700">&larr; Back to Therapist</a>
                <button type="submit" id="next-btn" class="bg-emerald-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-emerald-700 transition-colors shadow-md disabled:bg-gray-400" disabled>
                    Next: Confirm Details &rarr;
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentDate = new Date();
    currentDate.setDate(1);
    const therapistId = {{ $therapist->id }}; // Get the therapist ID from Blade

    const monthYearEl = document.getElementById('month-year');
    const calendarGridEl = document.getElementById('calendar-grid');
    const timeSlotsContainer = document.getElementById('time-slots-container');
    const timeSlotsEl = document.getElementById('time-slots');
    const timeSlotsPlaceholder = document.getElementById('time-slots-placeholder');
    const hiddenDateInput = document.getElementById('booking_date');
    const hiddenTimeInput = document.getElementById('booking_time');
    const nextBtn = document.getElementById('next-btn');

    const renderCalendar = () => {
        // ... (Calendar rendering logic remains the same) ...
        const month = currentDate.getMonth();
        const year = currentDate.getFullYear();
        monthYearEl.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;
        calendarGridEl.innerHTML = '';
        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        for (let i = 0; i < firstDayOfMonth; i++) {
            calendarGridEl.appendChild(document.createElement('div'));
        }
        for (let day = 1; day <= daysInMonth; day++) {
            const dayEl = document.createElement('button');
            dayEl.type = 'button';
            dayEl.textContent = day;
            dayEl.className = 'p-2 rounded-full hover:bg-emerald-100 transition cursor-pointer';
            const today = new Date();
            const cellDate = new Date(year, month, day);
            if (cellDate < today.setHours(0,0,0,0)) {
                dayEl.classList.add('text-gray-400', 'pointer-events-none');
            } else {
                dayEl.addEventListener('click', () => {
                    document.querySelectorAll('.calendar-day-selected').forEach(el => {
                        el.classList.remove('calendar-day-selected', 'bg-emerald-500', 'text-white');
                    });
                    dayEl.classList.add('calendar-day-selected', 'bg-emerald-500', 'text-white');
                    
                    const yearStr = cellDate.getFullYear();
                    const monthStr = String(cellDate.getMonth() + 1).padStart(2, '0');
                    const dayStr = String(cellDate.getDate()).padStart(2, '0');
                    const formattedDate = `${yearStr}-${monthStr}-${dayStr}`;
                    hiddenDateInput.value = formattedDate;

                    renderTimeSlots(formattedDate); // Pass the formatted date
                    checkFormCompletion();
                });
            }
            calendarGridEl.appendChild(dayEl);
        }
    };

    const renderTimeSlots = async (date) => {
        timeSlotsEl.innerHTML = '<p class="col-span-3 text-gray-500">Loading...</p>';
        timeSlotsPlaceholder.classList.add('hidden');
        timeSlotsContainer.classList.remove('hidden');
        hiddenTimeInput.value = '';
        checkFormCompletion();

        try {
            // --- NEW: Fetching real data ---
            const response = await fetch(`/api/therapists/${therapistId}/availability/${date}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const bookedTimes = await response.json();
            // --- END NEW ---

            timeSlotsEl.innerHTML = ''; // Clear loading message
            
            const availableTimes = ['09:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM', '06:00 PM'];

            availableTimes.forEach(time => {
                const timeSlotBtn = document.createElement('button');
                timeSlotBtn.type = 'button';
                timeSlotBtn.textContent = time;
                timeSlotBtn.className = 'p-2 border rounded-lg hover:border-emerald-500 transition';

                // Check if the current time slot is in the bookedTimes array
                if (bookedTimes.includes(time)) {
                    timeSlotBtn.classList.add('bg-gray-200', 'text-gray-400', 'cursor-not-allowed', 'line-through');
                    timeSlotBtn.disabled = true;
                } else {
                    timeSlotBtn.addEventListener('click', () => {
                        document.querySelectorAll('.time-slot-selected').forEach(el => {
                            el.classList.remove('time-slot-selected', 'bg-emerald-500', 'text-white', 'border-emerald-500');
                        });
                        timeSlotBtn.classList.add('time-slot-selected', 'bg-emerald-500', 'text-white', 'border-emerald-500');
                        hiddenTimeInput.value = time;
                        checkFormCompletion();
                    });
                }
                timeSlotsEl.appendChild(timeSlotBtn);
            });

        } catch (error) {
            console.error("Failed to fetch availability:", error);
            timeSlotsEl.innerHTML = '<p class="col-span-3 text-red-500">Could not load times.</p>';
        }
    };

    const checkFormCompletion = () => {
        nextBtn.disabled = !(hiddenDateInput.value && hiddenTimeInput.value);
    };

    document.getElementById('prev-month').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById('next-month').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    renderCalendar();
});
</script>
@endsection
