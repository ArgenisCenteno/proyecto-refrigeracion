<?php

namespace App\Http\Controllers;

use App\Models\CuentaPorCobrar;
use App\Models\Sector;
use App\Models\Servicio;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Viaje;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
class ViajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $user = Auth::user();
            if ($user->hasRole('superAdmin')) {
                // Si es superAdmin, obtiene todos los viajes
                $viajes = Viaje::with('user')->orderBy('id', 'DESC')->get();
            } elseif ($user->hasRole('cliente')) {
                // Si es Cliente, obtiene solo los viajes de su usuario
                $viajes = Viaje::with('user')->where('user_id', $user->id)->orderBy('id', 'DESC')->get();
            } else {
                // Manejo para otros roles si es necesario (opcional)
                $viajes = collect(); // o puedes manejar un caso diferente
            } // Cargar relaciones con 'vehiculo' y 'user'

            return DataTables::of($viajes)
                // Columna para vehiculo_id, si no tiene se muestra un badge "Sin asignar"
                ->addColumn('vehiculo_id', function ($row) {
                    return $row->vehiculo ? $row->vehiculo->placa : '<span class="badge badge-dark">Sin asignar</span>';
                })
                // Columna para mostrar el estado con un badge
                ->addColumn('estado', function ($row) {
                    $estado = ucfirst($row->estado); // Convertir la primera letra a mayúscula
                    $badgeClass = '';

                    switch ($row->estado) {
                        case 'Iniciado':
                            $badgeClass = 'badge-warning';
                            break;
                        case 'Completado':
                            $badgeClass = 'badge-success';
                            break;
                        case 'Cancelado':
                            $badgeClass = 'badge-danger';
                            break;
                        default:
                            $badgeClass = 'badge-secondary'; // Estado desconocido
                            break;
                    }
                    return '<span class="badge ' . $badgeClass . '">' . $estado . '</span>';
                })
                // Columna para hora de salida, si no tiene se muestra "Sin iniciar" en un badge
                ->addColumn('hora_salida', function ($row) {
                    return $row->hora_salida ? $row->hora_salida->format('H:i') : '<span class="badge badge-dark">Sin iniciar</span>';
                })
                // Columna para hora de llegada, si no tiene se muestra "Sin finalizar" en un badge
                ->addColumn('hora_llegada', function ($row) {
                    return $row->hora_llegada ? $row->hora_llegada->format('H:i') : '<span class="badge badge-dark">Sin finalizar</span>';
                })
                ->addColumn('usuario', function ($row) {
                    return $row->user->name;
                })
                // Columna para mostrar la fecha de creación en formato 'd-m-Y'
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y');
                })
                // Columna para mostrar la fecha de actualización en formato 'd-m-Y'
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d-m-Y');
                })
                // Columna de acciones (editar y eliminar)
                ->addColumn('actions', function ($row) {
                    $editUrl = route('viajes.edit', $row->id);
                    $deleteUrl = route('viajes.destroy', $row->id);
                    $cancelar = route('viajes.cancelar', $row->id);
                
                    // Botón de Editar, disponible para todos los roles
                    $actions = '<a href="' . $editUrl . '" class="btn btn-success btn-sm">Detalles</a>';
                
                    // Botón de Cancelar, disponible para todos los roles
                    $actions .= '<form action="' . $cancelar . '" method="POST" style="display:inline;" class="btn-delete" onsubmit="return confirm(\'¿Estás seguro de que deseas cancelar este viaje?\');">
                                    ' . csrf_field() . '
                                    ' . method_field('PUT') . '
                                    <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                </form>';
                
                    // Botón de Eliminar, disponible solo para superAdmin
                    if (auth()->user()->hasRole('superAdmin')) {
                        $actions .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" class="btn-delete" onsubmit="return confirm(\'¿Estás seguro de que deseas eliminar este viaje?\');">
                                        ' . csrf_field() . '
                                        ' . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>';
                    }
                
                    return $actions;
                })
                
                ->rawColumns(['vehiculo_id', 'estado', 'hora_salida', 'hora_llegada', 'created_at', 'updated_at', 'actions']) // Permitir HTML en estas columnas
                ->make(true);
        } else {
            return view('viajes.index'); // Vista para mostrar la datatable
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicios = Servicio::all();
        $sectores = Sector::all();
        return view('viajes.create')->with('servicios', $servicios)->with('sectores', $sectores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos enviados
        $request->validate([
            'servicio' => 'required|exists:servicios,id',
            'origen_lat' => 'required|numeric',
            'origen_lon' => 'required|numeric',
            'destino_lat' => 'required|numeric',
            'destino_lon' => 'required|numeric',
            'distancia' => 'required|numeric',
            'tiempo' => 'required|numeric',
        ]);
    
      //  dd($request);
        $servicio = Servicio::find($request->servicio);
    
        $precioPorKm = $servicio->costo;
        $distanciaKm = $request->distancia;
        $precio = $distanciaKm * $precioPorKm;
    
        // Crear una nueva instancia del modelo Viaje y guardar los datos
        $viaje = new Viaje();
        $viaje->user_id = auth()->id(); // Asigna el ID del usuario autenticado
        $viaje->origen = json_encode(['lat' => $request->origen_lat, 'lon' => $request->origen_lon]); // Guardar origen como JSON
        $viaje->destino = json_encode(['lat' => $request->destino_lat, 'lon' => $request->destino_lon]); // Guardar destino como JSON
        $viaje->distancia_km = $distanciaKm;
        $viaje->precio = $precio;
        $viaje->estado = 'Pendiente';
        $viaje->direccion = $request->direccion_destino;
        $viaje->sector_id = $request->sector;
        // Guardar el viaje en la base de datos
        $viaje->save();
    
        // Crear una cuenta por cobrar en estado 'Pendiente'
        $cuenta = new CuentaPorCobrar();
        $cuenta->descripcion = 'Cobro por servicio de viaje'; 
        $cuenta->monto = $precio; 
        $cuenta->status = 'Pendiente';
        $cuenta->viaje_id = $viaje->id;
        $cuenta->user_id = auth()->id();
        $cuenta->procesado_por = null; 
        $cuenta->save(); 
    
        // Redireccionar o devolver una respuesta
        Alert::success('¡Éxito!', 'Viaje solicitado correctamente, espere que se le asigne un conductor')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
    
        return redirect()->route('cuentasPorCobrar.index');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Buscar el viaje por su ID
        $viaje = Viaje::with('vehiculo', 'user')->findOrFail($id);
        $users = User::role('conductor')->get();
        // Retornar la vista de edición y pasar los datos del viaje
        $origen = json_decode($viaje->origen, true);
        $destino = json_decode($viaje->destino, true);

   //     dd($users);
        return view('viajes.edit', compact('viaje', 'origen', 'destino', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $viaje = Viaje::find($id);

        $vehiculo = Vehicle::where('user_id', $request->user_id)->first();

        if($request->user_id){
            if(!$vehiculo){
                Alert::error('¡Error!', 'Este usuario no tiene vehiculo registrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                return redirect()->route('viajes.index');
            }

            $viaje->vehiculo_id = $vehiculo->id;
        }
       
       
        $viaje->estado = $request->estado;
       

        if ($request->estado == 'Iniciado') {
            // Actualiza la hora de salida
            $viaje->hora_salida = Carbon::now();
        } elseif ($request->estado == 'Finalizado') {
            // Actualiza la hora de llegada
            $viaje->hora_llegada = Carbon::now();
        }

        $viaje->save();
        Alert::success('¡Éxito!', 'Viaje actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('viajes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancelar($id)
{
    // Buscar el viaje por ID
    $viaje = Viaje::findOrFail($id);

    // Verificar si el viaje ya no está finalizado
    if ($viaje->estado === 'Finalizado') {
        Alert::error('¡Error!', 'No se puede cancelar un viaje que ya finalizó')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->back()->with('error', 'No se puede cancelar un viaje que ya ha finalizado.');
    }else if($viaje->estado === 'Cancelado'){
        Alert::error('¡Error!', 'No se puede cancelar un viaje que ya fue cancelado con anterioridad')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->back()->with('error', 'No se puede cancelar un viaje que ya ha finalizado.');
    }

    // Cambiar el estado a "Cancelado"
    $viaje->estado = 'Cancelado';
    $viaje->save();

    // Redirigir con un mensaje de éxito
    Alert::success('¡Éxito!', 'Viaje cancelado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

    return redirect()->back()->with('success', 'El viaje ha sido cancelado exitosamente.');
}

}
