<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>¡Has acabado el cuestionario!</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
</head>

<body>
    @include('partials.navbar_student')

    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-6 mx-auto">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">¡Has superado el cuestionario!</h3>
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <p class="card-text">
                            ¡Enhorabuena! Has hecho un gran trabajo superando este cuestionario.<br><br> 
                            Sientete orgulloso de ti. Cada cuestionario que completas te lleva un paso más cerca de tus metas.<br><br>
                            Recuerda, el aprendizaje es un viaje y cada paso cuenta. ¡Sigue así! 
                        </p>
                        <div class="text-center">
                            <a href="{{ route('student_dashboard') }}" class="btn btn-primary">Volver al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
