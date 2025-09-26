window.appointmentModal = function(todayForJs) {
    return {
        // Data arrays
        branches: [],
        services: [],
        availableTherapists: [],
        availableSlots: [],
        
        // UI state
        show: false,
        currentStep: 1,
        modalTitle: 'New Appointment',
        stepPercentage: 25,
        
        // Form data
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

        // Initialization
        init() {
            this.fetchBranches();
            this.fetchServices();
            const { year, month, day } = todayForJs;
            this.initCalendar(year, month, day);
        },

        initCalendar(year, month, day) {
            const firstDayOfMonth = new Date(year, month - 1, 1);
            const lastDayOfMonth = new Date(year, month, 0);
            
            this.blankDays = Array.from(
                { length: firstDayOfMonth.getDay() },
                (_, i) => i + 1
            );
            
            this.dayCount = Array.from(
                { length: lastDayOfMonth.getDate() },
                (_, i) => i + 1
            );
        },

        // Modal methods
        openModal() {
            this.show = true;
            this.currentStep = 1;
            this.updateStepPercentage();
        },

        closeModal() {
            this.show = false;
            this.resetForm();
        },

        // Data fetching methods
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

        async fetchTherapists() {
            if (!this.formData.branch_id || !this.formData.service_id) return;
            
            this.loadingTherapists = true;
            try {
                const response = await fetch(`/api/branches/${this.formData.branch_id}/therapists?` + new URLSearchParams({
                    date: this.formData.booking_date || todayForJs.year + '-' + (todayForJs.month + 1) + '-' + todayForJs.day,
                    time: this.formData.booking_time || '09:00',
                    service_id: this.formData.service_id
                }));
                this.availableTherapists = await response.json();
            } catch (error) {
                console.error('Error fetching therapists:', error);
            } finally {
                this.loadingTherapists = false;
            }
        },

        // Helper methods
        getServiceName() {
            const service = this.services.find(s => s.id === this.formData.service_id);
            return service?.name || 'Selected Service';
        },

        getBranchName() {
            const branch = this.branches.find(b => b.id === this.formData.branch_id);
            return branch?.name || 'Selected Branch';
        },

        getTherapistName() {
            const therapist = this.availableTherapists.find(t => t.id === this.formData.therapist_id);
            return therapist?.name || 'Selected Therapist';
        },

        updateStepPercentage() {
            this.stepPercentage = this.currentStep * 25;
        },

        resetForm() {
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
            this.currentStep = 1;
            this.updateStepPercentage();
        },

        async submitForm() {
            try {
                const response = await fetch('/api/bookings', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.formData)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'An error occurred while creating the booking');
                }

                const data = await response.json();
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Booking Created!',
                    text: 'Your appointment has been successfully scheduled.',
                    confirmButtonColor: '#0d9488'
                }).then(() => {
                    // Close modal and reset form
                    this.closeModal();
                    // Refresh the page or update the UI as needed
                    window.location.reload();
                });

            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error.message || 'Something went wrong!',
                    confirmButtonColor: '#0d9488'
                });
            }
        }
    };
};