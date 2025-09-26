<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Get list of all services
     */
    public function index()
    {
        $services = Service::orderBy('name')
            ->select('id', 'name', 'description', 'duration', 'price')
            ->get();

        return response()->json($services);
    }
}