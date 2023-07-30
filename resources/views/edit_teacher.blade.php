<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Actualizar Profesor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
</head>

<body>
    @include('partials.navbar_principal')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Actualizar Profesor</h3>
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <form method="POST" action="{{ route('teachers.update', $teacher->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $teacher->name }}">
                            </div>
                            <div class="form-group">
                                <label for="surname">Apellido</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="{{ $teacher->surname }}">
                            </div>
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" value="{{ $teacher->dni }}">
                            </div>
                            <div class="form-group">
                                <label for="department">Departamento</label>
                                <input type="text" class="form-control" id="department" name="department" value="{{ $teacher->department }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $teacher->email }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Actualizar Profesor</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
