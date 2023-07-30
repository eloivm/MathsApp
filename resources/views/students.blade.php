<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estudiantes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
    <style>
        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
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
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Lista de Estudiantes</h3>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-3">
                        <label for="courseSelect">Filtrar por Curso:</label>
                        <select class="form-control" id="courseSelect" name="course">
                            <option value="todos">Todos los Alumnos</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->grade . ' ' . $course->class_letter }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-3">
                        <label for="searchInput">Buscar:</label>
                        <input type="text" class="form-control" id="searchInput"
                            placeholder="Buscar por nombre, apellidos, nivel, email, curso">
                    </div>
                </div>

                @if ($students->isEmpty())
                    <p class="lead text-center" style="font-style: italic;">No hay estudiantes en este curso.</p>
                @else
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Apellidos</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Nivel</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Curso</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr class="student-row" data-course="{{ $student->course_id }}">
                                            <td>{{ $student->surname }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->level }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>{{ $student->course->grade . ' ' . $student->course->class_letter }}
                                            </td>
                                            @if (Auth::guard('teacher')->check())
                                                <td><a href="{{ url('/students/' . str_replace(' ', '', $student->surname) . '_' . str_replace(' ', '', $student->name)) }}"
                                                        class="btn btn-primary">Ver más</a></td>
                                            @elseif(Auth::guard('superadmin')->check())
                                                <td><a href="{{ url('/principal/students/' . str_replace(' ', '', $student->surname) . '_' . str_replace(' ', '', $student->name)) }}"
                                                        class="btn btn-primary">Ver más</a></td>
                                            @endif
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

    <script>
        const courseSelect = document.getElementById('courseSelect');
        const searchInput = document.getElementById('searchInput');
        const studentRows = document.querySelectorAll('.student-row');

        courseSelect.addEventListener('change', function() {
            filterStudents();
        });

        searchInput.addEventListener('input', function() {
            filterStudents();
        });

        function filterStudents() {
            const selectedCourseId = courseSelect.value.toLowerCase();
            const searchQuery = searchInput.value.toLowerCase();

            studentRows.forEach(function(row) {
                const rowCourseId = row.getAttribute('data-course').toLowerCase();
                const rowText = row.innerText.toLowerCase();

                const isCourseMatched = selectedCourseId === 'todos' || selectedCourseId === rowCourseId;
                const isSearchMatched = rowText.includes(searchQuery);

                if (isCourseMatched && isSearchMatched) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>
