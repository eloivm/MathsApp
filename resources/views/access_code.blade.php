<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generar Código de Acceso</title>
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
                        <h3 class="title-text" style="font-size: 1.5rem;">Generar Código de Acceso</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead text-center" style="font-style: italic;">Código de Acceso:
                            <strong>{{ $accessCode }}</strong></p>
                        @if (optional($course))
                            <p class="lead text-center" style="font-style: italic;">Este código es para el curso:
                                <strong>{{ optional($course)->grade }}º{{ optional($course)->class_letter }}</strong>
                            </p>
                        @endif
                        <p class="lead text-center" style="font-style: italic;">Este código caducará en <span
                                id="countdown">{{ $expirationMinutes }}</span> minutos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    // Obtiene el elemento del contador de minutos
    const countdownElement = document.getElementById('countdown');

    // Establece el tiempo inicial en minutos
    let timeRemaining = {{ $expirationMinutes }};

    // Actualiza el contador cada minuto
    const countdown = setInterval(() => {
        timeRemaining--;
        countdownElement.textContent = timeRemaining;

        // Detiene el contador cuando se alcanza cero
        if (timeRemaining <= 0) {
            clearInterval(countdown);
            countdownElement.textContent = '0';
        }
    }, 60000); // 60000 milisegundos = 1 minuto
</script>

</html>
