<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{

    public function index()
    {
        $available_courses = Course::whereNull('teacher_id')->orderBy('grade', 'asc')->orderBy('class_letter', 'asc')->get();
        $courses = Course::orderBy('grade', 'asc')->orderBy('class_letter', 'asc')->get();
    
        // Obtener el curso asignado al profesor actual
        $assigned_course = Course::where('teacher_id', auth()->user()->id)->first();
    
        // Obtener todos los profesores
        $teachers = Teacher::all();
    
        return view('courses', [
            'available_courses' => $available_courses,
            'courses' => $courses,
            'assigned_course' => $assigned_course,
            'teachers' => $teachers, // Pasar los profesores a la vista
        ]);
    }
    


    public function store(Request $request)
    {
        $request->validate([
            'grade' => 'required|integer|min:0',
            'class_letter' => [
                'required',
                Rule::unique('courses')->where(function ($query) use ($request) {
                    return $query->where('grade', $request->grade)
                        ->where('class_letter', $request->class_letter);
                }),
            ],
            'description' => 'nullable',
        ]);


        $course = new Course;
        $course->grade = $request->grade;
        $course->class_letter = $request->class_letter;
        $course->description = $request->description;
        $course->save();

        return redirect()->route('courses');

        return redirect()->route('courses')->with('success', 'Curso creado exitosamente.');
    }

    public function show(Course $course)
    {
        return view('course_show', ['course' => $course]);
    }

    public function destroy(Course $course)
{
    // Actualizar los alumnos asociados al curso y poner course_id a null
    Student::where('course_id', $course->id)->update(['course_id' => null]);

    // Eliminar el curso
    $course->delete();

    return redirect()->route('courses')->with('success', 'Curso eliminado exitosamente.');
}

public function edit(Course $course)
{
    return view('edit_course', compact('course'));
}

public function update(Request $request, Course $course)
{
    $validatedData = $request->validate([
        'grade' => 'required|integer|min:1',
        'class_letter' => 'required|string',
        'description' => 'nullable|string',
    ]);

    $course->update($validatedData);

    return redirect()->route('courses', $course->id)->with('success', 'Curso actualizado correctamente');
}

}
