<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Actualizar estudiante</title>
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
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Actualizar Estudiante</h3>
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <form method="POST" action="#">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $student->email }}">
                            </div>
                            <div class="form-group">
                                <label for="phone">Teléfono</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ $student->phone }}">
                            </div>
                            <div class="form-group">
                                <label for="dob">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="{{ $student->dob }}">
                            </div>
                            <div class="form-group">
                                <label for="course">Curso Actual</label>
                                <input type="text" class="form-control" id="course" name="course" value="{{ $student->course }}">
                            </div>
                            <div class="form-group">
                                <label for="repeated_courses">Cursos Repetidos</label>
                                <input type="text" class="form-control" id="repeated_courses" name="repeated_courses" value="{{ $student->repeated_courses }}">
                            </div>
                            <div class="form-group">
                                <label for="nationality">Nacionalidad</label>
                                <input type="text" class="form-control" id="nationality" name="nationality" value="{{ $student->nationality }}">
                            </div>
                            <div class="form-group">
                                <label for="country_origin">País de Origen</label>
                                <input type="text" class="form-control" id="country_origin" name="country_origin" value="{{ $student->country_origin }}">
                            </div>
                            <div class="form-group">
                                <label for="arrival_date">Fecha de Llegada</label>
                                <input type="date" class="form-control" id="arrival_date" name="arrival_date" value="{{ $student->arrival_date }}">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Actualizar Estudiante</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
