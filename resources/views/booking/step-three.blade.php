@extends('layouts.Booking')

@section('title', 'Step 3: Select Date & Time')

@section('content')
<div class="glass-panel rounded-3xl max-w-6xl mx-auto overflow-hidden shadow-2xl">
    <div class="grid grid-cols-1 items-stretch min-h-[560px]">

    <div class="p-8 md:p-12 flex flex-col h-full" x-data="dateTimePicker('{{ $now }}', {{ json_encode($todayForJs) }}, {{ $extendedSession ? 'true' : 'false' }})">
            <div class="mb-8">
                <div class="flex justify-between items-center text-sm font-semibold text-cyan-100 mb-2"><span>Step 3/5: Date & Time</span><span>60%</span></div>
                <div class="w-full bg-white/20 rounded-full h-2.5"><div class="bg-white h-2.5 rounded-full" style="width: 60%"></div></div>
            </div>

            <div class="text-left mb-8">
                <h1 class="text-3xl md:text-4xl font-bold">Select Date & Time</h1>
                <p class="mt-2 text-lg text-cyan-100">Choose an available time slot with {{ $therapist->name }}.</p>
            </div>

            @if (session('error'))<div class="mb-4 p-4 text-sm text-red-200 bg-red-500/30 rounded-lg" role="alert">{{ session('error') }}</div>@endif
            @error('booking_time')<div class="mb-4 p-4 text-sm text-red-200 bg-red-500/30 rounded-lg" role="alert">{{ $message }}</div>@enderror

            <form action="{{ route('booking.store.step-three') }}" method="POST" class="flex flex-col flex-1">
                @csrf
                <input type="hidden" name="booking_date" x-model="selectedDate">
                <input type="hidden" name="booking_time" x-model="selectedTime">
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 flex-1 mb-8">
                    <div class="lg:col-span-3 bg-white/10 rounded-2xl p-6 shadow-lg" style="backdrop-filter: blur(6px);">
                        <div class="flex items-center justify-between mb-4">
                            <button type="button" @click="prevMonth()" class="p-2 rounded-full hover:bg-white/20 focus:outline-none transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                            <div class="text-xl font-bold text-white" x-text="`${months[month]} ${year}`"></div>
                            <button type="button" @click="nextMonth()" class="p-2 rounded-full hover:bg-white/20 focus:outline-none transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                        </div>
                        <div class="grid grid-cols-7 gap-2 text-center">
                            <template x-for="day in days" :key="day"><div class="font-semibold text-cyan-100 text-sm" x-text="day"></div></template>
                            <template x-for="blank in blankDays"><div class="border-none"></div></template>
                            <template x-for="day in dayCount" :key="day">
                                <div @click="selectDate(day)"
                                     :class="{
                                         'bg-white text-teal-600 font-bold shadow-lg scale-105': isSelected(day),
                                         'hover:bg-white/20 cursor-pointer': !isPast(day) && !isSelected(day),
                                         'text-gray-400 cursor-not-allowed opacity-50': isPast(day)
                                     }"
                                     class="p-2 rounded-full text-center transition-all duration-200 ease-in-out" x-text="day"></div>
                            </template>
                        </div>
                    </div>
                    <div class="lg:col-span-2 bg-white/10 rounded-2xl p-6 shadow-lg flex flex-col" style="backdrop-filter: blur(6px);">
                        <div class="mb-4">
                            <h2 class="text-xl font-bold text-white">Available Times</h2>
                            <p class="text-cyan-100">for <span class="font-semibold" x-text="selectedDateFormatted"></span></p>
                        </div>
                        <div class="flex-1 overflow-y-auto">
                            <div x-show="loading" class="flex items-center justify-center h-full"><svg class="animate-spin h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>
                            <div x-show="!loading && availableSlots.length > 0" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <template x-for="slot in availableSlots" :key="slot">
                                    <button type="button" @click="selectTime(slot)" 
                                            :class="selectedTime === slot ? 'bg-white text-teal-600 font-bold shadow-md' : 'bg-white/10 text-white hover:bg-white/20'" 
                                            class="p-3 rounded-lg text-sm text-center transition-all duration-200 ease-in-out transform hover:scale-105">
                                        <span x-text="formatTime(slot)"></span>
                                    </button>
                                </template>
                            </div>
                            <div x-show="!loading && availableSlots.length === 0" class="flex items-center justify-center h-full text-center">
                                <p class="text-cyan-100">No available time slots for this day.<br>Please select another date.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-auto flex justify-between">
                    <a href="{{ route('booking.create.step-two') }}" class="bg-white/20 text-white font-bold py-3 px-8 rounded-full shadow-md hover:bg-white/30 transition-all transform hover:scale-105">&larr; Back</a>
                    <button type="submit" :disabled="!selectedTime" class="bg-white text-teal-600 font-bold py-3 px-8 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:transform-none">Next Step &rarr;</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function dateTimePicker(serverTime, todayForJs, isExtended) { // Accept the new isExtended parameter
    return {
        month: '', year: '', dayCount: [], blankDays: [],
        days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        selectedDate: '', selectedDateFormatted: '', selectedTime: '',
        availableSlots: [], loading: false,
        serverTime: serverTime,
        todayForJs: todayForJs,
        isExtended: isExtended, // Store the value in the component's state

        init() {
            // Use the server's definition of today for all initial calendar state
            this.month = this.todayForJs.month;
            this.year = this.todayForJs.year;
            this.selectedDate = this.formatDate(new Date(this.todayForJs.year, this.todayForJs.month, this.todayForJs.day));

            this.getDays();
            this.fetchAvailability();
        },
        formatDate(date) { return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`; },
        getDays() {
            const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
            const firstDay = new Date(this.year, this.month).getDay();
            this.blankDays = Array(firstDay).fill(null);
            this.dayCount = Array.from({ length: daysInMonth }, (_, i) => i + 1);
        },
        prevMonth() { if (this.month === 0) { this.month = 11; this.year--; } else { this.month--; } this.getDays(); },
        nextMonth() { if (this.month === 11) { this.month = 0; this.year++; } else { this.month++; } this.getDays(); },
        isSelected(day) { const d = new Date(this.year, this.month, day); return this.selectedDate === this.formatDate(d); },
        isPast(day) {
            // Compare against the server's definition of today, ignoring time.
            const today = new Date(this.todayForJs.year, this.todayForJs.month, this.todayForJs.day);
            const d = new Date(this.year, this.month, day);
            return d < today;
        },
        selectDate(day) {
            if(this.isPast(day)) return;
            let d = new Date(this.year, this.month, day);
            this.selectedDate = this.formatDate(d);
            this.selectedTime = '';
            this.fetchAvailability();
        },
        selectTime(time) { this.selectedTime = time; },
        fetchAvailability() {
            this.loading = true;
            this.availableSlots = [];
            this.selectedDateFormatted = new Date(this.selectedDate + 'T00:00:00').toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
            
            // Use the isExtended state variable to build the correct API URL
            const extendedParam = this.isExtended ? '1' : '0';
            const apiUrl = `/api/therapists/{{ $therapist->id }}/availability/${this.selectedDate}/{{ $service->id }}?extended=${extendedParam}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    this.availableSlots = data;
                })
                .catch(error => console.error('Error fetching availability:', error))
                .finally(() => { this.loading = false; });
        },
        formatTime(time) {
            if (!time) return '';
            const [h, m] = time.split(':');
            const hour = parseInt(h, 10);
            const period = hour >= 12 ? 'PM' : 'AM';
            const adjustedHour = hour % 12 === 0 ? 12 : hour % 12;
            return `${adjustedHour}:${m} ${period}`;
        }
    }
}
</script>
@endpush
