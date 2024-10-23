<style>
    .invalid-feedback {
        color: red !important;
    }
</style>

<form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="dni" class="form-label">Cédula</label>
            <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" name="dni"
                value="{{ old('dni') }}" required>
            @error('dni')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="role" class="form-label">Rol</label>
                <select class="form-select role" id="role" name="role" required>
                    <option value="">Selecciona un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="mb-3 col-md-4">
            <label for="sector" class="form-label">Sector</label>
            <select class="form-select @error('sector') is-invalid @enderror" id="sector" name="sector" required>
                <option value="">Selecciona un sector</option>
                @foreach($sectores as $sector)
                    <option value="{{ $sector->nombre }}" {{ old('sector') == $sector->nombre ? 'selected' : '' }}>
                        {{ $sector->nombre }}
                    </option>
                @endforeach
            </select>
            @error('sector')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


    </div>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="calle" class="form-label">Calle</label>
            <input type="text" class="form-control @error('calle') is-invalid @enderror" id="calle" name="calle"
                value="{{ old('calle') }}" required>
            @error('calle')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="casa" class="form-label">Casa</label>
            <input type="text" class="form-control @error('casa') is-invalid @enderror" id="casa" name="casa"
                value="{{ old('casa') }}" required>
            @error('casa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="foto_perfil" class="form-label">Foto de Perfil</label>
            <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror" id="foto_perfil"
                name="foto_perfil" accept=".png, .jpg, .jpeg" required>
            @error('foto_perfil')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="genero" class="form-label">Género</label>
            <select class="form-select @error('genero') is-invalid @enderror" id="genero" name="genero" required>
                <option value="">Selecciona un género</option>
                <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('genero')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-12">
            <label for="referencia" class="form-label">Referencia</label>
            <textarea class="form-control @error('referencia') is-invalid @enderror" id="referencia" name="referencia"
                rows="3" placeholder="Detalles de la casa donde vive">{{ old('referencia') }}</textarea>
            @error('referencia')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div id="document-upload-fields" style="display: none;">
        <div class="row">
            <h4>Documentación</h4>
            <div class="col-md-4 mb-3">
                <label for="documento_conducir" class="form-label">Documento de Conducir</label>
                <input type="file" class="form-control" id="documento_conducir" name="documento_conducir">
            </div>
            <div class="col-md-4 mb-3">
                <label for="documento_contrato" class="form-label">Documento de Contrato</label>
                <input type="file" class="form-control" id="documento_contrato" name="documento_contrato">
            </div>
            <div class="col-md-4 mb-3">
                <label for="documento_propiedad" class="form-label">Documento de Propiedad</label>
                <input type="file" class="form-control" id="documento_propiedad" name="documento_propiedad">
            </div>
        </div>

        <div class="row">
            <h4>Datos del vehículo</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="servicio_id" class="form-label">Servicio</label>
                    <select class="form-select" id="servicio_id" name="servicio_id" required>
                        <option value="">Selecciona un servicio</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}">{{ $servicio->descripcion }}</option>
                        @endforeach
                    </select>
                </div>

               
                <div class="col-md-6 mb-3">
                    <label for="tipo" class="form-label">Tipo de Vehículo</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="">Selecciona un tipo de vehículo</option>
                        <option value="Moto">Moto</option>
                        <option value="Carro">Carro</option>
                        <option value="SUV">SUV</option>
                        <option value="Camioneta">Camioneta</option>
                        <option value="Deportivo">Deportivo</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>


                <div class="col-md-6 mb-3">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="modelo" class="form-label">Modelo</label>
                    <input type="text" class="form-control" id="modelo" name="modelo" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" class="form-control" id="color" name="color" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="placa" class="form-label">Placa</label>
                    <input type="text" class="form-control" id="placa" name="placa" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="anio" class="form-label">Año</label>
                    <input type="number" class="form-control" id="anio" name="anio" required>
                </div>


            </div>

        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Aceptar</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#role').change(function () {
            var selectedRole = $(this).val();

            // Show document upload fields if the selected role is "Conductor"
            if (selectedRole === 'conductor') { // Make sure the value matches the role name
                $('#document-upload-fields').show();
            } else {
                $('#document-upload-fields').hide();
            }
        });
    });
</script>