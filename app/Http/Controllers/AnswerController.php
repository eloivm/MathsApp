<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'content' => 'required',
            'is_correct' => 'required',
        ]);

        $answer = new Answer([
            'content' => $request->content,
            'is_correct' => $request->is_correct,
        ]);

        $question->answers()->save($answer);

        return redirect()->route('questions.show', $question);
    }

    public function edit(Question $question, Answer $answer)
    {
        return view('answers.edit', compact('question', 'answer'));
    }

    public function update(Request $request, Question $question, Answer $answer)
    {
        $request->validate([
            'content' => 'required',
            'is_correct' => 'required',
        ]);

        $answer->update($request->all());

        return redirect()->route('questions.show', $question);
    }

    public function destroy(Question $question, Answer $answer)
    {
        $answer->delete();

        return back();
    }
}
