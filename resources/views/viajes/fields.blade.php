<form action="{{ route('viajes.store') }}" method="POST">
    @csrf
    <div>
        <!-- Selectores para servicios y sectores -->
        <div style="margin-bottom: 10px;">
            <label for="servicio">Selecciona un servicio:</label>
            <select id="servicio" name="servicio" class="form-control" required>
                <option value="">Seleccione un servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}">{{ $servicio->descripcion }}</option>
                @endforeach
            </select>

            <label for="sector">Selecciona un sector:</label>
            <select id="sector" name="sector" class="form-control">
                <option value="">Seleccione un sector</option>
                @foreach($sectores as $sector)
                    <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                @endforeach
            </select>
        </div>

        <label for="">Seleccione su destino en el mapa</label>

        <!-- Contenedor del mapa -->
        <div id="map" style="height: 600px;"></div>

        <!-- Inputs ocultos para almacenar la ubicación del origen, destino, distancia y tiempo -->
        <input type="hidden" id="origen_lat" name="origen_lat">
        <input type="hidden" id="origen_lon" name="origen_lon">
        <input type="hidden" id="destino_lat" name="destino_lat">
        <input type="hidden" id="destino_lon" name="destino_lon">
        <input type="hidden" id="distancia" name="distancia">
        <input type="hidden" id="tiempo" name="tiempo">
        <input type="hidden" id="direccion_destino" name="direccion_destino">


        <button class="btn btn-primary mt-4" type="submit">Aceptar</button>
    </div>
</form>


<!-- Incluir los estilos de Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Incluir el script de Leaflet -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Incluir los estilos y scripts de Leaflet Routing Machine -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
    function obtenerNombreZona(lat, lon) {
        var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data && data.address) {
                    var direccion = data.display_name || 'Dirección no disponible';
                    document.getElementById('direccion_destino').value = direccion;
                } else {
                    document.getElementById('direccion_destino').value = 'Dirección no disponible';
                }
            })
            .catch(error => {
                console.error('Error al obtener el nombre de la zona:', error);
                document.getElementById('direccion_destino').value = 'Dirección no disponible';
            });
    }

    document.addEventListener('DOMContentLoaded', function () {


        // Inicializa el mapa y establece las coordenadas iniciales
        var map = L.map('map').setView([10.5000, -66.9167], 13); // Coordenadas iniciales (ejemplo de Caracas)

        // Agregar el mapa base de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Variable para almacenar el marcador del destino
        var destinationMarker = null;


        // Obtiene la ubicación actual del usuario
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;

                // Establece los valores del origen en los campos ocultos
                document.getElementById('origen_lat').value = lat;
                document.getElementById('origen_lon').value = lon;

                var userLocation = L.marker([lat, lon]).addTo(map);
                userLocation.bindPopup('Tu ubicación actual').openPopup();
                map.setView([lat, lon], 13);

                // Permite al usuario seleccionar el destino
                map.on('click', function (e) {
                    var destLat = e.latlng.lat;
                    var destLon = e.latlng.lng;

                    // Si ya existe un marcador de destino, remuévelo
                    if (destinationMarker) {
                        map.removeLayer(destinationMarker);
                    }

                    // Agregar un nuevo marcador en el destino
                    destinationMarker = L.marker([destLat, destLon]).addTo(map);
                    destinationMarker.bindPopup('Destino seleccionado').openPopup();
                    // Llamar a la función para obtener el nombre de la zona
                    obtenerNombreZona(destLat, destLon);
                    // Establecer los valores del destino en los campos ocultos
                    document.getElementById('destino_lat').value = destLat;
                    document.getElementById('destino_lon').value = destLon;

                    // Trazar la ruta entre la ubicación actual y el destino
                    calculateRoute(lat, lon, destLat, destLon);
                });

            }, function () {
                alert('No se pudo obtener la ubicación');
            });
        } else {
            alert('La geolocalización no está disponible en este navegador');
        }

        // Controlador de rutas
        var routeControl = null;

        // Función para calcular la ruta entre dos puntos
        function calculateRoute(userLat, userLon, destLat, destLon) {
            if (routeControl) {
                map.removeControl(routeControl); // Remover la ruta anterior
            }

            routeControl = L.Routing.control({
                waypoints: [
                    L.latLng(userLat, userLon),
                    L.latLng(destLat, destLon)
                ],
                routeWhileDragging: true
            }).on('routesfound', function (e) {
                var routes = e.routes;
                var summary = routes[0].summary;

                // Establecer la distancia y el tiempo en los campos ocultos
                document.getElementById('distancia').value = (summary.totalDistance / 1000).toFixed(2); // Convertir a kilómetros
                document.getElementById('tiempo').value = (summary.totalTime / 60).toFixed(2); // Convertir a minutos
            }).addTo(map);
        }
    });

</script>