@extends('layouts.Booking')

@section('title', 'Step 2: Choose Your Therapist')

@section('content')
<div x-data="{ showModal: false, selectedTherapist: '{{ old('therapist_id', $bookingData->therapist_id ?? '') }}' }" class="glass-panel rounded-3xl max-w-6xl mx-auto overflow-hidden shadow-2xl">
    <div class="grid md:grid-cols-2">
        
        <!-- Left Column: Image & Branding -->
        <div class="hidden md:block relative">
            <img src="https://placehold.co/800x1200/0d9488/FFFFFF?text=Expert+Hands&font=poppins" class="absolute h-full w-full object-cover" alt="A professional therapist preparing for a session">
            <div class="absolute inset-0 bg-teal-800/50"></div>
            <div class="relative z-10 p-12 text-white flex flex-col h-full">
                <div>
                    <h2 class="text-3xl font-bold">Meet Our Professionals</h2>
                    <p class="mt-2 text-cyan-100">Our certified therapists are dedicated to providing you with an exceptional wellness experience.</p>
                </div>
                <div class="mt-auto text-cyan-200 text-sm">
                    <p>Select a therapist to view their schedule.</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Form -->
        <div class="p-8 md:p-12">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between items-center text-sm font-semibold text-black mb-2">
                    <span class="text-black">Step 2/5: Therapist</span>
                    <span class="text-black">40%</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2.5">
                    <div class="bg-white h-2.5 rounded-full" style="width: 40%"></div>
                </div>
            </div>

            <!-- Form Header -->
            <div class="text-left mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-black">Select a Therapist</h1>
                <p class="mt-2 text-lg text-black">Choose your preferred wellness expert.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-500/30 border border-red-400 text-black px-4 py-3 rounded-lg relative" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Content -->
            <form x-ref="stepTwoForm" action="{{ route('booking.store.step-two') }}" method="POST">
                @csrf
                <input type="hidden" name="extended_session" x-ref="extendedSessionInput" value="0">
                <div class="space-y-4 max-h-[40vh] overflow-y-auto pr-4 text-black">
                    @forelse($therapists as $therapist)
                        <label class="block text-black">
                            <input type="radio" name="therapist_id" value="{{ $therapist->id }}" @change="selectedTherapist = $event.target.value" class="hidden peer" required {{ old('therapist_id', $bookingData->therapist_id ?? '') == $therapist->id ? 'checked' : '' }}>
                            <div class="p-4 rounded-lg border border-white/30 cursor-pointer peer-checked:bg-white peer-checked:text-teal-600 peer-checked:ring-2 peer-checked:ring-white hover:bg-white/20 transition-all text-black">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $therapist->image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($therapist->name) . '&color=FFFFFF&background=059669&size=128' }}" alt="{{ $therapist->name }}" class="w-12 h-12 rounded-full object-cover">
                                        <div>
                                            <p class="font-bold text-lg text-black">{{ $therapist->name }}</p>
                                        </div>
                                    </div>
                                    @if($therapist->current_status == 'Available')
                                        <div class="text-right">
                                            <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">Available Now</span>
                                        </div>
                                    @else
                                        <div class="text-right">
                                            <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full">Currently Busy</span>
                                            <p class="text-xs opacity-80 mt-1 text-black">Available after {{ $therapist->available_at }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </label>
                    @empty
                        <div class="p-8 text-center bg-white/10 rounded-lg">
                            <p>No therapists are currently available for this branch. Please check back later or select a different branch.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-10 flex justify-between">
                    <a href="{{ route('booking.create.step-one') }}" class="bg-white/20 text-white font-bold py-3 px-10 rounded-full shadow-md hover:bg-white/30 transition-all transform hover:scale-105">
                        &larr; Back
                    </a>
                    <button type="button" @click.prevent="if (selectedTherapist) showModal = true" :disabled="!selectedTherapist" :class="{ 'opacity-50 cursor-not-allowed': !selectedTherapist }" class="bg-white text-teal-600 font-bold py-3 px-10 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next Step &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Extension Modal -->
    <div x-show="showModal" @keydown.escape.window="showModal = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70" style="display: none;">
        <div x-show="showModal" x-transition class="bg-teal-700 text-white rounded-2xl shadow-2xl max-w-sm mx-auto p-8" @click.away="showModal = false">
            <h3 class="text-2xl font-bold mb-2">Extend Your Session?</h3>
            <p class="text-cyan-100 mb-6">An extended session will add one hour to your service. The available time slots in the next step will be adjusted for the longer duration.</p>
            <div class="flex justify-end space-x-4">
                <button @click="showModal = false; $refs.stepTwoForm.submit()" type="button" class="bg-white/20 font-bold py-2 px-6 rounded-full hover:bg-white/30 transition-all">
                    No, Thanks
                </button>
                <button @click="$refs.extendedSessionInput.value = '1'; showModal = false; $refs.stepTwoForm.submit()" type="button" class="bg-white text-teal-600 font-bold py-2 px-6 rounded-full hover:bg-cyan-100 transition-all">
                    Yes, Extend
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

