<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultados del cuestionario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
    <style>
        .isCorrect {
            color: green;
        }

        .isIncorrect {
            color: red;
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-header text-center" style="background-color: #F0F8FF;">
                        <h3 class="title-text" style="font-size: 1.5rem;">Resultados del cuestionario</h3>
                    </div>
                    <div class="card-body">
                        <p>Nivel alcanzado:
                            {{ $levelReached }}
                            @if (in_array($levelReached, [1, 2, 3, 4]))
                                ºESO
                            @elseif(in_array($levelReached, [5, 6]))
                                ºPrimaria
                            @endif
                        </p>
                        <p>Respuestas correctas: {{ $correctAnswers }} de {{ $totalAnswers }}
                            ({{ $correctPercentage }}%)</p>

                        <h2>Detalles de las preguntas</h2>

                        @foreach ($questions as $question)
                            <div class="card mt-4" style="border-radius: 15px;">
                                <div class="card-header" style="background-color: #F0F8FF;">
                                    <h3>Pregunta: {!! $question['question'] !!}</h3>
                                </div>
                                <div class="card-body">
                                    <p>Respuesta del alumno: {!! $question['studentAnswer'] !!}</p>
                                    <p>Respuesta correcta: {!! $question['correctAnswer'] !!}</p>
                                    <p class="{{ $question['isCorrect'] ? 'isCorrect' : 'isIncorrect' }}">
                                        Estado: {{ $question['isCorrect'] ? 'Correcto' : 'Incorrecto' }}
                                    </p>
                                    <p>Puntos obtenidos: {{ $question['isCorrect'] ? '1/1' : '0/1' }}</p>
                                </div>
                            </div>
                        @endforeach

                        @if (Auth::guard('teacher')->check())
                            <form method="POST" action="{{ route('quiz.destroy', $quiz->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-4">Eliminar cuestionario</button>
                            </form>
                        @elseif(Auth::guard('superadmin')->check())
                            <form method="POST" action="{{ route('quiz.destroyAdmin', $quiz->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-4">Eliminar cuestionario</button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
