@extends('layouts.booking')

@section('content')
<div x-data="dateTimePicker()" x-init="init()">
    <form action="{{ route('booking.store.step-three') }}" method="POST">
        @csrf
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Select Date & Time</h2>
            <p class="text-gray-500">Choose an available time slot with {{ $therapist->name }}.</p>
        </div>

        @if (session('error'))
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @error('booking_time')
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ $message }}
            </div>
        @enderror

        <input type="hidden" name="booking_date" x-model="selectedDate">
        <input type="hidden" name="booking_time" x-model="selectedTime">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Date Picker -->
            <div>
                <label class="block text-lg font-semibold text-gray-800 mb-2">Date</label>
                <div class="bg-white p-4 rounded-lg border">
                    <div class="flex items-center justify-between mb-4">
                        <button type="button" @click="prevMonth()" class="p-2 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <div class="text-lg font-semibold" x-text="`${months[month]} ${year}`"></div>
                        <button type="button" @click="nextMonth()" class="p-2 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-center text-sm">
                        <template x-for="day in days" :key="day"><div class="font-medium text-gray-500" x-text="day"></div></template>
                        <template x-for="blank in blankDays"><div class="border-none"></div></template>
                        <template x-for="day in dayCount" :key="day">
                            <div
                                @click="selectDate(day)"
                                :class="{
                                    'bg-indigo-600 text-white shadow-md': isSelected(day),
                                    'hover:bg-indigo-100 cursor-pointer': !isPast(day) && !isSelected(day),
                                    'text-gray-400 cursor-not-allowed': isPast(day)
                                }"
                                class="p-2 rounded-full transition-all duration-200"
                                x-text="day">
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Time Slots -->
            <div>
                <label class="block text-lg font-semibold text-gray-800 mb-2">Available Times for <span class="text-indigo-600" x-text="selectedDateFormatted"></span></label>
                <div class="border rounded-lg p-4 h-[284px] overflow-y-auto">
                    <div x-show="loading" class="flex items-center justify-center h-full">
                        <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <div x-show="!loading && availableSlots.length > 0" class="grid grid-cols-3 gap-2">
                        <template x-for="slot in availableSlots" :key="slot">
                             <button
                                type="button"
                                @click="selectTime(slot)"
                                :class="selectedTime === slot ? 'bg-indigo-600 text-white font-semibold' : 'bg-gray-100 text-gray-700 hover:bg-indigo-100'"
                                class="p-2 rounded-lg text-sm text-center transition-all duration-200">
                                <span x-text="formatTime(slot)"></span>
                             </button>
                        </template>
                    </div>
                     <div x-show="!loading && availableSlots.length === 0" class="flex items-center justify-center h-full text-center">
                        <p class="text-gray-500">No available time slots for this day.<br>Please select another date.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-between">
            <a href="{{ route('booking.create.step-two') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Therapists
            </a>
            <button type="submit" :disabled="!selectedTime" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:bg-gray-400 disabled:cursor-not-allowed">
                Next: Your Details
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-3 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </button>
        </div>
    </form>
</div>

<script>
function dateTimePicker() {
    return {
        month: '',
        year: '',
        dayCount: [],
        blankDays: [],
        days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        selectedDate: '',
        selectedDateFormatted: '',
        selectedTime: '',
        availableSlots: [],
        unavailableSlots: [],
        loading: false,

        init() {
            const today = new Date();
            this.month = today.getMonth();
            this.year = today.getFullYear();
            this.selectedDate = this.formatDate(new Date());
            this.getDays();
            this.fetchAvailability();
        },
        formatDate(date) {
            return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        },
        getDays() {
            const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
            const firstDay = new Date(this.year, this.month).getDay();
            this.blankDays = Array(firstDay).fill(null);
            this.dayCount = Array.from({ length: daysInMonth }, (_, i) => i + 1);
        },
        prevMonth() {
            if (this.month === 0) {
                this.month = 11;
                this.year--;
            } else {
                this.month--;
            }
            this.getDays();
        },
        nextMonth() {
            if (this.month === 11) {
                this.month = 0;
                this.year++;
            } else {
                this.month++;
            }
            this.getDays();
        },
        isSelected(day) {
            const d = new Date(this.year, this.month, day);
            return this.selectedDate === this.formatDate(d);
        },
        isPast(day) {
            const today = new Date();
            today.setHours(0,0,0,0);
            const d = new Date(this.year, this.month, day);
            return d < today;
        },
        selectDate(day) {
            if(this.isPast(day)) return;
            let d = new Date(this.year, this.month, day);
            this.selectedDate = this.formatDate(d);
            this.selectedTime = ''; // Reset time on new date selection
            this.fetchAvailability();
        },
        selectTime(time) {
            this.selectedTime = time;
        },
        fetchAvailability() {
            this.loading = true;
            this.availableSlots = [];
            this.selectedDateFormatted = new Date(this.selectedDate + 'T00:00:00').toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
            
            fetch(`/api/therapists/{{ $therapist->id }}/availability/${this.selectedDate}/{{ $service->id }}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    this.unavailableSlots = data;
                    this.generateTimeSlots();
                })
                .catch(error => {
                    console.error('Error fetching availability:', error);
                    // Handle error state in UI if needed
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        generateTimeSlots() {
            const slots = [];
            // Business hours: 8:00 AM to 8:30 PM (last booking slot)
            for (let h = 8; h < 21; h++) {
                for (let m = 0; m < 60; m += 30) { 
                    const time = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
                    const slotDateTime = new Date(`${this.selectedDate}T${time}:00`);
                    
                    if (slotDateTime < new Date()) continue; // Skip past slots
                    if (this.unavailableSlots.includes(time)) continue; // Skip booked slots

                    slots.push(time);
                }
            }
            this.availableSlots = slots;
        },
        formatTime(time) {
            const [h, m] = time.split(':');
            const hour = parseInt(h, 10);
            const period = hour >= 12 ? 'PM' : 'AM';
            const adjustedHour = hour % 12 === 0 ? 12 : hour % 12;
            return `${adjustedHour}:${m} ${period}`;
        }
    }
}
</script>
@endsection

