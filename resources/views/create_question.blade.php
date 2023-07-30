<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Pregunta</title>
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
    @include('partials.navbar_principal')
    <div class="container content">
        <div class="row justify-content-center" style="overflow: auto;">
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Crear Pregunta</h3>
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        @if (Auth::guard('superadmin')->check())
                            <form method="POST" action="{{ route('questions.store') }}">
                        @endif
                        @if (Auth::guard('teacher')->check())
                            <form method="POST" action="{{ route('questions.store.teacher') }}" id="questionForm">
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="question_type">Tipo de Pregunta</label>
                            <select class="form-control" id="question_type" name="question_type">
                                <option value="short_answer">Respuesta Corta</option>
                                <option value="multiple_choice">Tipo Test</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course">Curso</label>
                            <select class="form-control" id="course" name="course">
                                <option value="5">5º Primaria</option>
                                <option value="6">6º Primaria</option>
                                <option value="1">1º ESO</option>
                                <option value="2">2º ESO</option>
                                <option value="3">3º ESO</option>
                                <option value="4">4º ESO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category">Categoría</label>
                            <select class="form-control" id="category" name="category">
                                <option value="Fracciones">Fracciones</option>
                                <option value="Múltiplos y divisores">Múltiplos y divisores</option>
                                <option value="Números enteros">Números enteros</option>
                                <option value="Orden de operaciones">Orden de
                                    operaciones</option>
                                <option value="Porcentajes">Porcentajes</option>
                                <option value="Potencias">Potencias</option>
                                <option value="Problemas">Problemas</option>
                            </select>
                        </div>
                        <div id="short_answer_fields" style="display:none;">
                            <div class="form-group">
                                <label for="short_answer_question">Pregunta</label>
                                <div id="short_answer_question_output" class="latexOutput"></div>
                                <textarea class="form-control latexInput" id="short_answer_question" name="short_answer_question" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="short_answer">Respuesta</label>
                                <div id="short_answer_output" class="latexOutput"></div>
                                <input type="text" class="form-control latexInput" id="short_answer"
                                    name="short_answer">
                            </div>
                        </div>
                        <div id="multiple_choice_fields" style="display:none;">
                            <div class="form-group">
                                <label for="question">Pregunta</label>
                                <div id="question_output" class="latexOutput"></div>
                                <textarea class="form-control latexInput" id="question" name="question" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="correct_answer">Respuesta Correcta</label>
                                <div id="correct_answer_output" class="latexOutput"></div>
                                <input type="text" class="form-control latexInput" id="correct_answer"
                                    name="answers[]">
                            </div>
                            <div id="answers_container">
                                <div class="form-group">
                                    <label for="incorrect_answer_1">Respuesta Incorrecta 1</label>
                                    <div id="incorrect_answer_1_output" class="latexOutput"></div>
                                    <input type="text" class="form-control latexInput" id="incorrect_answer_1"
                                        name="answers[]">
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="addAnswer()">Añadir Respuesta
                                Incorrecta</button>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3">Crear Pregunta</button>
                        <button type="button" class="btn btn-primary btn-block mt-3"
                            onclick="previewQuestion(event)">Vista Previa</button>

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

        let incorrectAnswerCounter = 2;

        function registerLatexListener(element) {
            element.addEventListener('blur', function() {
                document.getElementById(this.id + '_output').textContent = this.value;
                MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
            });
        }

function previewQuestion(event) {
    event.preventDefault();
    var form = document.getElementById('questionForm');
    console.log(form.question_type.value);
    form.action = '/teacher/question/vistaprevia';
    form.submit();
}




        function addAnswer() {
            const answersContainer = document.getElementById('answers_container');
            const newAnswer = document.createElement('div');
            newAnswer.classList.add('form-group');
            newAnswer.innerHTML =
                `
            <label for="incorrect_answer_${incorrectAnswerCounter}">Respuesta Incorrecta ${incorrectAnswerCounter}</label>
            <div id="incorrect_answer_${incorrectAnswerCounter}_output" class="latexOutput"></div>
            <input type="text" class="form-control latexInput" id="incorrect_answer_${incorrectAnswerCounter}" name="answers[]">`;
            answersContainer.appendChild(newAnswer);
            registerLatexListener(document.getElementById(`incorrect_answer_${incorrectAnswerCounter}`));
            incorrectAnswerCounter++;
        }

        // Listeners for LaTeX conversion
        document.querySelectorAll('.latexInput').forEach(registerLatexListener);
    </script>


</body>

</html>
