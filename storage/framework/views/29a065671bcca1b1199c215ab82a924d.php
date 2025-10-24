<?php $__env->startSection('title', 'Step 4: Your Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="glass-panel rounded-3xl max-w-6xl mx-auto overflow-hidden shadow-2xl">
    <div class="grid md:grid-cols-2">
        
        <div class="hidden md:block relative">
            <img src="https://placehold.co/800x1200/0d9488/FFFFFF?text=Final+Details&font=poppins" class="absolute h-full w-full object-cover" alt="A customer happily checking in at the front desk">
            <div class="absolute inset-0 bg-teal-800/50"></div>
            <div class="relative z-10 p-12 text-white flex flex-col h-full">
                <div>
                    <h2 class="text-3xl font-bold">You're Almost Done!</h2>
                    <p class="mt-2 text-cyan-100">Please provide your contact information to finalize and confirm your appointment.</p>
                </div>
                <div class="mt-auto text-cyan-200 text-sm">
                    <p>We'll send a confirmation email and reminders to the address you provide.</p>
                </div>
            </div>
        </div>

        <div class="p-8 md:p-12">
            <div class="mb-8">
                <div class="flex justify-between items-center text-sm font-semibold text-black mb-2">
                    <span class="text-black">Step 4/5: Your Details</span>
                    <span class="text-black">80%</span>
                </div>
                <div class="w-full bg-emerald-200/60 rounded-full h-2.5">
                    <div class="bg-emerald-500 h-2.5 rounded-full transition-all duration-300" style="width: 80%"></div>
                </div>
            </div>

            <div class="text-left mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-black">Enter Your Details</h1>
                <p class="mt-2 text-lg text-black">This information will be used to confirm your booking.</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="mb-4 bg-red-500/30 border border-red-400 text-black px-4 py-3 rounded-lg relative" role="alert">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form x-data="{
                showPrivacyModal: false,
                agreed: false,
                scrolledToBottom: false,
                handleScroll(e) {
                    const el = e ? e.target : document.getElementById('privacyPolicyText');
                    if (el.scrollTop + el.clientHeight >= el.scrollHeight - 2) {
                        this.scrolledToBottom = true;
                    }
                }
            }" x-ref="bookingForm" action="<?php echo e(route('booking.store.step-four')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="space-y-6 text-black">
                    <div>
                        <label for="client_name" class="block text-lg font-semibold mb-2 text-black">Full Name</label>
               <input type="text" name="client_name" id="client_name" required
                   class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white text-black" placeholder="e.g., Jane Doe">
                    </div>
                    <div>
                        <label for="client_email" class="block text-lg font-semibold mb-2 text-black">Email Address</label>
               <input type="email" name="client_email" id="client_email" required
                   class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white text-black" placeholder="you@example.com">
                    </div>
                     <div>
                        <label for="client_phone" class="block text-lg font-semibold mb-2 text-black">Phone Number</label>
               <input type="tel" name="client_phone" id="client_phone" required
                   pattern="^[0-9]{11}$" maxlength="11" minlength="11" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
             class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white text-black" placeholder="e.g., 09171234567">
               <small class="text-black/70 text-sm">Please enter exactly 11 numbers (digits only)</small>
                    </div>
                </div>

                    <div class="mt-10 flex justify-between">
                    <a href="<?php echo e(route('booking.create.step-three')); ?>" class="bg-white border-2 border-emerald-400 text-emerald-600 font-bold py-3 px-10 rounded-full shadow-lg hover:bg-emerald-50 hover:text-emerald-700 transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                        &larr; Back
                    </a>
                    <!-- Open privacy modal before submitting -->
                    <button type="button" @click="showPrivacyModal = true" class="bg-white text-teal-600 font-bold py-3 px-10 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                        Next Step &rarr;
                    </button>
                </div>

                <!-- Privacy Policy Modal -->
                <div x-cloak x-show="showPrivacyModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/60" @click="showPrivacyModal = false"></div>
                    <div class="relative bg-white text-black rounded-2xl max-w-3xl w-full mx-4 p-6 shadow-xl">
                        <h3 class="text-2xl font-semibold mb-3">Privacy Policy</h3>
                        <div class="max-h-72 overflow-y-auto text-sm leading-relaxed mb-4" id="privacyPolicyText" @scroll="handleScroll">
                            <p class="mb-3 font-semibold">Your privacy is important to us.</p>
                            <p class="mb-3">At Renzman Blind Massage, we are committed to protecting your personal information in accordance with the Data Privacy Act of 2012 (Republic Act No. 10173).</p>
                            <p class="mb-3">As part of our booking process, we may collect certain personal details such as your full name, contact number, preferred schedule, and service request. This information helps us confirm your appointment, send reminders, and provide better service to you.</p>

                            <p class="mb-2 font-semibold">We assure you that:</p>
                            <ul class="list-disc list-inside mb-3">
                                <li>The information you provide will be used only for scheduling, confirming, and managing your appointment.</li>
                                <li>All personal data collected will be treated with strict confidentiality.</li>
                                <li>Your data will not be shared, sold, or disclosed to any other individual, company, or third party without your consent.</li>
                                <li>We store your information securely and take necessary measures to protect it from unauthorized access or misuse.</li>
                                <li>You have the right to access, correct, or request deletion of your data at any time by contacting us through our official channels.</li>
                            </ul>

                            <p class="mb-3">By clicking “I Agree,” you are giving your voluntary consent for Renzman Blind Massage to collect, store, and process your personal information for legitimate business purposes only, specifically for handling your appointment and customer records.</p>
                        </div>

                        <div class="flex items-center space-x-3 mb-4">
                            <input type="checkbox" id="agree" x-model="agreed" class="w-4 h-4" :disabled="!scrolledToBottom" />
                            <label for="agree" class="text-sm" :class="{'opacity-60': !scrolledToBottom}">I Agree</label>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="showPrivacyModal = false" class="px-4 py-2 rounded-full bg-gray-200 hover:bg-gray-300">Cancel</button>
                            <button type="button" :disabled="!agreed" @click="$refs.bookingForm.submit()" :class="agreed ? 'bg-teal-600 text-white hover:bg-teal-700' : 'bg-gray-300 text-gray-600 cursor-not-allowed'" class="px-4 py-2 rounded-full font-bold">
                                Continue
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.Booking', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/booking/step-four.blade.php ENDPATH**/ ?>