<?php $__env->startSection('title', 'Therapists Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Therapists <span class="text-teal-500">Management</span></h1>
            <p class="text-gray-500 mt-1">Add, edit, or remove therapists from your team.</p>
        </div>
        <a href="<?php echo e(route('admin.therapists.create')); ?>" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-6 rounded-full shadow-lg transition-transform transform hover:scale-105 whitespace-nowrap">
            + ADD THERAPIST
        </a>
    </div>

    <!-- Therapists Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $therapists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $therapist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-stone-50 rounded-2xl p-6 text-center shadow-lg border hover:shadow-xl transition-shadow duration-300">
                <img src="<?php echo e($therapist->image_url ? $therapist->image_url . '?v=' . $therapist->updated_at->timestamp : 'https://ui-avatars.com/api/?name=' . urlencode($therapist->name) . '&color=FFFFFF&background=059669&size=128'); ?>" alt="<?php echo e($therapist->name); ?>" class="w-24 h-24 mx-auto rounded-full mb-4 object-cover border-4 border-white shadow-md">
                <p class="text-xl font-bold text-gray-800"><?php echo e($therapist->name); ?></p>
                <p class="font-semibold text-teal-500">Therapist</p>
                <p class="text-gray-500 mt-2 flex items-center justify-center gap-2 text-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    <?php echo e($therapist->branch->name ?? 'No Branch Assigned'); ?>

                </p>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="<?php echo e(route('admin.therapists.edit', $therapist->id)); ?>" class="font-semibold bg-cyan-400 text-white py-2 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">EDIT</a>
                    <form action="<?php echo e(route('admin.therapists.destroy', $therapist->id)); ?>" method="POST" class="delete-form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="button" class="font-semibold bg-red-500 text-white py-2 px-8 rounded-full shadow-md transition-transform transform hover:scale-105 delete-button">DELETE</button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12 text-gray-500">
                <p class="font-bold text-lg">No therapists found.</p>
                <p>Click the "Add Therapist" button to get started.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <div class="mt-8">
        <?php echo e($therapists->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#14b8a6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.submit();
                }
            })
        });
    });
});
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/admin/therapists.blade.php ENDPATH**/ ?>