<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de control del profesor</title>
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
            <div class="col-md-8">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-header text-center" style="background-color: #F0F8FF;">
                        <h3 class="title-text" style="font-size: 1.5rem;">Bienvenido/a al Dashboard,
                            {{ auth()->user()->name }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead text-center" style="font-style: italic;">"La educación es el arma más poderosa
                            que puedes usar para cambiar el mundo." - Nelson Mandela
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
