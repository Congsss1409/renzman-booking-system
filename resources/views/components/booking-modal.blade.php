<x-app-layout>
    <!-- Booking Button -->
    <button 
        x-data
        @click="$dispatch('open-booking-modal')"
        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
        Book Appointment
    </button>

    <!-- Modal Component -->
    <div
        x-data="bookingModal"
        x-show="isOpen"
        @open-booking-modal.window="open()"
        @keydown.escape.window="close()"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">
        
        <!-- Modal Backdrop -->
        <div 
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50"
            @click="close">
        </div>

        <!-- Modal Content -->
        <div 
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 transform translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-white rounded-lg max-w-3xl mx-auto my-8 p-6 shadow-xl">
            
            <!-- Close Button -->
            <button 
                @click="close"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="h-2 bg-gray-200 rounded-full">
                    <div 
                        class="h-2 bg-primary rounded-full transition-all duration-500"
                        :style="'width: ' + getStepPercentage() + '%'">
                    </div>
                </div>
            </div>

            <!-- Modal Title -->
            <h2 class="text-2xl font-bold mb-6">Book Your Appointment</h2>

            <!-- Step 1: Branch Selection -->
            <div x-show="currentStep === 1">
                <h3 class="text-lg font-semibold mb-4">Select a Branch</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="branch in branches" :key="branch.id">
                        <button
                            @click="formData.branch_id = branch.id; nextStep()"
                            class="p-4 border rounded-lg hover:border-primary transition-colors"
                            :class="{'border-primary': formData.branch_id === branch.id}">
                            <h4 x-text="branch.name" class="font-medium"></h4>
                            <p x-text="branch.address" class="text-sm text-gray-600"></p>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Step 2: Service Selection -->
            <div x-show="currentStep === 2">
                <h3 class="text-lg font-semibold mb-4">Select a Service</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="service in services" :key="service.id">
                        <button
                            @click="formData.service_id = service.id; nextStep()"
                            class="p-4 border rounded-lg hover:border-primary transition-colors"
                            :class="{'border-primary': formData.service_id === service.id}">
                            <h4 x-text="service.name" class="font-medium"></h4>
                            <p x-text="'₱' + service.price" class="text-sm text-gray-600"></p>
                            <p x-text="service.description" class="text-sm text-gray-500 mt-2"></p>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between">
                <button 
                    x-show="currentStep > 1"
                    @click="prevStep"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors">
                    Previous
                </button>
                <button 
                    x-show="currentStep < 5"
                    @click="nextStep"
                    class="px-4 py-2 bg-primary text-white rounded hover:bg-primary-dark transition-colors ml-auto">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
</x-app-layout>