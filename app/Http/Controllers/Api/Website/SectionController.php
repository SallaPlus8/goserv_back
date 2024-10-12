<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    public function index()
    {
        $sections = Section::orderBy('order', 'asc')
        ->get(['id', 'name']);

    return response()->json($sections);
}

public function updateOrder(Request $request)
{
    if (auth()->user()->type!='admin') {

        return response()->json(['message' => 'You are not authenticated as an admin.'], 401);
    }
    $data = $request->all(); // Expecting the array of sections with their IDs and names

    foreach ($data as $key => $section) {
        // Update the order field based on the current position in the array
        Section::where('id', $section['id'])->update(['order' => $key + 1]);
    }

    return response()->json(['success' => true], 200);
}


}
