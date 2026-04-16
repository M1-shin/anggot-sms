<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Student::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
        $student = Student::create([
            'user_id' => auth()->id(),

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
        ]);

        return response()->json([
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $student = Student::findOrFail($id);

        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $student = Student::findOrFail($id);

        $student->update($request->all());

        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $student
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $student = Student::findOrFail($id);

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully'
        ]);
    }
}
