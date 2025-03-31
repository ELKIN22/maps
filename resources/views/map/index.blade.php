<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" lang="en">

<head>
    <base href="../../">
    <title>
        Metronic - Tailwind CSS
    </title>
    <meta charset="utf-8" />
    <meta content="follow, index" name="robots" />
    <link href="https://keenthemes.com/metronic" rel="canonical" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="@keenthemes" name="twitter:site" />
    <meta content="@keenthemes" name="twitter:creator" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="Metronic - Tailwind CSS " name="twitter:title" />
    <meta content="" name="twitter:description" />
    <meta content="assets/media/app/og-image.png" name="twitter:image" />
    <meta content="https://keenthemes.com/metronic" property="og:url" />
    <meta content="en_US" property="og:locale" />
    <meta content="website" property="og:type" />
    <meta content="@keenthemes" property="og:site_name" />
    <meta content="Metronic - Tailwind CSS " property="og:title" />
    <meta content="" property="og:description" />
    <meta content="assets/media/app/og-image.png" property="og:image" />
    <link href="assets/media/app/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="assets/media/app/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png" />
    <link href="assets/media/app/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png" />
    <link href="assets/media/app/favicon.ico" rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="assets/vendors/apexcharts/apexcharts.css" rel="stylesheet" />
    <link href="assets/vendors/keenicons/styles.bundle.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #map { height: 100vh; width: 100%; }

        .place-icon {
            width: 40px; /* Tamaño total del círculo */
            height: 40px;
            border-radius: 50%; /* Hace que sea un círculo */
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            transform: translate(-50%, -50%);
            box-shadow: 0px 2px 5px rgba(0,0,0,0.3);
            border: 2px solid white;
        }

        .place-icon img {
            width: 25px; /* Tamaño del icono interno */
            height: 25px;
            border-radius: 50%;
        }

        /* Etiqueta de nombre del lugar */
        .place-label {
            position: absolute;
            background: white;
            color: #333;
            font-size: 14px;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 4px;
            white-space: nowrap;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
        }

        /* 🔹 Estilos Responsive */
        @media (max-width: 768px) {
            .place-label {
                font-size: 12px;
                padding: 2px 6px;
            }
            .place-icon {
                width: 35px;
                height: 35px;
            }
            .place-icon img {
                width: 22px;
                height: 22px;
            }
        }


    </style>
</head>

<body
    class="antialiased flex h-full text-base text-gray-700 [--tw-page-bg:#fefefe] [--tw-page-bg-dark:var(--tw-coal-500)] demo1 sidebar-fixed header-fixed bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]">

    <div id="map"></div>
    {{-- <div class="controls">
        <select id="searchBox">
            <option value="">Seleccione una zona...</option>
        </select>
        <button onclick="searchPlace()">Buscar</button>
        <button onclick="centerMap()">Centrar</button>
        <button onclick="startNavigation()">Iniciar Navegación</button>
    </div> --}}

    <button class="btn btn-icon btn-outline btn-success fixed bottom-28 right-4" data-modal-toggle="#modalBusqueda">
        <i class="ki-outline ki-magnifier"></i>
    </button>
     
    <button class="btn  btn-outline btn-primary fixed bottom-16 right-4">
        <i class="ki-filled ki-focus"></i> Centrar
    </button>

    <button class="btn  btn-outline btn-danger fixed bottom-4 right-4">
        <i class="ki-filled ki-cross-circle"></i> Salir
    </button>
  

    <div class="modal" data-modal="true" id="modalBusqueda">
        <div class="modal-content   max-w-[800px] top-[10%] max-h-[80%]">
            <div class="modal-header">
                <h3 class="modal-title">
                    Buscar Ubicaciónes
                </h3>
                <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                    <i class="ki-outline ki-cross">
                    </i>
                </button>
            </div>
            <div class="modal-body ">
                <div class="pt-2.5  mb-1">
                    <div class="input">
                        <i class="ki-outline ki-magnifier"></i>
                        <input id="searchInput" placeholder="Input with icon" type="text" value="" />
                    </div>
                </div>
                <div id="searchResults"
                    class="px-3.5 scrollable-y border border-gray-300 rounded-md max-h-[60vh] overflow-y-auto mb-1">
                      <!-- Aquí se generarán las tarjetas dinámicamente -->
                </div>

            </div>
        </div>
    </div>

    <script>

        
        let map, userMarker, directionsService, directionsRenderer;
        let userLocation = null;
        let watchingPosition = false;
        const destination = {
            lat: 4.316583,
            lng: -74.7727809
        };
        let routePath = [];
        const deviationThreshold = 30;

        let lastSearchTime = 0;
        const searchCooldown = 1000;

        const places = [{
                name: "Cancha Tenis",
                categoria: "Deporte",
                location: {
                    lat: 4.314850,
                    lng: -74.774845
                },
                icon: "https://tse2.mm.bing.net/th?id=OIP.3JDA1BMjZiOTdM60A0VEgAHaHa&pid=Api&P=0&h=180"
            },
            {
                name: "Golf",
                categoria: "Deporte",
                location: {
                    lat: 4.313433,
                    lng: -74.774156
                },
                icon: "https://static.vecteezy.com/system/resources/previews/000/422/894/original/golf-icon-vector-illustration.jpg"
            },
            {
                name: "Gimnasio",
                categoria: "Deporte",
                location: {
                    lat: 4.311515,
                    lng: -74.768195
                },
                icon: "https://tse2.mm.bing.net/th?id=OIP.3JDA1BMjZiOTdM60A0VEgAHaHa&pid=Api&P=0&h=180"
            }
        ];
        
        document.getElementById('searchInput').addEventListener('input', manejarBusqueda);


        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 16,
                center: destination,
                mapTypeId: "roadmap",
                tilt: 45,
                streetViewControl: false,
                mapTypeId: "satellite",
                styles: [{
                    featureType: "poi", 
                    stylers: [{
                        visibility: "off"
                    }]
                }],
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                suppressMarkers: true
            });
            directionsRenderer.setMap(map);

            userMarker = new google.maps.Marker({
                position: {
                    lat: 0,
                    lng: 0
                },
                map: map,
                title: "Tu ubicación",
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 8,
                    fillColor: "#4285F4",
                    fillOpacity: 1,
                    strokeWeight: 2
                }
            });

            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(updateUserLocation, () => alert("No se pudo obtener la ubicación"), {
                    enableHighAccuracy: true,
                    maximumAge: 0
                });
            } else {
                alert("Tu navegador no soporta geolocalización");
            }

            addPlacesToMap();
        }

        function updateUserLocation(position) {

            userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            userMarker.setPosition(userLocation);
            if (watchingPosition) {
                map.setCenter(userLocation);
            }
            checkIfUserDeviates();

        }

        function addPlacesToMap() {
            places.forEach(lugar => {
                const marcador = new google.maps.Marker({
                    position: {
                        lat: lugar.location.lat,
                        lng: lugar.location.lng
                    },
                    map: map,
                    title: lugar.name,
                    icon: "https://maps.gstatic.com/mapfiles/transparent.png"
                });

                // Crear el ícono redondo personalizado
                const divIcon = document.createElement("div");
                divIcon.className = "place-icon";
                divIcon.style.background = lugar.color;
                divIcon.innerHTML = `<img src="${lugar.icon}" alt="icono">`;

                // Crear la etiqueta con el name del lugar
                const divLabel = document.createElement("div");
                divLabel.className = "place-label";
                divLabel.innerHTML = `${lugar.name} <br> <small style="color:gray">${lugar.categoria}</small>`;

                // Agregar los elementos al mapa
                const overlay = new google.maps.OverlayView();
                overlay.onAdd = function() {
                    const panes = this.getPanes();
                    panes.overlayMouseTarget.appendChild(divIcon);
                    panes.overlayMouseTarget.appendChild(divLabel);
                };
                overlay.draw = function() {
                    const pos = this.getProjection().fromLatLngToDivPixel(marcador.getPosition());
                    divIcon.style.left = `${pos.x}px`;
                    divIcon.style.top = `${pos.y}px`;
                    divLabel.style.left = `${pos.x + 20}px`;
                    divLabel.style.top = `${pos.y - 10}px`;
                };
                overlay.setMap(map);

                // // Evento para mostrar detalles al hacer clic
                // marcador.addListener("click", () => {
                //     alert(`📍 ${lugar.nombre}\nCategoría: ${lugar.categoria}\nUbicación: ${lugar.lat.toFixed(6)}, ${lugar.lng.toFixed(6)}`);
                // });
            });

        }


        async function searchPlace(ubicacionId) {
            const ubicacion = await obtenerUbicacion(ubicacionId);
            if (!ubicacion) return;
            console.log(ubicacion);
            
            const targetLocation = { lat: ubicacion.latitud, lng: ubicacion.longitud };
            console.log(targetLocation);
            
            map.setCenter(targetLocation);
            calculateRoute(targetLocation);
        }

        function calculateRoute(targetLocation) {
            if (!userLocation) return;

            directionsService.route({
                origin: userLocation,
                destination: targetLocation,
                travelMode: "DRIVING"
            }, (result, status) => {
                if (status === "OK") {
                    directionsRenderer.setDirections(result);
                } else {
                    console.error("Error al calcular la ruta: ", status);
                }
            });
        }

        async function obtenerUbicacion(id) {
            try {
                const response = await fetch(`/ubicaciones/${id}`);
                if (!response.ok) throw new Error(`Error: ${response.status}`);

                return await response.json();
            } catch (error) {
                console.error("Error al obtener la ubicación:", error);
                return null;
            }
        }


        function startNavigation() {
            watchingPosition = true;
        }

        function centerMap() {
            if (userLocation) {
                map.setCenter(userLocation);
            }
        }


        function checkIfUserDeviates() {
            if (!routePath.length || !userLocation) return;

            let nearestDistance = routePath.reduce((minDist, point) => {
                let dist = google.maps.geometry.spherical.computeDistanceBetween(
                    new google.maps.LatLng(userLocation.lat, userLocation.lng),
                    point
                );
                return Math.min(minDist, dist);
            }, Infinity);

            if (nearestDistance > deviationThreshold) {
                alert('desviacion: ', nearestDistance);

                console.log("Recalculando ruta por desviación...");
                calculateRoute();
            }
        }

        function stopNavigation() {
            directionsRenderer.setDirections({
                routes: []
            });
            document.getElementById("searchPanel").classList.remove("hidden");
            document.getElementById("navigationControls").classList.add("hidden");
            navigating = false;
        }

        async function buscarUbicaciones(busqueda) {

            try {
                const response = await fetch(`/ubicaciones/buscar/${encodeURIComponent(busqueda)}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error(`Error: ${response.status} - ${response.statusText}`);
                }

                const data = await response.json();
                console.log('Ubicaciones encontradas:', data);
                return data;

            } catch (error) {
                console.error('Error al buscar ubicaciones:', error.message);
                return [];
            }
        }

        // Función para manejar la búsqueda en tiempo real con debounce
        async function manejarBusqueda() {
            
            const now = Date.now();
            if (now - lastSearchTime < searchCooldown) {
                return;
            }
            
            lastSearchTime = now;
            await realizarBusqueda();
        }

        // Función que ejecuta la búsqueda y actualiza el DOM
        async function realizarBusqueda() {
            const busqueda = document.getElementById('searchInput').value.trim();
            const contenedor = document.getElementById('searchResults');

            if (busqueda === '') {
                contenedor.innerHTML = '<p class="text-gray-500 text-sm p-2">Escribe para buscar...</p>';
                return;
            }

            const resultados = await buscarUbicaciones(busqueda);

            // Limpiar resultados anteriores
            contenedor.innerHTML = '';

            if (resultados.length === 0) {
                contenedor.innerHTML = '<p class="text-gray-500 text-sm p-2">No se encontraron resultados.</p>';
                return;
            }

            // Construir tarjetas dinámicamente
            resultados.forEach(ubicacion => {
                const card = document.createElement('div');
                card.className = 'card mt-2';
             

                card.innerHTML = `
                    <div class="card-body flex items-center justify-between py-1 mb-1 gap-10 hover:bg-gray-100 cursor-pointer transition-all duration-200"  data-id="${ubicacion.id}">
                        <div class="flex items-center gap-2.5">
                            <div class="flex flex-col">
                                <div class="text-2sm mb-px">
                                    <p class="font-semibold text-gray-900" >
                                        ${ubicacion.nombre}
                                    </p>
                                </div>
                                <span class="flex items-center text-2xs font-medium text-gray-500">
                                    Propiedad
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2.5 btn btn-sm btn-icon btn-clear btn-success">
                            <i class="ki-filled ki-check-squared"></i>
                        </div>
                    </div>
                `;
                contenedor.appendChild(card);
            });
        }


        const contenedorResultados = document.getElementById('searchResults');

        // Delegación de eventos: Añadimos un solo event listener al contenedor
        contenedorResultados.addEventListener('click', async (e) => {
            const card = e.target.closest('.card-body');

            
            if (card) {
                const ubicacionId = card.getAttribute('data-id');

                console.log(ubicacionId);
                
                const result = await Swal.fire({
                    title: '¿Deseas ver la ruta hacia esta ubicación?',
                    text: 'Se mostrará la ruta hacia la ubicación seleccionada.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ver ruta',
                    cancelButtonText: 'No, gracias',
                });

                if (result.isConfirmed) {
                    searchPlace(ubicacionId);
                }
            }
        });



    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=geometry,places&callback=initMap"
        async defer></script>


    <script src="assets/js/core.bundle.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/widgets/general.js"></script>
    <script src="assets/js/layouts/demo1.js"></script>
    <!-- End of Scripts -->
</body>

</html>
