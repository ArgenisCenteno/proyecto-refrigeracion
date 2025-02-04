@extends('layouts.app')

@section('content')

<section class="h-100 py-5 " style="margin-bottom: 200px;">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-5 m-2"
                style="box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">
                <div class="p-5">
                    <h3 class="fw-bold mb-5 mt-2 pt-1">Detalles de pago</h3>
                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-4">

                        <h5>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-between mb-1">
                        <h5 class="text-success">Tasa del dolar</h5>
                        <h5 class="text-success" id="dolar"> {{ number_format($dollar, 2) }} BS</h5>
                        <!-- Assuming standard shipping fee -->
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <h5 class="text-uppercase">Monto Total</h5>
                        <h5 id="subtotal"> {{ number_format($total, 2) }} USD</h5>
                        <!-- Assuming standard shipping fee -->
                    </div>
                    <div class="d-flex justify-content-between mb-5">
                        <h5 class="text-uppercase">Monto BS</h5>
                        <h5 id="monto-bs"> {{ number_format($total * $dollar, 2) }} BS</h5>
                        <!-- Assuming standard shipping fee -->
                    </div>
                    <a href="{{ route('pagar') }}" class="btn btn-dark btn-block btn-lg" style=" width: 100%">
                        Realizar pago
                    </a>
                </div>
            </div>
            <div class="col-lg-6 mb-4">


                @if (session('cart') && count(session('cart')) > 0)
                    <section class="h-100 h-custom">
                        <div class="container  h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-12">
                                    <div class="card card-registration card-registration-2"
                                        style="box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">
                                        <div class="card-body p-0">
                                            <div class="p-5">
                                                <div class="d-flex justify-content-between align-items-center mb-5">
                                                    <h1 class="fw-bold mb-0">Mi Carrito</h1>
                                                    <h6 class="mb-0 text-muted">{{ count(session('cart')) }} items</h6>
                                                </div>
                                                <hr class="my-4">

                                                @foreach (session('cart') as $key => $item)
                                                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                                            <img src="{{ $item['imagen'] }}" class="img-fluid rounded-3"
                                                                alt="{{ $item['nombre'] }}">
                                                        </div>
                                                        <div class="col-md-2 col-lg-3 col-xl-3">
                                                            <h6 class="text-muted">{{ $item['nombre'] }}</h6>
                                                            <h6 class="mb-0">{{ $item['nombre'] }}</h6>
                                                        </div>
                                                        <div class="col-md-4 col-lg-3 col-xl-2 d-flex">
                                                            <button type="button" class="btn btn-link px-2"
                                                                onclick="changeQuantity({{ $key }}, -1, '{{ addslashes($item['nombre']) }}', {{ $item['precio'] }});">
                                                                <i class="fas fa-minus">
                                                                    <h3>-</h3>
                                                                </i>
                                                            </button>

                                                            <input id="quantity-{{ $key }}" min="1" name="quantity"
                                                                value="{{ $item['cantidad'] }}" type="number"
                                                                class="form-control form-control-lg me-2" style="width: 80px;"
                                                                readonly data-price="{{ $item['precio'] }}" />


                                                            <button type="button" class="btn btn-link px-2"
                                                                onclick="changeQuantity({{ $key }}, 1, '{{ addslashes($item['nombre']) }}', {{ $item['precio'] }});">
                                                                <i class="fas fa-plus">
                                                                    <h3>+</h3>
                                                                </i>
                                                            </button>
                                                            <!-- Spinner -->


                                                        </div>
                                                        <div class="col-md-2 col-lg-2 col-xl-2 offset-lg-1">
                                                            <h6 class="mb-0">{{ number_format($item['precio'], 2) }}
                                                                <small>Bs</small>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                            <a href="#!" class="text-muted"
                                                                onclick="removeFromCart({{ $key }});"><i
                                                                    class="fas fa-times"></i></a>
                                                        </div>
                                                        
                                                        
                                                    </div>

                                                    <hr class="my-4">
                                                   
                                                @endforeach

                                                <div class="pt-5">
                                                <div id="spinner"
                                                            style="display: none; text-align: center; margin-top: 20px;">
                                                            <div class="spinner-border text-primary" role="status">
                                                                <span class="visually-hidden">Cargando...</span>
                                                            </div>
                                                        </div>
                                                    <h6 class="mb-0"><a href="#!" class="text-body"><i
                                                                class="fas fa-long-arrow-alt-left me-2"></i>Seguir
                                                            comprando</a>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <div style="display: flex; justify-content: center; align-items: center">
                        <img src="{{asset('imagenes/noproduct.jpg')}}" alt="Sin datos">
                    </div>
                @endif


            </div>



        </div>
    </div>
</section>

@endsection
@include('layout.script')
<script src="{{asset('js/sweetalert2.js')}}"></script>
<script>

    function updateSubtotal(index, price) {
        // Obtener cantidad
        var quantity = document.getElementById('quantity-' + index).value;

        // Calcular el nuevo subtotal del producto
        var subtotalProduct = quantity * price;

        // Actualizar el subtotal del producto (opcional si deseas mostrar por producto)
        console.log("Subtotal del producto:", subtotalProduct);

        // Recalcular el monto total general en dólares
        let totalUSD = 0;
        document.querySelectorAll('input[name="quantity"]').forEach((input, i) => {
            const productPrice = parseFloat(input.dataset.price); // Asume que agregas un atributo data-price con el precio del producto
            totalUSD += productPrice * parseInt(input.value);
        });

        // Actualizar el monto total en dólares
        const totalUSDElement = document.getElementById('subtotal');
        totalUSDElement.innerText = totalUSD.toFixed(2) + ' USD';

        // Calcular y actualizar el monto en bolívares
        const dollarRate = {{ $dollar }}; // Asegúrate de que $dollar esté disponible en tu plantilla Blade
        const totalBSElement = document.querySelector('#monto-bs'); // Cambia el selector al ID que uses para mostrar el monto en Bs
        totalBSElement.innerText = (totalUSD * dollarRate).toFixed(2) + ' BS';
    }

    function changeQuantity(index, change, product, price) {
        // Obtener el input de cantidad
        var quantityInput = document.getElementById('quantity-' + index);

        // Calcular la nueva cantidad
        var newQuantity = parseInt(quantityInput.value) + change;

        // Asegurarse de que la cantidad no sea menor a 1
        if (newQuantity < 1) {
            newQuantity = 1;
        }

        // Actualizar el valor del input
        quantityInput.value = newQuantity;

        // Llamar a la función para actualizar el subtotal y total
        updateSubtotal(index, price);

        // Mostrar el spinner
        document.getElementById('spinner').style.display = 'block';

        fetch('{{ route("carrito.actualizar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product: product,
                cantidad: newQuantity
            })
        })
            .then(response => response.json())
            .then(data => {
                // Ocultar el spinner una vez que se haya recibido la respuesta
                document.getElementById('spinner').style.display = 'none';

                if (data.success) {
                    // Puedes agregar cualquier acción adicional en caso de éxito si es necesario
                } else {
                    // Mostrar un SweetAlert con el mensaje de error
                    quantityInput.value = newQuantity - 1;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        confirmButtonColor: '#d33'
                    });
                }
            })
            .catch(error => {
                // Ocultar el spinner en caso de error inesperado
                document.getElementById('spinner').style.display = 'none';

                console.error('Error:', error);

                // Mostrar un SweetAlert en caso de error inesperado
                Swal.fire({
                    icon: 'error',
                    title: 'Error inesperado',
                    text: 'Algo salió mal. Por favor, intenta de nuevo más tarde.',
                    confirmButtonColor: '#d33'
                });
            });
    }


</script>