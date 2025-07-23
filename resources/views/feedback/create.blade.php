{{-- resources/views/feedback/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-2xl">
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl sm:text-3xl font-bold text-center text-emerald-700 mb-2">Leave Your Feedback</h1>
        <p class="text-center text-gray-600 mb-8">
            Thank you for choosing Renzman. Please let us know how we did on your recent visit on <span class="font-semibold">{{ $booking->start_time->format('F j, Y') }}</span>.
        </p>

        <form action="{{ route('feedback.store', $booking->feedback_token) }}" method="POST">
            @csrf
            <!-- Star Rating -->
            <div class="mb-6">
                <label class="block text-lg font-semibold text-gray-700 mb-3 text-center">Your Rating</label>
                <div class="flex justify-center items-center space-x-2 text-4xl text-gray-300" id="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star cursor-pointer" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
                @error('rating')
                    <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <!-- Feedback Comments -->
            <div class="mb-6">
                <label for="feedback" class="block text-sm font-medium text-gray-700">Comments (Optional)</label>
                <textarea name="feedback" id="feedback" rows="4" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">{{ old('feedback') }}</textarea>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                    Submit Feedback
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('#star-rating .star');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const value = this.getAttribute('data-value');
            ratingInput.value = value;
            updateStars(value);
        });

        star.addEventListener('mouseover', function () {
            updateStars(this.getAttribute('data-value'));
        });

        star.addEventListener('mouseout', function () {
            updateStars(ratingInput.value);
        });
    });

    function updateStars(value) {
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= value) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }
});
</script>
@endsection
