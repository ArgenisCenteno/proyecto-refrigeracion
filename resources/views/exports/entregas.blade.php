<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha de Entrega</th>
            <th>Venta</th>
            <th> Cliente</th>
            <th>Empleado</th>
            <th>Observación</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entregas as $entrega)
            <tr>
                <td>{{ $entrega->id }}</td>
                <td>{{ $entrega->fecha_entrega->format('Y-m-d') }}</td>
                <td>{{ $entrega->venta->id ?? 'N/A' }}</td>
                <td>{{ $entrega->venta->user->name ?? 'N/A' }}</td>
                <td>{{ $entrega->empleado->name ?? 'N/A' }}</td> 
                <td>{{ $entrega->observaciones ?? 'N/A' }}</td>
                <td>{{ $entrega->estado }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
