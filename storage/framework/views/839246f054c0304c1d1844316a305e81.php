<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-8">
    
    <style>
        html, body { scroll-behavior: smooth; }
        .smooth-scroll { scroll-behavior: smooth; -webkit-overflow-scrolling: touch; }
    </style>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 mt-1">Welcome back, here's a summary of your activities.</p>
        </div>
        <button 
            type="button"
            x-data 
            @click.prevent="$dispatch('open-modal', 'appointment-modal')" 
            class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-6 rounded-full shadow-lg transition-transform transform hover:scale-105 whitespace-nowrap">
            + NEW APPOINTMENT
        </button>
    </div>

    <!-- Revenue Analytics Filter removed -->
    <!-- Dashboard Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
        <div class="bg-gradient-to-br from-teal-400 to-cyan-600 text-white p-6 rounded-2xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start"><h4 class="text-lg font-semibold">Today's Bookings</h4><svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
            <p class="text-6xl font-bold mt-4"><?php echo e($todaysBookings); ?></p>
        </div>
        <div class="bg-gradient-to-br from-teal-400 to-cyan-600 text-white p-6 rounded-2xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start"><h4 class="text-lg font-semibold">Total Bookings</h4><svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
            <p class="text-6xl font-bold mt-4"><?php echo e($totalBookings); ?></p>
        </div>
        <div 
            class="bg-gradient-to-br from-teal-400 to-cyan-600 text-white p-6 rounded-2xl shadow-xl transform hover:-translate-y-1 transition-all duration-300 cursor-pointer hover:shadow-2xl"
            x-data 
            @click="$dispatch('open-modal', 'revenue-modal')">
            <div class="flex justify-between items-start"><h4 class="text-lg font-semibold">Total Revenue</h4><svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01M12 6v-1m0-1V4m0 2.01M12 18v-1m0-1v-1m0 2v1m0 1v1M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg></div>
            <p class="text-5xl font-bold mt-4">₱<?php echo e(number_format($totalRevenue, 2)); ?></p>
            <div class="mt-2 text-sm opacity-75">Click to view details</div>
        </div>
        <div class="bg-gradient-to-br from-teal-400 to-cyan-600 text-white p-6 rounded-2xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start"><h4 class="text-lg font-semibold">Average Rating</h4><svg class="w-8 h-8 opacity-80" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg></div>
            <p class="text-5xl font-bold mt-4"><?php echo e(number_format($averageRating, 2)); ?> <span class="text-yellow-300">★</span></p>
        </div>
        <div class="bg-gradient-to-br from-green-200 to-green-400 text-green-900 p-6 rounded-2xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start"><h4 class="text-lg font-semibold">Completed Bookings</h4><svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
            <p class="text-5xl font-bold mt-4"><?php echo e($totalCompleted); ?></p>
        </div>
        <div class="bg-gradient-to-br from-red-200 to-red-400 text-red-900 p-6 rounded-2xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start"><h4 class="text-lg font-semibold">Cancellations</h4><svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></div>
            <p class="text-5xl font-bold mt-4"><?php echo e($totalCancellations); ?></p>
        </div>
    </div>


    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Left Column: All Bookings Table -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-lg">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                <h2 class="text-2xl font-bold text-gray-800">All Bookings</h2>
                <form action="<?php echo e(route('admin.dashboard')); ?>" method="GET" class="flex items-center">
                    <input type="text" name="search" placeholder="Search bookings..." value="<?php echo e(request('search')); ?>" class="w-full sm:w-64 p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <button type="submit" class="bg-teal-500 text-white p-2 rounded-r-lg hover:bg-teal-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <?php $sort_by = request('sort_by', 'start_time'); $sort_order = request('sort_order', 'desc'); ?>
                            <th scope="col" class="px-4 py-3"><a href="<?php echo e(route('admin.dashboard', ['sort_by' => 'client_name', 'sort_order' => ($sort_by == 'client_name' && $sort_order == 'asc') ? 'desc' : 'asc', 'search' => request('search')])); ?>" class="flex items-center gap-1">Client <?php if($sort_by == 'client_name'): ?><span class="text-teal-500"><?php echo e($sort_order == 'asc' ? '▲' : '▼'); ?></span><?php endif; ?></a></th>
                            <th scope="col" class="px-4 py-3">Details</th>
                            <th scope="col" class="px-4 py-3"><a href="<?php echo e(route('admin.dashboard', ['sort_by' => 'start_time', 'sort_order' => ($sort_by == 'start_time' && $sort_order == 'asc') ? 'desc' : 'asc', 'search' => request('search')])); ?>" class="flex items-center gap-1">Schedule <?php if($sort_by == 'start_time'): ?><span class="text-teal-500"><?php echo e($sort_order == 'asc' ? '▲' : '▼'); ?></span><?php endif; ?></a></th>
                            <th scope="col" class="px-4 py-3"><a href="<?php echo e(route('admin.dashboard', ['sort_by' => 'created_at', 'sort_order' => ($sort_by == 'created_at' && $sort_order == 'asc') ? 'desc' : 'asc', 'search' => request('search')])); ?>" class="flex items-center gap-1">Created <?php if($sort_by == 'created_at'): ?><span class="text-teal-500"><?php echo e($sort_order == 'asc' ? '▲' : '▼'); ?></span><?php endif; ?></a></th>
                            <th scope="col" class="px-4 py-3"><a href="<?php echo e(route('admin.dashboard', ['sort_by' => 'status', 'sort_order' => ($sort_by == 'status' && $sort_order == 'asc') ? 'desc' : 'asc', 'search' => request('search')])); ?>" class="flex items-center gap-1">Status <?php if($sort_by == 'status'): ?><span class="text-teal-500"><?php echo e($sort_order == 'asc' ? '▲' : '▼'); ?></span><?php endif; ?></a></th>
                            <th scope="col" class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-4 py-4">
                                    <p class="font-medium text-gray-900"><?php echo e($booking->client_name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($booking->client_phone); ?></p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-xs"><?php echo e($booking->service->name ?? 'N/A'); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($booking->therapist->name ?? 'N/A'); ?> at <?php echo e($booking->branch->name ?? 'N/A'); ?></p>
                                    <p class="font-bold text-xs text-teal-600">₱<?php echo e(number_format($booking->price, 2)); ?></p>
                                </td>
                                <td class="px-4 py-4"><p class="text-xs"><?php echo e($booking->start_time->format('M d, Y')); ?></p><p class="text-xs text-gray-500"><?php echo e($booking->start_time->format('g:i A')); ?></p></td>
                                <td class="px-4 py-4 text-xs text-gray-500">
                                    <p><?php echo e($booking->created_at->format('M d, Y')); ?></p>
                                    <p class="text-gray-400"><?php echo e($booking->created_at->format('g:i A')); ?></p>
                                </td>
                                <td class="px-4 py-4"><span class="font-semibold text-xs px-3 py-1 rounded-full <?php echo e($booking->status == 'Confirmed' ? 'bg-green-100 text-green-800' : ($booking->status == 'Cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>"><?php echo e($booking->status); ?></span></td>
                                <td class="px-4 py-4">
                                    <?php if($booking->status !== 'Cancelled' && $booking->status !== 'Completed'): ?>
                                    <form action="<?php echo e(route('admin.bookings.cancel', $booking)); ?>" method="POST" class="cancel-form">
                                        <?php echo csrf_field(); ?>
                                        <button type="button" class="font-medium text-red-600 hover:underline text-xs cancel-button">Cancel</button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="text-center py-12 text-gray-500"><p class="font-bold text-lg">No bookings found.</p><p>Try adjusting your search or filter.</p></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6"><?php echo e($bookings->links()); ?></div>

        </div>

        <!-- Right Column: Analytics Sidebar -->
        <div class="space-y-8">
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Top Services</h3>
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $topServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img src="<?php echo e($service->image_url ?? 'https://placehold.co/128x128/059669/FFFFFF?text=' . substr($service->name, 0, 1)); ?>" alt="<?php echo e($service->name); ?>" class="w-12 h-12 rounded-full object-cover">
                                <div><p class="font-bold text-gray-800"><?php echo e($service->name); ?></p></div>
                            </div>
                            <div class="text-right"><p class="font-bold text-lg text-teal-500"><?php echo e($service->bookings_count); ?></p><p class="text-sm text-gray-500">Bookings</p></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center text-gray-500 py-4">No service data available.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg flex justify-center items-center"><div class="w-full max-w-xs"><canvas id="topServicesChart"></canvas></div></div>
        </div>

    </div>

    <!-- Therapist Booking History (moved below all bookings table) -->
    <div class="bg-white p-6 rounded-2xl shadow-lg mt-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Therapist Booking History</h3>
        <!-- Therapist Search -->
        <div class="mb-4">
            <input type="text" id="therapist-search" placeholder="Search therapist or branch..." class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" onkeyup="filterTherapists()">
        </div>
        <div class="space-y-8 max-h-[400px] overflow-y-auto pr-2" id="therapist-history-list">
            <?php $allTherapists = \App\Models\Therapist::with('branch')->orderBy('name')->get(); ?>
            <?php $__empty_1 = true; $__currentLoopData = $allTherapists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $therapist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="border-b pb-4 mb-4">
                    <div class="flex items-center gap-4 mb-2">
                        <img src="<?php echo e($therapist->image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($therapist->name) . '&color=FFFFFF&background=059669&size=128'); ?>" alt="<?php echo e($therapist->name); ?>" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="font-bold text-gray-800 mb-0"><?php echo e($therapist->name); ?></p>
                            <p class="text-xs text-gray-500 mb-0"><?php echo e($therapist->branch->name ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700 mb-1">Recent Bookings:</p>
                        <?php
                            $recentBookings = \App\Models\Booking::where('therapist_id', $therapist->id)
                                ->orderBy('start_time', 'desc')
                                ->take(5)
                                ->get();
                        ?>
                        <?php if($recentBookings->count()): ?>
                            <ul class="text-xs text-gray-600">
                                <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <?php echo e($booking->start_time->format('M d, Y')); ?> - <?php echo e($booking->client_name); ?> (<?php echo e($booking->status); ?>)
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <span class="text-xs text-gray-400">No booking history</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-gray-500 py-4">No therapist data available.</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
    function filterTherapists() {
        const input = document.getElementById('therapist-search');
        const filter = input.value.toLowerCase();
        const list = document.getElementById('therapist-history-list');
        const therapists = Array.from(list.children).filter(div => div.classList.contains('border-b'));
        therapists.forEach(div => {
            const name = div.querySelector('.font-bold.text-gray-800')?.textContent.toLowerCase() || '';
            const branch = div.querySelector('.text-xs.text-gray-500')?.textContent.toLowerCase() || '';
            if (name.includes(filter) || branch.includes(filter)) {
                div.style.display = '';
            } else {
                div.style.display = 'none';
            }
        });
    }
    </script>
    </div>
</div>

<!-- New Appointment Modal -->
<div x-data="appointmentModal(<?php echo e(json_encode($todayForJs)); ?>)"
    x-init="initCalendar()"
    x-show="show"
    x-on:open-modal.window="if ($event.detail === 'appointment-modal') show = true"
    x-on:close-modal.window="closeModal()"
    x-on:keydown.escape.window="closeModal()"
    style="display: none;"
    class="fixed inset-0 bg-black bg-opacity-60 flex items-start justify-center p-4 overflow-y-auto z-[9999]">

    <div @click.away="closeModal()" class="bg-white rounded-3xl p-8 w-full max-w-4xl shadow-2xl max-h-[calc(100vh-4rem)] flex flex-col overflow-hidden my-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-3xl font-bold text-gray-800" x-text="modalTitle"></h2>
            <button @click="closeModal()" class="text-gray-400 hover:text-gray-600 text-3xl font-bold">&times;</button>
        </div>
        
        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-teal-500 h-2.5 rounded-full transition-all duration-500" :style="`width: ${stepPercentage}%`"></div>
            </div>
        </div>

    <div class="flex-grow overflow-y-auto pr-2 smooth-scroll">
            <form id="appointmentForm" x-ref="appointmentForm" action="<?php echo e(route('admin.bookings.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <!-- Hidden inputs to store selections -->
                <input type="hidden" name="branch_id" :value="formData.branch_id">
                <input type="hidden" name="service_id" :value="formData.service_id">
                <input type="hidden" name="therapist_id" :value="formData.therapist_id">
                <input type="hidden" name="booking_date" :value="formData.booking_date">
                <input type="hidden" name="booking_time" :value="formData.booking_time">
                <input type="hidden" name="client_name" :value="formData.client_name">
                <input type="hidden" name="client_phone" :value="formData.client_phone">
                <input type="hidden" name="client_email" :value="formData.client_email">

                <!-- Step 1: Select Branch & Service -->
                <div x-show="currentStep === 1" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold text-gray-700">Branch</label>
                            <select name="branch_select" x-model="formData.branch_id" @change="fetchTherapists()" class="w-full mt-2 bg-stone-100 p-4 rounded-full border-none focus:ring-2 focus:ring-teal-400 outline-none">
                                <option value="">Select Branch</option>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">Service</label>
                            <select name="service_select" x-model="formData.service_id" class="w-full mt-2 bg-stone-100 p-4 rounded-full border-none focus:ring-2 focus:ring-teal-400 outline-none">
                                <option value="">Select Service</option>
                                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?> (<?php echo e($service->duration); ?> mins)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Select Therapist -->
                <div x-show="currentStep === 2" x-transition>
                    <div class="space-y-3 max-h-[50vh] overflow-y-auto smooth-scroll">
                        <template x-if="loadingTherapists">
                            <p class="text-center text-gray-500">Loading therapists...</p>
                        </template>
                            <template x-for="therapist in availableTherapists" :key="therapist.id">
                            <label class="block">
                                <input type="radio" name="therapist_id" x-model="formData.therapist_id" :value="therapist.id" class="hidden peer">
                                <div class="p-4 rounded-lg border border-gray-300 cursor-pointer peer-checked:bg-teal-500 peer-checked:text-white peer-checked:border-teal-500 hover:border-teal-400 transition-all">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <img :src="getImageUrl(therapist.image_url, therapist.name)" :alt="therapist.name" class="w-12 h-12 rounded-full object-cover">
                                            <div><p class="font-bold text-lg" x-text="therapist.name"></p></div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </template>
                        <template x-if="!loadingTherapists && availableTherapists.length === 0">
                            <p class="text-center text-gray-500">No therapists available for this branch.</p>
                        </template>
                    </div>
                </div>

                <!-- Step 3: Date & Time -->
                <div x-show="currentStep === 3" x-transition>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-lg min-w-[320px] xl:min-w-[380px]">
                            <div class="flex items-center justify-between mb-4">
                                <button type="button" @click="prevMonth()" class="p-2 rounded-full hover:bg-gray-200 focus:outline-none"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                                <div class="text-lg font-semibold" x-text="`${months[month]} ${year}`"></div>
                                <button type="button" @click="nextMonth()" class="p-2 rounded-full hover:bg-gray-200 focus:outline-none"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                            </div>
                            <div class="grid grid-cols-7 gap-1 text-center text-sm">
                                <template x-for="(day, idx) in days" :key="idx"><div class="font-medium text-gray-600" x-text="day"></div></template>
                                <template x-for="(_, idx) in blankDays" :key="`blank-${idx}`"><div class="border-none"></div></template>
                                <template x-for="day in dayCount" :key="day">
                                    <div @click="selectDate(day)"
                                         :class="{
                                             'bg-teal-500 text-white font-bold shadow-md': isSelected(day),
                                             'hover:bg-gray-200 cursor-pointer': !isPast(day) && !isSelected(day),
                                             'text-gray-400 cursor-not-allowed opacity-50': isPast(day)
                                         }"
                                         class="p-2 rounded-full transition-all duration-200" x-text="day"></div>
                                </template>
                            </div>
                        </div>
                        <div class="min-w-[220px] xl:min-w-[260px]">
                            <label class="block text-lg font-semibold mb-2">Available Times for <span class="text-gray-800 font-bold" x-text="selectedDateFormatted"></span></label>
                            <div class="bg-gray-50 rounded-lg p-6 h-[284px] overflow-y-auto flex flex-col gap-4 smooth-scroll">
                                <div x-show="loadingSlots" class="flex items-center justify-center h-full"><svg class="animate-spin h-8 w-8 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>
                                <div x-show="!loadingSlots && availableSlots.length > 0" class="grid grid-cols-3 gap-2">
                                    <template x-for="slot in availableSlots" :key="slot">
                                        <button type="button" @click="formData.booking_time = slot" :class="formData.booking_time === slot ? 'bg-teal-500 text-white font-semibold' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'" class="p-2 rounded-lg text-sm text-center transition-all duration-200"><span x-text="formatTime(slot)"></span></button>
                                    </template>
                                </div>
                                <div x-show="!loadingSlots && availableSlots.length === 0" class="flex items-center justify-center h-full text-center"><p class="text-gray-500">No available time slots.<br>Please select another date.</p></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Client Details & Review -->
                <div x-show="currentStep === 4" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold mb-4">Client Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="font-semibold text-gray-700">Client Name</label>
                                    <input type="text" x-model="formData.client_name" class="w-full mt-2 bg-stone-100 p-4 rounded-full border-none focus:ring-2 focus:ring-teal-400 outline-none">
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">Client Phone</label>
                                    <input type="text" x-model="formData.client_phone" class="w-full mt-2 bg-stone-100 p-4 rounded-full border-none focus:ring-2 focus:ring-teal-400 outline-none">
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">Client Email</label>
                                    <input type="email" x-model="formData.client_email" required class="w-full mt-2 bg-stone-100 p-4 rounded-full border-none focus:ring-2 focus:ring-teal-400 outline-none">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-xl font-bold mb-4">Appointment Summary</h3>
                            <div class="space-y-3 text-gray-600">
                                <div class="flex justify-between"><span class="font-semibold">Service:</span> <span x-text="getServiceName()"></span></div>
                                <div class="flex justify-between"><span class="font-semibold">Branch:</span> <span x-text="getBranchName()"></span></div>
                                <div class="flex justify-between"><span class="font-semibold">Therapist:</span> <span x-text="getTherapistName()"></span></div>
                                <div class="flex justify-between"><span class="font-semibold">Date:</span> <span x-text="selectedDateFormatted"></span></div>
                                <div class="flex justify-between"><span class="font-semibold">Time:</span> <span x-text="formatTime(formData.booking_time)"></span></div>
                                <!-- Extended session not applicable for admin modal bookings -->
                                <hr class="my-2">
                                <div class="flex justify-between font-bold text-gray-800 text-lg"><span class="">Total Price:</span> <span x-text="`₱${getFinalPrice()}`"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Modal Footer with Navigation -->
        <div class="mt-8 pt-4 border-t flex justify-between items-center">
            <button type="button" @click="prevStep()" x-show="currentStep > 1" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">Back</button>
            <div x-show="currentStep === 1" class="w-full text-right">
                <button type="button" @click="nextStep()" :disabled="!isStep1Valid()" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">Next</button>
            </div>
            <button type="button" @click="nextStep()" x-show="currentStep === 2" :disabled="!isStep2Valid()" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">Next</button>
            <button type="button" @click="nextStep()" x-show="currentStep === 3" :disabled="!isStep3Valid()" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">Next</button>
            <button type="submit" form="appointmentForm" x-show="currentStep === 4" :disabled="!isStep4Valid()" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">CONFIRM APPOINTMENT</button>
        </div>
    </div>


</div>

<!-- Revenue Analytics Modal -->
<div x-data="revenueModal()"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    x-on:open-modal.window="if ($event.detail === 'revenue-modal') openModal()"
    x-on:close-modal.window="closeModal()"
    x-on:keydown.escape.window="closeModal()"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-start justify-center p-4 overflow-y-auto z-[9998]"
    style="display: none;">
    
    <div @click.away="closeModal()" class="bg-white rounded-3xl p-8 w-full max-w-4xl shadow-2xl max-h-[calc(100vh-4rem)] flex flex-col overflow-hidden my-8">
       <div class="overflow-y-auto pr-2 smooth-scroll">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Revenue Analytics</h2>
            <button @click="closeModal()" class="text-gray-400 hover:text-gray-600 text-3xl font-bold">&times;</button>
        </div>

        <!-- Revenue Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Revenue Card -->
            <div class="bg-gradient-to-br from-teal-400 to-cyan-600 text-white p-6 rounded-2xl">
                <h4 class="text-lg font-semibold mb-2">All Time Revenue</h4>
                <p class="text-3xl font-bold">₱<?php echo e(number_format($totalRevenue, 2)); ?></p>
            </div>
            
            <!-- Monthly Revenue Card -->
            <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-6 rounded-2xl">
                <h4 class="text-lg font-semibold mb-2">Monthly Revenue</h4>
                <p class="text-3xl font-bold">₱<?php echo e(number_format($monthlyRevenue, 2)); ?></p>
                <p class="text-sm opacity-80"><?php echo e(DateTime::createFromFormat('!m', $selectedMonth)->format('F')); ?> <?php echo e($selectedYear); ?></p>
            </div>
            
            <!-- Average per Booking -->
            <div class="bg-gradient-to-br from-green-400 to-green-600 text-white p-6 rounded-2xl">
                <h4 class="text-lg font-semibold mb-2">Average per Booking</h4>
                <p class="text-3xl font-bold">₱<?php echo e(number_format($totalRevenue > 0 && $totalBookings > 0 ? $totalRevenue / $totalBookings : 0, 2)); ?></p>
                <p class="text-sm opacity-80">Based on all bookings</p>
            </div>
        </div>

        <!-- Filter Controls -->
        <div class="bg-gray-50 rounded-2xl p-6 mb-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Filter Revenue Data</h3>
            <div class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Month</label>
                    <select x-model="selectedMonth" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <?php for($m = 1; $m <= 12; $m++): ?>
                            <option value="<?php echo e($m); ?>"><?php echo e(DateTime::createFromFormat('!m', $m)->format('F')); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                    <select x-model="selectedYear" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <?php for($y = now()->year; $y >= 2020; $y--): ?>
                            <option value="<?php echo e($y); ?>"><?php echo e($y); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <button @click="updateRevenue()" class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Update Data
                </button>
            </div>
        </div>

    <!-- Export Options -->
    <div class="bg-gray-50 rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Export Revenue Report</h3>
            <div class="flex flex-wrap gap-4">
                <button @click="exportPDF()" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export as PDF
                </button>
                
                <button @click="exportExcel()" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export as Excel
                </button>
            </div>
            
            <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-blue-800">Export Information</p>
                        <p class="text-sm text-blue-600 mt-1">Reports include all confirmed, in progress, and completed bookings for the selected month and year.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('appointmentModal', (todayForJs) => {
        const services = <?php echo json_encode($services->mapWithKeys(fn($s) => [$s->id => ['name' => $s->name, 'price' => $s->price, 'duration' => $s->duration]])) ?>;
        const branches = <?php echo json_encode($branches->pluck('name', 'id'), 512) ?>;
        const extensionPrice = 500;

        return {
            show: <?php echo e($errors->bookingCreation->any() ? 'true' : 'false'); ?>,
            currentStep: 1,
            
            formData: {
                branch_id: '<?php echo e(old('branch_id')); ?>',
                service_id: '<?php echo e(old('service_id')); ?>',
                therapist_id: '<?php echo e(old('therapist_id')); ?>',
                booking_date: '<?php echo e(old('booking_date')); ?>',
                booking_time: '<?php echo e(old('booking_time')); ?>',
                client_name: '<?php echo e(old('client_name')); ?>',
                client_phone: '<?php echo e(old('client_phone')); ?>',
                client_email: '<?php echo e(old('client_email')); ?>',
            },

            availableTherapists: [], availableSlots: [],
            loadingTherapists: false, loadingSlots: false,
            
            month: '', year: '', dayCount: [], blankDays: [],
            days: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            selectedDate: '', selectedDateFormatted: '',

            // --- COMPUTED PROPERTIES ---
            get modalTitle() {
                switch(this.currentStep) {
                    case 1: return 'Step 1: Service Details';
                    case 2: return 'Step 2: Select a Therapist';
                    case 3: return 'Step 3: Choose Date & Time';
                    case 4: return 'Step 4: Client & Review';
                    default: return 'New Appointment';
                }
            },
            get stepPercentage() {
                return (this.currentStep / 4) * 100;
            },

            // --- METHODS ---
            openModal() { this.show = true; },
            closeModal() { this.show = false; this.resetModal(); },
            resetModal() {
                this.currentStep = 1;
                this.formData = { branch_id: '', service_id: '', therapist_id: '', booking_date: '', booking_time: '', client_name: '', client_phone: '', client_email: '' };
                this.availableTherapists = [];
                this.availableSlots = [];
                this.initCalendar();
            },
            nextStep() {
                if (this.currentStep < 4) {
                    this.currentStep++;
                    // If entering the Date & Time step, refresh availability
                    if (this.currentStep === 3) {
                        this.fetchAvailability();
                    }
                }
            },
            prevStep() { if (this.currentStep > 1) this.currentStep--; },
            
            // extension handling removed for modal (walk-in only)

            // Step validation
            isStep1Valid() { return this.formData.branch_id && this.formData.service_id; },
            isStep2Valid() { return this.formData.therapist_id; },
            isStep3Valid() { return this.formData.booking_date && this.formData.booking_time; },
            isStep4Valid() { return this.formData.client_name && this.formData.client_phone && this.formData.client_email; },
            
            // Data fetching
            fetchTherapists() {
                this.formData.therapist_id = ''; // Reset therapist on branch change
                if (!this.formData.branch_id) return;
                this.loadingTherapists = true;
                fetch(`/admin/branches/${this.formData.branch_id}/therapists`)
                    .then(res => res.json())
                    .then(data => { this.availableTherapists = data; })
                    .finally(() => this.loadingTherapists = false);
            },
            fetchAvailability() {
                if (!this.selectedDate || !this.formData.therapist_id || !this.formData.service_id) return;
                this.loadingSlots = true; this.availableSlots = []; this.formData.booking_time = '';
                // Modal bookings do not support extension; always request availability with extended=0
                const url = `/api/therapists/${this.formData.therapist_id}/availability/${this.selectedDate}/${this.formData.service_id}?extended=0`;
                fetch(url, { headers: { 'Cache-Control': 'no-cache' }})
                    .then(res => res.json())
                    .then(data => { this.availableSlots = data; })
                    .finally(() => this.loadingSlots = false);
            },

            // Calendar logic
            initCalendar() {
                const today = new Date(todayForJs.year, todayForJs.month, todayForJs.day);
                this.month = today.getMonth(); this.year = today.getFullYear();
                this.getDays();
                this.selectDate(today.getDate());
            },
            getDays() {
                const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                this.blankDays = Array(new Date(this.year, this.month).getDay()).fill(null);
                this.dayCount = Array.from({ length: daysInMonth }, (_, i) => i + 1);
            },
            prevMonth() { if (this.month === 0) { this.month = 11; this.year--; } else { this.month--; } this.getDays(); },
            nextMonth() { if (this.month === 11) { this.month = 0; this.year++; } else { this.month++; } this.getDays(); },
            formatDate(date) { return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`; },
            selectDate(day) {
                if(this.isPast(day)) return;
                let d = new Date(this.year, this.month, day);
                this.selectedDate = this.formatDate(d);
                this.formData.booking_date = this.selectedDate;
                this.selectedDateFormatted = d.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                this.fetchAvailability();
            },
            isSelected(day) { return this.selectedDate === this.formatDate(new Date(this.year, this.month, day)); },
            isPast(day) {
                const today = new Date(todayForJs.year, todayForJs.month, todayForJs.day);
                return new Date(this.year, this.month, day) < today;
            },

            // Review data getters
            getServiceName() { return services[this.formData.service_id]?.name || 'N/A'; },
            getBranchName() { return branches[this.formData.branch_id] || 'N/A'; },
            getTherapistName() { return this.availableTherapists.find(t => t.id == this.formData.therapist_id)?.name || 'N/A'; },
            getFinalPrice() {
                // Coerce to Number to ensure toFixed exists
                const servicePrice = Number(services[this.formData.service_id]?.price || 0);
                const total = servicePrice; // Admin modal bookings don't include extension
                return Number.isFinite(total) ? total.toFixed(2) : '0.00';
            },
            getImageUrl(imageUrl, name) {
                // If imageUrl is falsy, return ui-avatars direct URL.
                // If imageUrl contains an absolute URL (starts with http), return it directly.
                if (!imageUrl) return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&color=FFFFFF&background=059669&size=128`;
                try {
                    const url = new URL(imageUrl, window.location.origin);
                    // If url is absolute (has protocol), return as-is
                    if (url.protocol === 'http:' || url.protocol === 'https:') return imageUrl;
                } catch (e) {
                    // If new URL failed, fall back to raw imageUrl
                    return imageUrl;
                }
                // For relative paths stored in 'imageUrl', prefix with storage path and trim leading slashes
                return `/storage/${String(imageUrl).replace(/^\/+/, '')}`;
            },
            formatTime(time) {
                if (!time) return 'N/A';
                const [h, m] = time.split(':');
                const hour = parseInt(h, 10);
                const period = hour >= 12 ? 'PM' : 'AM';
                const adjustedHour = hour % 12 === 0 ? 12 : hour % 12;
                return `${adjustedHour}:${m} ${period}`;
            },
            // submitForm removed to use native form submission
        }
    });

    // Revenue Modal Alpine.js Component
    Alpine.data('revenueModal', () => {
        return {
            show: false,
            selectedMonth: <?php echo e($selectedMonth); ?>,
            selectedYear: <?php echo e($selectedYear); ?>,
            isLoading: false,
            
            openModal() { 
                this.show = true; 
            },
            closeModal() { 
                this.show = false; 
            },
            
            updateRevenue() {
                if (this.selectedMonth && this.selectedYear) {
                    window.location.href = `?month=${this.selectedMonth}&year=${this.selectedYear}`;
                }
            },
            
            exportPDF() {
                window.open(`<?php echo e(route('admin.revenue.export.pdf')); ?>?month=${this.selectedMonth}&year=${this.selectedYear}`, '_blank');
            },
            
            exportExcel() {
                window.open(`<?php echo e(route('admin.revenue.export.excel')); ?>?month=${this.selectedMonth}&year=${this.selectedYear}`, '_blank');
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    Chart.defaults.font.family = "'Poppins', sans-serif"; Chart.defaults.color = '#64748b';
    const topServicesCtx = document.getElementById('topServicesChart')?.getContext('2d');
    if (topServicesCtx) { new Chart(topServicesCtx, { type: 'doughnut', data: { labels: <?php echo json_encode($topServicesLabels, 15, 512) ?>, datasets: [{ label: 'Bookings', data: <?php echo json_encode($topServicesData, 15, 512) ?>, backgroundColor: ['#2dd4bf', '#22d3ee', '#60a5fa', '#a78bfa', '#f87171'], borderColor: '#FFFFFF', borderWidth: 4, }] }, options: { responsive: true, cutout: '70%', plugins: { legend: { position: 'bottom' }, title: { display: true, text: 'Top Services by Bookings', font: { size: 18, weight: '600' }, padding: { bottom: 20 } } } } }); }
    
    const cancelButtons = document.querySelectorAll('.cancel-button');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({ 
                title: 'Are you sure?', 
                text: "This booking will be cancelled.", 
                icon: 'warning', 
                showCancelButton: true, 
                confirmButtonColor: '#14b8a6', 
                cancelButtonColor: '#d33', 
                confirmButtonText: 'Yes, cancel it!',
                didOpen: () => {
                    const sweetAlertModal = document.querySelector('.swal2-container');
                    if (sweetAlertModal) sweetAlertModal.style.zIndex = '9999';
                }
            }).then((result) => { 
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we cancel the booking.',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading(),
                    });
                    form.submit(); 
                } 
            })
        });
    });
});
</script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Vincen Basa\Desktop\renzman-booking-system\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>