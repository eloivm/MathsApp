<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preguntas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
</head>

<body>
    @if (Auth::guard('teacher')->check())
        @include('partials.navbar_teacher')
    @elseif(Auth::guard('superadmin')->check())
        @include('partials.navbar_principal')
    @endif
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="title-text text-center mb-5" style="font-size: 2.5rem;">Lista de Preguntas</h3>
                <div class="form-group">
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Buscar preguntas" value="{{ $search ?? '' }}">
                </div>
                @if ($questions->isEmpty())
                    <p class="lead text-center" style="font-style: italic;">Todavía no hay preguntas.</p>
                @else
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Enunciado</th>
                                        <th scope="col">Respuesta</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Tema</th>
                                        <th scope="col">Curso</th>
                                        @if (Auth::guard('superadmin')->check())
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="questionTableBody">
                                    @foreach ($questions as $question)
                                        @if ($question->is_delete === 0)
                                            <tr>
                                                <td class="mathjax">{{ $question->enunciation }}</td>
                                                <td>
                                                    @foreach ($question->answers as $answer)
                                                        @if ($answer->is_correct == 1)
                                                            {{ $answer->content }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $question->type == 'multiple_choice' ? 'Respuesta múltiple' : 'Respuesta corta' }}
                                                </td>
                                                <td>{{ $question->topic }}</td>
                                                <td>
                                                    @if ($question->course == 5 || $question->course == 6)
                                                        {{ $question->course }}º Primaria
                                                    @else
                                                        {{ $question->course }}º ESO
                                                    @endif
                                                </td>
                                                @if (Auth::guard('superadmin')->check())
                                                    <td>
                                                        <a href="{{ route('questions.edit', $question->id) }}"
                                                            class="btn btn-primary">Editar</a>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal{{ $question->id }}"
                                                            data-question-id="{{ $question->id }}">Eliminar</button>
                                                    </td>
                                                @elseif(Auth::guard('teacher')->check())
                                                    <td>
                                                        <a href="{{ route('questions.edit.teacher', $question->id) }}"
                                                            class="btn btn-primary">Editar</a>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal{{ $question->id }}"
                                                            data-question-id="{{ $question->id }}">Eliminar</button>
                                                    </td>
                                                @endif

                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if (Auth::guard('superadmin')->check())
        <div style="position: fixed; bottom: 20px; right: 20px;">
            <a href="{{ route('questions.create') }}" class="btn btn-primary add-question-btn">Añadir pregunta</a>
        </div>
    @endif
    @if (Auth::guard('teacher')->check())
        <div style="position: fixed; bottom: 20px; right: 20px;">
            <a href="{{ route('questions.create.teacher') }}" class="btn btn-primary add-question-btn">Añadir pregunta</a>
        </div>
    @endif

    @foreach ($questions as $question)
        <!-- Modal -->
        <div class="modal fade" id="deleteModal{{ $question->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $question->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $question->id }}">Eliminar Pregunta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro de que desea eliminar la pregunta?</p>
                        <p>{{ $question->enunciation }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                         @if (Auth::guard('superadmin')->check())
                        <form action="{{ route('preguntas.delete', $question->id) }}" method="POST">
                        @endif
                         @if (Auth::guard('teacher')->check())
                         <form action="{{ route('preguntas.delete.teacher', $question->id) }}" method="POST">
                         @endif
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        window.onload = function() {
            const cells = document.getElementsByClassName('mathjax');
            Array.prototype.forEach.call(cells, function(cell) {
                MathJax.typeset([cell]);
            });
        };

        const questionTableBody = document.getElementById('questionTableBody');
        const searchInput = document.getElementById('searchInput');
        const questionRows = questionTableBody.querySelectorAll('tr');

        searchInput.addEventListener('input', function() {
            const searchValue = searchInput.value.toLowerCase();

            questionRows.forEach(function(row) {
                let cellTexts = Array.from(row.querySelectorAll('td')).map(td => td.textContent
                    .toLowerCase());
                let rowContainsSearchValue = cellTexts.some(text => text.includes(searchValue));

                if (rowContainsSearchValue || searchValue === '') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
