<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cambiar Contraseña</title>
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
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Cambiar Contraseña</h3>
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <form method="POST" action="{{ route('change.password') }}">
                            @csrf
                            <div class="form-group">
                                <label for="old_password">Contraseña Actual</label>
                                <input type="password" class="form-control" id="old_password" name="old_password"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Cambiar Contraseña</button>
                        </form>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
