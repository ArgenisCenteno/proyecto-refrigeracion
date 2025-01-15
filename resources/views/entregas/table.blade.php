<table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Venta</th>
                <th>Empleado</th>
                <th>Fecha de Entrega</th>
                <th>Estado</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entregas as $entrega)
                <tr>
                    <td>{{ $entrega->id }}</td>
                    <td>{{ $entrega->venta->id }}</td>
                    <td>{{ $entrega->empleado->name }}</td>
                    <td>{{ $entrega->fecha_entrega }}</td>
                    <td>{{ $entrega->estado }}</td>
                    <td>{{ $entrega->observaciones }}</td>
                    
                    <td>
                        <a href="{{ route('entregas.edit', $entrega) }}" class="btn btn-info btn-sm">Editar</a>
                        <a href="{{ route('entregas.pdf', $entrega->id) }}" target="_blank" class="btn btn-warning btn-sm">PDF</a>
                        @if(Auth::user()->hasRole('superAdmin'))
                        <form action="{{ route('entregas.destroy', $entrega) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>