document.addEventListener('alpine:init', () => {
    Alpine.data('bookingModal', () => ({
        isOpen: false,
        currentStep: 1,
        loading: false,
        branches: [],
        services: [],
        availableTherapists: [],
        availableSlots: [],
        selectedDate: null,
        formData: {
            branch_id: null,
            service_id: null,
            therapist_id: null,
            booking_date: null,
            booking_time: null,
            client_name: '',
            client_email: '',
            client_phone: '',
            extended_session: false
        },

        init() {
            this.initializeData();
            this.selectedDate = new Date();
            
            // Listen for successful booking creation
            window.addEventListener('booking-created', () => {
                this.close();
                this.resetForm();
                // Refresh the bookings table or trigger any necessary updates
                window.location.reload();
            });
        },

        async initializeData() {
            try {
                await Promise.all([
                    this.fetchBranches(),
                    this.fetchServices()
                ]);
            } catch (error) {
                console.error('Error initializing data:', error);
                this.showError('Failed to load initial data');
            }
        },

        open() {
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },

        close() {
            this.isOpen = false;
            document.body.style.overflow = 'auto';
        },

        async fetchBranches() {
            try {
                const response = await fetch('/api/branches');
                this.branches = await response.json();
            } catch (error) {
                console.error('Error fetching branches:', error);
            }
        },

        async fetchServices() {
            try {
                const response = await fetch('/api/services');
                this.services = await response.json();
            } catch (error) {
                console.error('Error fetching services:', error);
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

        getStepPercentage() {
            return (this.currentStep - 1) * 25;
        },

        resetForm() {
            this.currentStep = 1;
            this.formData = {
                branch_id: null,
                service_id: null,
                therapist_id: null,
                booking_date: null,
                booking_time: null,
                client_name: '',
                client_email: '',
                client_phone: '',
                extended_session: false
            };
        },

        async fetchAvailableSlots() {
            if (!this.formData.branch_id || !this.formData.service_id || !this.selectedDate) return;
            
            try {
                const response = await fetch(`/api/time-slots?branch_id=${this.formData.branch_id}&service_id=${this.formData.service_id}&date=${this.selectedDate.toISOString().split('T')[0]}`);
                this.availableSlots = await response.json();
            } catch (error) {
                console.error('Error fetching available slots:', error);
                this.showError('Failed to fetch available time slots');
            }
        },

        async fetchTherapists() {
            if (!this.formData.branch_id) return;
            
            try {
                const response = await fetch(`/api/branches/${this.formData.branch_id}/therapists`);
                this.availableTherapists = await response.json();
            } catch (error) {
                console.error('Error fetching therapists:', error);
                this.showError('Failed to fetch available therapists');
            }
        },

        async submitBooking() {
            if (this.loading) return;
            this.loading = true;

            try {
                const response = await fetch('/api/bookings', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.formData)
                });

                if (response.ok) {
                    const result = await response.json();
                    this.showSuccess('Booking created successfully!');
                    window.dispatchEvent(new CustomEvent('booking-created'));
                } else {
                    const error = await response.json();
                    this.showError(error.message || 'Failed to create booking');
                }
            } catch (error) {
                console.error('Error creating booking:', error);
                this.showError('An unexpected error occurred');
            } finally {
                this.loading = false;
            }
        },

        showSuccess(message) {
            Swal.fire({
                title: 'Success!',
                text: message,
                icon: 'success',
                confirmButtonColor: '#14b8a6'
            });
        },

        showError(message) {
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                confirmButtonColor: '#14b8a6'
            });
        }
    }));
});