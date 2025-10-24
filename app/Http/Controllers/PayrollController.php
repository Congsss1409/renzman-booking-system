<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Therapist;
use App\Models\PayrollItem;
use App\Models\PayrollPayment;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('therapist')->orderBy('period_start', 'desc')->paginate(20);

        // Today's earnings summary (only include bookings with status 'completed')
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();
        $grossToday = Booking::whereBetween('start_time', [$todayStart, $todayEnd])
            ->whereRaw('LOWER(status) = ?', ['completed'])
            ->sum('price');

        $therapistShareToday = round($grossToday * 0.6, 2);
        $ownerShareToday = round($grossToday * 0.4, 2);

        return view('payrolls.index', compact('payrolls', 'grossToday', 'therapistShareToday', 'ownerShareToday'));
    }

    public function create()
    {
        $therapists = Therapist::orderBy('name')->get();
        return view('payrolls.create', compact('therapists'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'therapist_id' => 'nullable|exists:therapists,id',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
            // gross is calculated from therapist daily rate
            'deductions' => 'nullable|numeric|min:0',
            'status' => 'nullable|string',
        ]);
        // calculate gross based on bookings for the therapist in the period
        $gross = 0;
        if (!empty($data['therapist_id'])) {
            $start = \Carbon\Carbon::parse($data['period_start'])->startOfDay();
            $end = \Carbon\Carbon::parse($data['period_end'])->endOfDay();
            $gross = Booking::where('therapist_id', $data['therapist_id'])
                ->whereBetween('start_time', [$start, $end])
                ->whereRaw('LOWER(status) = ?', ['completed'])
                ->sum('price');
        }

        $data['gross'] = round($gross, 2);
        // split: therapist 60%, owner 40%
    $data['therapist_share'] = round($data['gross'] * 0.6, 2);
    $data['owner_share'] = round($data['gross'] * 0.4, 2);

    $data['deductions'] = $data['deductions'] ?? 0;
    // net = therapist_share - deductions (what therapist receives)
    $data['net'] = round($data['therapist_share'] - $data['deductions'], 2);

        $payroll = Payroll::create($data);

        return redirect()->route('admin.payrolls.show', $payroll->id)->with('success', 'Payroll created');
    }

    public function show(Payroll $payroll)
    {
    $payroll->load('therapist', 'items', 'payments');
    $services = Service::orderBy('name')->get();
    return view('payrolls.show', compact('payroll', 'services'));
    }

    public function addItem(Request $request, Payroll $payroll)
    {

        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'amount' => 'required|numeric',
        ]);

        $service = Service::find($data['service_id']);
        $item = $payroll->items()->create([
            'description' => $service->name,
            'amount' => $data['amount'],
        ]);

        // recalc totals
    $payroll->gross = $payroll->items()->sum('amount');
    $payroll->therapist_share = round($payroll->gross * 0.6, 2);
    $payroll->owner_share = round($payroll->gross * 0.4, 2);
    $payroll->net = round($payroll->therapist_share - $payroll->deductions, 2);
        $payroll->save();

        return redirect()->route('admin.payrolls.show', $payroll->id)->with('success', 'Item added');
    }

    public function removeItem(PayrollItem $item)
    {
        $payroll = $item->payroll;
        $item->delete();
    $payroll->gross = $payroll->items()->sum('amount');
    $payroll->therapist_share = round($payroll->gross * 0.6, 2);
    $payroll->owner_share = round($payroll->gross * 0.4, 2);
    $payroll->net = round($payroll->therapist_share - $payroll->deductions, 2);
        $payroll->save();

        return redirect()->route('admin.payrolls.show', $payroll->id)->with('success', 'Item removed');
    }

    public function addPayment(Request $request, Payroll $payroll)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'paid_at' => 'nullable|date',
            'method' => 'nullable|string',
            'reference' => 'nullable|string',
        ]);

        $data['paid_at'] = $data['paid_at'] ?? now()->toDateString();

        $payment = $payroll->payments()->create($data);

        // If total payments >= net, mark paid
        $totalPaid = $payroll->payments()->sum('amount');
        if (bccomp($totalPaid, $payroll->net, 2) >= 0) {
            $payroll->status = 'paid';
            $payroll->save();
        }

        return redirect()->route('admin.payrolls.show', $payroll->id)->with('success', 'Payment recorded');
    }

    public function generateFromBookings(Request $request)
    {
        $data = $request->validate([
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
        ]);
        $start = \Carbon\Carbon::parse($data['period_start'])->startOfDay();
        $end = \Carbon\Carbon::parse($data['period_end'])->startOfDay();

        $created = 0;

        // iterate each day in the range and create payrolls per therapist per day
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dayStart = $date->copy()->startOfDay();
            $dayEnd = $date->copy()->endOfDay();

            $therapistIds = Booking::whereBetween('start_time', [$dayStart, $dayEnd])
                ->whereRaw('LOWER(status) = ?', ['completed'])
                ->groupBy('therapist_id')
                ->pluck('therapist_id');

            foreach ($therapistIds as $tid) {
                $gross = Booking::where('therapist_id', $tid)
                    ->whereBetween('start_time', [$dayStart, $dayEnd])
                    ->whereRaw('LOWER(status) = ?', ['completed'])
                    ->sum('price');

                if ($gross <= 0) continue;

                // skip if payroll already exists for this therapist and day
                $exists = Payroll::where('therapist_id', $tid)
                    ->whereDate('period_start', $dayStart->toDateString())
                    ->whereDate('period_end', $dayStart->toDateString())
                    ->exists();

                if ($exists) continue;

                $therapistShare = round($gross * 0.6, 2);
                $ownerShare = round($gross * 0.4, 2);

                Payroll::create([
                    'therapist_id' => $tid,
                    'period_start' => $dayStart->toDateString(),
                    'period_end' => $dayStart->toDateString(),
                    'gross' => $gross,
                    'therapist_share' => $therapistShare,
                    'owner_share' => $ownerShare,
                    'deductions' => 0,
                    'net' => $therapistShare,
                    'status' => 'draft',
                ]);

                $created++;
            }
        }

        return redirect()->route('admin.payrolls.index')->with('success', "Generated {$created} payroll(s) from bookings");
    }

    public function exportCsv()
    {
        $rows = Payroll::with('therapist')->orderBy('period_start')->get();

        $filename = 'payrolls_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id', 'therapist', 'period_start', 'period_end', 'gross', 'therapist_share', 'owner_share', 'deductions', 'net', 'status']);

            foreach ($rows as $r) {
                fputcsv($handle, [
                    $r->id,
                    optional($r->therapist)->name,
                    $r->period_start->toDateString(),
                    $r->period_end->toDateString(),
                    $r->gross,
                    $r->therapist_share,
                    $r->owner_share,
                    $r->deductions,
                    $r->net,
                    $r->status,
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportPdf(Payroll $payroll)
    {
        $payroll->load('therapist', 'items', 'payments');

        $company_name = config('app.name', 'Renzman Spa');
        $company_logo_url = asset('images/logo_white.png');
        $employee_name = $payroll->therapist->name ?? 'Unknown Employee';

        // If dompdf is installed, use it. Otherwise return the HTML view.
        if (class_exists(\Dompdf\Dompdf::class) || class_exists(\Barryvdh\DomPDF\Facade::class)) {
            $html = View::make('payrolls.pdf', compact('payroll', 'company_name', 'company_logo_url', 'employee_name'))->render();

            // Prefer barryvdh/laravel-dompdf if available
            if (class_exists(\Barryvdh\DomPDF\Facade::class)) {
                $pdf = \Barryvdh\DomPDF\Facade::loadHTML($html);
                return $pdf->download("payroll_{$payroll->id}.pdf");
            }

            // Fallback to direct Dompdf
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->render();
            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=payroll_{$payroll->id}.pdf",
            ]);
        }

        // If no PDF library, return the HTML view so it can be printed in browser
        return view('payrolls.pdf', compact('payroll', 'company_name', 'company_logo_url', 'employee_name'));
    }

    /**
     * Remove the specified payroll from storage.
     */
    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll deleted successfully.');
    }
}
