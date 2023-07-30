<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generar Código de Acceso para Profesor</title>
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
            <div class="col-md-8">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-header text-center" style="background-color: #F0F8FF;">
                        <h3 class="title-text" style="font-size: 1.5rem;">Generar Código de Acceso para Profesor</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead text-center" style="font-style: italic;">Código de Acceso:
                            <strong>{{ $accessCode }}</strong></p>
                        <p class="lead text-center" style="font-style: italic;">Este código es de un solo uso y caducará en <span
                                id="countdownHours">{{ $expirationHours }}</span> horas y <span id="countdownMinutes">0</span> minutos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    // Obtiene los elementos del contador de horas y minutos
    const countdownHoursElement = document.getElementById('countdownHours');
    const countdownMinutesElement = document.getElementById('countdownMinutes');

    // Establece el tiempo inicial en horas
    let timeRemainingHours = {{ $expirationHours }};
    let timeRemainingMinutes = 0;

    // Actualiza el contador cada minuto
    const countdown = setInterval(() => {
        if(timeRemainingHours > 0) {
            timeRemainingHours--;
        } else {
            timeRemainingMinutes--;
        }
        countdownHoursElement.textContent = timeRemainingHours;
        countdownMinutesElement.textContent = timeRemainingMinutes;

        // Detiene el contador cuando se alcanza cero
        if (timeRemainingHours <= 0 && timeRemainingMinutes <= 0) {
            clearInterval(countdown);
            countdownHoursElement.textContent = '0';
            countdownMinutesElement.textContent = '0';
        }
    }, 60000); // 60000 milisegundos = 1 minuto
</script>

</html>
