<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreAboutOurStoreRequest;
use App\Http\Requests\Api\Dashboard\UpdateAboutOurStoreRequest;
use App\Http\Resources\AboutOurStoreResource;
use App\Models\AboutOurStore;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutOurStoreController extends Controller
{
    // public function __construct()
    // {
    //     // Apply middleware to the constructor
    //     $this->middleware(function ($request, $next) {
    //         if ( !auth()->user() instanceof Admin) {
    //             return response()->json(['message' => 'You are not authenticated as an admin.'], 401);
    //         }
    //         return $next($request);
    //     });
    // }
    public function index()
    {
        $data = AboutOurStore::first();

        if (!$data) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return new AboutOurStoreResource($data);
    }

    // public function show($id)
    // {
    //     $item = AboutOurStore::findOrFail($id);
    //     return new AboutOurStoreResource($item);
    // }

    public function store(StoreAboutOurStoreRequest $request)
    {
        $data = $request->validated();

        // Handling logo file upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        // Check if a record already exists
        $item = AboutOurStore::first();

        if ($item) {
            // Update existing record
            $item->update($data);
        } else {
            // Create a new record
            $item = AboutOurStore::create($data);
        }

        return new AboutOurStoreResource($item);
    }
    public function update(UpdateAboutOurStoreRequest $request)
    {
        $item = AboutOurStore::first();
        $data = $request->validated();

        return response()->json([
            'message' => 'Nothing to update'
        ], 404);


        // Handling logo file upload
        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($item->logo && Storage::disk('public')->exists($item->logo)) {
                Storage::disk('public')->delete($item->logo);
            }

            // Store the new logo
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        // Update the item
        $item->update($data);

        return new AboutOurStoreResource($item);
    }

public function destroy()
{
    $item = AboutOurStore::first();

    if ($item) {
        // Delete logo if it exists
        if ($item->logo && Storage::disk('public')->exists($item->logo)) {
            Storage::disk('public')->delete($item->logo);
        }

        $item->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ], 200);
    }

    return response()->json([
        'message' => 'Nothing to delete'
    ], 404); // Use 404 Not Found for when the item doesn't exist
}
}
