<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Get list of all branches
     */
    public function index()
    {
        $branches = Branch::orderBy('name')
            ->select('id', 'name', 'address', 'contact_number')
            ->get();

        return response()->json($branches);
    }
}