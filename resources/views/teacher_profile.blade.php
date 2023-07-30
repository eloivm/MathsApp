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
    @include('partials.navbar_teacher')
    <div class="content">
        <div class="card" style="border-radius: 15px;">
            <div class="card-header text-left" style="background-color: #F0F8FF;">
                <h1 class="title-text" style="font-size: 2.5rem;">
                    {{ auth()->guard('teacher')->user()->name }} {{ auth()->guard('teacher')->user()->surname }}
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col form-group">
                        <label>DNI</label>
                        <input type="text" class="form-control" value="{{ Auth::guard('teacher')->user()->dni }}"
                            readonly>
                    </div>
                    <div class="col form-group">
                        <label>Departamento</label>
                        <input type="text" class="form-control"
                            value="{{ Auth::guard('teacher')->user()->department }}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ Auth::guard('teacher')->user()->email }}"
                            readonly>
                    </div>
                    <div class="col form-group">
                        <label>Cursos impartidos</label>
                        <ul class="list-group">
                            @foreach (Auth::guard('teacher')->user()->courses as $course)
                                <input type="text" class="form-control"
                                    value="{{ $course->grade }} - {{ $course->class_letter }}" readonly>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
