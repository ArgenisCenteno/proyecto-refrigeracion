<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Session;
use Alert;
class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function products(Request $request)
    {
        $categorias = SubCategoria::all();
        $query = Producto::query();

        // Apply filters
        if ($request->filled('subcategoria')) {
            // Make sure you are using the correct key here
            $query->where('sub_categoria_id', $request->subcategoria);
        }

        if ($request->filled('rango_precio')) {
            // Correctly retrieve the price range
            // dd($request->filled('rango_precio'));
            $priceRange = explode('-', $request->rango_precio); // Ensure this key matches your request
            $query->whereBetween('precio_venta', [$priceRange[0], $priceRange[1]]);
        }

        $productos = $query->paginate(12);

        return view('productos')->with('categorias', $categorias)->with('productos', $productos);
    }

    public function detalles($id)
    {

        $producto = Producto::where('slug', $id)->first();
        $similares = Producto::where('sub_categoria_id', $producto->sub_categoria_id)
            ->where('id', '!=', $producto->id)
            ->take(4)->get();

        // dd($similares);

        function isConnected()
        {
            $connected = @fsockopen("www.google.com", 80); // Intenta conectar al puerto 80 de Google
            if ($connected) {
                fclose($connected);
                return true; // Hay conexión
            }
            return false; // No hay conexión
        }

        if (isConnected()) {
            $response = file_get_contents("https://ve.dolarapi.com/v1/dolares/oficial");
          
        } else {
             
            $response = false;
        }
 


        // dd();
        if ($response) {
            $dato = json_decode($response);
            $dollar = $dato->promedio;
        } else {
            $dollar =  54.60;
        }

        return view('detalles')->with('dollar', $dollar)->with('producto', $producto)->with('similares', $similares);
    }

    public function productosPorCategoria($categoriaId)
    {
        // Encuentra la categoría
        $categoria = Categoria::findOrFail($categoriaId);

        // Obtiene todos los productos de las subcategorías relacionadas
        $productos = Producto::whereHas('subcategoria', function ($query) use ($categoria) {
            $query->where('categoria_id', $categoria->id);
        })->get();

        return view('categorias', compact('productos'));
    }

    public function agregarCarrito(Request $request, $id)
    {
        // Retrieve the product based on ID
        $producto = Producto::find($id);
    
        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }
    
        // Check if product quantity is available
        if ($producto->cantidad < 1) {
            return redirect()->back()->with('error', 'Producto agotado');
        }
    
        // Create a cart item
        $cartItem = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'cantidad' => 1,
            'precio' => $producto->precio_venta,
            'imagen' => asset($producto->imagenes[0]->url) // Use the first image
        ];
    
        // Get existing cart from session
        $cart = Session::get('cart', []);
    
        // Check if product already exists in the cart
        foreach ($cart as $key => $item) {
            if ($item['id'] === $producto->id) {
                // Check if adding one more exceeds the available stock
                if ($item['cantidad'] + 1 > $producto->cantidad) {
                    return redirect()->back()->with('error', 'No hay suficiente stock disponible');
                }
    
                // Update quantity
                $cart[$key]['cantidad'] += 1;
                session()->put('cart', $cart);
                Alert::success('Éxito!', 'Cantidad incrementada')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                return redirect()->back();
            }
        }
    
        // Add product to the cart
        if ($cartItem['cantidad'] <= $producto->cantidad) {
            $cart[] = $cartItem;
        } else {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible');
        }
    
        // Save the cart back to session
        Session::put('cart', $cart);
        Alert::success('Éxito!', 'Producto agregado al carrito')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->back();
    }
    
    public function actualizarCarrito(Request $request)
    {
        // Get the cart from the session
        $carrito = session()->get('cart');
    
        // Check if the cart exists
        if ($carrito) {
            // Find the product by name
            foreach ($carrito as $key => $item) {
                if ($item['nombre'] === $request->product) {
                    // Retrieve the product from the database
                    $producto = Producto::find($item['id']);
                    
                    if (!$producto) {
                        return response()->json(['success' => false, 'message' => 'Producto no encontrado en base de datos.']);
                    }
    
                    // Check if the requested quantity exceeds available stock
                    if ($request->cantidad > $producto->cantidad) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cantidad solicitada excede el stock disponible.',
                        ]);
                    }
    
                    // Update quantity in the cart
                    $carrito[$key]['cantidad'] = $request->cantidad;
                    session()->put('cart', $carrito);
    
                    return response()->json([
                        'success' => true,
                        'message' => 'Carrito actualizado.',
                    ]);
                }
            }
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Item no encontrado en carrito',
        ]);
    }
    

    public function checkout(Request $request)
    {
        $carrito = session()->get('cart');

        if (!$carrito) {
            Alert::error('¡Error!', 'Carrito vacío')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        }

        $total = 0;
        $impuesto = 0;
        $montoTotal = 0;

        if (count($carrito) > 0) {
            foreach ($carrito as $c) {
                $total += $c['precio'] * $c['cantidad'];

                $consulta = Producto::find($c['id']);
                //dd($consulta);
                if ($consulta->aplica_iva === 1) {
                    $impuesto += $c['precio'] * $c['cantidad'] * 0.16;
                }

            }
        }

        $montoTotal = $impuesto + $total;

        return view('pagar', compact('carrito', 'total', 'montoTotal', 'impuesto'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $cart = Session::get('cart', []);
        function isConnected()
        {
            $connected = @fsockopen("www.google.com", 80); // Intenta conectar al puerto 80 de Google
            if ($connected) {
                fclose($connected);
                return true; // Hay conexión
            }
            return false; // No hay conexión
        }

        if (isConnected()) {
            $response = file_get_contents("https://ve.dolarapi.com/v1/dolares/oficial");
          
        } else {
             
            $response = false;
        }
 


        // dd();
        if ($response) {
            $dato = json_decode($response);
            $dollar = $dato->promedio;
        } else {
            $dollar =  54.60;
        }

        $total = 0;

        if (count($cart) > 0) {
            foreach ($cart as $c) {
                $total += $c['precio'] * $c['cantidad'];
            }
        }


        return view('carrito', compact('cart', 'total', 'dollar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
