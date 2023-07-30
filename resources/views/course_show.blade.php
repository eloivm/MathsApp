<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles del Curso</title>
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
        <div class="card" style="border-radius: 15px;">
            <div class="card-header text-left" style="background-color: #F0F8FF;">
                <h1 class="title-text" style="font-size: 2.5rem;">
                    {{ $course->grade }}º {{ $course->class_letter }}
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col form-group">
                        <label>Descripción</label>
                        <input type="text" class="form-control" value="{{ $course->description ?: 'Sin descripción' }}" readonly>
                    </div>
                    <div class="col form-group">
                        <label>Profesor Asignado</label>
                        <input type="text" class="form-control" value="{{ $course->teacher ? $course->teacher->name . ' ' . $course->teacher->surname : 'No asignado' }}" readonly>
                    </div>
                </div>
            </div>
            <div class="card-footer">
               <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary">Editar</a>
               <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Eliminar</button>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Eliminar Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar este curso?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>
