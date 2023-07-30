<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil del Estudiante</title>
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
    <div class="content">
        <div class="card" style="border-radius: 15px;">
            <div class="card-header text-left" style="background-color: #F0F8FF;">
                <h1 class="title-text" style="font-size: 2.5rem;">
                    {{ $student->name }} {{ $student->surname }}
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col form-group">
                        <label>Fecha de Nacimiento</label>
                        <input type="text" class="form-control"
                            value="{{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}" readonly>
                    </div>
                    <div class="col form-group">
                        <label>{{ $student->nationality == 'spanish' ? 'Nacionalidad' : 'Origen' }}</label>
                        <input type="text" class="form-control"
                            value="{{ $student->nationality == 'other' ? $student->origin : ($student->nationality == 'spanish' ? 'Española' : $student->nationality) }}"
                            readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ $student->email }}" readonly>
                    </div>
                    <div class="col form-group">
                        <label>Curso Actual</label>
                        @if ($student->course)
                            <input type="text" class="form-control"
                                value="{{ $student->course->grade }}º {{ $student->course->class_letter }}" readonly>
                        @else
                            <input type="text" class="form-control" value="No asignado" readonly>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col form-group">
                        <label>¿Ha repetido algún curso?</label>
                        <input type="text" class="form-control" value="{{ $student->repeated_grade ? 'Sí' : 'No' }}"
                            readonly>
                    </div>
                    @if ($student->repeated_grade)
                        <div class="col form-group">
                            <label>Cursos Repetidos</label>
                            @php
                                $courses = [
                                    1 => '1º ESO',
                                    2 => '2º ESO',
                                    3 => '3º ESO',
                                    4 => '4º ESO',
                                    5 => '5º Primaria',
                                    6 => '6º Primaria',
                                ];
                                
                                $repeated_courses_names = array_map(function ($courseNumber) use ($courses) {
                                    return $courses[trim($courseNumber)];
                                }, explode(',', $student->repeated_courses));
                            @endphp
                            <input type="text" class="form-control"
                                value="{{ implode(', ', $repeated_courses_names) }}" readonly>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col form-group">
                        <label>Nivel</label>
                        @if ($student->level)
                            <input type="text" class="form-control" value="{{ $student->level }}" readonly>
                        @else
                            <input type="text" class="form-control" value="No asignado" readonly>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-primary">Editar</a>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                    Eliminar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Eliminar Alumno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar este alumno?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('student.destroy', $student->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
