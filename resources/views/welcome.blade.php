<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de adaptaciones curriculares</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/style.css'])
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 80vh;">
            <div class="col-lg-7 text-center">
                <h1 class="title-text">Aprendizaje Sin Límites</h1>
                @if ($errors->any())
                    <div class="alert alert-danger mt-5">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="/login">
                            @csrf
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Acceder</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <a href="/register" class="btn btn-link register-link"><img src="{{ asset('icons/register.svg') }}"
                alt="Icono" width="20" height="20"> ¿No tienes cuenta? Regístrate aquí</a>
    </div>
</body>

</html>
