<form action="{{ route('entregas.update', $entrega->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Usamos PUT para la actualización -->

    <div class="form-group">
        <label for="venta_id">Venta</label>
        <select name="venta_id" id="venta_id" class="form-control">
            @foreach ($ventas as $venta)
                <option value="{{ $venta->id }}" {{ $entrega->venta_id == $venta->id ? 'selected' : '' }}>
                    {{ $venta->id }} - {{ $venta->user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="empleado_id">Empleado</label>
        <select name="empleado_id" id="empleado_id" class="form-control">
            @foreach ($empleados as $empleado)
                <option value="{{ $empleado->id }}" {{ $entrega->empleado_id == $empleado->id ? 'selected' : '' }}>
                    {{ $empleado->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="fecha_entrega">Fecha de Entrega</label>
        <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-control" value="{{ $entrega->fecha_entrega ? $entrega->fecha_entrega->format('Y-m-d') : '' }}">
        </div>

    <div class="form-group">
        <label for="estado">Estado</label>
        <select name="estado" id="estado" class="form-control">
            <option value="Entrega" {{ $entrega->estado == 'Entrega' ? 'selected' : '' }}>Entrega</option>
            <option value="Enviado" {{ $entrega->estado == 'Enviado' ? 'selected' : '' }}>Enviado</option>
            <option value="Sin Enviar" {{ $entrega->estado == 'Sin Enviar' ? 'selected' : '' }}>Sin Enviar</option>
        </select>
    </div>

    <div class="form-group">
        <label for="observaciones">Observaciones</label>
        <textarea name="observaciones" id="observaciones" class="form-control">{{ $entrega->observaciones }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
