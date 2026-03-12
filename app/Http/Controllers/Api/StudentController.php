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
        //
        $student = Student::create($request->all());

        return response()->json([
            'id' => $student->id,

            'last_name' => $student->last_name,
            'first_name' => $student->first_name,
            'middle_name' => $student->middle_name,

            'date_of_birth' => $student->date_of_birth,
            'sex' => $student->sex,

            'email' => $student->email,
            'mobile_number' => $student->mobile_number,
            'address' => $student->address,

            'school_name' => $student->school_name,
            'course' => $student->course,
            'year_level' => $student->year_level,

            'father_name' => $student->father_name,
            'mother_name' => $student->mother_name,
            'parent_occupation' => $student->parent_occupation,
            'parents_gross_income' => $student->parents_gross_income,
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
