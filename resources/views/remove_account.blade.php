<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminar cuenta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
</head>

<body>
    @if (Auth::guard('teacher')->check())
        @include('partials.navbar_teacher')
    @elseif(Auth::guard('student')->check())
        @include('partials.navbar_student')
    @endif
    <div class="container content">
        <div class="row justify-content-center" style="overflow: auto;">
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Eliminar cuenta</h3>
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <p class="text-center">¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.</p>
                        <form action="{{ route('teacher.destroy', Auth::id()) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block mt-3">Eliminar cuenta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
