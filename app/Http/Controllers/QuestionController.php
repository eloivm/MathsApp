<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::orderBy('enunciation', 'asc')->get();
        return view('teacher_questions', compact('questions'));
    }

    public function create()
    {
        return view('create_question');
    }

    public function store(Request $request)
    {
        $rules = [
            'question_type' => 'required',
            'course' => 'required|integer|between:1,6',
            'category' => 'required|string',
        ];

        $questionContent = '';
        if ($request->question_type === 'multiple_choice') {
            $rules['question'] = 'required';
            $rules['answers'] = 'required|array';
            $rules['answers.*'] = 'required|string';
            $questionContent = $request->question;
        } else if ($request->question_type === 'short_answer') {
            $rules['short_answer_question'] = 'required';
            $rules['short_answer'] = 'required|string';
            $questionContent = $request->short_answer_question;
        }

        $request->validate($rules);

        $question = new Question();
        $question->type = $request->question_type;
        $question->enunciation = $questionContent;
        $question->topic = $request->category;
        $question->course = $request->course;

        $question->save();

        if ($request->question_type === 'multiple_choice') {
            foreach ($request->answers as $index => $answer) {
                $new_answer = new Answer();
                $new_answer->content = $answer;
                $new_answer->is_correct = $index == 0 ? true : false; // assuming the first answer is always correct
                $new_answer->question_id = $question->id;

                $new_answer->save();
            }
        } else if ($request->question_type === 'short_answer') {
            $new_answer = new Answer();
            $new_answer->content = $request->short_answer;
            $new_answer->is_correct = true;
            $new_answer->question_id = $question->id;

            $new_answer->save();
        }

        if (Auth::guard('superadmin')->check()) {
            return redirect()->route('principal.questions')->with('success', 'Pregunta creada exitosamente.');
        } elseif (Auth::guard('teacher')->check()) {
            return redirect()->route('teacher.questions')->with('success', 'Pregunta creada exitosamente.');
        }
    }

    public function edit($id)
    {
        $question = Question::with('answers')->find($id);

        if (!$question) {
            return redirect()->route('principal.questions')->with('error', 'Pregunta no encontrada.');
        }

        // Separar respuestas correctas e incorrectas
        $correctAnswer = $question->answers->where('is_correct', 1)->first();
        $incorrectAnswers = $question->answers->where('is_correct', 0)->all();

        return view('edit_question', compact('question', 'correctAnswer', 'incorrectAnswers'));
    }


    public function update(Request $request, $id)
    {
        // Encuentra la pregunta usando el id
        $question = Question::find($id);

        // Verifica si la pregunta existe
        if (!$question) {
            return redirect()->route('principal.questions')->with('error', 'Pregunta no encontrada.');
        }

        // Actualiza la pregunta
        $question->update([
            'type' => $request->type,
            'course' => $request->course,
            'topic' => $request->topic,
            'enunciation' => $request->enunciation,
        ]);

        // Elimina las respuestas actuales
        $question->answers()->delete();

        foreach ($request->answers as $answerContent) {
            // Aquí debes decidir cuál de las respuestas es la correcta

            $isCorrect = $answerContent === $request->answers[0];
            $question->answers()->create([
                'content' => $answerContent,
                'is_correct' => $isCorrect,
            ]);
        }

        if (Auth::guard('superadmin')->check()) {
            return redirect()->route('principal.questions')->with('success', 'Pregunta actualizada con éxito.');
        } elseif (Auth::guard('teacher')->check()) {
            return redirect()->route('teacher.questions')->with('success', 'Pregunta actualizada con éxito.');
        }
    }


    public function delete($id)
    {
        try {
            $pregunta = Question::findOrFail($id);
            $pregunta->is_delete = 1;
            $pregunta->save();

            // Actualizar el campo 'is_delete' de las respuestas relacionadas
            Answer::where('question_id', $pregunta->id)->update(['is_delete' => 1]);

            return redirect()->back()->with('success', 'La pregunta se ha eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al eliminar la pregunta. Por favor, inténtalo de nuevo.');
        }
    }

    // En tu controlador:

    public function statistics()
    {
        // Obtener todas las preguntas
        $questions = Question::all();

        $statistics = $questions->map(function ($question) {
            $totalAnswers = QuestionQuiz::where('question_id', $question->id)->count();

            $correctAnswer = $question->answers->where('is_correct', true)->first()->content;

            $correctAnswersCount = QuestionQuiz::where('question_id', $question->id)
                ->where('student_answer', $correctAnswer)
                ->count();

            if ($totalAnswers === 0) {
                $percentageCorrect = 0;
            } else {
                $percentageCorrect = ($correctAnswersCount / $totalAnswers) * 100;
            }

            return [
                'question' => $question->enunciation,
                'answer' => $correctAnswer,
                'percentage' => $percentageCorrect,
            ];
        })->toArray();

        // Ordenar las estadísticas por porcentaje (descendente) y dentro por pregunta (ascendente)
        usort($statistics, function ($a, $b) {
            if ($a['percentage'] == $b['percentage']) {
                return $a['question'] <=> $b['question'];
            } else {
                return $b['percentage'] <=> $a['percentage'];
            }
        });

        return view('statistics', ['statistics' => $statistics]);
    }

    public function preview(Request $request)
    {
        // Guarda la pregunta en la sesión
        $request->session()->put('question_preview', $request->all());
    
        // Redirige a la vista previa
        return redirect()->route('preview_display');
    }
    
    public function previewDisplay(Request $request)
    {
        // Obtiene los datos de la sesión
        $question = $request->session()->get('question_preview', []);
    
        // Verifica si question_type existe en el array $question antes de intentar acceder a él
        $question_text = '';
        if (isset($question['question_type'])) {
            // Depende del tipo de pregunta
            $question_text = $question['question_type'] == 'short_answer'
                ? $question['short_answer_question'] ?? ''
                : $question['question'] ?? '';
        } 
    
        // Renderiza la vista
        return view('preview', ['question_text' => $question_text, 'question' => $question]);
    }
    
    
}
