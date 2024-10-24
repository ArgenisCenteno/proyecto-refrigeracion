<form action="{{ route('vehiculos.store') }}" method="POST">
    @csrf
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
            <label for="user_id" class="form-label">Conductor</label>
            <select class="form-select" id="user_id" name="user_id" required>
                <option value="">Selecciona un conductor</option>
                @foreach($conductores as $conductor)
                    <option value="{{ $conductor->id }}">{{ $conductor->name }}</option>
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

    <button type="submit" class="btn btn-primary">Agregar Vehículo</button>
</form>