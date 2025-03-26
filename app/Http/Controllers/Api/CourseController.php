<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Courses::where('visibility' , true)->get();
        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string',
            'sub_description' => 'required|string',
            'yard' => 'required|string',
            'location_city' => 'required|string',
            'location_country' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
            'discount' => 'nullable|numeric|min:0',
        ]);

        $course = Courses::create($validated);

        return response()->json($course, 201);
    }

    public function show(Courses $course)
    {
        return response()->json($course);
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_name' => 'sometimes|required|string',
            'sub_description' => 'sometimes|required|string',
            'yard' => 'sometimes|required|string',
            'location_city' => 'sometimes|required|string',
            'location_country' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'image' => 'sometimes|required|string',
            'rating' => 'sometimes|required|numeric|min:0|max:5',
            'discount' => 'sometimes|nullable|numeric|min:0',
        ]);

        $course->update($validated);
        return response()->json($course);
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }
}
