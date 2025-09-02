@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">
    
    {{-- Left Column: Information Panel --}}
    <div class="w-full md:w-1/3 bg-emerald-700 text-white p-8 flex flex-col justify-center">
        <div>
            <h1 class="text-3xl font-bold mb-4">Find Your Perfect Therapist</h1>
            <p class="text-emerald-100 mb-6">
                Here are the available therapists at your selected branch. Their current status is for today only. You can select any therapist to book for a future date.
            </p>
            <div class="border-t border-emerald-500 pt-6 space-y-4 text-emerald-200">
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">✓</span>
                    <span>Branch & Service</span>
                </div>
                <div class="flex items-center">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">2</span>
                    <span>Choose Therapist</span>
                </div>
                <div class="flex items-center opacity-50">
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

    {{-- Right Column: Main Content --}}
    <div class="w-full md:w-2/3 bg-white p-8 lg:p-12 overflow-y-auto">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Step 2: Choose a Therapist at {{ $branch->name }}</h2>
            
            <form action="{{ route('booking.store.step-two') }}" method="POST">
                @csrf
                <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2 border-t pt-4">
                    @forelse($therapists as $therapist)
                        @php
                            // Use status for styling, but not for disabling
                            $isFullyBooked = $therapist->current_status === 'Fully Booked';
                        @endphp
                        <label for="therapist-{{ $therapist->id }}" class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-600 
                            {{ $isFullyBooked ? 'bg-gray-50 opacity-70' : '' }}">
                            
                            {{-- FIX: Radio button is never disabled --}}
                            <input type="radio" name="therapist_id" id="therapist-{{ $therapist->id }}" value="{{ $therapist->id }}" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500" 
                                required 
                                {{ $loop->first ? 'checked' : '' }}>

                            <img src="{{ $therapist->image ? asset('storage/' . $therapist->image) : asset('images/admin.png') }}" alt="{{ $therapist->name }}" class="w-16 h-16 rounded-full object-cover ml-4 {{ $isFullyBooked ? 'grayscale' : '' }}">
                            <div class="ml-4 flex-grow">
                                <span class="font-semibold text-lg text-gray-800">{{ $therapist->name }}</span>
                                
                                <div id="therapist-status-{{ $therapist->id }}">
                                    @if($therapist->current_status == 'Available')
                                        <div class="flex items-center text-sm">
                                            <span class="h-2 w-2 rounded-full bg-green-500 mr-2"></span>
                                            <span class="text-green-600 font-medium">Available Now</span>
                                        </div>
                                    @elseif($therapist->current_status == 'In Session')
                                        <div class="flex items-center text-sm">
                                            <span class="h-2 w-2 rounded-full bg-red-500 mr-2"></span>
                                            <span class="text-red-600 font-medium">In Session</span>
                                        </div>
                                        @if($therapist->available_at)
                                            <p class="text-xs text-gray-500 mt-1">Available at {{ $therapist->available_at }}</p>
                                        @endif
                                    @else {{-- Fully Booked --}}
                                        <div class="flex items-center text-sm">
                                            <span class="h-2 w-2 rounded-full bg-gray-400 mr-2"></span>
                                            <span class="text-gray-500 font-medium">Fully Booked for Today</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </label>
                    @empty
                        <p class="text-center py-8 text-gray-500">No therapists are currently available for this branch.</p>
                    @endforelse
                </div>

                <div class="mt-10 flex justify-between items-center border-t pt-6">
                     <a href="{{ route('booking.create.step-one') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        &larr; Back to Services
                    </a>
                    <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                        Next: Select Date & Time &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Only initialize Pusher if the keys are present in the .env file
        if ("{{ env('PUSHER_APP_KEY') }}") {
            window.Pusher = Pusher;

            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: '{{ env('PUSHER_APP_KEY') }}',
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                forceTLS: true
            });

            // Listen on the public 'therapist-status-updates' channel
            // for the 'TherapistStatusUpdated' event from the server.
            window.Echo.channel('therapist-status-updates')
                .listen('TherapistStatusUpdated', (e) => {
                    // Log the received event to the console for easy debugging
                    console.log('Live status event received:', e); 
                    
                    // Call the function to update the UI with the new data
                    updateTherapistStatus(e.therapistId, e.status, e.availableAt);
                });

            /**
             * Finds the correct therapist on the page and updates their status HTML.
             * @param {number} therapistId - The ID of the therapist to update.
             * @param {string} newStatus - The new status ('Available', 'In Session', etc.).
             * @param {string|null} availableAt - The next available time, if applicable.
             */
            function updateTherapistStatus(therapistId, newStatus, availableAt) {
                const statusDiv = document.getElementById(`therapist-status-${therapistId}`);
                // If the therapist isn't on the current page, do nothing.
                if (!statusDiv) return; 

                let newHtml = '';
                if (newStatus === 'Available') {
                    newHtml = `
                        <div class="flex items-center text-sm">
                            <span class="h-2 w-2 rounded-full bg-green-500 mr-2"></span>
                            <span class="text-green-600 font-medium">Available Now</span>
                        </div>
                    `;
                } else { // 'In Session' or 'Fully Booked'
                    newHtml = `
                        <div class="flex items-center text-sm">
                            <span class="h-2 w-2 rounded-full bg-red-500 mr-2"></span>
                            <span class="text-red-600 font-medium">In Session</span>
                        </div>
                        ${availableAt ? `<p class="text-xs text-gray-500 mt-1">Available at ${availableAt}</p>` : ''}
                    `;
                }
                
                // Replace the old status with the new one
                statusDiv.innerHTML = newHtml;
            }
        } else {
            console.warn('Pusher keys not set in .env file. Live status updates are disabled.');
        }
    });
</script>
@endsection

