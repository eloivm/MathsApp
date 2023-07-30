<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estadísticas de Preguntas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
</head>

<body>
    @if (Auth::guard('teacher')->check())
        @include('partials.navbar_teacher')
    @elseif(Auth::guard('superadmin')->check())
        @include('partials.navbar_principal')
    @endif
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Estadísticas de Preguntas</h3>
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Pregunta</th>
                                    <th>Respuesta</th>
                                    <th>Porcentaje aciertos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistics as $statistic)
                                    <tr>
                                        <td>{{ $statistic['question'] }}</td>
                                        <td>{{ $statistic['answer'] }}</td>
                                        <td>{{ round($statistic['percentage'], 2) }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
