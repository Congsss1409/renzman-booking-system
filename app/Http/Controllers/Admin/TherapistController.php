<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Therapist;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TherapistController extends Controller
{
    /**
     * Display a listing of the therapists.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $selectedBranch = $request->input('branch');

        $therapistsQuery = Therapist::with('branch');

        if ($selectedBranch && $selectedBranch !== 'all') {
            $therapistsQuery->where('branch_id', $selectedBranch);
        }

        if ($search !== '') {
            $therapistsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('branch', function ($branchQuery) use ($search) {
                        $branchQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $therapists = $therapistsQuery->orderBy('name')->paginate(12)->withQueryString();
        $branches = Branch::orderBy('name')->get();

        return view('admin.therapists', compact('therapists', 'branches', 'selectedBranch', 'search'));
    }

    /**
     * Show the form for creating a new therapist.
     */
    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        return view('admin.create-therapist', compact('branches'));
    }

    /**
     * Store a newly created therapist in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // Unique name within the same branch
                \Illuminate\Validation\Rule::unique('therapists')->where(function ($query) use ($request) {
                    return $query->where('branch_id', $request->branch_id);
                }),
            ],
            'branch_id' => 'required|exists:branches,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'name.unique' => 'A therapist with this name already exists in the selected branch.'
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            // Corrected: Explicitly use the 'public' disk and store in the 'therapists' directory.
            $path = $request->file('image')->store('therapists', 'public');
            $imageUrl = Storage::disk('public')->url($path);
        } else {
            $nameForAvatar = urlencode($request->name);
            $imageUrl = "https://ui-avatars.com/api/?name={$nameForAvatar}&color=FFFFFF&background=059669&size=128";
        }

        Therapist::create([
            'name' => $request->name,
            'branch_id' => $request->branch_id,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('admin.therapists.index')->with('success', 'Therapist added successfully.');
    }

    /**
     * Show the form for editing the specified therapist.
     */
    public function edit(Therapist $therapist)
    {
        $branches = Branch::orderBy('name')->get();
        return view('admin.edit-therapist', compact('therapist', 'branches'));
    }

    /**
     * Update the specified therapist in storage.
     */
    public function update(Request $request, Therapist $therapist)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // Unique name within the same branch, ignore current therapist
                \Illuminate\Validation\Rule::unique('therapists')->ignore($therapist->id)->where(function ($query) use ($request) {
                    return $query->where('branch_id', $request->branch_id);
                }),
            ],
            'branch_id' => 'required|exists:branches,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'name.unique' => 'A therapist with this name already exists in the selected branch.'
        ]);

        $imageUrl = $therapist->image_url;
        if ($request->hasFile('image')) {
            // Delete old image if it exists and appears to be a relative storage path
            if ($therapist->image_url && !str_contains($therapist->image_url, 'ui-avatars.com')) {
                // If the URL starts with http(s) it's an absolute URL — don't attempt to delete via storage disk
                if (!preg_match('/^https?:\/\//', $therapist->image_url)) {
                    Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $therapist->image_url), '/'));
                }
            }
            // Corrected: Explicitly use the 'public' disk.
            $path = $request->file('image')->store('therapists', 'public');
            $imageUrl = Storage::disk('public')->url($path);
        }

        $therapist->update([
            'name' => $request->name,
            'branch_id' => $request->branch_id,
            'image_url' => $imageUrl,
        ]);
        

        return redirect()->route('admin.therapists.index')->with('success', 'Therapist updated successfully.');
    }

    /**
     * Remove the specified therapist from storage.
     */
    public function destroy(Therapist $therapist)
    {
        try {
            if ($therapist->image_url && !str_contains($therapist->image_url, 'ui-avatars.com')) {
                if (!preg_match('/^https?:\/\//', $therapist->image_url)) {
                    Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $therapist->image_url), '/'));
                }
            }
            $therapist->delete();
            return redirect()->route('admin.therapists.index')->with('success', 'Therapist deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.therapists.index')->with('error', 'Cannot delete therapist. They may have existing bookings.');
        }
    }
}

