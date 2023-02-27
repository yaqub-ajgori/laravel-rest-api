<?php

namespace App\Http\Controllers\api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){

        $students = Student::all();

        if ($students->count() > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $students
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No students found'
            ], 404);
        }
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required | min:3',
            'course' => 'required | min:3',
            'email' => 'required|email',
            'phone' => 'required |digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()
            ], 422);
        }else {
            $student = Student::create($request->all(), [
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }

        if ($student) {
            return response()->json([
                'status' => 200,
                'message' => 'Student created successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Student not created'
            ], 500);
        }
    }

    public function show($id){

        $student = Student::find($id);

        if ($student) {
            return response()->json([
                'status' => 200,
                'data' => $student
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }
    }

    public function edit($id){

        $student = Student::find($id);

        if ($student) {
            return response()->json([
                'status' => 200,
                'data' => $student
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required | min:3',
            'course' => 'required | min:3',
            'email' => 'required|email',
            'phone' => 'required |digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()
            ], 422);
        }else {
            $student = Student::find($id);
            $student->update($request->all(), [
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }

        if ($student) {
            return response()->json([
                'status' => 200,
                'message' => 'Student updated successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Student not updated'
            ], 500);
        }
    }

    public function destroy($id){

        $student = Student::find($id);

        if ($student) {
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Student deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }
    }
}
