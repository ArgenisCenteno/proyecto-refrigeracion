@extends('layout.app')
@section('content')
<main id="main"  class="main"> <!--begin::App Content Header-->
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class=" border-0 my-5">
                    <div class="px-2 row">
                        <div class="col-lg-12">
                            @include('flash::message')
                        </div>
                        <div class="col-md-6 col-6">
                            <h3 class="p-2 bold">Productos</h3>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                                <a href="{{route('productos.create')}}" class="btn btn-primary  round mx-1" >Registrar </a>
                                <a href="{{route('productoss.export')}}" class="btn btn-success">Inventario</a>
                            </div>

                    </div>
                    <div >
                  
                        @include('productos.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection
