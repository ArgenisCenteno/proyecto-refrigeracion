<form action="{{ route('pagos.update', $pago->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="tipo" value="{{ $pago->tipo }}" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label for="fecha_pago" class="form-label">Fecha de Pago</label>
            <input type="text" class="form-control" id="fecha_pago" value="{{ $pago->fecha_pago }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="fecha_pago" class="form-label">Cliente</label>
            <input type="text" class="form-control" id="fecha_pago" value="{{ $pago->user->name ?? '' }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="fecha_pago" class="form-label">Cédula</label>
            <input type="text" class="form-control" id="fecha_pago" value="{{ $pago->user->cedula ?? '' }}" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="monto_total" class="form-label">Monto Total</label>
            <input type="text" class="form-control" id="monto_total" value="{{ $pago->monto_total }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="monto_neto" class="form-label">Monto Neto</label>
            <input type="text" class="form-control" id="monto_neto" value="{{ $pago->monto_neto }}" readonly>
        </div>
    </div>

    @if($pago->status == 'Pagado')
    <h3 class="p-2 bold">Forma de Pago</h3>
    <table class="table ">
            <thead class="table-dark">
                <tr>
                    <th>Forma de Pago</th>
                    <th>Banco de Destino</th>
                    <th>Referencia</th>
                    <th>Moneda</th>
                    <th>Monto Total</th>
                    <th>Total Pagado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formaPagoArray as $pagos)
                    <tr>
                        <td>{{ $pagos['metodo'] }}</td>
                        <td>{{ $pagos['banco_destino'] }}</td>
                        <td>{{ $pagos['numero_referencia'] }}</td>
                        <td>{{ $pagos['metodo'] === 'Divisa' ? 'Dólar' : 'Bolívar' }}</td>
                        <td>{{ $pagos['metodo'] === 'Divisa' ? number_format($pago->monto_total, 2) : number_format($pago->monto_total, 2) }}</td>
                        <td>{{ number_format($pago->monto_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    @endif

    <div class="row mb-3">
       
        <div class="col-md-6">
        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Pendiente" {{ $pago->status == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Pagado"  {{ $pago->status == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                <option value="Rechazado"  {{ $pago->status == 'Rechazado' ? 'selected' : '' }}>Cancelado</option>
                <!-- Add other statuses as needed -->
            </select>
        </div>
        </div>
    </div>
    <div class="row g-4" id="campos-pagos" style="display: none">
        <div class="col-md-6">
            <label for="metodo" class="form-label text-muted">Método de Pago</label>
            <select class="form-select border-0 shadow-sm p-3" id="metodo" name="metodo" 
                style="background-color: #ECF0F1;">
                <option value="" selected>Seleccione un método de pago</option>
                <option value="Pago movil">Pago móvil</option>
                <option value="Transferencia">Transferencia</option>
              
            </select>
        </div>

        <div class="col-md-6">
            <label for="banco_origen" class="form-label text-muted">Banco de Origen</label>
            <select class="form-select border-0 shadow-sm p-3" id="banco_origen" name="banco_origen"
                style="background-color: #ECF0F1;">
                <option value="" disabled selected>Selecciona tu banco de origen</option>
                <option value="Banesco">Banesco</option>
                <option value="Banco de Venezuela">Banco de Venezuela</option>
                <option value="Mercantil">Mercantil</option>
                <option value="BBVA Provincial">BBVA Provincial</option>
                <option value="Bicentenario">Bicentenario</option>
                <option value="Banco Exterior">Banco Exterior</option>
                <option value="Banco del Tesoro">Banco del Tesoro</option>
                <option value="Banco Nacional de Crédito">Banco Nacional de Crédito</option>
                <option value="Banco Sofitasa">Banco Sofitasa</option>
                <option value="Banco del Caroní">Banco del Caroní</option>
                <option value="Banco Plaza">Banco Plaza</option>
                <option value="Bancrecer">Bancrecer</option>
                <option value="Banco Activo">Banco Activo</option>
                <option value="Banco Agrícola de Venezuela">Banco Agrícola de Venezuela</option>
                <option value="100% Banco">100% Banco</option>

            </select>
        </div>

        <div class="col-md-6">
            <label for="banco_destino" class="form-label text-muted">Banco de Destino</label>
            <select class="form-select border-0 shadow-sm p-3" id="banco_destino" name="banco_destino"
                style="background-color: #ECF0F1;">
                <option value="" selected>Selecciona tu banco de destino</option>
                <option value="Mercantil">Mercantil</option>
                <option value="Banco de Venezuela">Banco de Venezuela</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="numero_referencia" class="form-label text-muted">Número de
                Referencia</label>
            <input type="text" class="form-control border-0 shadow-sm p-3" id="numero_referencia"
                name="numero_referencia" maxlength="8" placeholder="12345678" pattern="\d{8}"
                title="Debe tener 8 dígitos" style="background-color: #ECF0F1;">
        </div>
 
    </div>


    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Aceptar</button>
    </div>
</form>

<script>
     $(document).ready(function () {
        $('#status').change(function () {
            var selectedRole = $(this).val();

            // Show document upload fields if the selected role is "Conductor"
            if (selectedRole === 'Pagado') { // Make sure the value matches the role name
                $('#campos-pagos').show();
            } else {
                $('#campos-pagos').hide();
            }
        });
    });
</script>