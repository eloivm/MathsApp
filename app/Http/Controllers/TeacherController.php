<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\Superadmin;
use App\Models\Teacher;
use App\Rules\DniRule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TeacherController extends Controller
{
    public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'surname' => 'required|max:255',
        'dni' => ['required', 'max:9', 'unique:teachers', new DniRule],
        'department' => 'required|max:255',
        'email' => 'required|email|max:255|unique:teachers',
        'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d@$!%*?&()¬\/\\"\'\;\.,\-_\{\}\[\]\+\^¿¡~€·]).+$/'],
        'ref_code' => 'required',
    ]);

    $refCodeData = Cache::get($request->ref_code);
    if (!$refCodeData) {
        return back()->withErrors(['ref_code' => 'El código de referencia no es válido o ya ha sido utilizado.']);
    }

    $teacher = new Teacher();
    $teacher->name = $request->name;
    $teacher->surname = $request->surname;
    $teacher->dni = $request->dni;
    $teacher->department = $request->department;
    $teacher->email = $request->email;
    $teacher->password = bcrypt($request->password);
    $teacher->save();

    Cache::forget($request->ref_code);

    Auth::login($teacher);

    return redirect()->route('teacher_dashboard');
}



    public function profile()
    {
        return view('teacher_profile');
    }

    public function students(Request $request)
    {
        $user = Auth::user();

        if ($user instanceof Teacher) {
            // Obtener todos los cursos que imparte este profesor
            $courses = $user->courses;
        } elseif ($user instanceof SuperAdmin) {
            // Obtener todos los cursos de la base de datos
            $courses = Course::all();
        } else {
            abort(403, 'Unauthorized action.');
        }

        $selectedCourseId = $request->input('course');

        // Obtener estudiantes según el filtro de curso seleccionado
        if ($selectedCourseId && $selectedCourseId != 'todos') {
            $selectedCourse = Course::findOrFail($selectedCourseId);
            $students = $selectedCourse->students;
        } else {
            if ($user instanceof Teacher) {
                $students = new Collection();

                // Iterar sobre todos los cursos, si existen
                if ($courses) {
                    foreach ($courses as $course) {
                        // Si el curso tiene estudiantes, añadirlos a la colección
                        if ($course->students) {
                            $students = $students->concat($course->students);
                        }
                    }
                }
            } elseif ($user instanceof SuperAdmin) {
                // Obtener todos los estudiantes de la base de datos
                $students = Student::all();
            }
        }

        // Pasar los datos a la vista
        return view('students', compact('students', 'courses', 'selectedCourseId'));
    }

    public function teachers()
    {
        $teachers = Teacher::all();
        return view('teachers', compact('teachers'));
    }

    public function studentProfile($studentname)
    {
        $name_parts = explode('_', $studentname);
        if (count($name_parts) != 2) {
            abort(404, 'Student not found.');
        }
        $surname = $name_parts[0];
        $name = $name_parts[1];

        $student = Student::whereRaw("REPLACE(name, ' ', '') = ?", [$name])
            ->whereRaw("REPLACE(surname, ' ', '') = ?", [$surname])
            ->first();

        if (!$student) {
            abort(404, 'Student not found.');
        }

        return view('student', compact('student'));
    }
    public function quizzes()
    {
        if (Auth::guard('superadmin')->check()) {
            // Si el usuario autenticado es un superadmin, se muestran todos los cuestionarios
            $quizzes = Quiz::orderBy('created_at', 'desc')->get();
        } elseif (Auth::guard('teacher')->check()) {
            // Si el usuario autenticado es un teacher, se muestra solo su curso
            $teacherId = Auth::id();
            $course = Course::where('teacher_id', $teacherId)->first();
    
            if (!$course) {
                return view('quizzes_teacher', ['quizzes' => collect()]);
            }
    
            $students = Student::where('course_id', $course->id)->get();
            $quizzes = collect();
    
            foreach ($students as $student) {
                if ($student->quizzes()->exists()) {
                    $studentQuizzes = $student->quizzes()->orderBy('created_at', 'desc')->get();
                    $quizzes = $quizzes->concat($studentQuizzes);
                }
            }
        } else {
            // Si el usuario autenticado no es ni superadmin ni teacher, se muestra una vista vacía
            return view('quizzes_teacher', ['quizzes' => collect()]);
        }
    
        foreach ($quizzes as $quiz) {
            $questions = $quiz->questions;
    
            $totalQuestions = count($questions);
            $correctAnswers = 0;
    
            foreach ($questions as $question) {
                $answer = $question->answers()->where('is_correct', 1)->first();
                $studentAnswer = $quiz->questions()->where('question_id', $question->id)->first()->pivot->student_answer;
    
                if ($answer && $studentAnswer === $answer->content) {
                    $correctAnswers++;
                }
            }
    
            if ($totalQuestions > 0) {
                $quiz->correctPercentage = ($correctAnswers / $totalQuestions) * 100;
            } else {
                $quiz->correctPercentage = 0;
            }
        }
    
        return view('quizzes_teacher', ['quizzes' => $quizzes]);
    }
    
    


    public function viewQuizzes()
    {
        $quizzes = Quiz::with('student')->get();

        return view('quiz_results', compact('quizzes'));
    }

    public function show($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return redirect()->route('superadmin_dashboard')->with('error', 'Profesor no encontrado.');
        }

        return view('teacher_show', compact('teacher'));
    }

    public function edit($id)
{
    $teacher = Teacher::find($id);

    return view('edit_teacher', compact('teacher'));
}

public function update(Request $request, $id)
{
    $teacher = Teacher::find($id);

    $validatedData = $request->validate([
        'name' => 'required',
        'surname' => 'required',
        'dni' => 'required',
        'department' => 'required',
        'email' => 'required|email',
        'password' => 'nullable|confirmed',
        'course_id' => 'nullable',
    ]);

    $teacher->update($validatedData);

    return redirect()->route('principal.teachers')->with('success', 'Profesor actualizado exitosamente');
}

public function destroy($id)
{
    $teacher = Teacher::find($id);

    if ($teacher) {
        // Establece a null el teacher_id de los cursos que imparte este profesor
        foreach ($teacher->courses as $course) {
            $course->teacher_id = null;
            $course->save();
        }

        // Elimina la cuenta del profesor
        $teacher->delete();
    }

    return redirect()->route('welcome');
}

public function delete()
{
  
    return view('remove_account');
}


public function courses()
{
    $courses = Auth::user()->courses;

    // Devuelve la vista de los cursos del profesor, pasando los cursos como datos a la vista
    return view('course_teacher', compact('courses'));
}


}
