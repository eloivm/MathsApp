<?php

use App\Http\Controllers\AccessCodeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\SuperadminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('login');

    Route::get('/login', function () {
        return view('welcome');
    })->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

    Route::get('/register', function () {
        return view('register');
    });

    Route::get('/register/teacher', function () {
        return view('register_teacher');
    });

    Route::post('/register/teacher', [TeacherController::class, 'register']);

    Route::get('/register/student', [StudentController::class, 'index']);

    Route::post('/register/student', [StudentController::class, 'register']);
});

Route::middleware(['auth.user'])->group(function () {
    Route::get('/change-password', [App\Http\Controllers\UserController::class, 'showChangePasswordForm'])->name('change.password.form');
    Route::post('/change-password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('change.password');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


Route::middleware(['auth:superadmin'])->group(function () {
    Route::get('/principal/dashboard', [SuperadminController::class, 'index'])->name('superadmin_dashboard');
    Route::get('principal/students', [TeacherController::class, 'students'])->name('principal.students');
    Route::get('/principal/students/{studentname}', [TeacherController::class, 'studentProfile'])->name('principal.student');
    Route::get('/principal/teachers', [TeacherController::class, 'teachers'])->name('principal.teachers');
    Route::get('/principal/questions', [QuestionController::class, 'index'])->name('principal.questions');
    Route::get('/principal/courses/create', function () {
        return view('create_course');
    })->name('courses.create');
    Route::get('/principal/profile', [SuperadminController::class, 'profile'])->name('principal.profile');
    Route::get('principal/{id}/edit', [SuperadminController::class, 'edit'])->name('superadmin.edit');
    Route::post('principal/{id}', [SuperadminController::class, 'update'])->name('superadmin.update');
    Route::get('principal/{id}/transfer', [SuperadminController::class, 'transferAccount'])->name('superadmin.transfer');
    Route::post('principal/{id}/transfer', [SuperadminController::class, 'transferAccountTo'])->name('superadmin.transferTo');

    Route::get('/principal/teachers/{id}', [TeacherController::class, 'show'])->name('teachers.show');
    Route::get('teachers/edit/{teacher}', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::post('teachers/edit/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('teachers/delete/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::get('courses/edit/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::post('courses/edit/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::get('/principal/courses', [CourseController::class, 'index'])->name('courses');
    Route::post('/assign-course', [TeacherController::class, 'assignCourse'])->name('teachers.assign_course');
    Route::post('/principal/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/principal/quizzes', [TeacherController::class, 'quizzes'])->name('principal.quizzes');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::post('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
    Route::get('/principal/students/{studentname}', [TeacherController::class, 'studentProfile'])->name('principal.student');
    Route::get('/principal/students/edit/{student}', [StudentController::class, 'edit'])->name('student.edit');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
    Route::delete('/questions/eliminar/{id}', [QuestionController::class, 'delete'])->name('preguntas.delete');
    Route::get('/principal/generate-access-code/{course}', [AccessCodeController::class, 'generateCourse'])->name('generate_access_code_course');
    Route::get('/principal/generate-access-code-teacher', [AccessCodeController::class, 'generateTeacherCode'])->name('generate_access_code_teacher');
    Route::get('/principal/statistics', [QuestionController::class, 'statistics'])->name('statistics_admin');
    Route::get('/principal/quiz/{id}', [QuizController::class, 'quizShow'])->name('quiz.showAdmin');
    Route::delete('/principal/quiz/{id}', [QuizController::class, 'destroy'])->name('quiz.destroyAdmin');
});

Route::middleware(['auth:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'show'])->name('teacher_dashboard');
    Route::get('/generate-access-code', [TeacherController::class, 'courses'])->name('generate_access_code');
    Route::get('/teacher/questions', [QuestionController::class, 'index'])->name('teacher.questions');
    Route::get('/teacher/profile', [TeacherController::class, 'profile'])->name('teacher.profile');
    Route::get('/students', [TeacherController::class, 'students'])->name('teacher.students');
    Route::get('/students/{studentname}', [TeacherController::class, 'studentProfile'])->name('teacher.student');
    Route::get('/teachers/quizzes', [TeacherController::class, 'quizzes'])->name('teacher.quizzes');
    Route::get('/teacher/generate-access-code/{course}', [AccessCodeController::class, 'generateCourse'])->name('generate_access_code_course_student');
    Route::get('/quizzes/view', [TeacherController::class, 'viewQuizzes'])->name('quizzes.view');
    Route::get('/teacher/questions/create', [QuestionController::class, 'create'])->name('questions.create.teacher');
    Route::post('/teacher/questions', [QuestionController::class, 'store'])->name('questions.store.teacher');
    Route::get('/teacher/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit.teacher');
    Route::post('/teacher/questions/{id}', [QuestionController::class, 'update'])->name('questions.update.teacher');
    Route::delete('/teacher/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');
    Route::get('/teacher/delete', [TeacherController::class, 'delete'])->name('teacher.delete');
    Route::get('/teacher/statistics', [QuestionController::class, 'statistics'])->name('statistics_teacher');
    Route::delete('/questions/eliminar/{id}', [QuestionController::class, 'delete'])->name('preguntas.delete.teacher');
    Route::get('/teacher/quiz/{id}', [QuizController::class, 'quizShow'])->name('quiz.show');
    Route::delete('/teacher/quiz/{id}', [QuizController::class, 'destroy'])->name('quiz.destroy');
    Route::post('/teacher/question/vistaprevia', [QuestionController::class, 'preview']);
    Route::get('/teacher/question/preview_display', [QuestionController::class, 'previewDisplay'])->name('preview_display');



});

Route::middleware(['auth:student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'show'])->name('student_dashboard');
    Route::get('/start_quiz', function () {
        return view('student_quiz');
    })->name('student.quiz');;
    Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');
    Route::get('/quiz', [QuizController::class, 'startQuiz'])->name('quiz.start');
    Route::post('/submit_quiz', [QuizController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/quiz/results', [QuizController::class, 'results'])->name('quiz.results');
    Route::get('/quiz/finish', [QuizController::class, 'terminateShow'])->name('quiz.terminate');
});
