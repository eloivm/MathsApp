<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cuestionario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
    <style>
        .title-text {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .custom-form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 auto;
        }

        .d-flex.justify-content-end.mb-3 {
            margin-top: auto;
            margin-right: 20px;
            margin-bottom: 20px;
            margin-left: 20px;
        }

        .custom-form-check label {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 10px;
            font-size: 1.2em;
        }

        .custom-radio {
            width: 20px;
            height: 20px;
            margin-bottom: 10px;
            border: 2px solid #007bff;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .custom-radio:after {
            content: "";
            display: block;
            width: 12px;
            height: 12px;
            margin: 3px;
            border-radius: 50%;
            background: #007bff;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .custom-form-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
        }

        .form-checks-wrapper {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
            margin: 0 20px;
        }

        .custom-form-check {
            flex: 0 0 auto;
            margin: 0 20px;
        }

        .custom-input {
            width: 80%;
            padding: 10px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var radios = document.querySelectorAll('.custom-radio');

            radios.forEach(function(radio) {
                radio.previousElementSibling.addEventListener('change', function(e) {
                    radios.forEach(function(radio) {
                        radio.style.backgroundColor = radio.previousElementSibling.checked ?
                            '#007bff' : 'white';
                    });
                });
            });
        });
    </script>
</head>

<body>
    @if (Auth::guard('teacher')->check())
        @include('partials.navbar_teacher')
    @elseif(Auth::guard('student')->check())
        @include('partials.navbar_student')
    @endif
    <div class="container content mt-3">
        <div class="row justify-content-center" style="overflow: auto;">
            <div class="col-md-12">
                <div class="card h-100" style="border-radius: 15px;">
                    <div class="card-body">
                        <form method="POST" action="{{ route('quiz.submit') }}"
                            class="d-flex flex-column justify-content-between">
                            @csrf
                            <div class="custom-form-wrapper">
                                <div class="form-group custom-form-group">
                                    <label class="title-text mb-3" for="question">{{ $question->enunciation }}</label>
                                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                                    @if ($question->type === 'multiple_choice')
                                        <div class="form-checks-wrapper">
                                            @php
                                                $answers = $question->answers->toArray();
                                                shuffle($answers);
                                            @endphp
                                            @foreach ($answers as $answer)
                                                <div class="form-check custom-form-check">
                                                    <label>
                                                        <input class="form-check-input" type="radio" name="answer"
                                                            id="answer{{ $answer['id'] }}"
                                                            value="{{ $answer['content'] }}" style="display: none;">
                                                        <div class="custom-radio"></div>
                                                        {{ $answer['content'] }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($question->type === 'short_answer')
                                        <input type="text" class="form-control mb-2 custom-input" id="answer"
                                            name="answer" required>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-end mb-3">
                                    <button type="submit" class="btn btn-primary">Siguiente</button>
                                </div>
                        </form>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
