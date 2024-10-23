@extends('layout.app')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Bienvenido</h1>
</div><!-- End Page Title -->
<section>
    <div class="row">

        <!-- Tramites Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Trámites</h5>
                        <p class="h2">{{ $totalTramites }}</p> <!-- Cambié 'display-4' por 'h2' -->
                    </div>
                    <i class="fas fa-file-alt fa-2x"></i> <!-- Cambié 'fa-3x' por 'fa-2x' -->
                </div>
            </div>
        </div>

        <!-- Pasajeros Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Pasajeros</h5>
                        <p class="h2">{{ $totalPasajeros }}</p> <!-- Cambié 'display-4' por 'h2' -->
                    </div>
                    <i class="fas fa-users fa-2x"></i> <!-- Cambié 'fa-3x' por 'fa-2x' -->
                </div>
            </div>
        </div>

        <!-- Conductores Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Conductores</h5>
                        <p class="h2">{{ $totalConductores }}</p> <!-- Cambié 'display-4' por 'h2' -->
                    </div>
                    <i class="fas fa-car fa-2x"></i> <!-- Cambié 'fa-3x' por 'fa-2x' -->
                </div>
            </div>
        </div>

        <!-- Vehículos Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Vehículos</h5>
                        <p class="h2">{{ $totalVehiculos }}</p> <!-- Cambié 'display-4' por 'h2' -->
                    </div>
                    <i class="fas fa-truck fa-2x"></i> <!-- Cambié 'fa-3x' por 'fa-2x' -->
                </div>
            </div>
        </div>

        <!-- Conductores Registrados Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Conductores Registrados</h5>
                        <p class="h2">{{ $totalConductoresRegistrados }}</p> <!-- Cambié 'display-4' por 'h2' -->
                    </div>
                    <i class="fas fa-user-check fa-2x"></i> <!-- Cambié 'fa-3x' por 'fa-2x' -->
                </div>
            </div>
        </div>

        <!-- Servicios Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Servicios</h5>
                        <p class="h2">{{ $totalServicios }}</p> <!-- Cambié 'display-4' por 'h2' -->
                    </div>
                    <i class="fas fa-concierge-bell fa-2x"></i> <!-- Cambié 'fa-3x' por 'fa-2x' -->
                </div>
            </div>
        </div>

        <!-- Pagos Card -->
        
        <!-- Viajes Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-light text-dark h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Viajes</h5>
                        <p class="h2">{{ $totalViajes }}</p> <!-- Cambié 'display-4' por 'h2' -->
                    </div>
                    <i class="fas fa-route fa-2x"></i> <!-- Cambié 'fa-3x' por 'fa-2x' -->
                </div>
            </div>
        </div>

    </div>
</section>


</main><!-- End #main -->

<!--begin::Footer-->
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@endsection
