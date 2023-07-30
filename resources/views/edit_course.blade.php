<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar curso</title>
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
                <h3 class="title-text text-center" style="font-size: 2rem; margin-bottom: 20px;">Editar curso</h3>
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <form action="{{ route('courses.update', $course->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="grade">Grado</label>
                                <input class="form-control" id="grade" type="number" min="1" name="grade"
                                    value="{{ $course->grade }}" required>
                            </div>
                            <div class="form-group">
                                <label for="class_letter">Letra de la clase:</label>
                                <select class="form-control" id="class_letter" name="class_letter">
                                    @foreach (range('A', 'Z') as $letter)
                                        <option value="{{ $letter }}"
                                            {{ $course->class_letter === $letter ? 'selected' : '' }}>
                                            {{ $letter }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea class="form-control" id="description" name="description"
                                    rows="3">{{ $course->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar curso</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
