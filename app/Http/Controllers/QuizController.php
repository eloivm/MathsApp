<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\QuestionQuiz;
use App\Models\Quiz;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{

    private $categoriesRules = [
        'orden de operaciones' => ['questions' => 1, 'allowed_fails' => 0],
        'números enteros' => ['questions' => 5, 'allowed_fails' => 1],
        'múltiplos y divisores' => ['questions' => 5, 'allowed_fails' => 1],
        'potencias' => ['questions' => 6, 'allowed_fails' => 2],
        'fracciones' => ['questions' => 6, 'allowed_fails' => 2],
        'porcentajes' => ['questions' => 2, 'allowed_fails' => 1],
        'problemas' => ['questions' => 3, 'allowed_fails' => 1],
    ];
    private $levelOrder = [5, 6, 1, 2, 3, 4];

    public function index()
    {
        // Obtenemos todos los cuestionarios
        $quizzes = Quiz::all();

        // Retornamos una vista (la que corresponda en tu caso), pasando los cuestionarios como datos
        return view('quizzes.index', compact('quizzes'));
    }


    public function startQuiz(Request $request)
    {
        $student = Auth::user();
        $studentGrade = $student->course->grade;  // Obtenemos el grado del curso del estudiante
        $studentGrade =  $studentGrade - 1;

        $initialLevelIndex = array_search($studentGrade, $this->levelOrder);  // Obtenemos el índice del nivel inicial
        if ($initialLevelIndex === false) {
            return redirect()->route('student.dashboard')->with('error', 'El grado del curso del estudiante es inválido');
        }

        // Iniciar el nivel en el nivel inferior al grado del curso del estudiante
        session()->put('level_index', $initialLevelIndex);

        // Iniciar el cuestionario vacío
        session()->put('quiz', []);

        // Iniciar la categoría en la primera del orden
        session()->put('category', array_key_first($this->categoriesRules));

        session()->put('fail_counts', []); // Inicializa el contador de fallos por categoría

        $question = $this->getNextQuestion();

        if (!$question) {
            return redirect()->route('student.dashboard')->with('error', 'No hay preguntas disponibles');
        }

        return view('question', ['question' => $question]);
    }

    public function submitQuiz(Request $request)
    {
        $answer = $request->get('answer');
        $questionId = $request->get('question_id');

        // Guardar la respuesta del estudiante en la sesión
        $sessionKey = "quiz.{$questionId}";
        $request->session()->put($sessionKey, $answer);

        // Contar las respuestas hasta ahora
        // $answerCount = count(session()->get('quiz', []));
        $category = session()->get('category');
        $categoryCount = session()->get('categoryCount', []);
        if (!isset($categoryCount[$category])) {
            $categoryCount[$category] = 0;
        }
        $categoryCount[$category]++;
        session()->put('categoryCount', $categoryCount);
        $answerCount = $categoryCount[$category];

        // Recalcular el nivel basado en las respuestas hasta ahora
        $this->calculateStudentLevel(session()->get('quiz'));

        // Actualizar el nivel del estudiante si es mayor que el nivel actual
        $student = Student::find(Auth::id());
        $level = $this->levelOrder[session()->get('level_index')];
        if ($student->level === null || $level > $student->level) {
            $student->level = $level;
            $student->save();
        }

        // Si ya se han respondido las preguntas necesarias para la categoría actual
        $category = session()->get('category');
        $questionsNeeded = $this->categoriesRules[$category]['questions'];
        if ($answerCount % $questionsNeeded == 0) {
            // Si no podemos avanzar a la siguiente categoría
            if (!$this->advanceCategory()) {
                // Comprueba si el estudiante ha respondido correctamente las preguntas de la categoría 'problemas'
                if ($category == 'problemas') {
                    // Si ha respondido correctamente las preguntas de 'problemas', termina el cuestionario.
                    return $this->terminate();
                } else {
                    // Si la categoría no es 'problemas', intenta aumentar el nivel.
                    if (!$this->increaseLevel()) {
                        // Si no podemos aumentar el nivel, eso significa que hemos agotado todas las preguntas. En este caso, terminamos el cuestionario.
                        return $this->terminate();
                    }
                }
            }
        }

        // Obtener la siguiente pregunta
        $question = $this->getNextQuestion();

        if ($question === null) {
            // No hay más preguntas, terminar el cuestionario
            return $this->terminate();
        }


        if ($question) {
            // Guardar la pregunta en la sesión
            session()->put("quiz.{$question->id}", null);
        }

        return view('question', ['question' => $question]);
    }

    private function calculateStudentLevel($answers)
    {
        $category = session()->get('category');
        $allowedFails = $this->categoriesRules[$category]['allowed_fails'];
        $failCounts = session()->get('fail_counts', []); // Recuperamos el contador de fallos por categoría

        // Inicializamos el contador de fallos para la categoría si aún no se ha hecho
        if (!array_key_exists($category, $failCounts)) {
            $failCounts[$category] = 0;
        }

        // Aumentamos el contador de fallos si la respuesta es incorrecta
        $questionId = array_key_last($answers);
        $studentAnswer = $answers[$questionId];
        $question = Question::find($questionId);
        if ($question) {
            $correctAnswer = $question->answers->firstWhere('is_correct', true);
            if (!($correctAnswer && $correctAnswer->content == $studentAnswer)) {
                $failCounts[$category]++;
            }
        }

        // Guardamos el contador de fallos actualizado en la sesión
        session()->put('fail_counts', $failCounts);

        // Verificamos si se superó el límite de fallos permitidos para la categoría
        if ($failCounts[$category] > $allowedFails) {
            // Si el estudiante ha fallado más que los fallos permitidos, bajamos de nivel y reiniciamos la categoría
            $this->decreaseLevel();
            session()->put('category', array_key_first($this->categoriesRules));
            session()->put('fail_counts', []); // Reiniciamos el contador de fallos porque cambiamos de categoría
        }
    }

    private function increaseLevel()
    {
        // Obtenemos el índice del nivel actual
        $currentLevelIndex = session()->get('level_index');

        // Verificamos si el índice es menor que el máximo índice posible (es decir, no estamos ya en el nivel más alto)
        if ($currentLevelIndex < count($this->levelOrder) - 1) {
            // Aumentamos el índice del nivel
            session()->put('level_index', $currentLevelIndex + 1);
            // Reiniciamos la categoría
            session()->put('category', array_key_first($this->categoriesRules));

            return true;  // Indicamos que se pudo aumentar el nivel
        }

        return false;  // Indicamos que no se pudo aumentar el nivel porque ya estamos en el nivel más alto
    }

    private function advanceCategory()
    {
        // Obtenemos el índice de la categoría actual
        $currentCategoryIndex = array_search(session()->get('category'), array_keys($this->categoriesRules));
        if ($currentCategoryIndex !== false && $currentCategoryIndex < count($this->categoriesRules) - 1) {
            $nextCategory = array_keys($this->categoriesRules)[$currentCategoryIndex + 1];
            session()->put('category', $nextCategory);
            return true;  // Indicamos que se pudo avanzar a la siguiente categoría
        }

        return false;  // Indicamos que no se pudo avanzar a la siguiente categoría porque ya estamos en la última
    }

    private function decreaseLevel()
    {
        // Obtenemos el índice del nivel actual
        $currentLevelIndex = session()->get('level_index');

        // Verificamos si el índice es mayor que 0 (es decir, no estamos ya en el nivel más bajo)
        if ($currentLevelIndex > 0) {
            // Disminuimos el índice del nivel
            session()->put('level_index', $currentLevelIndex - 1);
        }
    }


    private function getNextQuestion()
    {
        $answeredQuestions = array_keys(session()->get('quiz', []));
        $category = session()->get('category');
        $levelIndex = session()->get('level_index');

        // Aquí usamos el índice del nivel para obtener el nivel correspondiente de la matriz de orden de niveles
        $level = $this->levelOrder[$levelIndex];

        // Obtén todas las preguntas que no se han respondido en este cuestionario, del nivel y la categoría actuales
        $allQuestions = Question::whereNotIn('id', $answeredQuestions)
            ->where('topic', $category)
            ->where('course', $level)
            ->where('is_delete', 0)
            ->whereNotNull('enunciation')
            ->get();

        // Obtén el número de preguntas requeridas para la categoría dada
        $questionsRequired = $this->categoriesRules[$category]['questions'];

        // Si hay menos preguntas disponibles que las requeridas, ajusta el número de preguntas
        if ($allQuestions->count() < $questionsRequired) {
            $this->categoriesRules[$category]['questions'] = $allQuestions->count();
        }

        // Verificar si hay preguntas disponibles.
        if ($allQuestions->isEmpty()) {
            // No hay preguntas disponibles, por lo que devolvemos null.
            return null;
        }

        // Si hay preguntas disponibles, seleccionamos una al azar.
        $question = $allQuestions->random();

        // Devolvemos la pregunta seleccionada.
        return $question;
    }




    public function results(Request $request)
    {
        // Recupera las respuestas del cuestionario de la sesión
        $answers = session()->get('quiz', []);

        $totalAnswers = count($answers);
        $correctAnswers = 0;

        $questions = [];

        // Iterar sobre cada respuesta en las respuestas del cuestionario
        foreach ($answers as $questionId => $studentAnswer) {
            // Encontrar la pregunta correspondiente en la base de datos
            $question = Question::find($questionId);

            // Si la pregunta no existe, saltar a la siguiente iteración
            if (!$question) {
                continue;
            }

            // Encontrar la respuesta correcta para la pregunta
            $correctAnswer = $question->answers->firstWhere('is_correct', true);

            // Verificar si la respuesta del estudiante es correcta
            $isCorrect = $correctAnswer && $correctAnswer->content == $studentAnswer;

            // Si la respuesta del estudiante es correcta, incrementar el contador de respuestas correctas
            if ($isCorrect) {
                $correctAnswers++;
            }

            // Guardar los detalles de la pregunta y las respuestas en la estructura de datos
            $questions[] = [
                'question' => $question->enunciation,
                'studentAnswer' => $studentAnswer,
                'correctAnswer' => $correctAnswer ? $correctAnswer->content : null,
                'isCorrect' => $isCorrect,
            ];
        }

        // Calcular el porcentaje de respuestas correctas
        $correctPercentage = $totalAnswers > 0 ? ($correctAnswers / $totalAnswers) * 100 : 0;

        // Recupera el último nivel alcanzado en la sesión
        $levelReached = session()->get('level');

        // Devuelve una vista con los resultados
        return view('quiz_results', [
            'totalAnswers' => $totalAnswers,
            'correctAnswers' => $correctAnswers,
            'correctPercentage' => $correctPercentage,
            'levelReached' => $levelReached,
            'questions' => $questions,
        ]);
    }
    public function terminate()
    {
        // Crear un nuevo cuestionario en la base de datos con los datos de la sesión
        $quiz = Quiz::create([
            'student_id' => Auth::guard('student')->id(), // asumiendo que estás utilizando la autenticación incorporada de Laravel
            'level' => $this->levelOrder[session()->get('level_index')]
        ]);

        // Guardar las respuestas de las preguntas en la base de datos
        foreach (session()->get('quiz') as $questionId => $studentAnswer) {
            QuestionQuiz::create([
                'quiz_id' => $quiz->id,
                'question_id' => $questionId,
                'student_answer' => $studentAnswer
            ]);
        }

        // Redirigir al usuario a la página de resultados
        return redirect()->route('quiz.terminate');
    }

    public function terminateShow()
    {
        return view('terminate_question');
    }

    public function quizShow($id)
    {
        $quiz = Quiz::findOrFail($id);

        $levelReached = $quiz->level;
        $questions = $quiz->questions;

        $totalAnswers = count($questions);
        $correctAnswers = 0;
        $questionsData = [];

        foreach ($questions as $question) {
            $answer = $question->answers()->where('is_correct', 1)->first();
            $studentAnswer = $question->pivot->student_answer;

            $isCorrect = false;
            if ($answer && $studentAnswer === $answer->content) {
                $correctAnswers++;
                $isCorrect = true;
            }

            $questionsData[] = [
                'question' => $question->enunciation,
                'correctAnswer' => $answer->content,
                'studentAnswer' => $studentAnswer,
                'isCorrect' => $isCorrect
            ];
        }

        $correctPercentage = $totalAnswers > 0 ? ($correctAnswers / $totalAnswers) * 100 : 0;

        return view('quiz_results', [
            'quiz' => $quiz,
            'levelReached' => $levelReached,
            'correctAnswers' => $correctAnswers,
            'totalAnswers' => $totalAnswers,
            'correctPercentage' => $correctPercentage,
            'questions' => $questionsData
        ]);
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        if (Auth::guard('teacher')->check()) {
            return redirect()->route('teacher.quizzes')->with('success', 'Cuestionario eliminado con éxito');
        } elseif (Auth::guard('superadmin')->check()) {
            return redirect()->route('principal.quizzes')->with('success', 'Cuestionario eliminado con éxito');
        }

        // Si no es ninguno de los anteriores, puedes redirigir a una ruta por defecto o lanzar una excepción
        return redirect()->route('welcome');
    }
}
