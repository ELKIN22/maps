@extends('layouts.base')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h1>Lista de Ubicaciones</h1>
        <button class="btn btn-primary" data-modal-toggle="#createUbicacionModal">
            <i class="ki-filled ki-plus fs-2"></i> Crear Ubicación
        </button>
    </div>

    <div class="grid gap-5 lg:gap-7.5">
        <div class="lg:col-span-3">
            <div class="grid">
                <div class="card card-grid h-full min-w-full">
                    <div class="card-header">
                        <h3 class="card-title">Ubicaciones</h3>
                        <div class="input input-sm max-w-48">
                            <i class="ki-filled ki-magnifier"></i>
                            <input id="buscarUbicaciones" placeholder="Buscar Ubicaciones" type="text"/>
                        </div>
                    </div>
                    <div class="card-body">
                        <div data-datatable-page-size="10"> {{-- data-datatable-page-size can set initial value --}}
                            <div class="scrollable-x-auto">
                                <table class="table table-border" data-datatable-table="true">
                                    <thead>
                                        <tr>
                                            <th class="min-w-[200px]">
                                                <span class="sort asc">
                                                    <span class="sort-label">Nombre</span>
                                                </span>
                                            </th>
                                            <th class="min-w-[150px]">
                                                <span class="sort">
                                                    <span class="sort-label">Tipo</span>
                                                </span>
                                            </th>
                                            <th class="min-w-[100px]">
                                                <span class="sort">
                                                    <span class="sort-label">Destacada</span>
                                                </span>
                                            </th>
                                            <th class="min-w-[100px]">
                                                <span class="sort">
                                                    <span class="sort-label">Estado</span>
                                                </span>
                                            </th>
                                            <th class="min-w-[80px] text-center">Galería</th>
                                            <th class="min-w-[100px]">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyUbicaciones">
                                        {{-- Rows will be injected here by JavaScript --}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium">
                                <div class="flex items-center gap-2 order-2 md:order-1">
                                    Mostrar
                                    <select class="select select-sm w-16" id="perPageSelect" name="perpage">
                                        <option value="5">5</option>
                                        <option value="10" selected>10</option> {{-- Set default selected --}}
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                    </select>
                                    por página
                                </div>
                                <div class="flex items-center gap-4 order-1 md:order-2">
                                    <span id="paginationInfo"></span> {{-- Text like "1-10 de 100" goes here --}}
                                    <div id="paginationControls" class="pagination">
                                         {{-- Pagination buttons will be injected here by JavaScript --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para crear/editar ubicaciones --}}
    <div class="modal fade" id="createUbicacionModal" data-modal="true" tabindex="-1" aria-labelledby="createUbicacionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Quitamos action y method, se manejará por JS --}}
                <form id="formUbicacion" novalidate="novalidate">
                    {{-- CSRF Token (Importante para Laravel) --}}
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUbicacionModalLabel">Crear Nueva Ubicación</h5>
                        <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-n5" data-modal-dismiss="true"" aria-label="Close">
                            <i class="ki-filled ki-cross-square"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

                            <div class="flex flex-col">
                                <label for="nombre" class="form-label required">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="input" placeholder="Nombre de la ubicación" required>
                                <div class="fv-plugins-message-container invalid-feedback"></div> {{-- Para mensajes de error JS --}}
                            </div>

                            <div class="flex flex-col">
                                <label for="tipo_id" class="form-label required">Tipo</label>
                                <select id="tipo_id" name="tipo_id" class="select" data-control="select2" data-dropdown-parent="#createUbicacionModal" data-placeholder="Seleccione un tipo..." required>
                                    <option></option>
                                    {{-- Carga dinámica de opciones --}}
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>

                            <div class="flex flex-col">
                                <label for="estado" class="form-label required">Estado</label>
                                <select id="estado" name="estado" class="select" data-control="select2" data-dropdown-parent="#createUbicacionModal" data-hide-search="true" required>
                                    <option value="Activo" selected>Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>

                            <div class="flex flex-col">
                                <label for="destacada" class="form-label">Destacada</label>
                                <select id="destacada" name="destacada" class="select" data-control="select2" data-dropdown-parent="#createUbicacionModal" data-hide-search="true">
                                    <option value="0" selected>No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>

                            <div class="md:col-span-2 flex flex-col">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea id="descripcion" name="descripcion" class="textarea" placeholder="Añada una descripción..." rows="3"></textarea>
                            </div>

                            <div class="md:col-span-2 flex flex-col justify-center items-center p-4">

                                <label class="form-label self-start mb-2 font-medium text-gray-700">Imagen Destacada</label>

                                <label for="imagen_destacada_input" class="cursor-pointer block mb-4">
                                    <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-gray-300 bg-gray-200 flex items-center justify-center hover:border-blue-500 transition-colors duration-200">
                                        <img id="imagePreview"
                                            src="https://via.placeholder.com/150/CCCCCC/808080?text=Click+aqu%C3%AD" alt="Vista previa de imagen destacada"
                                            class="w-full h-full object-cover">
                                    </div>
                                </label>

                                <input class="file-input hidden" type="file" name="imagen_destacada" id="imagen_destacada_input" accept="image/*" />

                            </div>
                            {{-- SECCIÓN PARA EL MAPA --}}
                            <div class="col-span-2 md:col-span-4 flex flex-col gap-y-2 mt-3">
                                <label class="form-label required">Selecciona la ubicación en el mapa:</label>
                                <div id="mapSelector" style="height: 350px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">
                                    {{-- Mensaje mientras carga --}}
                                    <div class="flex items-center justify-center h-full text-gray-500">Cargando mapa...</div>
                                </div>
                                <input type="hidden" id="latitudeHidden" name="latitude" required>
                                <input type="hidden" id="longitudeHidden" name="longitude" required>
                                <div class="text-sm text-gray-600 mt-1">
                                    Coords: (<span id="selected-lat-display">N/A</span>, <span id="selected-lon-display">N/A</span>)
                                </div>
                                {{-- Mensaje de error para validación del mapa --}}
                                <div id="mapCoordsFeedback" class="text-red-600 text-xs mt-1" style="display: none;">
                                    Por favor, selecciona una ubicación en el mapa.
                                </div>
                            </div>
                            {{-- FIN SECCIÓN DEL MAPA --}}

                        </div> {{-- Fin del grid principal --}}
                    </div> {{-- Fin del modal-body --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-modal-dismiss="true"">Cerrar</button>
                        {{-- Botón de submit con indicador de carga (Metronic) --}}
                        <button type="submit" id="submitButton" class="btn btn-primary">
                            <span class="indicator-label">Guardar Ubicación</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="imageGalleryModal" class="fixed inset-0 bg-black bg-opacity-60 hidden flex items-center justify-center z-[1055] p-4 transition-opacity duration-300 ease-in-out" aria-labelledby="galleryModalTitle" role="dialog" aria-modal="true">
        <div class="bg-white p-6 rounded-xl shadow-2xl max-w-5xl w-full max-h-[90vh] flex flex-col transform transition-all duration-300 ease-in-out scale-95 opacity-0" id="galleryModalContent">
            <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-3">
                <h2 id="galleryModalTitle" class="text-2xl font-semibold text-gray-800">Galería de Imágenes - <span id="galleryUbicacionNombre"></span></h2>
                <button id="closeGalleryModalBtn" class="text-gray-400 hover:text-gray-700 text-3xl leading-none font-semibold outline-none focus:outline-none" aria-label="Cerrar modal de galería">&times;</button>
            </div>

            {{-- Contenedor de la Galería (con scroll y grid responsive) --}}
            <div id="galleryImageContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 overflow-y-auto flex-grow mb-5 pr-2 custom-scrollbar">
                <div id="galleryLoadingIndicator" class="col-span-full text-center py-10 text-gray-500">Cargando imágenes...</div>
            </div>

            {{-- Sección para agregar nuevas imágenes --}}
            <div class="mt-auto pt-4 border-t border-gray-200">
                <label for="addGalleryImageInput" class="block mb-2 text-sm font-medium text-gray-700">Agregar nueva imagen:</label>
                <div class="flex items-center gap-2 bg-gray-50 border border-gray-300 rounded-lg p-2">
                    <input type="file" id="addGalleryImageInput" accept="image/*" class="block w-full text-sm text-gray-900 cursor-pointer focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                 <p class="text-xs text-gray-500 mt-1">Selecciona un archivo de imagen (jpg, png, gif, etc.). La subida comenzará automáticamente.</p>
              
                 <div id="galleryUploadIndicator" class="text-sm text-blue-600 mt-2 hidden">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Subiendo imagen...
                 </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts') 

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=marker">
</script>

<script>
    // =========================================================================
    // Global Variables
    // =========================================================================

    // --- Map Selector Variables ---
    let mapSelectorInstance = null;
    let mapSelectorMarker = null;
    const mapSelectorDiv = document.getElementById('mapSelector');
    const latitudeHiddenInput = document.getElementById('latitudeHidden');
    const longitudeHiddenInput = document.getElementById('longitudeHidden');
    const selectedLatDisplay = document.getElementById('selected-lat-display');
    const selectedLonDisplay = document.getElementById('selected-lon-display');
    const mapCoordsFeedback = document.getElementById('mapCoordsFeedback');

    // --- Form Variables ---
    const modalForm = document.getElementById('createUbicacionModal');
    const formUbicacion = document.getElementById('formUbicacion');
    const modalTitle = document.querySelector('.modal-title');
    const submitButton = document.getElementById('submitButton');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let editingUbicacionId = null; // Variable to track if we are editing
    const tipoSelect = document.getElementById('tipo_id');

    // --- Table/Pagination Variables ---
    const searchInput = document.getElementById('buscarUbicaciones');
    const tbody = document.getElementById('tbodyUbicaciones');
    
    const perPageSelect = document.getElementById('perPageSelect');
    const paginationInfoSpan = document.getElementById('paginationInfo');
    const paginationControlsDiv = document.getElementById('paginationControls');
    const apiUrl = '/ubicaciones/getPaginate'; // API endpoint for data table
    let currentPage = 1;
    let itemsPerPage = parseInt(perPageSelect ? perPageSelect.value : 10);
    let searchQuery = '';

    // --- Default Map Coords/Zoom (Girardot - Peñon) ---
    const defaultCoords = { lat: 4.316756, lng: -74.771513 };
    const defaultZoom = 15;

     // --- API Endpoint for Types ---
     const typesApiUrl = '/tipoUbi/all';

      // Variables para la Vista Previa de Imagen Circular <===
    const imageUploadInput = document.getElementById('imagen_destacada_input'); 
    const imagePreviewElement = document.getElementById('imagePreview');    
    const defaultImageUrl = 'https://camarasal.com/wp-content/uploads/2020/08/default-image-5-1.jpg'; 

    // Variables para la Galería de Imágenes <===
    const imageGalleryModal = document.getElementById('imageGalleryModal');
    const galleryModalContent = document.getElementById('galleryModalContent');
    const closeGalleryModalBtn = document.getElementById('closeGalleryModalBtn');
    const galleryImageContainer = document.getElementById('galleryImageContainer');
    const addGalleryImageInput = document.getElementById('addGalleryImageInput');
    const galleryUbicacionNombreSpan = document.getElementById('galleryUbicacionNombre');
    const galleryLoadingIndicator = document.getElementById('galleryLoadingIndicator');
    const galleryUploadIndicator = document.getElementById('galleryUploadIndicator');

    let currentGalleryUbicacionId = null; 
    let currentGalleryImages = [];
    let galleryDraggedItem = null; 
    let galleryDragStartIndex = -1; 

    const galleryBaseUrl = '/ubicaciones/{ubicacionId}';



    // =========================================================================
    // Helper Functions - Map Selector
    // =========================================================================

    /**
     * Initializes or resets the Google Maps instance for the selector.
     * @param {object} initialCoords - The coordinates to center the map on initially.
     */
    function initMapSelector(initialCoords = defaultCoords) {
        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
            console.error("Google Maps API no está cargada.");
            if (mapSelectorDiv) mapSelectorDiv.innerHTML = '<div class="p-4 text-red-600 bg-red-100 border border-red-300 rounded">Error al cargar Google Maps. Verifica la API Key.</div>';
            return;
        }
        if (!mapSelectorDiv) {
            console.error("Elemento #mapSelector no encontrado.");
            return;
        }


        if (!mapSelectorInstance) {
            // --- Solo se ejecuta la PRIMERA VEZ que se abre el modal ---
            console.log("Creando NUEVA instancia de mapa.");

            mapSelectorDiv.innerHTML = ''; // Limpia mensaje de carga SOLO la primera vez

            const mapOptions = {
                zoom: defaultZoom,
                center: initialCoords, // Centra inicialmente
                mapTypeId: 'satellite',
                streetViewControl: false,
                fullscreenControl: false,
                mapTypeControl: false,
                scaleControl: false,
                rotateControl: false,
                zoomControl: true,
                styles: [{ featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] }]
            };
            mapSelectorInstance = new google.maps.Map(mapSelectorDiv, mapOptions);

            // Listener para click en el mapa (solo se añade una vez)
            mapSelectorInstance.addListener("click", (event) => {
                placeSelectorMarkerAndUpdateFields(event.latLng);
            });

        }

        // --- LÓGICA COMÚN: Se ejecuta SIEMPRE que se muestra el modal ---
        // (Tanto la primera vez como las siguientes)

        console.log("Ajustando mapa existente o recién creado.", initialCoords);

        // Asegura que el centro y zoom estén correctos ANTES del resize
        mapSelectorInstance.setCenter(initialCoords);
        mapSelectorInstance.setZoom(defaultZoom);

        // Manejo del marcador: Ponerlo si son coords de edición, quitarlo si son las default
        if (initialCoords.lat !== defaultCoords.lat || initialCoords.lng !== defaultCoords.lng) {
            // Estamos editando o recibimos coords específicas
            console.log("Colocando marcador para edición/coords específicas.");
            // Asegúrate de pasar un objeto google.maps.LatLng o un objeto {lat, lng} válido
            const positionForMarker = (typeof initialCoords.lat === 'function')
                                      ? initialCoords // Ya es un LatLng
                                      : new google.maps.LatLng(initialCoords.lat, initialCoords.lng); // Crear uno
            placeSelectorMarkerAndUpdateFields(positionForMarker, true); // Coloca/mueve el marcador
        } else {
            // Estamos creando nuevo (coords default)
            console.log("Quitando marcador existente (si lo hay) para modo creación.");
            if (mapSelectorMarker) {
                mapSelectorMarker.setMap(null); // Quita el marcador del mapa
                mapSelectorMarker = null;       // Limpia la referencia
            }
            // Limpia los campos de coordenadas y display
            if (latitudeHiddenInput) latitudeHiddenInput.value = '';
            if (longitudeHiddenInput) longitudeHiddenInput.value = '';
            if (selectedLatDisplay) selectedLatDisplay.textContent = 'N/A';
            if (selectedLonDisplay) selectedLonDisplay.textContent = 'N/A';
            if (mapCoordsFeedback) mapCoordsFeedback.style.display = 'none';
            if (mapSelectorDiv) mapSelectorDiv.style.borderColor = '#ccc'; // Reset border
        }

        // --- CLAVE: Forzar redibujo y re-centrado DESPUÉS de que el modal sea visible ---
        // Usamos setTimeout para darle una mínima oportunidad al navegador de renderizar el modal
        setTimeout(() => {
            if (mapSelectorInstance) { // Doble chequeo por si acaso
                console.log("Disparando resize y re-centrando DENTRO de setTimeout.");
                google.maps.event.trigger(mapSelectorInstance, 'resize');
                mapSelectorInstance.setCenter(initialCoords); // Re-centra DESPUÉS del resize
            }
        }, 100); // Aumenté un poco el tiempo por si acaso, puedes probar con 50 o 150
    }


    /**
     * Places or updates the map marker and updates related form fields/displays.
     * Accepts both google.maps.LatLng objects (from map clicks) and plain {lat, lng} objects.
     * @param {google.maps.LatLng|object} latLng - The coordinates for the marker.
     * @param {boolean} [updateHiddenFields=true] - Whether to update the hidden input fields and display spans.
     */
    function placeSelectorMarkerAndUpdateFields(latLng, updateHiddenFields = true) {
        let lat, lng;

        if (!latLng) {
            console.warn("Coordenadas nulas o indefinidas para el marcador:", latLng);
            return;
        }

        // Extraer lat y lng, asegurando que sean números
        try {
            if (typeof latLng.lat === 'function' && typeof latLng.lng === 'function') {
                lat = latLng.lat();
                lng = latLng.lng();
            } else if (typeof latLng.lat === 'number' && typeof latLng.lng === 'number') {
                lat = latLng.lat;
                lng = latLng.lng;
            } else {
                 console.warn("Coordenadas con formato inválido para el marcador:", latLng);
                 return;
            }

             // Convertir a float por si acaso vienen como strings de la DB
             lat = parseFloat(lat);
             lng = parseFloat(lng);

            if (isNaN(lat) || isNaN(lng)) {
                throw new Error("Coordenadas calculadas no son números válidos.");
            }

        } catch (e) {
            console.error("Error procesando coordenadas:", e, latLng);
            // Opcional: Mostrar un error al usuario
            // Swal.fire('Error', 'Las coordenadas recibidas no son válidas.', 'error');
            return; // Salir si las coordenadas no son válidas
        }


        // console.log("Posición para marcador:", {lat, lng});

        const position = new google.maps.LatLng(lat, lng); // Crear objeto LatLng

        if (mapSelectorInstance) { // Asegurar que la instancia del mapa exista
             if (mapSelectorMarker === null) {
                 // Crear nuevo marcador
                 mapSelectorMarker = new google.maps.Marker({
                     position: position,
                     map: mapSelectorInstance,
                     draggable: true,
                     title: "Ubicación seleccionada (arrastra para ajustar)"
                 });

                 // Listener para marker drag end (solo se añade una vez)
                 mapSelectorMarker.addListener('dragend', (event) => {
                     if (event.latLng) {
                         // El evento dragend proporciona un objeto google.maps.LatLng
                         placeSelectorMarkerAndUpdateFields(event.latLng);
                     }
                 });

             } else {
                 // Mover marcador existente
                 mapSelectorMarker.setPosition(position);
             }
        } else {
             console.warn("No se pudo colocar el marcador: la instancia del mapa no existe.");
             return; // No se puede colocar marcador sin mapa
        }


        if (updateHiddenFields) {
             if (latitudeHiddenInput) latitudeHiddenInput.value = lat;
             if (longitudeHiddenInput) longitudeHiddenInput.value = lng;
             if (selectedLatDisplay) selectedLatDisplay.textContent = lat.toFixed(6);
             if (selectedLonDisplay) selectedLonDisplay.textContent = lng.toFixed(6);

             // Limpiar feedback de validación del mapa
             if (mapCoordsFeedback && mapCoordsFeedback.style.display === 'block') {
                 mapCoordsFeedback.style.display = 'none';
             }
             if (mapSelectorDiv && mapSelectorDiv.style.borderColor === 'red') {
                 mapSelectorDiv.style.borderColor = '#ccc';
             }
             // Limpiar clase de error del label si existe
             const mapLabel = formUbicacion.querySelector('.form-label.text-danger');
             if (mapLabel && mapLabel.textContent.includes('Selecciona la ubicación en el mapa')) {
                mapLabel.classList.remove('text-danger');
             }
        }
    }

    // En la función resetMapAndCoords:
    function resetMapAndCoords() {
        if (latitudeHiddenInput) latitudeHiddenInput.value = '';
        if (longitudeHiddenInput) longitudeHiddenInput.value = '';
        if (selectedLatDisplay) selectedLatDisplay.textContent = 'N/A';
        if (selectedLonDisplay) selectedLonDisplay.textContent = 'N/A';
        if (mapCoordsFeedback) mapCoordsFeedback.style.display = 'none';
        if (mapSelectorDiv) mapSelectorDiv.style.borderColor = '#ccc';

        // Solo quita el marcador de la instancia actual y limpia la variable
        if (mapSelectorMarker) {
            mapSelectorMarker.setMap(null);
            mapSelectorMarker = null;
        }
        // NO destruir mapSelectorInstance aquí
    }

    // =========================================================================
    // Helper Functions - Data Table & Pagination
    // =========================================================================

    /**
     * Fetches data from the API and updates the table and pagination.
     */
    function fetchUbicaciones() {
        if (!tbody) {
             console.error("Elemento tbody para la tabla no encontrado.");
             return;
        }
        // Add loading state
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">Cargando...</td></tr>';
        if (paginationControlsDiv) paginationControlsDiv.innerHTML = '';
        if (paginationInfoSpan) paginationInfoSpan.textContent = '';

        const url = new URL(apiUrl, window.location.origin);
        url.searchParams.append('page', currentPage);
        url.searchParams.append('per_page', itemsPerPage);
        if (searchQuery) {
            url.searchParams.append('search', searchQuery);
        }

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                
                renderTableRows(data.data);
                renderPagination(data);
                updateFooterText(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error al cargar los datos.</td></tr>';
                 if (paginationControlsDiv) paginationControlsDiv.innerHTML = '';
                 if (paginationInfoSpan) paginationInfoSpan.textContent = '';
            });
    }


    
    /**
     * Renders the table rows based on the provided ubicaciones data.
     * @param {Array<object>} ubicaciones - Array of ubicacion objects.
     */
    function renderTableRows(ubicaciones) {
         if (!tbody) return;
         
        tbody.innerHTML = ''; // Clear current rows
        if (ubicaciones.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No se encontraron ubicaciones.</td></tr>';
            return;
        }

        ubicaciones.forEach(ubicacion => {
            
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>
                    <div class="flex flex-col gap-px">
                        <p class="leading-none font-medium text-sm text-gray-900 ">
                            ${ubicacion.nombre}
                        </p>
                    </div>
                </td>
                <td>${ubicacion.tipo.nombre}</td>
                <td>
                    <span class="badge ${ubicacion.destacada ? 'badge-success' : 'badge-light-danger'}">
                        ${ubicacion.destacada ? 'Sí' : 'No'}
                    </span>
                </td>
                <td>
                    <span class="badge badge-sm badge-outline ${ubicacion.estado === 'Activo' ? 'badge-success' : 'badge-danger'}">
                        ${ubicacion.estado}
                    </span>
                </td>
        
            `;

            const galeriaCell = document.createElement('td');
            galeriaCell.classList.add('text-center'); 
            const galeriaButton = document.createElement('button');
            galeriaButton.classList.add('btn', 'btn-3xl', 'btn-light-info', 'btn-icon');
            galeriaButton.title = `Abrir galería de ${ubicacion.nombre}`;
            galeriaButton.dataset.ubicacionId = ubicacion.id; 
            galeriaButton.dataset.ubicacionNombre = ubicacion.nombre; 
            galeriaButton.innerHTML = '<i class="ki-filled ki-picture"></i>';
            galeriaCell.appendChild(galeriaButton);
            row.appendChild(galeriaCell);

            const accionesCell = document.createElement('td');
            accionesCell.innerHTML = `
                 <button class="btn btn-sm btn-warning" title="Editar" onclick="window.editUbicacion(${ubicacion.id})">
                        <i class="ki-filled ki-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Eliminar" onclick="window.deleteUbicacion(${ubicacion.id})">
                        <i class="ki-filled ki-trash"></i>
                    </button>`;
            row.appendChild(accionesCell);


            tbody.appendChild(row);
            
        });

    }

    /**
     * Renders pagination controls based on the provided pagination data.
     * @param {object} paginationData - Pagination metadata from the API response (Laravel's paginate).
     */
    function renderPagination(paginationData) {
        if (!paginationControlsDiv) return;
        paginationControlsDiv.innerHTML = ''; // Clear current controls

        const { current_page, last_page, total } = paginationData;

        if (total === 0 || last_page <= 1) {
            return; // No pagination needed
        }

        // Previous Button
        const prevButton = document.createElement('button');
        prevButton.classList.add('btn');
        if (current_page === 1) {
            prevButton.classList.add('disabled');
            prevButton.disabled = true;
        }
        prevButton.innerHTML = '<i class="ki-outline ki-black-left"></i>';
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                fetchUbicaciones();
            }
        });
        paginationControlsDiv.appendChild(prevButton);

        // Page Number Buttons (simplified: first, last, and nearby pages)
        const maxPageButtons = 5;
        let startPage = Math.max(1, current_page - Math.floor(maxPageButtons / 2));
        const endPage = Math.min(last_page, startPage + maxPageButtons - 1);

         // Adjust startPage if we're near the end
         if (endPage - startPage + 1 < maxPageButtons) {
             const diff = maxPageButtons - (endPage - startPage + 1);
             startPage = Math.max(1, startPage - diff);
         }

        // First page button
        if (startPage > 1) {
            const firstPageButton = document.createElement('button');
            firstPageButton.classList.add('btn');
            firstPageButton.textContent = '1';
            firstPageButton.addEventListener('click', () => {
                currentPage = 1;
                fetchUbicaciones();
            });
            paginationControlsDiv.appendChild(firstPageButton);

            if (startPage > 2) {
                const ellipsis = document.createElement('span');
                ellipsis.classList.add('btn', 'disabled');
                ellipsis.textContent = '...';
                paginationControlsDiv.appendChild(ellipsis);
            }
        }

        // Page buttons
        for (let i = startPage; i <= endPage; i++) {
            const pageButton = document.createElement('button');
            pageButton.classList.add('btn');
            if (i === current_page) {
                pageButton.classList.add('active', 'disabled');
                pageButton.disabled = true;
            }
            pageButton.textContent = i;
            pageButton.addEventListener('click', () => {
                currentPage = i;
                fetchUbicaciones();
            });
            paginationControlsDiv.appendChild(pageButton);
        }

        // Last page button
        if (endPage < last_page) {
            if (endPage < last_page - 1) {
                const ellipsis = document.createElement('span');
                ellipsis.classList.add('btn', 'disabled');
                ellipsis.textContent = '...';
                paginationControlsDiv.appendChild(ellipsis);
            }
            const lastPageButton = document.createElement('button');
            lastPageButton.classList.add('btn');
            lastPageButton.textContent = last_page;
            lastPageButton.addEventListener('click', () => {
                currentPage = last_page;
                fetchUbicaciones();
            });
            paginationControlsDiv.appendChild(lastPageButton);
        }

        // Next Button
        const nextButton = document.createElement('button');
        nextButton.classList.add('btn');
        if (current_page === last_page) {
            nextButton.classList.add('disabled');
            nextButton.disabled = true;
        }
        nextButton.innerHTML = '<i class="ki-outline ki-black-right"></i>';
        nextButton.addEventListener('click', () => {
            if (currentPage < last_page) {
                currentPage++;
                fetchUbicaciones();
            }
        });
        paginationControlsDiv.appendChild(nextButton);
    }

    /**
     * Updates the pagination info text (e.g., "1-10 of 100").
     * @param {object} paginationData - Pagination metadata from the API response.
     */
    function updateFooterText(paginationData) {
        if (!paginationInfoSpan) return;
        const { current_page, per_page, total } = paginationData;

        if (total === 0) {
            paginationInfoSpan.textContent = '0-0 de 0';
            return;
        }

        const start = (current_page - 1) * per_page + 1;
        const end = Math.min(current_page * per_page, total);

        paginationInfoSpan.textContent = `${start}-${end} de ${total}`;
    }

     // =========================================================================
    // Helper Functions - Form Handling
    // =========================================================================
    /**
      * Fetches the list of location types from the API.
      * @returns {Promise<Array<object>>} A promise that resolves with the list of types.
      */
      async function fetchTypes() {
         try {
             const response = await fetch(typesApiUrl, {
                  headers: {
                      'Accept': 'application/json'
                  }
             });
             if (!response.ok) {
                 throw new Error(`HTTP error! status: ${response.status}`);
             }
             return await response.json();
         } catch (error) {
             console.error('Error fetching location types:', error);
             // Handle error, maybe disable the select or show a message
             if (tipoSelect) {
                 tipoSelect.innerHTML = '<option value="">Error cargando tipos</option>';
                 tipoSelect.disabled = true;
                 // No jQuery/Select2 specific update needed here, rely on native disabled state
             }
             throw error; // Re-throw to allow chaining .catch() if needed elsewhere
         }
     }

     /**
      * Populates the 'Tipo' select element with options.
      * @param {Array<object>} types - The list of type objects ({id, nombre}).
      */
     function populateTypesSelect(types) {
         if (!tipoSelect) return;

         // Clear existing options except the first placeholder (if present)
         // Check if the first option is a placeholder with no value
         const hasPlaceholder = tipoSelect.options.length > 0 && tipoSelect.options[0].value === '';

         // Remove all options after the potential placeholder
         while (tipoSelect.options.length > (hasPlaceholder ? 1 : 0)) {
             tipoSelect.remove(hasPlaceholder ? 1 : 0);
         }

         if (types && types.length > 0) {
             types.forEach(type => {
                 const option = document.createElement('option');
                 option.value = type.id;
                 option.textContent = type.nombre;
                 tipoSelect.appendChild(option);
             });
             tipoSelect.disabled = false; // Enable select if data loaded successfully

         } else if (!hasPlaceholder) {
              // If no types are returned and no placeholder exists, add a default 'no options' message
              const option = document.createElement('option');
              option.value = "";
              option.textContent = "No hay tipos disponibles";
              tipoSelect.appendChild(option);
              tipoSelect.disabled = true; // Disable if no options
         }

         // No jQuery/Select2 specific update needed here.
         // Metronic's initialization or handling on modal 'show' should update the display.
     }

    /**
     * Resets the form fields and state.
     */
    function resetForm() {
        if (!formUbicacion) return;
        formUbicacion.reset();
        editingUbicacionId = null;
        clearValidationErrors();

        // Reset ImageInput preview (manual fallback)
        const imageInputDiv = formUbicacion.querySelector('[data-image-input="true"]');
        if (imageInputDiv) {
            const previewElement = imageInputDiv.querySelector('.image-input-preview');
            const placeholderElement = imageInputDiv.querySelector('.image-input-placeholder');
            const removeBtn = imageInputDiv.querySelector('[data-image-input-remove]');
            const fileInput = imageInputDiv.querySelector('input[type="file"]');
            const removeHidden = imageInputDiv.querySelector('input[type="hidden"][name*="_remove"]');

            if (previewElement) previewElement.style.backgroundImage = '';
            imageInputDiv.classList.remove('image-input-changed');
             if (placeholderElement) placeholderElement.style.display = 'flex';
            if(removeBtn) removeBtn.style.display = 'none';
            if(fileInput) fileInput.value = '';
            if(removeHidden) removeHidden.value = '';
        }

        if (imagePreviewElement) {
            imagePreviewElement.src = defaultImageUrl;
        }
        if (imageUploadInput) {
            imageUploadInput.value = null; 
        }

        // Reset select elements (manual fallback)
        const selects = formUbicacion.querySelectorAll('select');
        selects.forEach(select => {
            // Avoid resetting the data table's perPageSelect if it happens to be in the form container
             if (select.id !== 'perPageSelect') {
                const defaultOption = select.querySelector('option[selected]') || select.querySelector('option[value=""]');
                if (defaultOption) {
                    select.value = defaultOption.value;
                } else if (select.options.length > 0) {
                    select.value = select.options[0].value;
                }
             }
        });

         // Reset map and coords display
        resetMapAndCoords();
    }

    /**
     * Clears any validation errors displayed on the form.
     * Includes clearing map validation feedback.
     */
    function clearValidationErrors() {
        if (!formUbicacion) return;

         // Clear standard input/select errors
        formUbicacion.querySelectorAll('.invalid-feedback').forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });
        formUbicacion.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        formUbicacion.querySelectorAll('.is-valid').forEach(el => {
            el.classList.remove('is-valid');
        });

         // Clear map specific errors
        if (mapCoordsFeedback) mapCoordsFeedback.style.display = 'none';
        if (mapSelectorDiv) mapSelectorDiv.style.borderColor = '#ccc'; // Reset border color

        // Remove text-danger class from labels
        formUbicacion.querySelectorAll('.form-label').forEach(label => {
            label.classList.remove('text-danger');
        });
    }

    // =========================================================================
    // Global Functions (called from HTML onclick)
    // =========================================================================

    /**
     * Handles the deletion of a ubicacion.
     * @param {number} id - The ID of the ubicacion to delete.
     */
    window.deleteUbicacion = function(id) {
        Swal.fire({
            title: '¿Estás seguro de eliminar esta ubicación?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/ubicaciones/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.status === 204) {
                        return {};
                    }
                    if (!response.ok) {
                         return response.json().then(err => { throw err; }).catch(() => {
                              throw new Error(`HTTP error! status: ${response.status}`);
                         });
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.fire(
                        '¡Eliminado!',
                        'La ubicación ha sido eliminada.',
                        'success'
                    );
                    fetchUbicaciones();
                })
                .catch(error => {
                    console.error('Error deleting ubicacion:', error);
                    const errorMessage = error.message || 'Ocurrió un error al eliminar.';
                    Swal.fire(
                        '¡Error!',
                        errorMessage,
                        'error'
                    );
                });
            }
        });
    }

    /**
     * Prepares the modal form for editing an existing ubicacion and shows the modal.
     * @param {number} id - The ID of the ubicacion to edit.
     */
     window.editUbicacion = function(id) {
        

        resetForm();
        editingUbicacionId = id;

        if (modalTitle) modalTitle.textContent = 'Editar Ubicación';
        if (submitButton) {
            submitButton.querySelector('.indicator-label').textContent = 'Guardar Cambios';
            submitButton.classList.remove('btn-primary');
            submitButton.classList.add('btn-warning');
        }

        fetch(`/ubicaciones/${id}`, {
             headers: {
                 'Accept': 'application/json'
             }
        })
        .then(response => {

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(ubicacion => {
            // Populate the form fields
            const nombreInput = document.getElementById('nombre');
            if(nombreInput) nombreInput.value = ubicacion.nombre || '';

            const tipoSelect = document.getElementById('tipo_id');
            if(tipoSelect) {
                 tipoSelect.value = ubicacion.tipo_id || '';
            }

            const estadoSelect = document.getElementById('estado');
            if(estadoSelect) {
                 estadoSelect.value = ubicacion.estado || 'Activo'; 
            }

            const destacadaSelect = document.getElementById('destacada');
            if(destacadaSelect) {
                 destacadaSelect.value = ubicacion.destacada ? '1' : '0';
            }

            const descripcionTextarea = document.getElementById('descripcion');
             if(descripcionTextarea) descripcionTextarea.value = ubicacion.descripcion || '';

             if (imagePreviewElement) { 
                console.log('xd');
                console.log(ubicacion.imagen_destacada);
                
                if (ubicacion.imagen_destacada && ubicacion.imagen_destacada.trim() !== '') {
                    console.log("Editando: Estableciendo src de imagen circular a:", ubicacion.imagen_destacada);
                    const imageUrl = ubicacion.imagen_destacada;
                    console.log("Editando: Estableciendo src de imagen circular a:", imageUrl);
                    imagePreviewElement.src = imageUrl;
                } else {
                   
                    console.log("Editando: No hay imagen_path, estableciendo src a default:", defaultImageUrl);
                    imagePreviewElement.src = defaultImageUrl;
                }
            } else {
                console.warn("#imagePreview element not found during edit setup.");
            }

            // Determine coordinates to show on the map when the modal opens
            const coordsToShowMap = (ubicacion.latitud && ubicacion.longitud) ?
                                    { lat: parseFloat(ubicacion.latitud), lng: parseFloat(ubicacion.longitud) } :
                                    defaultCoords;

            let modalElement = modalForm ? KTModal.getInstance(modalForm) : null;
             if (modalElement) {
                 modalElement._coordsToShowMap = coordsToShowMap;
                modalElement.show();
             } else {
                 console.error("Modal instance not found when trying to show for edit.");
             }

        })
        .catch(error => {
      
            console.error('Error fetching ubicacion for edit:', error);
            const errorMessage = error.message || 'Ocurrió un error al cargar los datos de la ubicación.';
            Swal.fire(
                '¡Error!',
                errorMessage,
                'error'
            );
            // Optionally hide the modal if it was opened empty
             let modalElement = modalForm ? KTModal.getInstance(modalForm) : null;
            if (modalElement) {
                modalElement.hide();
            }
        });
    }




    // =========================================================================
    // Helper Functions - Form Handling (Validación y Envío)
    // =========================================================================

    // (Mantén las funciones fetchTypes, populateTypesSelect, resetForm, clearValidationErrors aquí)

    /**
     * Performs client-side validation on the ubicacion form.
     * Adds Bootstrap/Metronic validation classes and feedback messages.
     * @returns {boolean} - True if the form is valid, false otherwise.
     */
     function validateForm() {
        if (!formUbicacion) return false; // Cannot validate if form element is missing

        clearValidationErrors(); // Clear previous errors

        let isValid = true;

        // --- Validate Nombre ---
        const nombreInput = document.getElementById('nombre');
        const nombreFeedback = nombreInput ? formUbicacion.querySelector('#nombre + .invalid-feedback') : null;
        if (nombreInput && nombreInput.value.trim() === '') {
            isValid = false;
            nombreInput.classList.add('is-invalid');
            if (nombreFeedback) {
                 nombreFeedback.textContent = 'El nombre es obligatorio.';
                 nombreFeedback.style.display = 'block';
            }
            // Find label and add text-danger class
             const nombreLabel = formUbicacion.querySelector('label[for="nombre"]');
             if (nombreLabel) nombreLabel.classList.add('text-danger');

        } else {
            if (nombreInput) {
                 nombreInput.classList.remove('is-invalid');
                 const nombreLabel = formUbicacion.querySelector('label[for="nombre"]');
                 if (nombreLabel) nombreLabel.classList.remove('text-danger');
            }
             if (nombreFeedback) nombreFeedback.style.display = 'none';
        }

        // --- Validate Tipo ---
        const tipoSelect = document.getElementById('tipo_id');
        const tipoFeedback = tipoSelect ? formUbicacion.querySelector('#tipo_id + .invalid-feedback') : null;
        if (tipoSelect && (tipoSelect.value === '' || tipoSelect.value === null)) {
   
            isValid = false;
            tipoSelect.classList.add('is-invalid');
            if (tipoFeedback) {
                 tipoFeedback.textContent = 'Debes seleccionar un tipo.';
                 tipoFeedback.style.display = 'block';
            }
            // Find label and add text-danger class
            const tipoLabel = formUbicacion.querySelector('label[for="tipo_id"]');
            if (tipoLabel) tipoLabel.classList.add('text-danger');

        } else {
             if (tipoSelect) {
                 tipoSelect.classList.remove('is-invalid');
                 const tipoLabel = formUbicacion.querySelector('label[for="tipo_id"]');
                 if (tipoLabel) tipoLabel.classList.remove('text-danger');
             }
             if (tipoFeedback) tipoFeedback.style.display = 'none';
        }


        // --- Validate Estado ---
        const estadoSelect = document.getElementById('estado');
         const estadoFeedback = estadoSelect ? formUbicacion.querySelector('#estado + .invalid-feedback') : null;
        if (estadoSelect && (estadoSelect.value === '' || estadoSelect.value === null)) {
            isValid = false;
            estadoSelect.classList.add('is-invalid');
            if (estadoFeedback) {
                 estadoFeedback.textContent = 'Debes seleccionar un estado.';
                 estadoFeedback.style.display = 'block';
            }
             // Find label and add text-danger class
             const estadoLabel = formUbicacion.querySelector('label[for="estado"]');
             if (estadoLabel) estadoLabel.classList.add('text-danger');

        } else {
             if (estadoSelect) {
                 estadoSelect.classList.remove('is-invalid');
                 const estadoLabel = formUbicacion.querySelector('label[for="estado"]');
                 if (estadoLabel) estadoLabel.classList.remove('text-danger');
             }
             if (estadoFeedback) estadoFeedback.style.display = 'none';
        }

        // --- Validate Coordinates ---
         if (mapSelectorDiv && latitudeHiddenInput && longitudeHiddenInput) {
            const latValue = latitudeHiddenInput.value;
            const lonValue = longitudeHiddenInput.value;

            if (latValue === '' || lonValue === '' || isNaN(parseFloat(latValue)) || isNaN(parseFloat(lonValue))) {
                isValid = false;
                mapSelectorDiv.style.borderColor = 'red';
                 if (mapCoordsFeedback) {
                      mapCoordsFeedback.textContent = 'Por favor, selecciona una ubicación en el mapa.'; 
                      mapCoordsFeedback.style.display = 'block';
                 }
       
                 const mapLabel = formUbicacion.querySelector('.form-label[for="mapSelector"]'); 
                 if (!mapLabel) {
                     
                      const labels = formUbicacion.querySelectorAll('.form-label');
                      for (const label of labels) {
                           if (label.textContent.includes('Selecciona la ubicación en el mapa')) {
                                mapLabel = label;
                                break;
                           }
                      }
                 }
                 if (mapLabel) mapLabel.classList.add('text-danger');

            } else {
                mapSelectorDiv.style.borderColor = '#ccc';
                if (mapCoordsFeedback) mapCoordsFeedback.style.display = 'none';
                 const mapLabel = formUbicacion.querySelector('.form-label.text-danger');
                  if (mapLabel) mapLabel.classList.remove('text-danger');
            }
         } else {
             console.error("Elementos del mapa no encontrados para validación de coordenadas.");
         }


        return isValid;
    }


    /**
     * Handles the form submission (create or update).
     * @param {Event} event - The submit event.
     */
    async function handleFormSubmit(event) {
        event.preventDefault(); // Prevent default form submission

        if (!validateForm()) {
            console.log("Validación fallida.");
            Swal.fire({
                 icon: 'error',
                 title: 'Error de validación',
                 text: 'Por favor, corrige los errores en el formulario.',
                 confirmButtonText: 'Entendido'
            });
            return; // Stop if validation fails
        }

        const submitButton = document.getElementById('submitButton');
         if (submitButton) {
            submitButton.setAttribute('data-kt-indicator', 'on'); // Show loading indicator
            submitButton.disabled = true; // Disable button
         }

        const formData = new FormData(formUbicacion);
        console.log('Archivo imagen:', formData.get('imagen_destacada')); 


        let method = 'POST';
        let url = '/ubicaciones';

        console.log("Ubicacion ID para edición:", editingUbicacionId);
        
        if (editingUbicacionId) {
            method = 'POST'; 
            url = `/ubicaciones/${editingUbicacionId}`;
            formData.append('_method', 'PUT');
        }

        const headers = {
            'Accept': 'application/json', 

        };

        if (csrfToken) {
             headers['X-CSRF-TOKEN'] = csrfToken;
        }


        try {
            const response = await fetch(url, {
                method: method,
                headers: headers,
                body: formData // FormData object includes file and all inputs
            });

            if (!response.ok) {
                
                if (response.status === 422) {
                    const errors = await response.json();
                    displayValidationErrors(errors.errors); 
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de validación',
                        text: 'Por favor, revisa los campos marcados.',
                        confirmButtonText: 'Entendido'
                    });
                   
                    return; 
                }
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json(); 

            Swal.fire(
                '¡Guardado!',
                `Ubicación ${editingUbicacionId ? 'actualizada' : 'creada'} correctamente.`,
                'success'
            );

            let modalElement = modalForm ? KTModal.getInstance(modalForm) : null;
            if (modalElement) {
                modalElement.hide(); 
            }

            fetchUbicaciones();

        } catch (error) {
            console.error('Error saving ubicacion:', error);
            const errorMessage = error.message || 'Ocurrió un error al guardar la ubicación.';
            Swal.fire(
                '¡Error!',
                errorMessage,
                'error'
            );
          
        } finally {
             if (submitButton) {
                 submitButton.removeAttribute('data-kt-indicator');
                 submitButton.disabled = false;
             }
        }
    }


     /**
      * Displays validation errors received from the backend API (status 422).
      * @param {object} errors - An object where keys are field names and values are arrays of error messages.
      */
     function displayValidationErrors(errors) {
          clearValidationErrors(); // Start fresh

          if (!errors) return;

          const fieldMap = {
               'nombre': { id: 'nombre', isMapCoord: false },
               'tipo_id': { id: 'tipo_id', isMapCoord: false },
               'estado': { id: 'estado', isMapCoord: false },
               'latitude': { id: 'latitudeHidden', isMapCoord: true },
               'longitude': { id: 'longitudeHidden', isMapCoord: true },
          };

          for (const fieldName in errors) {
               if (errors.hasOwnProperty(fieldName)) {
                    const fieldErrors = errors[fieldName];
                    const errorText = fieldErrors.join(', ');

                    const mappedField = fieldMap[fieldName];

                    if (mappedField) {
                         if (mappedField.isMapCoord) {
                            
                              if (mapSelectorDiv) mapSelectorDiv.style.borderColor = 'red';
                              if (mapCoordsFeedback) {
                                   mapCoordsFeedback.textContent = errorText;
                                   mapCoordsFeedback.style.display = 'block';
                              }
                             
                              const mapLabel = formUbicacion.querySelector('.form-label.text-danger');
                              if (!mapLabel) { 
                                   const labels = formUbicacion.querySelectorAll('.form-label');
                                   for (const label of labels) {
                                        if (label.textContent.includes('Selecciona la ubicación en el mapa')) {
                                             label.classList.add('text-danger');
                                             break;
                                        }
                                   }
                              }

                         } else {
                              
                              const inputElement = document.getElementById(mappedField.id);
                              if (inputElement) {
                                   inputElement.classList.add('is-invalid');
                                
                                   let feedbackElement = inputElement.nextElementSibling;
                                    while(feedbackElement && !feedbackElement.classList.contains('invalid-feedback')) {
                                         feedbackElement = feedbackElement.nextElementSibling;
                                    }
                    
                                    if (!feedbackElement) {
                                         feedbackElement = formUbicacion.querySelector(`#${mappedField.id} + .invalid-feedback`);
                                    }


                                   if (feedbackElement) {
                                        feedbackElement.textContent = errorText;
                                        feedbackElement.style.display = 'block';
                                   }

                                   const labelElement = formUbicacion.querySelector(`label[for="${mappedField.id}"]`);
                                   if (labelElement) labelElement.classList.add('text-danger');
                              } else {
                                  console.warn(`Validation error for unknown element ID: ${mappedField.id}`);
                              }
                         }
                    } else {
                        console.warn(`Backend validation error for unmapped field "${fieldName}": ${errorText}`);
                    }
               }
          }
     }



    // =========================================================================
    // ===> INICIO: Funciones para la Galería de Imágenes <===
    // =========================================================================

    /**
     * Construye la URL para una acción específica de la galería.
     * @param {number|string} ubicacionId El ID de la ubicación.
     * @param {number|string|null} [imageId=null] El ID de la imagen (para borrar).
     * @param {string|null} [action=null] Acción adicional ('reorder').
     * @returns {string} La URL completa.
     */
    function getGalleryApiUrl(ubicacionId, imageId = null, action = null) {
        let url = galleryBaseUrl.replace('{ubicacionId}', ubicacionId);
        if (imageId) {
            url += `/${imageId}`;
        }
        if (action) {
            url += `/${action}`;
        }
        return url;
    }

    /**
     * Abre el modal de la galería, carga las imágenes y configura el estado.
     * @param {number|string} ubicacionId El ID de la ubicación.
     * @param {string} ubicacionNombre El nombre de la ubicación.
     */
    async function openImageGallery(ubicacionId, ubicacionNombre) {
        currentGalleryUbicacionId = ubicacionId;
        currentGalleryImages = [];
        if (galleryUbicacionNombreSpan) galleryUbicacionNombreSpan.textContent = ubicacionNombre || 'Ubicación';
        galleryImageContainer.innerHTML = ''; 
        galleryLoadingIndicator.style.display = 'block'; 
        addGalleryImageInput.value = null; 
        galleryUploadIndicator.style.display = 'none'; 

       
        if (imageGalleryModal) {
            imageGalleryModal.classList.remove('hidden');
            requestAnimationFrame(() => {
                imageGalleryModal.classList.add('opacity-100');
                if (galleryModalContent) {
                    galleryModalContent.classList.remove('scale-95', 'opacity-0');
                    galleryModalContent.classList.add('scale-100', 'opacity-100');
                }
            });
        }

        try {
            const url = getGalleryApiUrl(ubicacionId);
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) {
                throw new Error(`Error al cargar galería: ${response.statusText}`);
            }
            let imagesData = await response.json();
            imagesData = imagesData.imagenes; 
            console.log("Datos de imágenes:", imagesData);
 
            currentGalleryImages = imagesData.sort((a, b) => (a.orden ?? 0) - (b.orden ?? 0));
            renderImageGallery(); 
        } catch (error) {
            console.error("Error fetching gallery images:", error);
            galleryImageContainer.innerHTML = `<p class="text-red-500 col-span-full text-center py-10">Error al cargar la galería.</p>`;
        } finally {
            galleryLoadingIndicator.style.display = 'none'; 
        }
    }

    /**
     * Cierra el modal de la galería y resetea el estado.
     */
    function closeImageGallery() {
        if (galleryModalContent) {
            galleryModalContent.classList.remove('scale-100', 'opacity-100');
            galleryModalContent.classList.add('scale-95', 'opacity-0');
        }
        if (imageGalleryModal) {
            imageGalleryModal.classList.remove('opacity-100');
            setTimeout(() => {
                imageGalleryModal.classList.add('hidden');
               
                currentGalleryUbicacionId = null;
                currentGalleryImages = [];
                galleryImageContainer.innerHTML = ''; 
                if (galleryUbicacionNombreSpan) galleryUbicacionNombreSpan.textContent = '';
            }, 300); 
        }
    }

    /**
     * Renderiza las tarjetas de imagen en el modal de la galería.
     */
    function renderImageGallery() {
        console.log('Renderizando galería de imágenes...');
        galleryImageContainer.innerHTML = ''; 

        if (currentGalleryImages.length === 0) {
            galleryImageContainer.innerHTML = '<p class="text-gray-500 col-span-full text-center py-10">Esta galería está vacía. ¡Agrega algunas imágenes!</p>';
            return;
        }

        currentGalleryImages.forEach((imageData, index) => {
            const imageId = imageData.id;
            const imageUrl = imageData.url.startsWith('http') ? imageData.url : `/storage/${imageData.url}`; 

            const card = document.createElement('div');
            card.className = 'relative border border-gray-200 rounded-lg shadow-sm overflow-hidden group cursor-move transition-transform duration-150 ease-in-out hover:shadow-md bg-white';
            card.setAttribute('draggable', true);
            card.dataset.imageId = imageId;
            card.dataset.index = index; 

            const img = document.createElement('img');
            img.src = imageUrl;
            img.alt = `Imagen ${index + 1}`;
            img.className = 'w-full h-auto object-cover aspect-square block';
            img.onerror = function() {
                this.onerror=null;
                this.src='https://placehold.co/150x150/cccccc/ffffff?text=Error';
                this.alt = 'Error al cargar imagen';
            };

            const deleteBtn = document.createElement('button');
            deleteBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>`;
            deleteBtn.className = 'absolute top-1.5 right-1.5 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 z-10'; // Añadir z-index
            deleteBtn.title = "Eliminar imagen";
            deleteBtn.setAttribute('aria-label', 'Eliminar imagen');
            deleteBtn.dataset.imageId = imageId;

            // Event Listener para eliminar (usando delegación o directo)
            deleteBtn.addEventListener('click', handleDeleteImageClick);

            // Event Listeners para Drag and Drop
            card.addEventListener('dragstart', handleGalleryDragStart);
            card.addEventListener('dragover', handleGalleryDragOver);
            card.addEventListener('dragenter', handleGalleryDragEnter);
            card.addEventListener('dragleave', handleGalleryDragLeave);
            card.addEventListener('drop', handleGalleryDrop);
            card.addEventListener('dragend', handleGalleryDragEnd);

            card.appendChild(img);
            card.appendChild(deleteBtn);
            galleryImageContainer.appendChild(card);
        });
    }

    /**
     * Maneja el clic en el botón de eliminar imagen.
     */
    async function handleDeleteImageClick(event) {
        event.stopPropagation();
        const button = event.currentTarget;
        const imageId = button.dataset.imageId;
        const ubicacionId = currentGalleryUbicacionId;

        if (!imageId || !ubicacionId) {
            console.error("Falta imageId o ubicacionId para eliminar.");
            return;
        }

        // Confirmación con Swal
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir la eliminación de esta imagen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminarla',
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                button.disabled = true; // Deshabilitar botón mientras se procesa
                button.innerHTML = '<svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>'; // Indicador

                try {
                    const url = `ubicaciones/${ubicacionId}/gallery/${imageId}`; // URL para eliminar imagen
                    const response = await fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        // Intentar obtener mensaje de error del backend
                        let errorMsg = `Error al eliminar la imagen (Status: ${response.status}).`;
                        try {
                            const errorData = await response.json();
                            errorMsg = errorData.message || errorMsg;
                        } catch (e) { /* Ignorar si no hay JSON */ }
                        throw new Error(errorMsg);
                    }

                    // Éxito: Eliminar del array local y re-renderizar
                    currentGalleryImages = currentGalleryImages.filter(img => img.id != imageId);
                    console.log(imageId);
                    
                    console.log(currentGalleryImages);
                    
                    renderImageGallery();
                    Swal.fire('¡Eliminada!', 'La imagen ha sido eliminada.', 'success');

                } catch (error) {
                    console.error("Error deleting image:", error);
                    Swal.fire('Error', error.message || 'No se pudo eliminar la imagen.', 'error');
                    // Restaurar botón en caso de error
                    button.disabled = false;
                     button.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>`;
                }
            }
        });
    }

    /**
     * Maneja la selección de un nuevo archivo para subir a la galería.
     */
    async function handleAddImageChange(event) {
        const file = event.target.files[0];
        const ubicacionId = currentGalleryUbicacionId;

        if (!file || !ubicacionId) {
            addGalleryImageInput.value = null;
            return;
        }

        if (!file.type.startsWith('image/')) {
            Swal.fire('Archivo no válido', 'Por favor, selecciona un archivo de imagen (JPG, PNG, GIF, etc.).', 'warning');
            addGalleryImageInput.value = null;
            return;
        }

        // Mostrar indicador de subida
        galleryUploadIndicator.style.display = 'block';
        addGalleryImageInput.disabled = true;

        const formData = new FormData();
        formData.append('image', file);

        try {
            const url = `ubicaciones/${ubicacionId}/gallery`; 
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!response.ok) {
                let errorMsg = `Error al subir la imagen (Status: ${response.status}).`;
                 try {
                     const errorData = await response.json();
                     // Manejar errores de validación específicos si el backend los devuelve
                     if (response.status === 422 && errorData.errors && errorData.errors.image) {
                        errorMsg = errorData.errors.image.join(', ');
                     } else {
                         errorMsg = errorData.message || errorMsg;
                     }
                 } catch (e) { /* Ignorar si no hay JSON */ }
                 throw new Error(errorMsg);
            }

            const newImageData = await response.json();

            currentGalleryImages.push(newImageData);
            currentGalleryImages.sort((a, b) => (a.orden ?? 0) - (b.orden ?? 0));

            renderImageGallery();

        } catch (error) {
            console.error("Error uploading image:", error);
            Swal.fire('Error', error.message || 'No se pudo subir la imagen.', 'error');
        } finally {
            // Ocultar indicador y rehabilitar input
            galleryUploadIndicator.style.display = 'none';
            addGalleryImageInput.value = null; // Limpiar el input
            addGalleryImageInput.disabled = false;
        }
    }

    /**
     * Guarda el nuevo orden de las imágenes en el backend.
     */
    async function saveImageOrder() {
        const ubicacionId = currentGalleryUbicacionId;
        if (!ubicacionId || currentGalleryImages.length === 0) {
            return; // No hay nada que guardar
        }

        // Crear un array solo con los IDs en el nuevo orden
        const orderedImageIds = currentGalleryImages.map(img => img.id);

        try {
            const url = `ubicaciones/${ubicacionId}/gallery/reorder`; 
            const response = await fetch(url, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ order: orderedImageIds })
            });

            if (!response.ok) {
                let errorMsg = `Error al guardar el orden (Status: ${response.status}).`;
                try {
                    const errorData = await response.json();
                    errorMsg = errorData.message || errorMsg;
                } catch (e) { /* Ignorar */ }
                throw new Error(errorMsg);
            }

            Swal.fire({ icon: 'success', title: 'Orden guardado', timer: 1500, showConfirmButton: false });

        } catch (error) {
            console.error("Error saving image order:", error);
            Swal.fire('Error', error.message || 'No se pudo guardar el nuevo orden de las imágenes.', 'error');

        } 
    }


    // --- Funciones de Drag and Drop para la Galería ---

    function handleGalleryDragStart(e) {
        galleryDraggedItem = this;
        galleryDragStartIndex = parseInt(this.dataset.index);
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', galleryDragStartIndex);
        setTimeout(() => this.classList.add('dragging'), 0);
    }

    function handleGalleryDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        return false;
    }

    function handleGalleryDragEnter(e) {
        if (this !== galleryDraggedItem) {
            this.classList.add('drag-over'); 
        }
    }

    function handleGalleryDragLeave(e) {
        this.classList.remove('drag-over');
    }

    function handleGalleryDrop(e) {
        e.stopPropagation();
        e.preventDefault();

        this.classList.remove('drag-over');

        if (galleryDraggedItem !== this) {
            const dropIndex = parseInt(this.dataset.index);
            const originalIndex = parseInt(e.dataTransfer.getData('text/plain'));

            const itemToMove = currentGalleryImages.splice(originalIndex, 1)[0];
            currentGalleryImages.splice(dropIndex, 0, itemToMove);

            renderImageGallery();

            saveImageOrder();
        }
        return false;
    }

    function handleGalleryDragEnd(e) {
    
        if(galleryDraggedItem) { 
            galleryDraggedItem.classList.remove('dragging');
        }
        document.querySelectorAll('#galleryImageContainer .drag-over').forEach(el => {
            el.classList.remove('drag-over');
        });

        galleryDraggedItem = null;
        galleryDragStartIndex = -1;
    }

    // ===> FIN: Funciones para la Galería de Imágenes <===


    // =========================================================================
    // DOM Ready
    // =========================================================================

    document.addEventListener('DOMContentLoaded',async  function () {

        // Initialize Metronic Modal components
        if (typeof KTModal !== 'undefined') {
             KTModal.init();
             KTModal.createInstances();
        } else {
             console.warn("KTModal is not defined. Modal functionality may not work as expected.");
        }

        // === Fetch and populate location types on page load ==
        if (tipoSelect) {
            tipoSelect.innerHTML = '<option value="">Seleccione un Tipo</option>';
            tipoSelect.disabled = true;

            try {
                const types = await fetchTypes();
                populateTypesSelect(types); 
            } catch (error) {
                console.error('Failed to load location types:', error);
               
            }
         } else {
              console.warn("Elemento #tipo_id no encontrado. No se cargarán los tipos.");
         }

        if (imageUploadInput && imagePreviewElement) {
            imageUploadInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreviewElement.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });

            imagePreviewElement.onerror = function() {
                if (imagePreviewElement.src !== defaultImageUrl) { 
                    imagePreviewElement.src = defaultImageUrl;
                }
            };

            imagePreviewElement.src = defaultImageUrl;

        } else {
            console.warn("Elementos de vista previa de imagen (#imagen_destacada_input o #imagePreview) no encontrados en DOMContentLoaded.");
        }
      

        let modalElement = modalForm ? KTModal.getInstance(modalForm) : null;

        if (modalElement) {
            modalElement.on('show', () => {
                // ESTA LÓGICA PARECE CORRECTA:
                const initialCoords = modalElement._coordsToShowMap ? modalElement._coordsToShowMap : defaultCoords;
                console.log("Modal 'show' event: Iniciando mapa con coords:", initialCoords);

                initMapSelector(initialCoords);
                delete modalElement._coordsToShowMap;
            });

            modalElement.on('hide', () => {
                console.log("Modal 'hide' event: Reseteando formulario y mapa.");
                resetForm();
            });

        } else {
            console.error("Elemento modal #createUbicacionModal no encontrado o instancia KTModal falló.");
        }

        // Add click listener to map div to clear validation feedback
        if (mapSelectorDiv) {
            mapSelectorDiv.addEventListener('click', () => {
                if (mapSelectorDiv.style.borderColor === 'red') {
                    mapSelectorDiv.style.borderColor = '#ccc';
                    if (mapCoordsFeedback) mapCoordsFeedback.style.display = 'none';
                }
            });
        }


        // --- Data Table & Pagination Event Listeners ---
        let debounceTimer;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    searchQuery = this.value;
                    currentPage = 1; 
                    fetchUbicaciones();
                }, 300);
            });
        } else {
             console.warn("Elemento #buscarUbicaciones no encontrado.");
        }


        // Per Page Select
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                itemsPerPage = parseInt(this.value);
                currentPage = 1; 
                fetchUbicaciones();
            });
        } else {
            console.warn("Elemento #perPageSelect no encontrado.");
        }


        // Initial fetch of data table data
        fetchUbicaciones();


        // === Add form submit listener ===
         if (formUbicacion) {
             formUbicacion.addEventListener('submit', handleFormSubmit);
        } else {
             console.error("Elemento form #formUbicacion no encontrado. No se puede añadir listener de submit.");
        }


        if (tbody) {
            tbody.addEventListener('click', function(event) {
                const galleryButton = event.target.closest('button[data-ubicacion-id]');
                if (galleryButton) {
                    const ubicacionId = galleryButton.dataset.ubicacionId;
                    const ubicacionNombre = galleryButton.dataset.ubicacionNombre;
                    openImageGallery(ubicacionId, ubicacionNombre);
                }
            });
        }

        if (closeGalleryModalBtn) {
            closeGalleryModalBtn.addEventListener('click', closeImageGallery);
        }


        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                if (imageGalleryModal && !imageGalleryModal.classList.contains('hidden')) {
                    closeImageGallery();
                }
                else if (ubicacionModalInstance && modalForm && !modalForm.classList.contains('hidden')) {
                if (getComputedStyle(modalForm).display !== 'none') {
                    ubicacionModalInstance.hide();
                }
                } else if (modalForm && !modalForm.classList.contains('hidden') && getComputedStyle(modalForm).display !== 'none'){
                    const bsModal = bootstrap.Modal.getInstance(modalForm);
                    if(bsModal) bsModal.hide();
                }
            }
        });


        if (addGalleryImageInput) {
            addGalleryImageInput.addEventListener('change', handleAddImageChange);
        }
    });

</script>


@endpush 