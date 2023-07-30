<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quizzes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
</head>

<body>
    @php
    function convertLevelToDescription($level) {
        switch($level) {
            case 5:
                return '5º Primaria';
            case 6:
                return '6º Primaria';
            case 1:
                return '1º ESO';
            case 2:
                return '2º ESO';
            case 3:
                return '3º ESO';
            case 4:
                return '4º ESO';
            default:
                return $level;
        }
    }
    @endphp
    @if (Auth::guard('teacher')->check())
        @include('partials.navbar_teacher')
    @elseif(Auth::guard('superadmin')->check())
        @include('partials.navbar_principal')
    @endif
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Lista de Cuestionarios</h3>
                @if ($quizzes->isEmpty())
                    <p class="lead text-center" style="font-style: italic;">No hay cuestionarios asignados a los
                        estudiantes de este curso.</p>
                @else
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Estudiante</th>
                                        <th scope="col">Nivel obtenido</th>
                                        <th scope="col">Respuestas acertadas %</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quizzes as $quiz)
                                        <tr>
                                            <td>{{ $quiz->student->name }} {{ $quiz->student->surname }}</td>
                                        
                                            <td>{{ convertLevelToDescription($quiz->level) }}</td>
                                            <td>{{ number_format($quiz->correctPercentage, 2) }}%</td>
                                            <td>{{ $quiz->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                @if (Auth::guard('teacher')->check())
                                                    <a href="{{ route('quiz.show', $quiz->id) }}"
                                                        class="btn btn-primary">Ver más</a>
                                                @elseif(Auth::guard('superadmin')->check())
                                                    <a href="{{ route('quiz.showAdmin', $quiz->id) }}"
                                                        class="btn btn-primary">Ver más</a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
