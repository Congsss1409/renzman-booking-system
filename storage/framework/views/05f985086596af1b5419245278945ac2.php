<!--
    This component is a self-contained Alpine.js modal for a multi-step booking process.
    - It is triggered by a global window event 'open-booking-modal'.
    - All state management (current step, form data, API data) is handled within the `bookingModal` Alpine component.
    - It fetches data from your existing API endpoints.
-->

<!-- Trigger Button (Example of how to open the modal) -->
<div class="text-center p-10">
    <button @click="$dispatch('open-booking-modal')" class="bg-teal-600 text-white font-bold py-3 px-8 rounded-full hover:bg-teal-700 transition-transform transform hover:scale-105 shadow-lg">
        Book an Appointment
    </button>
</div>

<!-- Modal Container -->
<div
    x-data="bookingModal()"
    x-show="isOpen"
    @open-booking-modal.window="openModal()"
    @keydown.escape.window="closeModal()"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
    x-cloak
>
    <!-- Backdrop -->
    <div x-show="isOpen" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-60"></div>

    <!-- Modal Dialog -->
    <div class="relative bg-white rounded-xl shadow-2xl max-w-3xl mx-auto my-8 p-6 sm:p-8 transition-all duration-300"
         x-show="isOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90">

        <!-- Close Button -->
        <button @click="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <!-- Header -->
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800" x-text="modalTitle"></h2>
            <p class="text-gray-500 mt-1">Follow the steps to complete your booking</p>
        </div>

        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
            <div class="bg-teal-500 h-2.5 rounded-full transition-all duration-500" :style="`width: ${stepPercentage}%`"></div>
        </div>

        <!-- Hidden Inputs for Form Submission -->
        <form id="bookingForm" @submit.prevent="submitBooking">
            <input type="hidden" x-model="formData.branch_id">
            <input type="hidden" x-model="formData.service_id">
            <input type="hidden" x-model="formData.therapist_id">
            <input type="hidden" x-model="formData.booking_date">
            <input type="hidden" x-model="formData.booking_time">
            <input type="hidden" x-model="formData.client_name">
            <input type="hidden" x-model="formData.client_phone">
            <input type="hidden" x-model="formData.client_email">
        </form>

        <!-- Step 1: Select Branch & Service -->
        <div x-show="currentStep === 1" x-transition>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-lg text-gray-700 mb-3">1. Select a Branch</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                        <template x-for="branch in branches" :key="branch.id">
                            <label :class="{'bg-teal-50 border-teal-500': formData.branch_id == branch.id, 'border-gray-200': formData.branch_id != branch.id}" class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-teal-400">
                                <input type="radio" name="branch" :value="branch.id" x-model="formData.branch_id" class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                                <span class="ml-3 text-sm font-medium text-gray-700" x-text="branch.name"></span>
                            </label>
                        </template>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-lg text-gray-700 mb-3">2. Select a Service</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                        <template x-for="service in services" :key="service.id">
                            <label :class="{'bg-teal-50 border-teal-500': formData.service_id == service.id, 'border-gray-200': formData.service_id != service.id}" class="flex justify-between p-4 border rounded-lg cursor-pointer hover:border-teal-400">
                                <div>
                                    <input type="radio" name="service" :value="service.id" x-model="formData.service_id" class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700" x-text="service.name"></span>
                                </div>
                                <span class="text-sm font-semibold text-teal-600" x-text="`₱${service.price}`"></span>
                            </label>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Select Therapist -->
        <div x-show="currentStep === 2" x-transition>
             <div class="text-center" x-show="isLoading.therapists">Loading therapists...</div>
             <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4" x-show="!isLoading.therapists && availableTherapists.length > 0">
                <template x-for="therapist in availableTherapists" :key="therapist.id">
                    <div @click="formData.therapist_id = therapist.id"
                         :class="{'ring-2 ring-teal-500 ring-offset-2': formData.therapist_id === therapist.id}"
                         class="cursor-pointer text-center p-2 rounded-lg hover:bg-gray-100">
                        <img :src="therapist.image_url || 'https://placehold.co/100x100/E2E8F0/4A5568?text=Therapist'" alt="Therapist" class="w-20 h-20 rounded-full mx-auto object-cover">
                        <p class="mt-2 text-sm font-medium text-gray-700" x-text="therapist.name"></p>
                    </div>
                </template>
            </div>
            <div class="text-center text-gray-500 py-8" x-show="!isLoading.therapists && availableTherapists.length === 0">
                No therapists available for the selected criteria. Please try another service or branch.
            </div>
        </div>

        <!-- Step 3: Select Date & Time -->
        <div x-show="currentStep === 3" x-transition>
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Calendar -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <button @click="prevMonth()" type="button" class="p-2 rounded-full hover:bg-gray-100">&larr;</button>
                        <div class="text-lg font-semibold" x-text="`${months[month]} ${year}`"></div>
                        <button @click="nextMonth()" type="button" class="p-2 rounded-full hover:bg-gray-100">&rarr;</button>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-center text-sm">
                        <template x-for="day in days" :key="day"><div class="text-gray-500" x-text="day"></div></template>
                        <template x-for="d in blankDays" :key="d"><div class="border border-transparent"></div></template>
                        <template x-for="date in dayCount" :key="date">
                            <div @click="selectDate(date)"
                                 :class="{
                                     'bg-teal-500 text-white': isToday(date),
                                     'bg-blue-200': isSelectedDate(date),
                                     'hover:bg-gray-200 cursor-pointer': !isPast(date) && !isToday(date),
                                     'text-gray-400 cursor-not-allowed': isPast(date)
                                 }"
                                 class="w-8 h-8 flex items-center justify-center rounded-full"
                                 x-text="date">
                            </div>
                        </template>
                    </div>
                </div>
                <!-- Time Slots -->
                <div>
                     <h3 class="font-semibold text-lg text-gray-700 mb-3" x-text="selectedDateFormatted || 'Select a time'"></h3>
                     <div x-show="isLoading.slots" class="text-center">Loading slots...</div>
                     <div x-show="!isLoading.slots && availableSlots.length > 0" class="grid grid-cols-3 gap-2">
                        <template x-for="slot in availableSlots" :key="slot">
                             <button type="button" @click="formData.booking_time = slot"
                                     :class="{'bg-teal-600 text-white': formData.booking_time === slot, 'bg-gray-100 hover:bg-gray-200': formData.booking_time !== slot}"
                                     class="p-2 rounded-md text-sm transition"
                                     x-text="formatTime(slot)"></button>
                        </template>
                     </div>
                     <div x-show="!isLoading.slots && !availableSlots.length && formData.booking_date" class="text-gray-500">
                        No available slots for this day. Please select another date.
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Your Information -->
        <div x-show="currentStep === 4" x-transition>
             <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label for="client_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="client_name" x-model="formData.client_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="Juan Dela Cruz">
                </div>
                 <div>
                    <label for="client_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" id="client_phone" x-model="formData.client_phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="09171234567">
                </div>
                 <div class="sm:col-span-2">
                    <label for="client_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="client_email" x-model="formData.client_email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="you@example.com">
                </div>
            </div>
        </div>
        
        <!-- Step 5: Confirmation -->
        <div x-show="currentStep === 5" x-transition>
            <h3 class="font-semibold text-xl text-gray-800 mb-4">Confirm Your Booking</h3>
            <div class="space-y-3 bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between"><span class="font-medium text-gray-600">Branch:</span> <span x-text="getBranchName()"></span></div>
                <div class="flex justify-between"><span class="font-medium text-gray-600">Service:</span> <span x-text="getServiceName()"></span></div>
                <div class="flex justify-between"><span class="font-medium text-gray-600">Therapist:</span> <span x-text="getTherapistName()"></span></div>
                <div class="flex justify-between"><span class="font-medium text-gray-600">Date:</span> <span x-text="selectedDateFormatted"></span></div>
                <div class="flex justify-between"><span class="font-medium text-gray-600">Time:</span> <span x-text="formatTime(formData.booking_time)"></span></div>
                <hr>
                <div class="flex justify-between font-bold"><span class="text-gray-700">Total Price:</span> <span x-text="`₱${getFinalPrice()}`"></span></div>
            </div>
        </div>

        <!-- Footer Navigation -->
        <div class="mt-8 pt-5 border-t flex items-center">
            <button type="button" @click="prevStep" x-show="currentStep > 1" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-sm transition-transform transform hover:scale-105">
                Back
            </button>
            <div class="ml-auto">
                <button type="button" @click="nextStep" x-show="currentStep < 5" :disabled="!isStepValid()" :class="{'opacity-50 cursor-not-allowed': !isStepValid()}" class="font-semibold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white py-2 px-6 rounded-full shadow-lg transition-transform transform hover:scale-105 disabled:opacity-50">
                    Next
                </button>
                <button type="submit" form="bookingForm" x-show="currentStep === 5" class="font-semibold bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-2 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">
                    Confirm Booking
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function bookingModal() {
        return {
            // State
            isOpen: false,
            currentStep: 1,
            modalTitle: 'Book an Appointment',
            
            // API Data
            branches: [],
            services: [],
            availableTherapists: [],
            availableSlots: [],

            // Loading states
            isLoading: {
                therapists: false,
                slots: false,
            },

            // Form Data
            formData: {
                branch_id: null,
                service_id: null,
                therapist_id: null,
                booking_date: null,
                booking_time: null,
                client_name: '',
                client_phone: '',
                client_email: '',
            },

            // Calendar State
            month: '',
            year: '',
            blankDays: [],
            dayCount: [],
            days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            
            // Methods
            init() {
                const today = new Date();
                this.month = today.getMonth();
                this.year = today.getFullYear();
                this.generateCalendar();
            },

            openModal() {
                this.isOpen = true;
                this.fetchBranchesAndServices();
            },

            closeModal() {
                this.isOpen = false;
                // Reset to initial state after a short delay to allow for closing animation
                setTimeout(() => {
                    this.currentStep = 1;
                    this.formData = { branch_id: null, service_id: null, therapist_id: null, booking_date: null, booking_time: null, client_name: '', client_phone: '', client_email: '' };
                }, 300);
            },
            
            async fetchBranchesAndServices() {
                if (this.branches.length === 0) {
                    try {
                        const [branchesRes, servicesRes] = await Promise.all([
                            fetch('/api/branches'),
                            fetch('/api/services')
                        ]);
                        this.branches = await branchesRes.json();
                        this.services = await servicesRes.json();
                    } catch (error) {
                        console.error('Error fetching initial data:', error);
                    }
                }
            },
            
            async fetchAvailableTherapists() {
                if (!this.formData.branch_id || !this.formData.service_id) return;
                this.isLoading.therapists = true;
                this.availableTherapists = [];
                try {
                    const response = await fetch(`/api/therapists?branch_id=${this.formData.branch_id}&service_id=${this.formData.service_id}`);
                    this.availableTherapists = await response.json();
                } catch (error) {
                    console.error('Error fetching therapists:', error);
                } finally {
                    this.isLoading.therapists = false;
                }
            },

            async fetchAvailableSlots() {
                if (!this.formData.therapist_id || !this.formData.booking_date) return;
                this.isLoading.slots = true;
                this.availableSlots = [];
                this.formData.booking_time = null; // Reset time when date changes
                try {
                    const response = await fetch(`/api/available-slots?therapist_id=${this.formData.therapist_id}&date=${this.formData.booking_date}`);
                    this.availableSlots = await response.json();
                } catch (error) {
                    console.error('Error fetching slots:', error);
                } finally {
                    this.isLoading.slots = false;
                }
            },

            nextStep() {
                if (this.currentStep < 5) {
                    this.currentStep++;
                }
            },

            prevStep() {
                if (this.currentStep > 1) {
                    this.currentStep--;
                }
            },

            isStepValid() {
                switch (this.currentStep) {
                    case 1: return this.formData.branch_id && this.formData.service_id;
                    case 2: return this.formData.therapist_id;
                    case 3: return this.formData.booking_date && this.formData.booking_time;
                    case 4: return this.formData.client_name && this.formData.client_phone && this.formData.client_email;
                    default: return true;
                }
            },

            // Computed Properties
            get stepPercentage() {
                return ((this.currentStep - 1) / 4) * 100;
            },

            get selectedDateFormatted() {
                if (!this.formData.booking_date) return '';
                const date = new Date(this.formData.booking_date + 'T00:00:00');
                return date.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            },

            // Calendar Methods
            generateCalendar() {
                const firstDay = new Date(this.year, this.month, 1).getDay();
                const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                this.blankDays = Array.from({ length: firstDay }, (_, i) => i);
                this.dayCount = Array.from({ length: daysInMonth }, (_, i) => i + 1);
            },
            
            prevMonth() {
                if (this.month === 0) {
                    this.month = 11;
                    this.year--;
                } else {
                    this.month--;
                }
                this.generateCalendar();
            },

            nextMonth() {
                if (this.month === 11) {
                    this.month = 0;
                    this.year++;
                } else {
                    this.month++;
                }
                this.generateCalendar();
            },

            isToday(date) {
                const today = new Date();
                return today.getFullYear() === this.year && today.getMonth() === this.month && today.getDate() === date;
            },

            isSelectedDate(date) {
                if (!this.formData.booking_date) return false;
                const selected = new Date(this.formData.booking_date + 'T00:00:00');
                return selected.getFullYear() === this.year && selected.getMonth() === this.month && selected.getDate() === date;
            },
            
            isPast(date) {
                const today = new Date();
                today.setHours(0,0,0,0);
                const checkDate = new Date(this.year, this.month, date);
                return checkDate < today;
            },
            
            selectDate(date) {
                if(this.isPast(date)) return;
                let d = new Date(this.year, this.month, date);
                this.formData.booking_date = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
            },

            // Helper methods for display
            getBranchName() {
                return this.branches.find(b => b.id == this.formData.branch_id)?.name || 'N/A';
            },

            getServiceName() {
                return this.services.find(s => s.id == this.formData.service_id)?.name || 'N/A';
            },
            
            getTherapistName() {
                return this.availableTherapists.find(t => t.id == this.formData.therapist_id)?.name || 'N/A';
            },
            
            getFinalPrice() {
                return this.services.find(s => s.id == this.formData.service_id)?.price || 0;
            },

            formatTime(time) {
                if (!time) return '';
                const [hour, minute] = time.split(':');
                const h = hour % 12 || 12;
                const ampm = hour < 12 || hour === 24 ? 'AM' : 'PM';
                return `${h}:${minute} ${ampm}`;
            },

            async submitBooking() {
                try {
                    const response = await fetch('/api/bookings', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(this.formData)
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Booking failed.');
                    }
                    
                    this.closeModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Booking Successful!',
                        text: 'Your appointment has been confirmed. Please check your email for details.',
                        confirmButtonColor: '#14B8A6'
                    });

                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.message,
                        confirmButtonColor: '#14B8A6'
                    });
                }
            },

            // Watchers to trigger API calls when dependencies change
            initWatchers() {
                this.$watch('formData.service_id', () => {
                    this.formData.therapist_id = null; // Reset therapist when service changes
                    this.fetchAvailableTherapists();
                });
                this.$watch('formData.branch_id', () => {
                    this.formData.therapist_id = null; // Reset therapist when branch changes
                    this.fetchAvailableTherapists();
                });
                this.$watch('formData.booking_date', () => {
                    this.fetchAvailableSlots();
                });
            },

            // This is a helper to run init logic for watchers
            start() {
                this.initWatchers();
            }
        }
    }
</script>
<?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views\components\booking-modal.blade.php ENDPATH**/ ?>