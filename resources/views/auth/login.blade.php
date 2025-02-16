@extends('layouts.app')

@section('content')
<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="{{asset('iconos/draw2.svg')}}"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <h2 class="text-center m-2 p-3">Iniciar sesión</h2>
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <!-- Email input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form1Example13">Email</label>

            <input type="email" id="form1Example13" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus />
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form1Example23">Contraseña</label>

            <input type="password" id="form1Example23" placeholder="Ingrese contraseña" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required />
            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="d-flex justify-content-around align-items-center mb-4">
            <!-- Checkbox -->
            <div class="form-check">
              <input class="form-check-input" type="checkbox" placeholder="Contraseña" name="remember" id="form1Example3" {{ old('remember') ? 'checked' : '' }} />
              <label class="form-check-label" for="form1Example3">Recordar </label>
            </div>
            <a href="{{route('register')}}">¿No tienes cuenta?</a>
          </div>

          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-lg btn-block">Ingresar</button>

          

          
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
