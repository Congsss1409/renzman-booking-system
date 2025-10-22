<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Revenue Report - <?php echo e($monthName); ?> <?php echo e($year); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
               <div class="logo-section">
                <!-- Professional Logo Design -->
                <div class="logo-container">
                    <div class="logo-brand">
                        <div class="brand-initial">R</div>
                        <div class="brand-text">ENZMAN</div>
                    </div>
                    <div class="logo-tagline">Premium Spa Services</div>
                </div>
                
                <div class="company-name">RENZMAN SPA</div>ight: 1.6;
            color: #2d3748;
            background: #f7fafc;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 780px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #2dd4bf 0%, #06b6d4 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.1) 10px, rgba(255,255,255,0.1) 20px),
                repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(255,255,255,0.05) 10px, rgba(255,255,255,0.05) 20px);
            opacity: 0.3;
        }
        
        .logo-section {
            position: relative;
            z-index: 2;
            margin-bottom: 20px;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo-brand {
            background: rgba(255,255,255,0.25);
            border-radius: 20px;
            padding: 20px 30px;
            display: inline-block;
            margin-bottom: 12px;
            border: 3px solid rgba(255,255,255,0.4);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .logo-brand::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        }
        
        .brand-initial {
            font-size: 36px;
            font-weight: 900;
            color: white;
            display: inline-block;
            background: linear-gradient(135deg, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
            width: 60px;
            height: 60px;
            line-height: 60px;
            border-radius: 50%;
            margin-right: 15px;
            vertical-align: middle;
            border: 3px solid rgba(255,255,255,0.5);
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            box-shadow: inset 0 2px 4px rgba(255,255,255,0.2);
        }
        
        .brand-text {
            font-size: 28px;
            font-weight: 900;
            color: white;
            display: inline-block;
            vertical-align: middle;
            letter-spacing: 3px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            font-family: 'Arial Black', Arial, sans-serif;
        }
        
        .logo-tagline {
            font-size: 12px;
            color: rgba(255,255,255,0.9);
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
            background: rgba(255,255,255,0.1);
            padding: 4px 12px;
            border-radius: 8px;
            display: inline-block;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .logo-placeholder {
            background-color: rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 15px 25px;
            margin: 0 auto 15px auto;
            border: 2px solid rgba(255,255,255,0.3);
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .logo-text {
            font-size: 18px;
            font-weight: bold;
            color: white;
            letter-spacing: 3px;
            font-family: Arial, sans-serif;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        
        .report-title {
            font-size: 20px;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        
        .report-period {
            font-size: 16px;
            opacity: 0.8;
            font-weight: 300;
        }
        
        .content {
            padding: 30px 25px;
        }
        
        .summary-section {
            margin-bottom: 40px;
        }
        
        .summary-cards {
            width: 100%;
            margin-bottom: 25px;
            overflow: hidden;
        }
        
        .summary-cards::after {
            content: "";
            clear: both;
            display: table;
        }
        
        .summary-card {
            float: left;
            width: 30%;
            margin-right: 5%;
            border-radius: 12px;
            padding: 25px 20px;
            text-align: left;
            margin-bottom: 20px;
            box-sizing: border-box;
            color: white;
        }
        
        .summary-card:last-child {
            margin-right: 0;
        }
        
        .teal-card {
            background: #2dd4bf;
        }
        
        .blue-card {
            background: #4f96ff;
        }
        
        .green-card {
            background: #22c55e;
        }
        
        .card-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
            color: white;
            opacity: 0.9;
        }
        
        .card-value {
            font-size: 28px;
            font-weight: bold;
            color: white;
            margin-bottom: 5px;
        }
        
        .card-subtitle {
            font-size: 12px;
            color: white;
            opacity: 0.8;
            font-weight: 400;
        }
        
        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #2dd4bf;
        }
        
        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: #2dd4bf;
            color: white;
            font-weight: 600;
            padding: 20px 15px;
            text-align: left;
            font-size: 14px;
        }
        
        td {
            padding: 18px 15px;
            border-bottom: 1px solid #f7fafc;
            font-size: 14px;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        tbody tr:hover {
            background-color: #edf2f7;
        }
        
        .amount {
            text-align: right;
            font-weight: 600;
            color: #2d3748;
        }
        
        .date-column {
            color: #4a5568;
            font-weight: 500;
        }
        
        .client-column {
            font-weight: 600;
            color: #2d3748;
        }
        
        .therapist-column {
            color: #718096;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #a0aec0;
            font-style: italic;
            background-color: #f7fafc;
        }
        
        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            margin-top: 40px;
        }
        
        .footer-text {
            color: #718096;
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .generation-date {
            color: #a0aec0;
            font-size: 11px;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .container {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="logo-section">
                <!-- Professional Logo Design -->
                <div class="logo-container">
                    <div class="logo-brand">
                        <div class="brand-initial">R</div>
                        <div class="brand-text">ENZMAN</div>
                    </div>
                    <div class="logo-tagline">Premium Spa Services</div>
                </div>
                
                <div class="company-name">RENZMAN SPA</div>
                <div class="report-title">Revenue Analytics Report</div>
                <div class="report-period"><?php echo e($monthName); ?> <?php echo e($year); ?></div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content">
            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="summary-cards">
                    <div class="summary-card teal-card">
                        <div class="card-title">All Time Revenue</div>
                        <div class="card-value">₱<?php echo e(number_format($totalRevenue, 2)); ?></div>
                    </div>
                    <div class="summary-card blue-card">
                        <div class="card-title">Monthly Revenue</div>
                        <div class="card-value">₱<?php echo e(number_format($totalRevenue, 2)); ?></div>
                        <div class="card-subtitle"><?php echo e($monthName); ?> <?php echo e($year); ?></div>
                    </div>
                    <div class="summary-card green-card">
                        <div class="card-title">Average per Booking</div>
                        <div class="card-value">₱<?php echo e($bookings->count() > 0 ? number_format($totalRevenue / $bookings->count(), 2) : '0.00'); ?></div>
                        <div class="card-subtitle">Based on all bookings</div>
                    </div>
                </div>
            </div>

            <!-- Detailed Bookings Table -->
            <h3 class="section-title">Detailed Booking Records</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Client Name</th>
                            <th>Therapist</th>
                            <th>Service</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="date-column">
                                    <?php echo e($booking->start_time->format('M d, Y')); ?><br>
                                    <small style="color: #a0aec0;"><?php echo e($booking->start_time->format('h:i A')); ?></small>
                                </td>
                                <td class="client-column"><?php echo e($booking->client_name); ?></td>
                                <td class="therapist-column"><?php echo e(optional($booking->therapist)->name ?? 'Unassigned'); ?></td>
                                <td><?php echo e(optional($booking->service)->name ?? 'N/A'); ?></td>
                                <td class="amount">₱<?php echo e(number_format($booking->price, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="no-data">
                                    <div style="padding: 20px;">
                                        <strong>No bookings found for this period.</strong><br>
                                        <small>Try selecting a different month or year to view revenue data.</small>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <div class="footer-text">
                <strong>Renzman Blind Massage</strong> - Revenue Analytics Report
            </div>
            <div class="generation-date">
                Generated on <?php echo e(now()->format('F d, Y \a\t h:i A')); ?> | <?php echo e($bookings->count()); ?> records processed
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views\admin\reports\revenue-pdf-backup.blade.php ENDPATH**/ ?>