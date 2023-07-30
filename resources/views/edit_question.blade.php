<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Pregunta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-AMS_CHTML"></script>
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
    <style>
        .latexOutput {
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #e9ecef;
            border-radius: 0.25rem;
            min-height: 38px;
            overflow: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }
    </style>
</head>

<body>
    @if (Auth::guard('teacher')->check())
        @include('partials.navbar_teacher')
    @elseif(Auth::guard('superadmin')->check())
        @include('partials.navbar_principal')
    @endif
    <div class="container content">
        <div class="row justify-content-center" style="overflow: auto;">
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Editar Pregunta</h3>
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        @if (Auth::guard('teacher')->check())
                            <form method="POST" action="{{ route('questions.update.teacher', $question->id) }}">
                            @elseif(Auth::guard('superadmin')->check())
                            <form method="POST" action="{{ route('questions.update', $question->id) }}">
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="question_type">Tipo de Pregunta</label>
                            <select class="form-control" id="question_type" name="type">
                                <option value="short_answer" @if ($question->type == 'short_answer') selected @endif>
                                    Respuesta Corta</option>
                                <option value="multiple_choice" @if ($question->type == 'multiple_choice') selected @endif>
                                    Tipo Test</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course">Curso</label>
                            <select class="form-control" id="course" name="course">
                                @php
                                    $courses = [
                                        5 => '5º Primaria',
                                        6 => '6º Primaria',
                                        1 => '1º ESO',
                                        2 => '2º ESO',
                                        3 => '3º ESO',
                                        4 => '4º ESO',
                                    ];
                                @endphp
                                @foreach ($courses as $key => $value)
                                    <option value="{{ $key }}"
                                        @if ($key == $question->course) selected @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category">Categoría</label>
                            <select class="form-control" id="topic" name="topic">
                                @php
                                    $categories = ['Fracciones', 'Múltiplos y divisores', 'Números enteros', 'Orden de operaciones', 'Porcentajes', 'Potencias', 'Problemas'];
                                @endphp
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}"
                                        @if ($category == $question->topic) selected @endif>{{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="enunciation">Pregunta</label>
                            <div id="enunciation_output" class="latexOutput">{{ $question->enunciation }}</div>
                            <textarea class="form-control latexInput" id="enunciation" name="enunciation" rows="3">{{ $question->enunciation }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="correct_answer">Respuesta Correcta</label>
                            <div id="correct_answer_output" class="latexOutput">{{ $correctAnswer->content }}</div>
                            <input type="text" class="form-control latexInput" id="correct_answer" name="answers[]"
                                value="{{ $correctAnswer->content }}">
                        </div>
                        @foreach ($incorrectAnswers as $incorrectAnswer)
                            <div class="form-group">
                                <label for="incorrect_answer{{ $loop->index }}">Respuesta Incorrecta
                                    {{ $loop->index + 1 }}</label>
                                <div id="incorrect_answer{{ $loop->index }}_output" class="latexOutput">
                                    {{ $incorrectAnswer->content }}</div>
                                <input type="text" class="form-control latexInput"
                                    id="incorrect_answer{{ $loop->index }}" name="answers[]"
                                    value="{{ $incorrectAnswer->content }}">
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary btn-block mt-3">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('question_type').addEventListener('change', function() {
            const shortAnswerFields = document.getElementById('short_answer_fields');
            const multipleChoiceFields = document.getElementById('multiple_choice_fields');
            if (this.value === 'short_answer') {
                shortAnswerFields.style.display = 'block';
                multipleChoiceFields.style.display = 'none';
            } else if (this.value === 'multiple_choice') {
                shortAnswerFields.style.display = 'none';
                multipleChoiceFields.style.display = 'block';
            }
        });

        document.getElementById('question_type').dispatchEvent(new Event('change'));

        document.querySelectorAll('.latexInput').forEach(inputElement => {
            inputElement.addEventListener('blur', function() {
                document.getElementById(this.id + '_output').textContent = this.value;
                MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
            });
        });
    </script>
</body>

</html>
