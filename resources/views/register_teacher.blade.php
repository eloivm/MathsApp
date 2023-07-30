<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro para Profesores</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
</head>

<body>
    <div class="container">
        <a href="/register" class="btn btn-link back-link"><img src="{{ asset('icons/left-arrow.svg') }}" alt="Icono"
                width="20" height="20"> Volver</a>
        <div class="row justify-content-center align-items-center" style="height: 80vh;">
            <div class="col-lg-7 text-center">
                <h1 class="title-text">Bienvenido, Profesor</h1>
                @if ($errors->any())
                    <div class="alert alert-danger mt-5">
                        <ul class="text-left">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="/register/teacher">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Apellidos</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" value="{{ old('dni') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="department">Departamento</label>
                                <input type="text" class="form-control" id="department" name="department" value="{{ old('department') }}" required>
                            </div>
                              <div class="form-group">
                                <label for="ref_code">Código de Acceso</label>
                                <input type="text" class="form-control" id="ref_code" name="ref_code" value="{{ old('ref_code') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
