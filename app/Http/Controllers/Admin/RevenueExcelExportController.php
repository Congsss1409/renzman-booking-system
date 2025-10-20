<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RevenueExcelExportController extends Controller
{
    public function monthlyExcel(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $revenueStatuses = ['Confirmed', 'In Progress', 'Completed'];

        $bookings = Booking::whereIn('status', $revenueStatuses)
            ->whereMonth('start_time', $month)
            ->whereYear('start_time', $year)
            ->orderBy('start_time')
            ->get();

        $totalRevenue = $bookings->sum('price');
    $monthName = Carbon::create(null, $month)->format('F');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Revenue Report');
        $sheet->setCellValue('A1', "Revenue Report for $monthName $year");
        $sheet->setCellValue('A2', "Total Revenue: ₱" . number_format($totalRevenue, 2));
        $sheet->setCellValue('A4', 'Date');
        $sheet->setCellValue('B4', 'Client');
        $sheet->setCellValue('C4', 'Therapist');
        $sheet->setCellValue('D4', 'Amount');

        $row = 5;
        foreach ($bookings as $booking) {
            $sheet->setCellValue('A' . $row, $booking->start_time->format('Y-m-d'));
            $sheet->setCellValue('B' . $row, $booking->client_name);
            $sheet->setCellValue('C' . $row, optional($booking->therapist)->name);
            $sheet->setCellValue('D' . $row, $booking->price);
            $row++;
        }

    $filename = "revenue_report_{$month}_{$year}.xlsx";
    $temp_file = tempnam(sys_get_temp_dir(), $filename);
    $writer = new Xlsx($spreadsheet);
    $writer->save($temp_file);
    return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }
}
