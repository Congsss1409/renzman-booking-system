<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EventStreamController extends Controller
{
    /**
     * Stream booking updates for the admin dashboard using Server-Sent Events.
     */
    public function bookings(Request $request): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($request) {
            $start = microtime(true);
            $lastId = $request->headers->get('Last-Event-ID');

            while (ob_get_level() > 0) {
                ob_end_flush();
            }
            ob_implicit_flush(true);
            set_time_limit(0);

            $initialSnapshot = Cache::get('dashboard:last-update');
            if (!$lastId && $initialSnapshot && isset($initialSnapshot['id'])) {
                $lastId = $initialSnapshot['id'];
            }

            echo "event: stream.open\n";
            echo 'data: {"connected":true}' . "\n\n";

            while (!connection_aborted()) {
                $update = Cache::get('dashboard:last-update');

                if ($update && isset($update['id']) && $update['id'] !== $lastId) {
                    echo 'id: ' . $update['id'] . "\n";
                    echo "event: bookings.updated\n";
                    echo 'data: ' . json_encode($update) . "\n\n";
                    $lastId = $update['id'];
                } else {
                    echo "event: keep-alive\n";
                    echo "data: {}\n\n";
                }

                @ob_flush();
                flush();

                if ((microtime(true) - $start) > 300) {
                    echo "event: stream.stopped\n";
                    echo "data: {}\n\n";
                    @ob_flush();
                    flush();
                    break;
                }

                sleep(3);
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }
}
