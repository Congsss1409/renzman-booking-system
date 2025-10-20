<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RevenueReportController extends Controller
{
    public function monthlyPdf(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $reportStatuses = ['Confirmed', 'In Progress', 'Completed'];

        // Get all bookings for the report
        $bookings = Booking::with(['therapist', 'service', 'branch'])
            ->whereIn('status', $reportStatuses)
            ->whereMonth('start_time', $month)
            ->whereYear('start_time', $year)
            ->orderBy('start_time')
            ->get();

        // Only count completed bookings for revenue
        $totalRevenue = $bookings->where('status', 'Completed')->sum('price');
        $monthName = Carbon::create(null, $month)->format('F');

        $pdf = Pdf::loadView('admin.reports.revenue-pdf', [
            'bookings' => $bookings,
            'totalRevenue' => $totalRevenue,
            'monthName' => $monthName,
            'year' => $year,
            'month' => $month
        ])->setPaper('a4', 'portrait')->setOptions([
            'defaultFont' => 'Arial',
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => false,
            'chroot' => public_path(),
        ]);

        $filename = "Renzman_Revenue_Report_{$monthName}_{$year}.pdf";
        return $pdf->download($filename);
    }
}
