<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Courses::where('visibility', true);

        if ($request->has('course_name') && !empty($request->course_name)) {
            $query->where('course_name', 'like', '%' . $request->course_name . '%');
        }

        if ($request->has('location_city') && !empty($request->location_city)) {
            $query->where('location_city', 'like', '%' . $request->location_city . '%');
        }

        $courses = $query->get();
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

    public function getFeaturedCourses()
    {
        $courses = Courses::where('is_featured' , true)->paginate(4);

        return response()->json($courses);
    }
}
