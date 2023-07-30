<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Cuestionario</title>
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
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">¡Es hora del cuestionario!</h3>
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <p class="card-text">
                            ¡Hola! ¿Listo para divertirte y aprender con este cuestionario? <br><br> Tiene varias preguntas
                            y
                            algunas te pedirán que escribas una respuesta corta, mientras que otras serán de tipo test
                            con
                            opciones para seleccionar. En las preguntas de tipo test, recuerda, solo puedes seleccionar
                            una respuesta.<br><br>
                            Y no te preocupes si no conoces todas las respuestas, lo importante es que te diviertas y
                            aprendas cosas nuevas. ¡Empecemos!
                        </p>
                        <div class="text-center">
                            <a href="{{ route('quiz.start') }}" class="btn btn-primary">Iniciar Cuestionario</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
