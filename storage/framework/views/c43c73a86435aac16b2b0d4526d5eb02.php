<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Revenue Report - <?php echo e($monthName); ?> <?php echo e($year); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        
        .container {
            border: 2px solid #000;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .subtitle {
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-row {
            margin-bottom: 5px;
        }
        
        .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background: #f0f0f0;
            font-weight: bold;
        }
        
        .amount {
            text-align: right;
        }
        
        .total {
            background: #e0e0e0;
            font-weight: bold;
        }
        

    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="title">RENZMAN BLIND MASSAGE</div>
            <div class="subtitle">Revenue Report - <?php echo e($monthName); ?> <?php echo e($year); ?></div>
        </div>
        
        <!-- Basic Info -->
        <div class="info-section">
            <div class="info-row">
                <span class="label">Report ID:</span> REV-<?php echo e($year); ?>-<?php echo e(str_pad($month, 2, '0', STR_PAD_LEFT)); ?>

            </div>
            <div class="info-row">
                <span class="label">Period:</span> <?php echo e($monthName); ?> <?php echo e($year); ?>

            </div>
            <div class="info-row">
                <span class="label">Generated:</span> <?php echo e(now()->format('F d, Y - h:i A')); ?>

            </div>
        </div>
        
        <!-- Revenue Table -->
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Therapist</th>
                    <th>Status</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('M d')); ?></td>
                    <td><?php echo e($booking->client_name); ?></td>
                    <td><?php echo e($booking->service->name ?? 'N/A'); ?></td>
                    <td><?php echo e($booking->therapist->name ?? 'N/A'); ?></td>
                    <td><?php echo e($booking->status); ?></td>
                    <td class="amount">PHP <?php echo e(number_format($booking->price, 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No bookings found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Summary -->
        <table>
            <tr class="total">
                <td><strong>Total Revenue</strong></td>
                <td class="amount"><strong>PHP <?php echo e(number_format($totalRevenue, 2)); ?></strong></td>
            </tr>
            <tr>
                <td>Total Bookings</td>
                <td class="amount"><?php echo e($bookings->count()); ?></td>
            </tr>
        </table>
        
        <p style="text-align: center; margin-top: 20px; font-size: 10px;">
            Generated on <?php echo e(now()->format('F d, Y \a\t h:i A')); ?>

        </p>
    </div>
</body>
</html><?php /**PATH C:\Desktop\renzman-booking-system\resources\views/admin/reports/revenue-pdf.blade.php ENDPATH**/ ?>