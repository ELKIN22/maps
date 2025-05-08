<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" lang="es">

<head>
    <base href="../../">
    <title>
        CAGUZ
    </title>
    <meta charset="utf-8" />
    <meta content="follow, index" name="robots" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <meta content="CAGUZ - Aplicación Maps, navegación mejorada, búsqueda y galería." name="description" />
    <meta content="es_CO" property="og:locale" />
    <meta content="website" property="og:type" />
    <meta content="@keenthemes" property="og:site_name" />
    <meta content="CAGUZ" property="og:title" />
    <meta content="CAGUZ - Aplicación web Maps, navegación mejorada, búsqueda y galería." property="og:description" />
    <meta content="assets/media/app/og-image.png" property="og:image" />
    <link href="assets/media/app/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="{{ asset('favicon.jpg') }}" rel="icon" sizes="32x32" type="image/png" />
    <link href="{{ asset('favicon.jpg') }}" rel="icon" sizes="16x16" type="image/png" />
    <link href="{{ asset('favicon.jpg') }}" rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="assets/vendors/apexcharts/apexcharts.css" rel="stylesheet" />
    <link href="assets/vendors/keenicons/styles.bundle.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #map { height: 100vh; width: 100%; }

        .place-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            transform: translate(-50%, -50%);
            box-shadow: 0px 2px 5px rgba(0,0,0,0.3);
            border: 2px solid white;
            background-color: #17C653;
            cursor: pointer;
        }

        .place-icon img {
            width: 25px;
            height: 25px;
            border-radius: 50%;
        }

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
                cursor: pointer;
                transform: translate(20px, -10px); 
            }

            /* 🔹 Estilos Responsive */
            @media (max-width: 768px) {
                .place-label {
                    font-size: 12px;
                    padding: 2px 6px;
                    transform: translate(18px, -8px); 
                }
                .place-icon {
                    width: 30px;
                    height: 30px;
                }
                .place-icon img {
                    width: 22px;
                    height: 22px;
                }
            }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(66, 133, 244, 0.7);
            }
            70% {
                transform: scale(1.05); 
                box-shadow: 0 0 10px 10px rgba(66, 133, 244, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(66, 133, 244, 0);
            }
        }

        .pulsating-button {
            animation: pulse 2s infinite ease-in-out;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}">
</head>

<body
    class="antialiased flex h-full text-base text-gray-700 [--tw-page-bg:#fefefe] [--tw-page-bg-dark:var(--tw-coal-500)] demo1 sidebar-fixed header-fixed bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]">

    <div id="preloader">
        <img src="{{ asset('assets/media/images/preload.png') }}" alt="Cargando...">
        <p class="loading-text">Ubícate con facilidad</p>
    </div>

    <div id="map"></div>

    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-[90%] max-w-3xl" id="buscar" data-modal-toggle="#modalBusqueda">
        <div class="flex items-center bg-white shadow-md rounded-full px-4 py-2 space-x-3">
        <i class="ki-outline ki-magnifier"></i>
    
        <input type="text"
                class="flex-1 focus:outline-none text-gray-800 placeholder-gray-400 bg-transparent"
                placeholder="Busca aquí..." />
    
        <img src="SIMBOLO.png"
            alt="Logo empresa"
            class="w-8 h-8 rounded-full object-cover" />
        </div>
    </div>
      
      
    <button id="iniciarRuta" class="btn btn-outline btn-primary fixed bottom-28 right-4 z-10 pulsating-button ">
        <i class="ki-filled ki-route"></i> Iniciar Ruta
    </button>

    <button id="centrar" class="btn btn-outline btn-info fixed bottom-16 right-4 z-10 hidden">
        <i class="ki-filled ki-focus"></i> Centrar
    </button>
    <button id="salirRuta" class="btn btn-outline btn-danger fixed bottom-4 right-4 z-10 hidden">
        <i class="ki-filled ki-cross-circle"></i> Salir Ruta
    </button>

    <div class="modal" data-modal="true" id="modalBusqueda">
        <div class="modal-content max-w-[800px] top-[10%] max-h-[80%]">
            <div class="modal-header">
                <h3 class="modal-title">Buscar Ubicaciones</h3>
                <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                    <i class="ki-outline ki-cross"></i>
                </button>
            </div>
            <div class="modal-body ">
                <div class="pt-2.5 mb-1">
                    <div class="input">
                        <i class="ki-outline ki-magnifier"></i>
                        <input id="searchInput" placeholder="Buscar lugar..." type="text" value="" />
                    </div>
                </div>
                <div id="searchResults" class="px-3.5 scrollable-y border border-gray-300 rounded-md max-h-[60vh] overflow-y-auto mb-1">
                        
                </div>
            </div>
        </div>
    </div>

    <div class="modal" data-modal="true" id="modalGaleria">
        <div class="modal-content max-w-[800px] top-[10%] max-h-[80%]">
            <div class="modal-header">
                <h3 class="modal-title">Galería</h3>
                <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                    <i class="ki-outline ki-cross"></i>
                </button>
            </div>
            <div class="modal-body ">
                <div class="flex justify-center items-center bg-gray-100 p-4">
                    <div class="grid gap-4 max-w-2xl">
                        <div>
                            <img id="mainImage" class="h-auto w-full max-w-full rounded-lg object-cover object-center md:h-[480px]"
                                src="" alt="Imagen principal de la galería" />
                        </div>
                        <div class="overflow-x-auto">
                            <div id="thumbnailContainer" class="flex gap-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/preloader.js') }}"></script>
    <script>
        // --- Variables Globales ---
        let map;
        let userMarker = null; 
        let directionsService;
        let directionsRenderer;
        let userLocation = null; // { lat: number, lng: number }
        let navigating = false; 
        let watchId = null;

        let currentRoute = null; 

        // --- Constantes ---
        const searchCooldown = 500; 
        const DEFAULT_LOCATION = { lat: 4.316583, lng: -74.7727809 }; 


        // --- Variables de UI ---
        let modalInstanceBusq;
        let modalInstanceGaleria;
        let placesMarkers = []; // Almacenar marcadores personalizados y overlays
        let activeInfoWindow = null; // InfoWindow actualmente abierta
        let lastSearchTime = 0;
        let initialCheckDone = false; // Para el primer chequeo de desvío

        // --- Inicialización de UI (Modal, Botones) ---
        document.addEventListener("DOMContentLoaded", () => {
            KTModal.init();
            KTModal.createInstances();

            const modalElBusq = document.querySelector('#modalBusqueda');
            modalInstanceBusq = KTModal.getInstance(modalElBusq);

            const modalGaleria = document.querySelector('#modalGaleria');
            modalInstanceGaleria = KTModal.getInstance(modalGaleria);

            if (modalInstanceBusq) {
                modalInstanceBusq.on('show', () => {
                    realizarBusqueda();
                    setTimeout(() => {
                        document.getElementById('searchInput').focus(); 
                    }, 200);
                   
                });
            } else {
                 console.error("No se pudo inicializar el modal de búsqueda");
            }

             if (!modalInstanceGaleria) {
                 console.error("No se pudo inicializar el modal de galería");
            }


            // Listeners de botones
            document.getElementById('searchInput').addEventListener('input', manejarBusqueda);
            document.getElementById('iniciarRuta').addEventListener('click', startNavigation);
            document.getElementById('centrar').addEventListener('click', centerMap);
            document.getElementById('salirRuta').addEventListener('click', stopNavigation);

            // Estado inicial de botones
            document.getElementById("iniciarRuta").classList.add("hidden");
            document.getElementById("buscar").classList.remove("hidden");
            // document.getElementById("centrar").classList.remove("hidden");
            document.getElementById("salirRuta").classList.add("hidden");

             // Listener para resultados de búsqueda (Delegación)
             const contenedorResultados = document.getElementById('searchResults');
             if(contenedorResultados){
                 contenedorResultados.addEventListener('click', handleSearchResultClick);
             } else {
                 console.error("Contenedor de resultados de búsqueda no encontrado.");
             }
        });

        // --- Inicialización del Mapa ---
        async function initMap() {
            try {
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: DEFAULT_LOCATION,
                    streetViewControl: false,
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DEFAULT,
                        position: google.maps.ControlPosition.LEFT_BOTTOM
                    },
                    zoomControl: false,
                    fullscreenControl: false,
                    mapId: 'dca8e9ef523bf712',
                    disableDefaultUI: true,
                    styles: [
                        {
                            elementType: 'labels',
                            stylers: [{ visibility: 'off' }] 
                        },
                    ]
                });

                directionsService = new google.maps.DirectionsService();
                directionsRenderer = new google.maps.DirectionsRenderer({
                    suppressMarkers: true,    
                    preserveViewport: true, 
                    polylineOptions: {
                        strokeColor: '#4285F4', 
                        strokeWeight: 8,      
                        strokeOpacity: 1     
                    }
               
                });
                directionsRenderer.setMap(map);

                // Iniciar Geolocalización
                if (navigator.geolocation) {
                    watchId = navigator.geolocation.watchPosition(
                        updateUserLocation,
                        handleLocationError,
                        { enableHighAccuracy: true, maximumAge: 500, timeout: 5000 }
                    );
                } else {
                    handleLocationError();
                }

                // Cargar lugares en el mapa
                await addPlacesToMap();

            } catch (error) {
                 console.error("Error fatal inicializando el mapa:", error);
                 alert("Hubo un error al cargar el mapa. Por favor, recarga la página.");
            }
        }

        // --- Manejo de Errores de Geolocalización ---
        function handleLocationError(error = null) {
            let message = "Error desconocido de geolocalización.";
            
            if (error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        message = "Permiso de ubicación denegado.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        message = "Información de ubicación no disponible.";
                        break;
                    case error.TIMEOUT:
                        message = "Se agotó el tiempo para obtener la ubicación.";
                        break;
                }
                console.error("Error de Geolocalización:", error.message);
            } else if (!navigator.geolocation) {
                message = "Tu navegador no soporta geolocalización.";
            }

            if (!userLocation) {
                map.setCenter(DEFAULT_LOCATION);
                map.setZoom(12); 
            }
        }


        // --- Actualización de Ubicación del Usuario ---
        function updateUserLocation(position) {
 
            userLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            if (!navigating || !currentRoute || typeof google.maps.geometry === 'undefined') return; 

            const heading = position.coords.heading; 
                
            createUserMarker(userLocation, heading);
            
            map.moveCamera({ center: userLocation }); 

            if (heading !== null && !isNaN(heading)) {
                map.setHeading(heading);
            }

        }

        // --- Crear/Actualizar Marcador de Usuario (Flecha Rotatoria) ---
        function createUserMarker(location, deviceHeading  = 0) {

            const currentMapHeading = map ? map.getHeading() || 0 : 0;
            const rotation = deviceHeading !== null && !isNaN(deviceHeading) ? deviceHeading : currentMapHeading;

            const icon = {
                url: 'arrow.png', 
                scaledSize: new google.maps.Size(35, 35),
                origin: new google.maps.Point(0, 0), 
                anchor: new google.maps.Point(17.5, 17.5), 
                rotation: rotation
            };

            if (!userMarker) {
                userMarker = new google.maps.Marker({
                    position: location,
                    map: map,
                    icon: icon,
                    title: "Tu ubicación"
                });
            } else {
                userMarker.setPosition(location);
                userMarker.setIcon(icon);
            }
        }


        // --- Gestión de Lugares (Marcadores Personalizados) ---
        async function addPlacesToMap() {
            try {
                const places = await buscarUbicaciones('@');

                clearPlacesMarkers();

                places.forEach(lugar => {
                    const position = { lat: Number(lugar.latitud), lng: Number(lugar.longitud) };

                     if (isNaN(position.lat) || isNaN(position.lng)) {
                        console.warn(`Coordenadas inválidas para lugar ${lugar.id}:`, lugar.latitud, lugar.longitud);
                        return; 
                     }

                    // Marcador base transparente (ancla para InfoWindow)
                    const marcador = new google.maps.Marker({
                        position: position,
                        map: map,
                        title: lugar.nombre,
                        icon: "https://maps.gstatic.com/mapfiles/transparent.png" 
                    });

                    // InfoWindow con acciones
                    const infoWindowContent = `
                        <div style="text-align:center;" class="btn-group">
                            <button class="btn btn-sm btn-outline btn-primary" onclick="confirmAndSearchPlace(${lugar.id}, '${lugar.nombre}')">
                                <i class="ki-filled ki-route"></i> Ver Ruta
                            </button>
                            ${lugar.imagenes && lugar.imagenes.length > 0 ?
                            `<button class="btn btn-sm btn-outline btn-success" onclick="cargarGaleria(${lugar.id})">
                                <i class="ki-filled ki-picture"></i> Galería
                             </button>` : ''}
                        </div>`;
                    const infoWindow = new google.maps.InfoWindow({ content: infoWindowContent });

                    // --- Overlay Personalizado ---
                    const divIcon = document.createElement("div");
                    divIcon.className = "place-icon";
                    divIcon.innerHTML = `<img src="${lugar.imagen_destacada || 'assets/media/app/favicon.ico'}" alt="icono">`;

                    const divLabel = document.createElement("div");
                    divLabel.className = "place-label";
                    divLabel.innerHTML = `${lugar.nombre}`;

                    const overlay = new google.maps.OverlayView();
                    overlay.onAdd = function () {
                        const panes = this.getPanes();
                        if (panes) {
                            panes.overlayMouseTarget.appendChild(divIcon);
                            panes.overlayMouseTarget.appendChild(divLabel);

                            [divIcon, divLabel].forEach(element => {
                                element.addEventListener("click", (e) => {
                                     e.stopPropagation();
                                    cerrarInfoWindow(); 
                                    infoWindow.open(map, marcador);
                                    activeInfoWindow = infoWindow;
                                });
                            });
                        }
                    };

                    overlay.draw = function () {
                        const projection = this.getProjection();
                        if (!projection) return;
                        const pos = projection.fromLatLngToDivPixel(marcador.getPosition());
                        if (pos) {
 
                            divIcon.style.left = `${pos.x}px`;
                            divIcon.style.top = `${pos.y}px`;
                            divLabel.style.left = `${pos.x}px`;
                            divLabel.style.top = `${pos.y}px`;

                        }
                    };
                    overlay.onRemove = function() {
                        if (divIcon.parentNode) { divIcon.parentNode.removeChild(divIcon); }
                        if (divLabel.parentNode) { divLabel.parentNode.removeChild(divLabel); }
                    };

                    overlay.setMap(map);
                    placesMarkers.push({ marcador, overlay, infoWindow });
                });

                map.addListener('click', cerrarInfoWindow);

            } catch (error) {
                console.error("Error al agregar lugares al mapa:", error);
            }
        }

        function clearPlacesMarkers() {
            placesMarkers.forEach(({ marcador, overlay, infoWindow }) => {
                marcador.setMap(null);
                overlay.setMap(null);
                infoWindow.close();
            });
            placesMarkers = [];
            cerrarInfoWindow();
        }

        function cerrarInfoWindow() {
            if (activeInfoWindow) {
                activeInfoWindow.close();
                activeInfoWindow = null;
            }
        }

        // --- Búsqueda y Cálculo de Ruta ---
        async function confirmAndSearchPlace(ubicacionId, nombre) {
             cerrarInfoWindow();
             const result = await Swal.fire({
                 title: `¿Ver ruta a ${nombre}?`,
                 text: 'Se calculará la ruta desde tu ubicación actual.',
                 icon: 'question',
                 showCancelButton: true,
                 confirmButtonText: 'Sí, ver ruta',
                 cancelButtonText: 'Cancelar',
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33'
             });

             if (result.isConfirmed) {
                 searchPlace(ubicacionId);
             }
        }


        async function searchPlace(ubicacionId) {
            cerrarInfoWindow();
            if (!userLocation) {
                alert("No se puede calcular la ruta sin tu ubicación actual. Asegúrate de haber concedido permisos.");
                return;
            }

            try {
                const ubicacion = await obtenerUbicacion(ubicacionId);
                if (!ubicacion || isNaN(Number(ubicacion.latitud)) || isNaN(Number(ubicacion.longitud))) {
                     alert("No se pudieron obtener los detalles de la ubicación o las coordenadas son inválidas.");
                     return;
                }

                const targetLocation = {
                    lat: Number(ubicacion.latitud),
                    lng: Number(ubicacion.longitud)
                };

                calculateRoute(targetLocation);

            } catch (error) {
                 console.error("Error buscando o calculando ruta para el lugar:", error);
                 alert("Hubo un problema al obtener o calcular la ruta.");
            }
        }

        function calculateRoute(targetLocation) {
            if (!userLocation || !targetLocation) {
                console.warn("Origen o destino faltante para calcular ruta.");
                return;
            }

            document.getElementById('iniciarRuta').classList.add('hidden');

            directionsRenderer.setDirections({ routes: [] });
         
            currentRoute = null; 

            directionsService.route({
                origin: userLocation,
                destination: targetLocation,
                travelMode: google.maps.TravelMode.DRIVING,
                provideRouteAlternatives: false 
            })
            .then((result) => {
               
                 if (result.routes && result.routes.length > 0) {
                    directionsRenderer.setDirections(result);
                    currentRoute = result.routes[0];
                   
                    if (modalInstanceBusq) {
                        modalInstanceBusq.hide();
                    }

                    if(!navigating) {
                        map.fitBounds(currentRoute.bounds);
                    }

                    document.getElementById('iniciarRuta').classList.remove('hidden');

                 } else {
                     throw new Error("La API de Directions no devolvió rutas.");
                 }
            })
            .catch((e) => {
                console.error("Error al calcular la ruta: ", e);
                alert("No se pudo calcular la ruta. Verifica la conexión o las ubicaciones. Detalles: " + e.message);
                document.getElementById('iniciarRuta').disabled = true;
            });
        }

        // --- Funciones de Navegación ---
        function startNavigation() {
            if (!currentRoute) {
                alert("Debes calcular una ruta primero.");
                return;
            }
            if (!userLocation) {
                alert("Necesitamos tu ubicación para iniciar la navegación.");
                 return;
            }

            console.log("Iniciando navegación...");
            navigating = true;
            initialCheckDone = false;
           

            // Actualizar UI
            document.getElementById("iniciarRuta").classList.add("hidden");
            document.getElementById("buscar").classList.add("hidden");
            document.getElementById("salirRuta").classList.remove("hidden");
            document.body.classList.add('navigating');

            map.setZoom(18); 
            map.setTilt(45);
            map.setCenter(userLocation); 


            if (!watchId && navigator.geolocation) {
                console.warn("WatchPosition no estaba activo, reiniciando...");
                watchId = navigator.geolocation.watchPosition(
                    updateUserLocation,
                    handleLocationError,
                    { enableHighAccuracy: true, maximumAge: 5000, timeout: 10000 }
                );
            }
        }

        function stopNavigation() {
            console.log("Deteniendo navegación...");
            navigating = false;

            // Resetear vista del mapa
            map.setTilt(0);        
            map.setHeading(0);    
            map.setZoom(15);       
            map.setCenter(DEFAULT_LOCATION);

            directionsRenderer.setDirections({ routes: [] });
            currentRoute = null; 


            // Actualizar UI
            document.getElementById("iniciarRuta").classList.add("hidden");
            document.getElementById("buscar").classList.remove("hidden");
            document.getElementById("salirRuta").classList.add("hidden");
            document.body.classList.remove('navigating');
        }

        function centerMap() {
            if (userLocation) {
                map.setCenter(userLocation);

                if (!navigating) map.setZoom(16);
                else map.setZoom(18);
            } else {
                alert("Aún no se ha detectado tu ubicación para centrar.");
            }
        }

        // --- Funciones de API Backend (Búsqueda, Detalles, Galería) ---
        async function buscarUbicaciones(busqueda) {
          
            try {
                 const encodedBusqueda = encodeURIComponent(busqueda || '@'); 
                const response = await fetch(`/ubicaciones/buscar/${encodedBusqueda}`);
                if (!response.ok) {
                    throw new Error(`Error de red: ${response.status} - ${response.statusText}`);
                }
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Error al buscar ubicaciones:', error.message);
                return [];
            }
        }

        async function obtenerUbicacion(id) {
            try {
                const response = await fetch(`/ubicaciones/${id}`);
                if (!response.ok) {
                     throw new Error(`Error de red al obtener ubicación ${id}: ${response.status}`);
                }
                return await response.json();
            } catch (error) {
                console.error("Error al obtener la ubicación:", error);
                return null;
            }
        }

        async function cargarGaleria(id) {
            cerrarInfoWindow();
            if (!modalInstanceGaleria) {
                 console.error("Instancia del modal de galería no disponible.");
                 alert("No se puede mostrar la galería en este momento.");
                 return;
            }

            const mainImage = document.getElementById("mainImage");
            const thumbnailContainer = document.getElementById("thumbnailContainer");
            mainImage.src = '';
            thumbnailContainer.innerHTML = '<p class="text-center w-full p-4">Cargando galería...</p>';
            modalInstanceGaleria.show();


            try {
                const data = await obtenerUbicacion(id);
                if (!data || !data.imagenes || !Array.isArray(data.imagenes) || data.imagenes.length === 0) {
                    thumbnailContainer.innerHTML = '<p class="text-center w-full p-4 text-red-500">No se encontraron imágenes para este lugar.</p>';
                    console.warn("No se encontraron imágenes válidas para ID:", id);
                    return;
                }

                const images = data.imagenes;
                mainImage.src = `/storage/${images[0].url}` || ""; 

                thumbnailContainer.innerHTML = "";

                images.forEach((imgData, index) => {
                    if (!imgData || !imgData.url) return;

                    const thumb = document.createElement("img");
                    thumb.src = `/storage/${imgData.url}`;
                    thumb.alt = `Miniatura ${index + 1}`;

                    thumb.className = "object-cover object-center h-20 w-20 rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500 transition duration-200 ease-in-out";

                    thumb.addEventListener("click", () => {
                        mainImage.src = `/storage/${imgData.url}`;
                        document.querySelectorAll("#thumbnailContainer img").forEach(img => img.classList.replace("border-blue-500", "border-transparent"));
                        thumb.classList.replace("border-transparent", "border-blue-500");
                    });
                    thumbnailContainer.appendChild(thumb);
                });

                if (thumbnailContainer.children.length > 0) {
                     thumbnailContainer.children[0].classList.replace("border-transparent", "border-blue-500");
                }

            } catch (error) {
                console.error("Error al cargar la galería:", error);
                 thumbnailContainer.innerHTML = `<p class="text-center w-full p-4 text-red-500">Error al cargar galería: ${error.message}</p>`;
            }
        }

        // --- Manejo de Búsqueda en Tiempo Real ---
        async function manejarBusqueda() {
            const now = Date.now();
            if (now - lastSearchTime < searchCooldown) {
                return;
            }
            lastSearchTime = now;
            await realizarBusqueda();
        }

        async function realizarBusqueda() {
            let busqueda = document.getElementById('searchInput').value.trim();
            const contenedor = document.getElementById('searchResults');
            if (!contenedor) return;

            contenedor.innerHTML = '<p class="text-gray-500 text-sm p-2 text-center">Buscando...</p>';

            const resultados = await buscarUbicaciones(busqueda);

            contenedor.innerHTML = '';

            if (resultados.length === 0) {
                contenedor.innerHTML = '<p class="text-gray-500 text-sm p-2 text-center">No se encontraron resultados.</p>';
                return;
            }

            // Construir tarjetas dinámicamente
            resultados.forEach(ubicacion => {
                const card = document.createElement('div');
                card.className = 'flex items-center justify-between p-2 mb-1 hover:bg-gray-100 cursor-pointer border-b border-gray-200 last:border-b-0';
                card.setAttribute('data-id', ubicacion.id);
                card.setAttribute('data-nombre', ubicacion.nombre); 

                card.innerHTML = `
                    <div class="flex-grow pr-4">
                        <p class="font-semibold text-gray-900 text-sm">${ubicacion.nombre}</p>
                        <span class="text-xs font-medium text-gray-500">${ubicacion.tipo?.nombre || 'Ubicación'}</span>
                    </div>
                     ${ubicacion.imagenes && ubicacion.imagenes.length > 0 ? `
                    <button class="btn btn-outline  btn-success flex-shrink-0 btn-galeria-busqueda" title="Ver Galería">
                       <i class="ki-duotone ki-picture fs-5"></i> Galeria
                    </button>
                    ` : '' }
                `;
                contenedor.appendChild(card);
            });
        }

        // --- Manejador de Clics en Resultados de Búsqueda (Delegación) ---
        async function handleSearchResultClick(event) {
            const card = event.target.closest('.flex.items-center.justify-between');
            if (!card) return;

            const ubicacionId = card.getAttribute('data-id');
            const ubicacionNombre = card.getAttribute('data-nombre');

            if (event.target.closest('.btn-galeria-busqueda')) {
                event.stopPropagation();
                cargarGaleria(ubicacionId);
            } else {
                confirmAndSearchPlace(ubicacionId, ubicacionNombre);
            }
        }

    </script>

    <script src="assets/js/core.bundle.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/widgets/general.js"></script>
    <script src="assets/js/layouts/demo1.js"></script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=geometry,places&callback=initMap&language=es&region=CO">
    </script>
</body>
</html>