<nav class="navbar navbar-expand-lg navbar-dark bg-primary w-100 navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('teacher_dashboard') }}">DASHBOARD</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('teacher.students') }}">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('teacher.questions') }}">Preguntas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('statistics_teacher') }}">Estadísticas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('teacher.quizzes') }}">Cuestionarios</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (Auth::guard('teacher')->check())
                            Bienvenido/a, {{ Auth::guard('teacher')->user()->name }}
                        @elseif(Auth::guard('student')->check())
                            Bienvenido/a, {{ Auth::guard('student')->user()->name }}
                        @else
                            Bienvenido/a, Invitado
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('teacher.profile') }}">Mi perfil</a>
                        <a class="dropdown-item" href="{{ route('change.password.form') }}">Cambiar contraseña</a>
                        <a class="dropdown-item" href="{{ route('generate_access_code') }}">Generar código de acceso</a>
                        <a class="dropdown-item" href="{{ route('teacher.delete') }}">Eliminar cuenta</a>
                    </div>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
