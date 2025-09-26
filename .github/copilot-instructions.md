# AI Agent Instructions for Renzman Booking System

## Project Overview
This is a Laravel-based spa/massage booking system with real-time updates using Alpine.js for frontend interactivity. Key features include:
- Multi-branch booking management
- Therapist availability tracking
- Real-time booking notifications
- Email confirmations and reminders
- Payment processing and downpayment handling

## Frontend Architecture

### Alpine.js Components
The booking flow uses Alpine.js for dynamic UI interactions. Key components:

```javascript
// Example booking modal component structure
appointmentModal({ year, month, day }) {
    return {
        show: false,
        currentStep: 1,
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
        // Required helper functions
        initCalendar() { /* ... */ },
        openModal() { /* ... */ },
        closeModal() { /* ... */ },
        getServiceName() { /* ... */ },
        getBranchName() { /* ... */ },
        getTherapistName() { /* ... */ },
        formatTime() { /* ... */ },
        getFinalPrice() { /* ... */ }
    }
}

## Architecture Patterns

### Domain Model
- `Booking`: Central entity managing spa appointments (`app/Models/Booking.php`)
- `Branch`: Physical locations (`app/Models/Branch.php`) 
- `Service`: Available spa treatments (`app/Models/Service.php`)
- `Therapist`: Staff providing services (`app/Models/Therapist.php`)

### Key Workflows
1. **Booking Flow**:
   - Multi-step booking process (`app/Http/Controllers/BookingController.php`)
   - Real-time availability checks via broadcasting
   - Email notifications triggered by `BookingCreated` event

2. **Admin Dashboard**:
   - Therapist status management
   - Booking confirmations/cancellations
   - Revenue tracking and reporting

### Project Conventions

#### Frontend State Management
- Alpine.js components handle form state and UI interactions
- State variables must be initialized in component setup
- Validation functions (`isStep1Valid`, `isStep2Valid`, etc.) manage multi-step form flow
- Modal state managed through `show`, `openModal()`, and `closeModal()`

#### Events & Broadcasting
- Booking status changes broadcast via Pusher
- Events in `app/Events/` trigger corresponding Mail notifications
- Real-time updates use `ShouldBroadcast` interface
- Frontend listens for events through Echo/Pusher

#### Form Validation
- Form requests in `app/Http/Requests/` handle validation
- Client-side validation mirrors server rules
- Customized error messages in language files

#### Database Patterns
- Soft deletes used for all major models
- Timestamp fields standardized (created_at, updated_at)
- Foreign key constraints enforced

## Development Workflow

### Local Setup
```bash
composer install
php artisan migrate:fresh --seed
npm install && npm run dev
```

### Testing
- Feature tests focus on booking workflows
- Unit tests for complex business logic
- Run tests: `php artisan test`

### Key Integration Points
- Pusher for real-time updates
- SMTP for email notifications
- Payment gateway integration (see `.env.example`)

## Common Tasks
- Adding new service: Update `ServiceSeeder.php` and run `php artisan db:seed --class=ServiceSeeder`
- Modifying booking rules: Check `app/Rules/` directory
- Email template changes: Edit views in `resources/views/emails/`
- Creating Alpine.js components: Initialize all required state variables and methods
- Debugging frontend: Check browser console for undefined Alpine.js variables/methods

## Alpine.js Component Checklist
When working with Alpine.js components:
1. Initialize all state variables in component return object
2. Define all referenced methods in component scope
3. Set up x-init for any required initialization
4. Handle event listeners with proper method bindings
5. Validate form state through dedicated validation methods

For detailed API documentation and additional context, refer to the project wiki.