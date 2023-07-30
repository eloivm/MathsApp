<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
</head>

<body>
    @include('partials.navbar_student')
    <div class="content">
        <div class="card" style="border-radius: 15px;">
            <div class="card-header text-left" style="background-color: #F0F8FF;">
                <h1 class="title-text" style="font-size: 2.5rem;">
                    {{ auth()->guard('student')->user()->name }} {{ auth()->guard('student')->user()->surname }}
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col form-group">
                        <label>Fecha de Nacimiento</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse(auth()->guard('student')->user()->dob)->format('d/m/Y') }}"
                            readonly>
                    </div>
                    <div class="col form-group">
                         <label>{{ auth()->guard('student')->user()->nationality == 'spanish' ? 'Nacionalidad' : 'Origen' }}</label>
                        <input type="text" class="form-control" value="{{ auth()->guard('student')->user()->nationality == 'other' ? auth()->guard('student')->user()->origin : (auth()->guard('student')->user()->nationality == 'spanish' ? 'Española' : auth()->guard('student')->user()->nationality) }}"
                            readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ auth()->guard('student')->user()->email }}"
                            readonly>
                    </div>
                    <div class="col form-group">
                        <label>Curso Actual</label>
                        @if(auth()->guard('student')->user()->course)
                            <input type="text" class="form-control"
                                value="{{ auth()->guard('student')->user()->course->grade }}º {{ auth()->guard('student')->user()->course->class_letter }}" readonly>
                        @else
                            <input type="text" class="form-control" value="No asignado" readonly>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
