@extends('layouts.app')

@section('content')
<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
    <div class="col-md-8 col-lg-7 col-xl-6 d-none d-md-block">
        <img src="{{ asset('iconos/draw2.svg') }}" class="img-fluid" alt="Reset Password">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5">
        <div class="card shadow-lg">
          <div class="card-header text-center">
            <h4>{{ __('Restablecer Contraseña') }}</h4>
          </div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
              @csrf

              <!-- Email input -->
              <div class="mb-3">
                <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <!-- Submit button -->
              <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">
                  {{ __('Enviar enlace de recuperación') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Imagen a la derecha -->
     
    </div>
  </div>
</section>
@endsection
