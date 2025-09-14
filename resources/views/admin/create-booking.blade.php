<!-- Create Booking Modal -->
<dialog id="createBookingModal" class="p-0 bg-transparent rounded-lg backdrop:bg-black/50">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-xl">
        <form action="{{ route('admin.bookings.store') }}" method="POST" id="createBookingForm">
            @csrf
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Create New Booking</h3>
                <p class="mt-1 text-sm text-gray-500">Manually add a new booking to the system.</p>
            </div>

            <div class="p-6 space-y-6">
                <!-- Client Details -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="sm:col-span-1">
                        <label for="client_name" class="block text-sm font-medium text-gray-700">Client Name</label>
                        <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('client_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                     <div class="sm:col-span-1">
                        <label for="client_email" class="block text-sm font-medium text-gray-700">Client Email</label>
                        <input type="email" name="client_email" id="client_email" value="{{ old('client_email') }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('client_email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="sm:col-span-1">
                        <label for="client_phone" class="block text-sm font-medium text-gray-700">Client Phone</label>
                        <input type="text" name="client_phone" id="client_phone" value="{{ old('client_phone') }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('client_phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <hr>

                <!-- Booking Details -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch</label>
                        <select name="branch_id" id="branch_id" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select a Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                         @error('branch_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700">Service</label>
                        <select name="service_id" id="service_id" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                             <option value="">Select a Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                         @error('service_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="therapist_id" class="block text-sm font-medium text-gray-700">Therapist</label>
                        <select name="therapist_id" id="therapist_id" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" disabled>
                            <option value="">Select a branch first</option>
                        </select>
                         @error('therapist_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                     <div>
                        <label for="booking_date" class="block text-sm font-medium text-gray-700">Date & Time</label>
                        <div class="flex gap-2 mt-1">
                            <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <input type="time" name="booking_time" id="booking_time" value="{{ old('booking_time') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        @error('booking_date') <span class="block mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                        @error('booking_time') <span class="block mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-lg">
                <button type="button" onclick="document.getElementById('createBookingModal').close()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">Create Booking</button>
            </div>
        </form>
    </div>
</dialog>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const branchSelect = document.getElementById('branch_id');
    const therapistSelect = document.getElementById('therapist_id');

    branchSelect.addEventListener('change', function () {
        const branchId = this.value;
        therapistSelect.innerHTML = '<option value="">Loading...</option>';
        therapistSelect.disabled = true;

        if (!branchId) {
            therapistSelect.innerHTML = '<option value="">Select a branch first</option>';
            return;
        }

        fetch(`/admin/branches/${branchId}/therapists`)
            .then(response => response.json())
            .then(data => {
                therapistSelect.innerHTML = '<option value="">Select a Therapist</option>';
                data.forEach(therapist => {
                    const option = document.createElement('option');
                    option.value = therapist.id;
                    option.textContent = therapist.name;
                    therapistSelect.appendChild(option);
                });
                therapistSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching therapists:', error);
                therapistSelect.innerHTML = '<option value="">Could not load therapists</option>';
            });
    });

    // If there were validation errors, the page reloaded. We need to re-trigger
    // the change event if a branch was already selected to populate therapists.
    if (branchSelect.value) {
        branchSelect.dispatchEvent(new Event('change'));
        // And if a therapist was already selected, we try to re-select them.
        const oldTherapistId = "{{ old('therapist_id') }}";
        if (oldTherapistId) {
            // We need a small delay to allow the options to be populated by the fetch call
            setTimeout(() => {
                therapistSelect.value = oldTherapistId;
            }, 500);
        }
    }
    
    // Logic to automatically show modal if there are validation errors from form submission
    @if($errors->any())
        document.getElementById('createBookingModal').showModal();
    @endif
});
</script>
