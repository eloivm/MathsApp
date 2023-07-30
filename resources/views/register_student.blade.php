<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiante</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
</head>

<body>
    <div class="container">
        <a href="/register" class="btn btn-link back-link"><img src="{{ asset('icons/left-arrow.svg') }}" alt="Icono"
                width="20" height="20"> Volver</a>
        <div class="row justify-content-center align-items-center" style="height: 80vh;">
            <div class="col-lg-7 text-center">
                <h1 class="title-text">Bienvenido, Estudiante</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="/register/student">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Apellidos</label>
                                <input type="text" class="form-control" id="surname" name="surname"
                                    value="{{ old('surname') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="dob">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="dob" name="dob"
                                    value="{{ old('dob') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="ref_code">Código de Acceso</label>
                                <input type="text" class="form-control" id="ref_code" name="ref_code"
                                    value="{{ old('ref_code') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="repeated_grade">¿Repitió algún curso?</label>
                                <select class="form-control" id="repeated_grade" name="repeated_grade"
                                    onchange="displayCheckboxes(this.value)">
                                    <option value="no" {{ old('repeated_grade') == 'no' ? 'selected' : '' }}>No
                                    </option>
                                    <option value="yes" {{ old('repeated_grade') == 'yes' ? 'selected' : '' }}>Sí
                                    </option>
                                </select>
                            </div>
                            <div id="checkboxes_container" style="display:none;">
                                <label>Marque los cursos que ha repetido:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="grade1"
                                        name="repeated_courses[]"
                                        {{ is_array(old('repeated_courses')) && in_array(1, old('repeated_courses')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade1">1º de ESO</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2" id="grade2"
                                        name="repeated_courses[]"
                                        {{ is_array(old('repeated_courses')) && in_array(2, old('repeated_courses')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade2">2º de ESO</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="3" id="grade3"
                                        name="repeated_courses[]"
                                        {{ is_array(old('repeated_courses')) && in_array(3, old('repeated_courses')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade3">3º de ESO</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="4" id="grade4"
                                        name="repeated_courses[]"
                                        {{ is_array(old('repeated_courses')) && in_array(4, old('repeated_courses')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade4">4º de ESO</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nationality">Nacionalidad</label>
                                <select class="form-control" id="nationality" name="nationality"
                                    onchange="displayExtraFields(this.value)">
                                    <option value="spanish" {{ old('nationality') == 'spanish' ? 'selected' : '' }}>
                                        Español/a</option>
                                    <option value="other" {{ old('nationality') == 'other' ? 'selected' : '' }}>
                                        Otro/a</option>
                                </select>
                            </div>
                            <div id="extra_fields" style="display:none;">
                                <div class="form-group">
                                    <label for="origin">País de origen</label>
                                    <select class="form-control" id="origin" name="origin">
                                        <option value="">Selecciona tu país</option>
                                        <option value="Afganistán">Afganistán</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Alemania">Alemania</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Antigua y Barbuda">Antigua y Barbuda</option>
                                        <option value="Arabia Saudita">Arabia Saudita</option>
                                        <option value="Argelia">Argelia</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaiyán">Azerbaiyán</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bangladés">Bangladés</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Baréin">Baréin</option>
                                        <option value="Bélgica">Bélgica</option>
                                        <option value="Belice">Belice</option>
                                        <option value="Benín">Benín</option>
                                        <option value="Bielorrusia">Bielorrusia</option>
                                        <option value="Birmania">Birmania</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bosnia y Herzegovina">Bosnia y Herzegovina</option>
                                        <option value="Botsuana">Botsuana</option>
                                        <option value="Brasil">Brasil</option>
                                        <option value="Brunéi">Brunéi</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Bután">Bután</option>
                                        <option value="Cabo Verde">Cabo Verde</option>
                                        <option value="Camboya">Camboya</option>
                                        <option value="Camerún">Camerún</option>
                                        <option value="Canadá">Canadá</option>
                                        <option value="Catar">Catar</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Chipre">Chipre</option>
                                        <option value="Ciudad del Vaticano">Ciudad del Vaticano</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoras">Comoras</option>
                                        <option value="Corea del Norte">Corea del Norte</option>
                                        <option value="Corea del Sur">Corea del Sur</option>
                                        <option value="Costa de Marfil">Costa de Marfil</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Croacia">Croacia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Dinamarca">Dinamarca</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egipto">Egipto</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Emiratos Árabes Unidos">Emiratos Árabes Unidos</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Eslovaquia">Eslovaquia</option>
                                        <option value="Eslovenia">Eslovenia</option>
                                        <option value="Estados Unidos">Estados Unidos</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Eswatini">Eswatini</option>
                                        <option value="Etiopía">Etiopía</option>
                                        <option value="Filipinas">Filipinas</option>
                                        <option value="Finlandia">Finlandia</option>
                                        <option value="Fiyi">Fiyi</option>
                                        <option value="Francia">Francia</option>
                                        <option value="Gabón">Gabón</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Granada">Granada</option>
                                        <option value="Grecia">Grecia</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guinea Ecuatorial">Guinea Ecuatorial</option>
                                        <option value="Guinea-Bisáu">Guinea-Bisáu</option>
                                        <option value="Haití">Haití</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hungría">Hungría</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Irak">Irak</option>
                                        <option value="Irán">Irán</option>
                                        <option value="Irlanda">Irlanda</option>
                                        <option value="Islandia">Islandia</option>
                                        <option value="Islas Marshall">Islas Marshall</option>
                                        <option value="Islas Salomón">Islas Salomón</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italia">Italia</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japón">Japón</option>
                                        <option value="Jordania">Jordania</option>
                                        <option value="Kazajistán">Kazajistán</option>
                                        <option value="Kenia">Kenia</option>
                                        <option value="Kirguistán">Kirguistán</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Lesoto">Lesoto</option>
                                        <option value="Letonia">Letonia</option>
                                        <option value="Líbano">Líbano</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libia">Libia</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lituania">Lituania</option>
                                        <option value="Luxemburgo">Luxemburgo</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malasia">Malasia</option>
                                        <option value="Malaui">Malaui</option>
                                        <option value="Maldivas">Maldivas</option>
                                        <option value="Malí">Malí</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marruecos">Marruecos</option>
                                        <option value="Mauricio">Mauricio</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="México">México</option>
                                        <option value="Micronesia">Micronesia</option>
                                        <option value="Moldavia">Moldavia</option>
                                        <option value="Mónaco">Mónaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montenegro">Montenegro</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Namibia">Namibia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Níger">Níger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Noruega">Noruega</option>
                                        <option value="Nueva Zelanda">Nueva Zelanda</option>
                                        <option value="Omán">Omán</option>
                                        <option value="Países Bajos">Países Bajos</option>
                                        <option value="Pakistán">Pakistán</option>
                                        <option value="Palaos">Palaos</option>
                                        <option value="Panamá">Panamá</option>
                                        <option value="Papúa Nueva Guinea">Papúa Nueva Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Perú">Perú</option>
                                        <option value="Polonia">Polonia</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Reino Unido">Reino Unido</option>
                                        <option value="República Centroafricana">República Centroafricana</option>
                                        <option value="República Checa">República Checa</option>
                                        <option value="República de Macedonia">República de Macedonia</option>
                                        <option value="República del Congo">República del Congo</option>
                                        <option value="República Democrática del Congo">República Democrática del Congo
                                        </option>
                                        <option value="República Dominicana">República Dominicana</option>
                                        <option value="República Sudafricana">República Sudafricana</option>
                                        <option value="Ruanda">Ruanda</option>
                                        <option value="Rumanía">Rumanía</option>
                                        <option value="Rusia">Rusia</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="San Cristóbal y Nieves">San Cristóbal y Nieves</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="San Vicente y las Granadinas">San Vicente y las Granadinas
                                        </option>
                                        <option value="Santa Lucía">Santa Lucía</option>
                                        <option value="Santo Tomé y Príncipe">Santo Tomé y Príncipe</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Serbia">Serbia</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leona">Sierra Leona</option>
                                        <option value="Singapur">Singapur</option>
                                        <option value="Siria">Siria</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Suazilandia">Suazilandia</option>
                                        <option value="Sudán">Sudán</option>
                                        <option value="Sudán del Sur">Sudán del Sur</option>
                                        <option value="Suecia">Suecia</option>
                                        <option value="Suiza">Suiza</option>
                                        <option value="Surinam">Surinam</option>
                                        <option value="Tailandia">Tailandia</option>
                                        <option value="Taiwán">Taiwán</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Tayikistán">Tayikistán</option>
                                        <option value="Timor Oriental">Timor Oriental</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad y Tobago">Trinidad y Tobago</option>
                                        <option value="Túnez">Túnez</option>
                                        <option value="Turkmenistán">Turkmenistán</option>
                                        <option value="Turquía">Turquía</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Ucrania">Ucrania</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="Uzbekistán">Uzbekistán</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Yibuti">Yibuti</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabue">Zimbabue</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="arrival_date">Fecha de llegada a España</label>
                                    <input type="date" class="form-control" id="arrival_date" name="arrival_date"
                                        value="{{ old('arrival_date') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" required>
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
                            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function displayCheckboxes(value) {
            const container = document.getElementById('checkboxes_container');
            if (value === 'yes') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        function displayExtraFields(value) {
            const container = document.getElementById('extra_fields');
            if (value === 'other') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        window.onload = function() {
            displayCheckboxes(document.getElementById('repeated_grade').value);
            displayExtraFields(document.getElementById('nationality').value);
        }
    </script>
</body>

</html>
