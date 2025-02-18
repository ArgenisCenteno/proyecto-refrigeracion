<!-- ======= Header ======= -->
<style>
  .notifications {
    max-height: 300px;  /* Ajusta la altura máxima del dropdown */
    overflow-y: auto;   /* Activa el scroll vertical si el contenido es más grande que el contenedor */
    width: 400px;       /* Ajusta el ancho del dropdown si es necesario */
}
</style>
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="{{route('home')}}" class="logo d-flex align-items-center">

      <span class="d-none d-lg-block">FRIONAX</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->



  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle " href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- End Search Icon-->

      <li class="nav-item dropdown">
    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number">{{ Auth::user()->unreadNotifications->count() }}</span>
    </a>
    <!-- End Notification Icon -->

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
        <li class="dropdown-header">
            Usted tiene {{ Auth::user()->unreadNotifications->count() }} notificaciones
            <a href="{{ route('notificaciones.index') }}">
                <span class="badge rounded-pill bg-primary p-2 ms-2">Ver todas</span>
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>

        <!-- Aquí mostramos las notificaciones -->
        @foreach(Auth::user()->unreadNotifications as $notificacion)
            <li class="notification-item">
                <a href="{{ $notificacion->data['url'] }}">
                    <i class="bi bi-info-circle"></i> <!-- Icono de la notificación -->
                    <span>{{ $notificacion->data['message'] ?? 'Notificación' }}</span> <!-- Mensaje de la notificación -->
                    <small class="text-muted">{{ $notificacion->created_at->diffForHumans() }}</small>
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
        @endforeach

        <li class="dropdown-footer">
            <a href="{{ route('notificaciones.index') }}">Show all notifications</a>
        </li>
    </ul>
    <!-- End Notification Dropdown Items -->
</li>

      <!-- End Notification Nav -->



      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

          <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->name}}</span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{Auth::user()->name}}</h6>
            <span>{{Auth::user()->role}}</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
              <i class="bi bi-person"></i>
              <span>Mi perfil</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>


          <li>
            <hr class="dropdown-divider">
          </li>


          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Salir
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>


        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
@include('layout.script')
