<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
</head>
<body>
    <div class="container text-center">
        <a href="/" class="btn btn-link back-link"><img src="{{ asset('icons/left-arrow.svg') }}" alt="Icono" width="20" height="20"> Volver</a>
        <div class="row justify-content-center align-items-center" style="height: 80vh;">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="title-text">Soy Alumno</h2>
                        <a href="/register/student" class="btn btn-primary btn-block">Registrarse</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="title-text">Soy Profesor</h2>
                        <a href="/register/teacher" class="btn btn-primary btn-block">Registrarse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
