<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Therapist;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TherapistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = Therapist::with('branch');

        if ($sortBy == 'name') {
            $query->orderBy('name', $sortOrder);
        } elseif ($sortBy == 'branch') {
            $query->join('branches', 'therapists.branch_id', '=', 'branches.id')
                  ->orderBy('branches.name', $sortOrder)
                  ->select('therapists.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $therapists = $query->paginate(12);
        return view('admin.therapists', compact('therapists', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        return view('admin.create-therapist', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('therapists', 'public');
        }

        Therapist::create([
            'name' => $validated['name'],
            'branch_id' => $validated['branch_id'],
            'image' => $imagePath
        ]);

        return redirect()->route('admin.therapists.index')->with('success', 'Therapist created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Therapist $therapist)
    {
        $branches = Branch::all();
        return view('admin.edit-therapist', compact('therapist', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Therapist $therapist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $therapist->image;
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($therapist->image) {
                Storage::disk('public')->delete($therapist->image);
            }
            $imagePath = $request->file('image')->store('therapists', 'public');
        }

        $therapist->update([
            'name' => $validated['name'],
            'branch_id' => $validated['branch_id'],
            'image' => $imagePath
        ]);

        return redirect()->route('admin.therapists.index')->with('success', 'Therapist updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Therapist $therapist)
    {
        if ($therapist->image) {
            Storage::disk('public')->delete($therapist->image);
        }
        $therapist->delete();
        return redirect()->route('admin.therapists.index')->with('success', 'Therapist deleted successfully.');
    }
}
