<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\SocialMediaRequest;
use App\Http\Requests\Api\Dashboard\StoreAllSocialRequest;
use App\Models\Admin;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
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
        $socialMedia = SocialMedia::all(); // Retrieve all social media records

        return response()->json($socialMedia, 200); // Return with 200 OK status
    }

    public function show($id)
    {
        $socialMedia = SocialMedia::where('id',$id)->first();

        if (!$socialMedia) {
            return response()->json([
                'message' => 'Nothing to show'
            ], 404);
        }
        return response()->json([
            'message' => 'Social media record retrieved successfully.',
            'data' => $socialMedia
        ], 200);
    }

    public function store(SocialMediaRequest $request)
    {
        $validated = $request->validated();

        $socialMedia = SocialMedia::create($validated);

        return response()->json([
            'message' => 'Social media record created successfully.',
            'data' => $socialMedia
        ]);
    }

    public function storeAll(StoreAllSocialRequest $request)
    {
        $validated = $request->validated();

        $socialMediaRecords  = [];
        foreach ($validated['social_media'] as $socialMediaData) {
            $socialMedia = SocialMedia::where('platform', $socialMediaData['platform'])->first();
            if ($socialMedia) {
                $socialMedia->update($socialMediaData);
                $socialMediaRecords[] =  $socialMedia;
            } else {
                $socialMediaRecords[] = SocialMedia::create($socialMediaData);
            }
        }

        return response()->json([
            'message' => 'Social media records created successfully.',
            'data' => $socialMediaRecords
        ]);
    }

    public function update(SocialMediaRequest $request, $id)
    {
        $socialMedia = SocialMedia::findOrFail($id); // Find social media record by ID
        $validated = $request->validated(); // Validate the request data

        $socialMedia->update($validated); // Update the record

        return response()->json([
            'message' => 'Social media record updated successfully.',
            'data' => $socialMedia
        ]);
    }
    public function destroy($id)
    {
        $socialMedia = SocialMedia::findOrFail($id); // Find social media record by ID
        $socialMedia->delete(); // Delete the record

        return response()->json([
            'message' => 'Social media record deleted successfully.'
        ]);
    }
}
