<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'barry:' . (class_exists('Barryvdh\\DomPDF\\Facade\\Pdf') ? 'yes' : 'no') . PHP_EOL;
echo 'dompdf:' . (class_exists('Dompdf\\Dompdf') ? 'yes' : 'no') . PHP_EOL;

try {
    $pdf = app('dompdf.wrapper')->loadHTML('<h1>PDF test</h1>');
    $path = storage_path('app/test-payroll.pdf');
    $pdf->save($path);
    echo 'saved:' . (file_exists($path) ? 'yes' : 'no') . PHP_EOL;
} catch (Throwable $e) {
    echo 'err:' . $e->getMessage() . PHP_EOL;
}
