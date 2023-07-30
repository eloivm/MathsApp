<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Profesores</title>
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
    @include('partials.navbar_principal')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Lista de Profesores</h3>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-3">
                        <input type="text" class="form-control" id="searchInput" placeholder="Buscar profesor">
                    </div>
                </div>

                @if ($teachers->isEmpty())
                    <p class="lead text-center" style="font-style: italic;">No hay profesores en este departamento.</p>
                @else
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body">
                            <table class="table custom-table">
                                <thead>
                                    <tr class="header-row">
                                        <th scope="col">Apellidos</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Departamento</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teachers as $teacher)
                                        <tr>
                                            <td>{{ $teacher->surname }}</td>
                                            <td>{{ $teacher->name }}</td>
                                            <td>{{ $teacher->dni }}</td>
                                            <td>{{ $teacher->department }}</td>
                                            <td><a href="{{ route('teachers.show', $teacher->id) }}"
                                                    class="btn btn-primary">Ver más</a></td>
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
        const searchInput = document.getElementById('searchInput');
        const table = document.querySelector('.custom-table');

        searchInput.addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();

            Array.from(table.getElementsByTagName('tr')).forEach(function (row, index) {
                if (index === 0) return;

                const cells = row.getElementsByTagName('td');
                let found = false;

                Array.from(cells).forEach(function (cell) {
                    const text = cell.textContent.toLowerCase();

                    if (text.includes(searchValue)) {
                        found = true;
                    }
                });

                row.style.display = found ? 'table-row' : 'none';
            });
        });
    </script>
</body>

</html>
