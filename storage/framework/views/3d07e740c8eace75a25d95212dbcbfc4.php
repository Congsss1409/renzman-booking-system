<!-- Booking Modal Component -->
<div x-data="bookingModal"
     x-show="isOpen"
     @open-booking-modal.window="open()"
     @keydown.escape.window="close()"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">

    <!-- Modal Backdrop -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="close"
         class="fixed inset-0 bg-black bg-opacity-50">
    </div>

    <!-- Modal Content -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 transform translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative bg-white rounded-xl max-w-3xl mx-auto my-8 p-6 shadow-xl">

        <!-- Close Button -->
        <button @click="close"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="h-2 bg-gray-200 rounded-full">
                <div class="h-2 bg-teal-500 rounded-full transition-all duration-500"
                     :style="'width: ' + getStepPercentage() + '%'">
                </div>
            </div>
        </div>

        <!-- Modal Title -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Appointment</h2>

        <!-- Step Content -->
        <div class="space-y-6">
            <!-- Step 1: Branch Selection -->
            <div x-show="currentStep === 1">
                <h3 class="text-lg font-semibold mb-4">Select Branch</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="branch in branches" :key="branch.id">
                        <button @click="formData.branch_id = branch.id; nextStep()"
                                class="p-4 border rounded-lg hover:border-teal-500 transition-colors text-left"
                                :class="{'border-teal-500 bg-teal-50': formData.branch_id === branch.id}">
                            <h4 x-text="branch.name" class="font-medium"></h4>
                            <p x-text="branch.address" class="text-sm text-gray-600 mt-1"></p>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Step 2: Service Selection -->
            <div x-show="currentStep === 2">
                <h3 class="text-lg font-semibold mb-4">Select Service</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="service in services" :key="service.id">
                        <button @click="formData.service_id = service.id; nextStep()"
                                class="p-4 border rounded-lg hover:border-teal-500 transition-colors text-left"
                                :class="{'border-teal-500 bg-teal-50': formData.service_id === service.id}">
                            <h4 x-text="service.name" class="font-medium"></h4>
                            <div class="flex justify-between mt-2">
                                <p x-text="'₱' + service.price" class="text-sm font-semibold text-teal-600"></p>
                                <p x-text="service.duration + ' mins'" class="text-sm text-gray-600"></p>
                            </div>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Step 3: Date and Time Selection -->
            <div x-show="currentStep === 3">
                <h3 class="text-lg font-semibold mb-4">Select Date & Time</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Calendar -->
                    <div class="bg-white p-4 rounded-lg border">
                        <!-- Calendar implementation will go here -->
                    </div>
                    <!-- Time Slots -->
                    <div class="space-y-4">
                        <h4 class="font-medium">Available Time Slots</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="slot in availableSlots" :key="slot">
                                <button @click="formData.booking_time = slot"
                                        class="py-2 px-4 border rounded hover:border-teal-500"
                                        :class="{'border-teal-500 bg-teal-50': formData.booking_time === slot}"
                                        x-text="slot">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Client Information -->
            <div x-show="currentStep === 4">
                <h3 class="text-lg font-semibold mb-4">Client Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" x-model="formData.client_name"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" x-model="formData.client_email"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="tel" x-model="formData.client_phone"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-8 flex justify-between">
            <button x-show="currentStep > 1"
                    @click="prevStep"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                Previous
            </button>
            <button x-show="currentStep < 4"
                    @click="nextStep"
                    class="ml-auto px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                Next
            </button>
            <button x-show="currentStep === 4"
                    @click="submitBooking"
                    class="ml-auto px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                Create Appointment
            </button>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views\components\admin-booking-modal.blade.php ENDPATH**/ ?>