<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Student;

class ApplicationController extends Controller
{
    public function index()
    {
        //Show all applications WITH student info
        return Application::with('student')->get();
    }

    public function store(Request $request)
    {
        $student = Student::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $application = Application::create([
            'student_id' => $student->id,
            'scholarship_id' => $request->scholarship_id,
            'application_date' => now(),
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Created',
            'data' => $application->load('student')
        ], 201);
    }

    public function show(string $id)
    {
        $application = Application::with('student')->findOrFail($id);

        return response()->json($application);
    }

    public function update(Request $request, string $id)
{
    $user = auth()->user();

    if (!$user || !$user->student) {
        return response()->json([
            'message' => 'Student record not found'
        ], 404);
    }

    $student = $user->student;

    $student->update([
        'last_name' => $request->last_name ?? $student->last_name,
        'first_name' => $request->first_name ?? $student->first_name,
        'middle_name' => $request->middle_name ?? $student->middle_name,
        'date_of_birth' => $request->date_of_birth ?? $student->date_of_birth,
        'sex' => $request->sex ?? $student->sex,
        'email' => $request->email ?? $student->email,
        'mobile_number' => $request->mobile_number ?? $student->mobile_number,
        'address' => $request->address ?? $student->address,
        'school_name' => $request->school_name ?? $student->school_name,
        'course' => $request->course ?? $student->course,
        'year_level' => $request->year_level ?? $student->year_level,
        'father_name' => $request->father_name ?? $student->father_name,
        'mother_name' => $request->mother_name ?? $student->mother_name,
        'parent_occupation' => $request->parent_occupation ?? $student->parent_occupation,
        'parents_gross_income' => $request->parents_gross_income ?? $student->parents_gross_income,
    ]);

    $application = Application::where('id', $id)
        ->where('student_id', $student->id)
        ->firstOrFail();

    $application->update([
        'scholarship_id' => $request->scholarship_id ?? $application->scholarship_id,
        'status' => $request->status ?? $application->status,
    ]);

    return response()->json([
        'message' => 'Updated successfully',
        'data' => $application->load('student')
    ]);
}

    public function destroy(string $id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return response()->json([
            'message' => 'Application deleted successfully'
        ]);
    }

    public function apply(Request $request)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    $request->validate([
        'last_name' => 'required',
        'first_name' => 'required',
        'date_of_birth' => 'required|date',
        'sex' => 'required',
        'email' => 'required|email',
        'mobile_number' => 'required',
        'address' => 'required',
        'school_name' => 'required',
        'course' => 'required',
        'year_level' => 'required',
        'father_name' => 'required',
        'mother_name' => 'required',
        'parent_occupation' => 'required',
        'parents_gross_income' => 'required|numeric',
        'scholarship_id' => 'required'
    ]);

    $student = Student::updateOrCreate(
        ['user_id' => $user->id],
        [
            'user_id' => $user->id, 
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'date_of_birth' => $request->date_of_birth,
            'sex' => $request->sex,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'address' => $request->address,
            'school_name' => $request->school_name,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_occupation' => $request->parent_occupation,
            'parents_gross_income' => $request->parents_gross_income,
        ]
    );

    $application = Application::create([
        'student_id' => $student->id,
        'scholarship_id' => $request->scholarship_id,
        'application_date' => now(),
        'status' => 'pending',
    ]);

    return response()->json([
        'message' => 'Application submitted',
        'data' => $application->load('student')
    ], 201);
}

    public function myApplications()
    {
        $user = auth()->user();

        if (!$user || !$user->student) {
            return response()->json([
                'message' => 'Student record not found'
            ], 404);
        }

        return Application::with('student')
            ->where('student_id', $user->student->id)
            ->get();
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


}