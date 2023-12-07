<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Carbon\Carbon;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::All();

        $students->map(function($student) {
            $student->formatted_date = Carbon::parse($student->created_at)->format('d-m-Y');
            return $student;
        });

        return response()->json([
            'students' => $students,
        ], 200);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
            ], 404);
        }

        return response()->json([
            'student' => $student,
        ], 200);
    }

    public function store(StoreStudentRequest $storeStudentRequest)
    {
        $student = Student::create([
            'name' => $storeStudentRequest->name,
            'course' => $storeStudentRequest->course,
            'email' => $storeStudentRequest->email,
            'phone' => $storeStudentRequest->phone,
        ]);

        return response()->json([
            'message' => 'Data has been save'
        ], 201);
    }

    public function update(UpdateStudentRequest $updateStudentRequest, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
            ], 404);
        }

        $student->update([
            'name' => $updateStudentRequest->name,
            'course' => $updateStudentRequest->course,
            'email' => $updateStudentRequest->email,
            'phone' => $updateStudentRequest->phone,
        ]);

        return response()->json([
            'message' => 'Data has been save'
        ], 201);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Data has been deleted'
        ], 201);
    }
}
