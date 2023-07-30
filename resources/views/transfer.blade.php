<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Perfil</title>
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
        <div class="card">
            <div class="card-header">
                <h3 class="title-text">Estás a punto de ceder tu cuenta</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('superadmin.transferTo', ['id' => Auth::guard('superadmin')->id()]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ Auth::guard('superadmin')->user()->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni"
                            value="{{ Auth::guard('superadmin')->user()->dni }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>
                    </div>
                    <a href="{{ route('principal.profile') }}" class="btn btn-primary">Cancelar</a>
                   <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">Ceder cuenta</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
