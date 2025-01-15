<?php

namespace App\Http\Controllers;

use App\Exports\EntregaExport;
use App\Models\Entrega;
use App\Models\Venta;
use App\Models\User;
use Illuminate\Http\Request;
use Alert;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class EntregaController extends Controller
{
    public function index()
    {
        $entregas = Entrega::with(['venta', 'empleado'])->get();
        return view('entregas.index', compact('entregas'));
    }

    public function create()
    {
        $ventas = Venta::where('estado_envio', 'Sin enviar')->get();
        $empleados = User::all();
        return view('entregas.create', compact('ventas', 'empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'empleado_id' => 'required|exists:users,id',
            'fecha_entrega' => 'required|date',
            'estado' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        Entrega::create($request->all());
        $venta = Venta::find($request->venta_id);
        $venta->estado_envio = $request->estado;
        $venta->save();
        Alert::success('Éxito!', 'Entrega Registrada correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('entregas.index')->with('success', 'Entrega creada correctamente.');
    }

    public function show(Entrega $entrega)
    {
        return view('entregas.show', compact('entrega'));
    }

    public function edit(Entrega $entrega)
    {
        $ventas = Venta::all();
        $empleados = User::all();
        return view('entregas.edit', compact('entrega', 'ventas', 'empleados'));
    }

    public function update(Request $request, Entrega $entrega)
    {
        
        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'empleado_id' => 'required|exists:users,id',
            'fecha_entrega' => 'required|date',
            'estado' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        $entrega->update($request->all());
        Alert::success('Éxito!', 'Entrega actualizada correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('entregas.index')->with('success', 'Entrega actualizada correctamente.');
    }

    public function destroy(Entrega $entrega)
    {
        $entrega->delete();
        Alert::success('Éxito!', 'Entrega Eliminada correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('entregas.index')->with('success', 'Entrega eliminada correctamente.');
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $type = $request->type;
    
        if ($type == 'EXCEL') {
            return Excel::download(new EntregaExport($startDate, $endDate), 'entregas.xlsx');
        } elseif ($type == 'PDF') {
            $ventas = Venta::with(['user', 'vendedor'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
    
            $pdf = \PDF::loadView('exports.ventas_pdf', compact('ventas'));
    
            // Abre el PDF en el navegador
            return $pdf->stream('ventas.pdf');
        }
    }

    public function pdf($id){
        $entrega = Entrega::find($id);

        $pdf = \App::make('dompdf.wrapper');
        $userArray = $entrega->venta->user->makeHidden(['password', 'remember_token'])->toArray();
        $qrCode = QrCode::size(120)->generate('http://127.0.0.1:8000/entregas/' . $id);
        $fechapago = $entrega->created_at->format('d-m-Y');
        $formaPagoArray = json_decode($entrega->venta->pago->forma_pago, true); 
        $pdf->loadView('entregas.pdf', compact('qrCode','entrega','userArray', 'fechapago', 'formaPagoArray'));
        return $pdf->stream('entrega.pdf');
    }
}
