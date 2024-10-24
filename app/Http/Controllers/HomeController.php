<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Compra;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\RegistroConductor;
use App\Models\Servicio;
use App\Models\SubCategoria;
use App\Models\Tramite;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Venta;
use App\Models\Viaje;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
<<<<<<< HEAD
        
        $ventas = Venta::count();
        $compras = Compra::count();
        $usuarios = User::count();
        $productos = Producto::count();
        $categorias = Categoria::count();
        $subcategorias = SubCategoria::count();
        $proveedores = Proveedor::count();
        $pagos = Pago::count();
=======
     
        $totalTramites = Tramite::count();
        $totalPasajeros = User::whereHas('roles', function ($query) {
            $query->where('name', 'cliente');
        })->count();
    
        // Contar usuarios con rol 'conductor'
        $totalConductores = User::whereHas('roles', function ($query) {
            $query->where('name', 'conductor');
        })->count();
    
        $totalVehiculos = Vehicle::count();
        $totalConductoresRegistrados = RegistroConductor::where('estado', 'Aprobado')->count();
        $totalServicios = Servicio::count();
        $totalPagos = Pago::sum('monto');
        $totalViajes = Viaje::count();
        return view('home', compact('totalTramites', 'totalPasajeros', 'totalConductores', 'totalVehiculos', 'totalConductoresRegistrados', 'totalServicios', 'totalPagos', 'totalViajes'));
>>>>>>> af132ad71bd899e0ab6489eaccc4870aaa210ad7

    }
    
  
}
