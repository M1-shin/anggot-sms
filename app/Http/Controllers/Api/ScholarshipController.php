<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scholarship;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Scholarship::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $scholarship = Scholarship::create($request->all());

        return response()->json([
            'id' => $scholarship->id,
            'name' => $scholarship->name,
            'description' => $scholarship->description,
            'amount' => $scholarship->amount,
            'provider' => $scholarship->provider,
            'requirements' => $scholarship->requirements,
            'slots' => $scholarship->slots
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $scholarship = Scholarship::findOrFail($id);

        return response()->json($scholarship);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $scholarship = Scholarship::findOrFail($id);

        $scholarship->update($request->all());

        return response()->json([
            'message' => 'Scholarship updated successfully',
            'data' => $scholarship
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $scholarship = Scholarship::findOrFail($id);

        $scholarship->delete();

        return response()->json([
            'message' => 'Scholarship deleted successfully'
        ]);
    }
}
