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
                <input type="hidden" name="booking_date" id="booking_date" value="{{ old('booking_date', $booking->date ?? '') }}">
                <input type="hidden" name="booking_time" id="booking_time" value="{{ old('booking_time', $booking->time ?? '') }}">

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
                            <div id="time-slots" class="grid grid-cols-3 sm:grid-cols-4 gap-2"></div>
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
document.addEventListener('DOMContentLoaded', function() {
    let currentDate = new Date();
    currentDate.setDate(1);
    const therapistId = {{ $therapist->id }};

    const monthYearEl = document.getElementById('month-year');
    const calendarGridEl = document.getElementById('calendar-grid');
    const timeSlotsContainer = document.getElementById('time-slots-container');
    const timeSlotsEl = document.getElementById('time-slots');
    const timeSlotsPlaceholder = document.getElementById('time-slots-placeholder');
    const hiddenDateInput = document.getElementById('booking_date');
    const hiddenTimeInput = document.getElementById('booking_time');
    const nextBtn = document.getElementById('next-btn');

    const renderCalendar = () => {
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

                    renderTimeSlots(cellDate); // Pass the full cellDate object now
                    checkFormCompletion();
                });
            }
            if (hiddenDateInput.value && new Date(hiddenDateInput.value+'T00:00:00').toDateString() === cellDate.toDateString()) {
                dayEl.classList.add('calendar-day-selected', 'bg-emerald-500', 'text-white');
            }
            calendarGridEl.appendChild(dayEl);
        }
    };

    const renderTimeSlots = async (selectedDate) => {
        const formattedDate = selectedDate.toISOString().split('T')[0];
        timeSlotsEl.innerHTML = '<p class="col-span-full text-gray-500">Loading...</p>';
        timeSlotsPlaceholder.classList.add('hidden');
        timeSlotsContainer.classList.remove('hidden');
        hiddenTimeInput.value = '';
        checkFormCompletion();

        try {
            const response = await fetch(`/api/therapists/${therapistId}/availability/${formattedDate}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const bookedTimes = await response.json();
            
            timeSlotsEl.innerHTML = '';
            
            const availableTimes = ['08:00 AM', '09:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM', '06:00 PM', '07:00 PM', '08:00 PM', '09:00 PM'];
            
            const now = new Date();
            const isToday = selectedDate.toDateString() === now.toDateString();

            availableTimes.forEach(time => {
                const timeSlotBtn = document.createElement('button');
                timeSlotBtn.type = 'button';
                timeSlotBtn.textContent = time;
                timeSlotBtn.className = 'p-2 border rounded-lg hover:border-emerald-500 transition';

                // --- NEW: LOGIC TO DISABLE PAST TIMES FOR TODAY ---
                let isDisabled = false;
                if (isToday) {
                    const [hour, minutePart] = time.split(':');
                    const [minute, period] = minutePart.split(' ');
                    let hour24 = parseInt(hour, 10);
                    if (period === 'PM' && hour24 !== 12) {
                        hour24 += 12;
                    }
                    if (period === 'AM' && hour24 === 12) { // Midnight case
                        hour24 = 0;
                    }
                    
                    if (hour24 < now.getHours()) {
                        isDisabled = true;
                    }
                }
                // --- END NEW LOGIC ---

                if (bookedTimes.includes(time) || isDisabled) {
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

                if(hiddenTimeInput.value === time){
                    timeSlotBtn.classList.add('time-slot-selected', 'bg-emerald-500', 'text-white', 'border-emerald-500');
                }

                timeSlotsEl.appendChild(timeSlotBtn);
            });

        } catch (error) {
            console.error("Failed to fetch availability:", error);
            timeSlotsEl.innerHTML = '<p class="col-span-full text-red-500">Could not load times.</p>';
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

    if (hiddenDateInput.value) {
        renderTimeSlots(new Date(hiddenDateInput.value+'T00:00:00'));
    }
});
</script>
@endsection
