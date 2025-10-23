
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{
    // Delete branch
    public function destroy(Branch $branch)
    {
        try {
            // Delete the associated image from storage if it exists
            if ($branch->image_url && strpos($branch->image_url, '/storage/') === 0) {
                $path = substr($branch->image_url, 9);
                Storage::disk('public')->delete($path);
            }
            $branch->delete();
            return redirect()->route('admin.branches.index')->with('success', 'Branch deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.branches.index')->with('error', 'Cannot delete branch. It may be associated with other records.');
        }
    }
    // List branches in admin
    public function index()
    {
        $branches = Branch::orderBy('id')->paginate(12);
        return view('admin.branches.index', compact('branches'));
    }

    // Show create branch form
    public function create()
    {
        return view('admin.branches.create');
    }

    // Store new branch
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:branches,name',
            'address' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'address']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('branches', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        Branch::create($data);

        return redirect()->route('admin.branches.index')->with('success', 'Branch created successfully.');
    }

    // Show form for editing branch image
    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    // Update branch image
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        // Store image in 'public/branches' directory
        $path = $request->file('image')->store('branches', 'public');
        
        // Update branch image_url field
        $branch->image_url = '/storage/' . $path;
        $branch->save();
        
        return redirect()->back()->with('success', 'Branch image updated successfully.');
    }

    // Remove branch image
    public function removeImage(Branch $branch)
    {
        if ($branch->image_url) {
            // If stored in /storage, delete from public disk
            if (strpos($branch->image_url, '/storage/') === 0) {
                $path = substr($branch->image_url, 9); // remove '/storage/'
                Storage::disk('public')->delete($path);
            }
            $branch->image_url = null;
            $branch->save();
        }

        return redirect()->back()->with('success', 'Branch image removed successfully.');
    }
}
