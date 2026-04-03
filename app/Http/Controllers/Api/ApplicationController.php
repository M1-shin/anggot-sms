<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Application::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $application = Application::create([
            'student_id' => $request->student_id,
            'scholarship_id' => $request->scholarship_id,
            'application_date' => $request->application_date,
            'status' => 'Pending',
            'remarks' => $request->remarks
        ]);

        return response()->json([
            'id' => $application->id,
            'student_id' => $application->student_id,
            'scholarship_id' => $application->scholarship_id,
            'application_date' => $application->application_date,
            'status' => $application->status,
            'remarks' => $application->remarks,
            'created_at' => $application->created_at,
            'updated_at' => $application->updated_at
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $application = Application::findOrFail($id);

        return response()->json($application);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = Application::where('id', $id)
        ->where('student_id', auth()->id())
        ->firstOrFail();

        $application->update($request->all());

        return response()->json(['message' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $application = Application::findOrFail($id);

        $application->delete();

        return response()->json([
            'message' => 'Application deleted successfully'
        ]);
    }

    public function apply(Request $request)
    {
        $application = Application::create([
            'student_id' => auth()->id(),
            'scholarship_id' => $request->scholarship_id,
            'application_date' => now(),
            'status' => 'Pending',
            'remarks' => $request->remarks
    ]);

    return response()->json($application, 201);
    }

    public function approve($id)
    {
        $app = Application::findOrFail($id);

        if ($app->status !== 'Pending') {
            return response()->json(['message' => 'Already processed'], 400);
        }

        $app->update([
            'status' => 'Approved',
            'remarks' => 'Approved',
            'approved_by' => auth()->id()
        ]);

        return response()->json(['message' => 'Application Approved']);
    }

    public function reject(Request $request, $id)
    {
        $app = Application::findOrFail($id);

        if ($app->status !== 'Pending') {
            return response()->json(['message' => 'Already processed'], 400);
        }

        $app->update([
            'status' => 'Rejected',
            'remarks' => $request->remarks ?? 'Rejected',
            'rejected_by' => auth()->id()
        ]);

        return response()->json(['message' => 'Application Rejected']);
    }

    public function myApplications()
    {
        return Application::where('student_id', auth()->id())->get();
    }


}
