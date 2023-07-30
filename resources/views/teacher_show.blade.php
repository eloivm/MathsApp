<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles del Profesor</title>
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
                    {{ $teacher->name }} {{ $teacher->surname }}
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col form-group">
                        <label>DNI</label>
                        <input type="text" class="form-control" value="{{ $teacher->dni }}" readonly>
                    </div>
                    <div class="col form-group">
                        <label>Departamento</label>
                        <input type="text" class="form-control" value="{{ $teacher->department }}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ $teacher->email }}" readonly>
                    </div>
                    <div class="col form-group">
                        <label>Curso</label>
                          @if ($teacher->courses->count() > 0)
                            <input type="text" class="form-control" value="{{ $teacher->courses[0]->grade }}º {{ $teacher->courses[0]->class_letter }}" readonly>
                        @else
                            <input type="text" class="form-control" value="No asignado" readonly>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
               <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-primary">Editar</a>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Eliminar</button>
            </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Eliminar Profesor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar a este profesor?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST">
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
