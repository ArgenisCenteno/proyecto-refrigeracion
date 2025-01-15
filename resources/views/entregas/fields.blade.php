<form action="{{ route('entregas.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="venta_id">Venta</label>
        <select name="venta_id" id="venta_id" class="form-control">
            @foreach ($ventas as $venta)
                <option value="{{ $venta->id }}">{{ $venta->id }}-{{ $venta->user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="empleado_id">Empleado</label>
        <select name="empleado_id" id="empleado_id" class="form-control">
            @foreach ($empleados as $empleado)
                <option value="{{ $empleado->id }}">{{ $empleado->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="fecha_entrega">Fecha de Entrega</label>
        <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-control">
    </div>
    <div class="form-group">
        <label for="estado">Estado</label>
        <select name="estado" id="estado" class="form-control">
            <option value="Entregado" {{ old('estado', isset($entrega) ? $entrega->estado : '') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
            <option value="Enviado" {{ old('estado', isset($entrega) ? $entrega->estado : '') == 'Enviado' ? 'selected' : '' }}>Enviado</option>
            <option value="Sin Enviar" {{ old('estado', isset($entrega) ? $entrega->estado : '') == 'Sin Enviar' ? 'selected' : '' }}>Sin Enviar</option>
        </select>
    </div>


    <div class="form-group">
        <label for="observaciones">Observaciones</label>
        <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>