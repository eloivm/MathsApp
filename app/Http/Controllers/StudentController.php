<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    public function index()
    {
        return view('register_student');
    }
    public function register(Request $request)
    {
        // Validación de los campos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'dob' => 'required|date',
            'ref_code' => 'required|string|max:255',
            'repeated_grade' => 'required|string',
            'nationality' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Comprobación de los cursos repetidos
        $repeated_courses = null;
        if ($request->repeated_courses) {
            $repeated_courses = implode(', ', $request->repeated_courses);
        }
        // Comprobación del código de referencia y obtención del ID del curso correspondiente
        $courseData = Cache::get($request->ref_code);

        if (is_array($courseData) && array_key_exists('course_id', $courseData)) {
            $course_id = $courseData['course_id'];
        } else {
            return back()->with('error', 'El código de referencia proporcionado no es válido.');
        }

        // Si no se encontró un ID de curso correspondiente, devolver un error
        if (!$course_id) {
            return back()->with('error', 'El código de referencia proporcionado no es válido.');
        }
        // Creación del estudiante
        $student = new Student();
        $student->name = $request->name;
        $student->surname = $request->surname;
        $student->dob = $request->dob;
        $student->course_id = $course_id;
        $student->repeated_grade = $request->repeated_grade === 'yes';
        $student->repeated_courses = $repeated_courses;
        $student->nationality = $request->nationality;
        $student->origin = $request->origin;
        $student->arrival_date = $request->arrival_date;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->save();

        // Redirección a la página de inicio de sesión con un mensaje de éxito
        return redirect('/')->with('success', 'Registro exitoso. Ahora puede iniciar sesión.');
    }

    public function profile()
    {
        return view('student_profile');
    }

    public function edit($id)
{
    $student = Student::find($id);

    return view('edit_student', compact('student'));
}

public function destroy($id)
{
    $student = Student::find($id);

    if (!$student) {
        // El alumno no existe, devuelve una respuesta o redirige según tus necesidades.
    }

    // Elimina todos los cuestionarios asociados al alumno.
    $student->quizzes()->delete();

    // Elimina el alumno.
    $student->delete();

   
    return redirect()->route('principal.students');
}


}
