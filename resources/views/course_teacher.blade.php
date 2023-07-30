<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cursos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
</head>

<body>
    @include('partials.navbar_teacher')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Lista de Cursos</h3>
                @if ($courses->isEmpty())
                    <p class="lead text-center" style="font-style: italic;">Todavía no hay cursos.</p>
                @else
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Curso</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td>{{ $course->grade }}º {{ $course->class_letter }}</td>
                                            <td>{{ $course->description ?: 'Sin descripción' }}</td>
                                            <td>
                                                <a href="{{ route('generate_access_code_course_student', $course->id) }}"
                                                    class="btn btn-primary">Generar código</a>
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
