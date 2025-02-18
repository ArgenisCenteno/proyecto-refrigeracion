<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <title>{{ config('app.name', 'FRIONAX') }}</title>

    <!-- Fonts -->
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

        body {
            font-family: "Roboto" !important;
        }

        .navbar-nav .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
            /* Alinea el submenú con el menú principal */
            transition: 0.3s ease-in-out;
        }
 
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        @include('layout.head')
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a href="{{ url('/') }}"> <strong class="navbar-brand text-white">FRIONAX</strong></a>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#services">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Ubicaciones</a>
                        </li>

                        <div class="nav-item">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#searchModal">
                                <i class="material-icons">search</i>
                            </button>
                        </div>

                    </ul>
                    <div class="d-flex align-items-center">
                        <a class="text-reset me-3" href="#">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        <a href="{{ route('carrito.show') }}" class="text-white me-3">
                            Carrito
                        </a>
                        @auth
                            <a href="{{ route('home') }}" class="nav-link text-white me-3">
                                Mi perfil
                            </a>
                            <a href="{{ route('logout') }}" class="nav-link text-white "
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Salir
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-white">Ingresar</a>
                        @endauth


                    </div>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @foreach($categorias as $categoria)
                            <li class="nav-item dropdown">
                                <!-- Enlace principal de la categoría -->
                                <a class="nav-link dropdown-toggle"
                                    href="{{ route('productosPorCategoria', $categoria->id) }}"
                                    id="dropdown{{ $categoria->id }}" role="button" aria-expanded="false">
                                    {{ $categoria->nombre }}
                                </a>
                                <!-- Subcategorías desplegables -->
                                <ul class="dropdown-menu" aria-labelledby="dropdown{{ $categoria->id }}">
                                    @foreach($categoria->subCategorias as $subCategoria)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('productosPorSubcategoria', $subCategoria->id) }}">
                                                {{ $subCategoria->nombre }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar -->

        <main class="">
            @yield('content')
        </main>
    </div>
    <!-- Modal de búsqueda -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('buscar')}}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">Buscar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" name="query" id="searchProduct"
                            placeholder="Escriba el nombre del producto">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <footer id="footer" class="footer bg-light py-4">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <a href="index.html" class="d-flex align-items-center text-decoration-none">
                    <span class="h4 fw-bold">FRIONAX</span>
                </a>
                <div class="pt-3">
                    <p class="mb-1">Calle Andres Bello</p>
                    <p class="mb-1">Punta de Mata</p>
                    <p class="mb-1"><strong>Teléfono:</strong> 04148079255</p>
                    <p><strong>Email:</strong> atencionalcliente@frionax.com</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3">
                <h5>Principal</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-dark">Home</a></li>
                    <li><a href="#" class="text-dark">About</a></li>
                    <li><a href="#" class="text-dark">Servicios</a></li>
                    <li><a href="#" class="text-dark">Términos y Condiciones</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3">
                <h5>Nuestros servicios</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-dark">Repuestos</a></li>
                    <li><a href="#" class="text-dark">Mantenimiento</a></li>
                    <li><a href="#" class="text-dark">Refrigeración</a></li>
                    <li><a href="#" class="text-dark">Electricidad</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h5>¡Síguenos en nuestras redes!</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="text-dark"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-dark"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-dark"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-dark"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="mb-0">© Copyright <strong>Frionax</strong> All Rights Reserved</p>
        </div>
    </div>
</footer>

</body>
@yield('js')
@include('layout.script')
@include('sweetalert::alert')
@include('layout.datatables_css')
@include('layout.datatables_js')
<script>
    function buscarProducto() {
        const producto = document.getElementById('searchProduct').value;
        if (producto) {
            // Aquí iría la lógica para buscar el producto (puede ser una solicitud AJAX).
            alert('Buscando el producto: ' + producto);
        } else {
            alert('Por favor, ingrese un nombre de producto.');
        }
    }
</script>

</html>