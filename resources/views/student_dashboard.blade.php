<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
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
            <div class="col-md-8">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-header text-center" style="background-color: #F0F8FF;">
                        <h3 class="title-text" style="font-size: 1.5rem;">¡Bienvenido/a,
                            {{ auth()->user()->name }}!</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead text-center phrase-text" style="font-style: italic;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var quotes = [
                {
                    text: "\"Aprender es descubrir que algo es posible.\" - Fritz Perls",
                },
                {
                    text: "\"La educación es el pasaporte hacia el futuro.\" - Malcolm X",
                },
                {
                    text: "\"Nunca dejes de aprender, porque la vida nunca deja de enseñar.\" - Anónimo",
                },
                {
                    text: "\"El conocimiento es poder.\" - Francis Bacon",
                },
                {
                    text: "\"El aprendizaje es un viaje sin fin.\" - Benjamin Franklin",
                },
                {
                    text: "\"Si puedes soñarlo, puedes lograrlo.\" - Walt Disney",
                }
            ];

            var quoteElement = document.querySelector('.phrase-text');

            var randomIndex = Math.floor(Math.random() * quotes.length);
            var randomQuote = quotes[randomIndex];
            
            quoteElement.textContent = randomQuote.text;
        });
    </script>
</body>

</html>
