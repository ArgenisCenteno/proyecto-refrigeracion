@extends('layouts.app')
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
<style>
  .hero {
    width: 100%;
    min-height: 100vh;
    position: relative;
    padding: 120px 0 60px 0;
    display: flex;
    align-items: center;
  }

  .hero h1 {
    margin: 0;
    font-size: 48px;
    font-weight: 700;
    line-height: 56px;
  }

  .hero p {
    color: color-mix(in srgb, var(--default-color), transparent 30%);
    margin: 5px 0 30px 0;
    font-size: 22px;
    line-height: 1.3;
    font-weight: 600;
  }

  .hero .btn-get-started {
    color: var(--contrast-color);
    background: var(--accent-color);
    font-family: var(--heading-font);
    font-weight: 500;
    font-size: 15px;
    letter-spacing: 1px;
    display: inline-block;
    padding: 10px 28px 12px 28px;
    border-radius: 50px;
    transition: 0.5s;
  }






  .hero .animated {
    animation: up-down 2s ease-in-out infinite alternate-reverse both;
  }

  @media (max-width: 640px) {
    .hero h1 {
      font-size: 28px;
      line-height: 36px;
    }

    .hero p {
      font-size: 18px;
      line-height: 24px;
      margin-bottom: 30px;
    }


  }

  @keyframes up-down {
    0% {
      transform: translateY(10px);
    }

    100% {
      transform: translateY(-10px);
    }
  }


  /*--------------------------------------------------------------
# Services Section
--------------------------------------------------------------*/
  .services .service-item {
    background-color: var(--surface-color);
    box-shadow: 0px 5px 90px 0px rgba(0, 0, 0, 0.1);
    padding: 50px 30px;
    transition: all ease-in-out 0.4s;
    height: 100%;
  }

  .services .service-item .icon {
    margin-bottom: 10px;
  }

  .services .service-item .icon i {
    color: var(--accent-color);
    font-size: 36px;
    transition: 0.3s;
  }

  .services .service-item h4 {
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 20px;
  }

  .services .service-item h4 a {
    color: var(--heading-color);
    transition: ease-in-out 0.3s;
  }

  .services .service-item p {
    line-height: 24px;
    font-size: 14px;
    margin-bottom: 0;
  }

  .services .service-item:hover {
    transform: translateY(-10px);
  }

  .services .service-item:hover h4 a {
    color: var(--accent-color);
  }

  /*--------------------------------------------------------------
# producto Section
--------------------------------------------------------------*/
  .producto .producto-filters {
    padding: 0;
    margin: 0 auto 20px auto;
    list-style: none;
    text-align: center;
  }

  .producto .producto-filters li {
    cursor: pointer;
    display: inline-block;
    padding: 8px 20px 10px 20px;
    margin: 0;
    font-size: 15px;
    font-weight: 500;
    line-height: 1;
    margin-bottom: 5px;
    border-radius: 50px;
    transition: all 0.3s ease-in-out;
    font-family: var(--heading-font);
  }

  .producto .producto-filters li:hover,
  .producto .producto-filters li.filter-active {
    color: var(--contrast-color);
    background-color: var(--accent-color);
  }

  .producto .producto-filters li:first-child {
    margin-left: 0;
  }

  .producto .producto-filters li:last-child {
    margin-right: 0;
  }

  @media (max-width: 575px) {
    .producto .producto-filters li {
      font-size: 14px;
      margin: 0 0 10px 0;
    }
  }

  .producto .producto-item {
    position: relative;
    overflow: hidden;
  }

  .producto .producto-item .producto-info {
    opacity: 0;
    position: absolute;
    left: 12px;
    right: 12px;
    bottom: -100%;
    z-index: 3;
    transition: all ease-in-out 0.5s;
    background: color-mix(in srgb, var(--background-color), transparent 10%);
    padding: 15px;
  }

  .producto .producto-item .producto-info h4 {
    font-size: 18px;
    font-weight: 600;
    padding-right: 50px;
    color: teal;
  }

  .producto .producto-item .producto-info p {
    color: color-mix(in srgb, var(--default-color), transparent 30%);
    font-size: 14px;
    margin-bottom: 0;
    padding-right: 50px;
    color: teal;
  }

  .producto .producto-item .producto-info .preview-link,
  .producto .producto-item .producto-info .details-link {
    position: absolute;
    right: 50px;
    font-size: 24px;
    top: calc(50% - 14px);
    color: color-mix(in srgb, var(--default-color), transparent 30%);
    transition: 0.3s;
    line-height: 0;
  }

  .producto .producto-item .producto-info .preview-link:hover,
  .producto .producto-item .producto-info .details-link:hover {
    color: var(--accent-color);
  }

  .producto .producto-item .producto-info .details-link {
    right: 14px;
    font-size: 28px;
  }

  .producto .producto-item:hover .producto-info {
    opacity: 1;
    bottom: 0;
  }

  #hero {
    position: relative;
    overflow: hidden; /* Evita que la imagen se desborde */
  }
  .hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1; /* Coloca la imagen detrás del contenido */
  }
  .hero-bg img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ajusta la imagen al contenedor */
    opacity: 0.4; /* Aplica la opacidad */
  }
  .row {
    position: relative; /* Asegura que el contenido esté por encima de la imagen */
    z-index: 2; /* Coloca el contenido encima de la imagen */
  }
</style>
@section('content')

<section id="hero" style="display: flex; align-items: center; justify-content: center;  color: white; padding: 50px 20px;">
  <div style="max-width: 1200px; display: flex; flex-wrap: wrap; align-items: center; gap: 20px;">
    <!-- Imagen -->
    <div style="flex: 1; text-align: center;">
      <img src="{{asset('imagenes/banner.jpg')}}" alt="banner" 
           style="max-width: 100%; height: auto; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); border-radius: 10px;">
    </div>
    <!-- Texto -->
    <div style="flex: 1; padding: 20px;">
      <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 20px;" class="text-black">¡Siempre a la orden!</h1>
      <p style="font-size: 1.2rem; line-height: 1.6; margin-bottom: 30px;" class="text-black" >Más de 20 años atendiendo al público y ofreciendo productos de calidad a precios asequibles.</p>
      <a href="#productos" 
         style="display: inline-block; padding: 12px 30px; background:rgb(0, 0, 0); color:rgb(255, 255, 255); font-weight: bold; border-radius: 5px; text-decoration: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);">
        Ver Productos
      </a>
    </div>
  </div>
</section>


<!-- Services Section -->
<section id="services" class="services section light-background mt-4 mb-4">
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Servicios</h2>
    <p>REFRI RESPUESTOS FRIONAX VIP 2019 C.A, somos una empresa de venta de productos de refrigeración. Contamos con más de 20 años de experiencia en el rubro, ofreciendo productos de calidad y el mejor servicio posible a nuestros consumidores.</p>
  </div><!-- End Section Title -->

  <div class="container">
    <div class="row gy-4">
      <!-- Service Item 1 -->
      <div class="col-lg-6 col-md-12 d-flex" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item position-relative text-center w-100">
          <div class="icon mb-3">
            <img src="{{ asset('imagenes/1.jpg') }}" alt="Instalación de Sistemas" style="width: 150px; height: 150px;">
          </div>
          <h4><a href="" class="stretched-link">Instalación de Sistemas</a></h4>
          <p>¡Tu hogar siempre fresco! Expertos en instalación de sistemas de refrigeración. ¡Cotiza ahora y disfruta de un ambiente climatizado!</p>
        </div>
      </div><!-- End Service Item -->

      <!-- Service Item 2 -->
      <div class="col-lg-6 col-md-12 d-flex" data-aos="fade-up" data-aos-delay="200">
        <div class="service-item position-relative text-center w-100">
          <div class="icon mb-3">
            <img src="{{ asset('imagenes/2.jpg') }}" alt="Mantenimiento Preventivo" style="width: 150px; height: 150px;">
          </div>
          <h4><a href="" class="stretched-link">Mantenimiento Preventivo</a></h4>
          <p>¡Respira tranquilo con nuestro mantenimiento preventivo! Ahorra energía, reduce ruidos molestos y disfruta de un ambiente fresco siempre. ¡Llámanos!</p>
        </div>
      </div><!-- End Service Item -->

      <!-- Service Item 3 -->
      <div class="col-lg-6 col-md-12 d-flex" data-aos="fade-up" data-aos-delay="300">
        <div class="service-item position-relative text-center w-100">
          <div class="icon mb-3">
            <img src="{{ asset('imagenes/3.jpg') }}" alt="Diagnóstico y Reparación" style="width: 150px; height: 150px;">
          </div>
          <h4><a href="" class="stretched-link">Diagnóstico y Reparación</a></h4>
          <p>¡Tu equipo de refrigeración en las mejores manos! Diagnóstico preciso y reparaciones eficientes. ¡Contáctanos!</p>
        </div>
      </div><!-- End Service Item -->

      <!-- Service Item 4 -->
      <div class="col-lg-6 col-md-12 d-flex" data-aos="fade-up" data-aos-delay="400">
        <div class="service-item position-relative text-center w-100">
          <div class="icon mb-3">
            <img src="{{ asset('imagenes/4.jpg') }}" alt="Optimización Energética" style="width: 150px; height: 150px;">
          </div>
          <h4><a href="" class="stretched-link">Optimización Energética</a></h4>
          <p>¡Ahorra energía y cuida el medio ambiente! Optimizamos tu sistema de refrigeración para un mayor rendimiento y menor consumo. ¡Contáctanos!</p>
        </div>
      </div><!-- End Service Item -->
    </div>
  </div>
</section><!-- /Services Section -->


<!-- producto Section -->
<section id="productos" class="producto section m-4">

  <!-- Section Title -->
  <div class="container section-title mt-4" data-aos="fade-up">
    <h2>Productos</h2>
    <p>¡Aprovecha nuestras ofertas!</p>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="isotope-layout" data-layout="masonry" data-sort="original-order">



      <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
        @foreach ($productos as $producto) <!-- Itera sobre los productos -->
      <div class="col-lg-4 col-md-6 producto-item isotope-item filter-app">
        <img src="{{ $producto->imagenes->first()->url }}" class="img-fluid" alt="">
        <div class="producto-info">
        <h4>{{ $producto->nombre }}</h4>
        <p>{{ $producto->descripcion }}</p>
        <a href="{{ route('detalles', $producto->slug) }}" title="More Details" class="details-link"><i
          class="bi bi-link-45deg"></i></a>
        </div>
      </div><!-- End producto Item -->
    @endforeach


      </div><!-- End producto Container -->

    </div>

  </div>

</section><!-- /producto Section -->






<!-- Footer -->

<!-- Footer -->

@endsection