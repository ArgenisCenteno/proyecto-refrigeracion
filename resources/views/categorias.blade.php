@extends('layouts.app')

@section('content')
<style>
         .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
        main {
    min-height: 100vh;  /* Asegura que el main ocupe al menos la altura de la pantalla */
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
<section class="h-100 py-5" style="margin-bottom: 40rem !important;">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            @foreach ($productos as $similar)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm p-3">
                        <img src="{{$similar->imagenes->first()->url}}" style="height: 400px; ;"
                            class="card-img-top" alt="...">
                        <div class="label-top shadow-sm">{{$similar->nombre}}</div>
                        <div class="card-body">
                            <div class="clearfix mb-3">
                                <span class="float-start badge rounded-pill bg-success">{{$similar->precio_venta}}</span>
                            </div>
                            <h5 class="card-title">{{$similar->descripcion}}</h5>
                            <div class="text-center my-4">
                              
                            </div>
                            <div class="clearfix mb-1">
                            <span class="float-end"><i class="fas fa-plus"></i></span>

                                <span class="float-start">  <a href="{{ route('detalles', $similar->slug) }}" class="btn btn-info">Detalles</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if(count($productos) == 0)
                <div style="display: flex; justify-content: center; align-items: center">
                    <img src="{{asset('imagenes/noproduct.jpg')}}" alt="Sin datos">
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
@include('layout.script')
<script src="{{asset('js/sweetalert2.js')}}"></script>