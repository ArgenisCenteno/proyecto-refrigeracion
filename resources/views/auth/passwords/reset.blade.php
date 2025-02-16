@extends('layouts.app')

@section('content')
<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
         <!-- Imagen a la derecha -->
      <div class="col-md-8 col-lg-7 col-xl-6 d-none d-md-block">
        <img src="{{ asset('iconos/draw2.svg') }}" class="img-fluid" alt="Reset Password">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5">
        <div class="card shadow-lg">
          <div class="card-header text-center">
            <h4>{{ __('Restablecer Contraseña') }}</h4>
          </div>

          <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
              @csrf
              <input type="hidden" name="token" value="{{ $token }}">

              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <!-- Nueva Contraseña -->
              <div class="mb-3">
                <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <!-- Confirmar Contraseña -->
              <div class="mb-3">
                <label for="password-confirm" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
              </div>

              <!-- Botón -->
              <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">
                  {{ __('Restablecer Contraseña') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

     
    </div>
  </div>
</section>
@endsection
