<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index()
    {
        $services = Service::orderBy('name')->paginate(12);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB Max
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            // Explicitly use the 'public' disk and store in the 'services' directory.
            $path = $request->file('image')->store('services', 'public');
            $imageUrl = Storage::disk('public')->url($path);
        }

        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name,' . $service->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB Max
        ]);

        $imageUrl = $service->image_url;
        if ($request->hasFile('image')) {
            // Delete the old image from storage if it exists and is a relative storage path
            if ($service->image_url) {
                if (!preg_match('/^https?:\/\//', $service->image_url)) {
                    Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $service->image_url), '/'));
                }
            }
            // Store the new image
            $path = $request->file('image')->store('services', 'public');
            $imageUrl = Storage::disk('public')->url($path);
        }

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        try {
            // Delete the associated image from storage if it exists
            if ($service->image_url) {
                if (!preg_match('/^https?:\/\//', $service->image_url)) {
                    Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $service->image_url), '/'));
                }
            }
            $service->delete();
            return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle cases where the service cannot be deleted due to existing bookings
            return redirect()->route('admin.services.index')->with('error', 'Cannot delete service. It may be associated with existing bookings.');
        }
    }
}

