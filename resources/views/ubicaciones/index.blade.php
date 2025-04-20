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
                                                    <span class="sort-icon"></span>
                                                </span>
                                            </th>
                                            <th class="min-w-[150px]">
                                                <span class="sort">
                                                    <span class="sort-label">Tipo</span>
                                                    <span class="sort-icon"></span>
                                                </span>
                                            </th>
                                            <th class="min-w-[100px]">
                                                <span class="sort">
                                                    <span class="sort-label">Destacada</span>
                                                    <span class="sort-icon"></span>
                                                </span>
                                            </th>
                                            <th class="min-w-[100px]">
                                                <span class="sort">
                                                    <span class="sort-label">Estado</span>
                                                    <span class="sort-icon"></span>
                                                </span>
                                            </th>
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
                        <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-n5" data-bs-dismiss="modal" aria-label="Close">
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
                                    <option value="1">Tipo 1 (Ejemplo)</option>
                                    <option value="2">Tipo 2 (Ejemplo)</option>
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

                            <div class="md:col-span-2 flex flex-col justify-center items-center">
                                <label class="form-label self-start">Imagen Destacada</label>
                                <div class="image-input size-16" data-image-input="true">
                                    {{-- Asegúrate que el name="imagen_destacada" sea correcto --}}
                                    <input accept=".png, .jpg, .jpeg" name="imagen_destacada" type="file"/>
                                    <input name="imagen_destacada_remove" type="hidden"/>
                                    <div class="btn btn-icon btn-icon-xs btn-light shadow-default absolute z-1 size-5 -top-0.5 -right-0.5 rounded-full" data-image-input-remove="" data-tooltip="#image_input_tooltip" data-tooltip-trigger="hover">
                                        <i class="ki-outline ki-cross"></i>
                                    </div>
                                    <span class="tooltip" id="image_input_tooltip">Click para quitar</span>
                                    <div class="image-input-placeholder rounded-full border-2 border-success image-input-empty:border-gray-300" style="background-image:url(/static/metronic/tailwind/docs/dist/assets/media/avatars/blank.png)">
                                        <div class="image-input-preview rounded-full"></div>
                                        <div class="flex items-center justify-center cursor-pointer h-5 left-0 right-0 bottom-0 bg-dark-clarity absolute">
                                            <svg class="fill-light opacity-80" height="12" viewbox="0 0 14 12" width="14" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.6665 2.64585H11.2232C11.0873 2.64749 10.9538 2.61053 10.8382 2.53928C10.7225 2.46803 10.6295 2.36541 10.5698 2.24335L10.0448 1.19918C9.91266 0.931853 9.70808 0.707007 9.45438 0.550249C9.20068 0.393491 8.90806 0.311121 8.60984 0.312517H5.38984C5.09162 0.311121 4.799 0.393491 4.5453 0.550249C4.2916 0.707007 4.08701 0.931853 3.95484 1.19918L3.42984 2.24335C3.37021 2.36541 3.27716 2.46803 3.1615 2.53928C3.04584 2.61053 2.91234 2.64749 2.7765 2.64585H2.33317C1.90772 2.64585 1.49969 2.81486 1.19885 3.1157C0.898014 3.41654 0.729004 3.82457 0.729004 4.25002V10.0834C0.729004 10.5088 0.898014 10.9168 1.19885 11.2177C1.49969 11.5185 1.90772 11.6875 2.33317 11.6875H11.6665C12.092 11.6875 12.5 11.5185 12.8008 11.2177C13.1017 10.9168 13.2707 10.5088 13.2707 10.0834V4.25002C13.2707 3.82457 13.1017 3.41654 12.8008 3.1157C12.5 2.81486 12.092 2.64585 11.6665 2.64585ZM6.99984 9.64585C6.39413 9.64585 5.80203 9.46624 5.2984 9.12973C4.79478 8.79321 4.40225 8.31492 4.17046 7.75532C3.93866 7.19572 3.87802 6.57995 3.99618 5.98589C4.11435 5.39182 4.40602 4.84613 4.83432 4.41784C5.26262 3.98954 5.80831 3.69786 6.40237 3.5797C6.99644 3.46153 7.61221 3.52218 8.1718 3.75397C8.7314 3.98576 9.2097 4.37829 9.54621 4.88192C9.88272 5.38554 10.0623 5.97765 10.0623 6.58335C10.0608 7.3951 9.73765 8.17317 9.16365 8.74716C8.58965 9.32116 7.81159 9.64431 6.99984 9.64585Z" fill=""></path>
                                                <path d="M7 8.77087C8.20812 8.77087 9.1875 7.7915 9.1875 6.58337C9.1875 5.37525 8.20812 4.39587 7 4.39587C5.79188 4.39587 4.8125 5.37525 4.8125 6.58337C4.8125 7.7915 5.79188 8.77087 7 8.77087Z" fill=""></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
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
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        {{-- Botón de submit con indicador de carga (Metronic) --}}
                        <button type="submit" id="submitButton" class="btn btn-primary">
                            <span class="indicator-label">Guardar Ubicación</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- Incluye esto en tu @push('scripts') o al final del body --}}
@push('scripts') 
{{-- 1. Carga la API de Google Maps (REEMPLAZA TU_API_KEY) --}}
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
    let itemsPerPage = parseInt(perPageSelect ? perPageSelect.value : 10); // Default to 10 if select not found
    let searchQuery = '';

    // --- Default Map Coords/Zoom (Girardot - Peñon) ---
    const defaultCoords = { lat: 4.316756, lng: -74.771513 };
    const defaultZoom = 15;

     // --- API Endpoint for Types ---
     const typesApiUrl = '/tipoUbi/all';



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

        mapSelectorDiv.innerHTML = ''; // Clear loading message

        if (!mapSelectorInstance) {
            const mapOptions = {
                zoom: defaultZoom,
                center: initialCoords,
                mapTypeId: 'roadmap',
                streetViewControl: false,
                fullscreenControl: false,
                mapTypeControl: false,
                scaleControl: false,
                rotateControl: false,
                zoomControl: true,
                styles: [{ featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] }] // Hide points of interest
            };
            mapSelectorInstance = new google.maps.Map(mapSelectorDiv, mapOptions);

            // Listener for map click to place marker
            mapSelectorInstance.addListener("click", (event) => {
                placeSelectorMarkerAndUpdateFields(event.latLng);
            });
        } else {
            mapSelectorInstance.setCenter(initialCoords);
            mapSelectorInstance.setZoom(defaultZoom);
        }

        // Place initial marker if coords are provided (for editing)
        if (initialCoords.lat !== defaultCoords.lat || initialCoords.lng !== defaultCoords.lng) {
            placeSelectorMarkerAndUpdateFields(initialCoords, true);
        } else {
            if (mapSelectorMarker) {
                mapSelectorMarker.setMap(null); // Remove existing marker
                mapSelectorMarker = null;
            }
        }

        // Trigger resize to ensure map displays correctly in modal
        google.maps.event.trigger(mapSelectorInstance, 'resize');
        mapSelectorInstance.setCenter(initialCoords); // Set center again after resize
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

        // Get lat and lng values, handling both function (google.maps.LatLng) and property access
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

         // Ensure lat and lng are valid numbers before proceeding
         if (isNaN(lat) || isNaN(lng)) {
              console.warn("Coordenadas calculadas no son números válidos:", { lat, lng });
              return;
         }


        // The rest of the function logic remains the same, using the extracted `lat` and `lng` variables.
        // Now, use the extracted `lat` and `lng` values
        const position = new google.maps.LatLng(lat, lng); // Create a LatLng object for the marker
        if (mapSelectorInstance) { // Ensure map instance exists before adding marker
             if (mapSelectorMarker === null) {
                 mapSelectorMarker = new google.maps.Marker({
                     position: position, // Use the new position object
                     map: mapSelectorInstance,
                     draggable: true,
                     title: "Ubicación seleccionada (arrastra para ajustar)"
                 });

                 // Listener for marker drag end
                 mapSelectorMarker.addListener('dragend', (event) => {
                     if (event.latLng) {
                         // The dragend event provides a google.maps.LatLng object
                         placeSelectorMarkerAndUpdateFields(event.latLng);
                     }
                 });

             } else {
                 mapSelectorMarker.setPosition(position); // Use the new position object
             }
        } else {
             console.warn("No se pudo colocar el marcador: la instancia del mapa no existe.");
             return; // Can't place marker without a map
        }


        if (updateHiddenFields) {
            if (latitudeHiddenInput) latitudeHiddenInput.value = lat;
            if (longitudeHiddenInput) longitudeHiddenInput.value = lng;
            if (selectedLatDisplay) selectedLatDisplay.textContent = lat.toFixed(6);
            if (selectedLonDisplay) selectedLonDisplay.textContent = lng.toFixed(6);

            // Clear map validation feedback
            if (mapCoordsFeedback && mapCoordsFeedback.style.display === 'block') {
                mapCoordsFeedback.style.display = 'none';
            }
            if (mapSelectorDiv && mapSelectorDiv.style.borderColor === 'red') {
                mapSelectorDiv.style.borderColor = '#ccc';
            }
        }
    }

    /**
     * Resets the map and associated coordinate fields to default state.
     */
    function resetMapAndCoords() {
        if (latitudeHiddenInput) latitudeHiddenInput.value = '';
        if (longitudeHiddenInput) longitudeHiddenInput.value = '';
        if (selectedLatDisplay) selectedLatDisplay.textContent = 'N/A';
        if (selectedLonDisplay) selectedLonDisplay.textContent = 'N/A';
        if (mapCoordsFeedback) mapCoordsFeedback.style.display = 'none';
        if (mapSelectorDiv) mapSelectorDiv.style.borderColor = '#ccc';
        if (mapSelectorMarker) {
            mapSelectorMarker.setMap(null);
            mapSelectorMarker = null;
        }

        if (mapSelectorInstance) {
            mapSelectorInstance.setCenter(defaultCoords);
            mapSelectorInstance.setZoom(defaultZoom);
        }
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
                 <td>
                    <button class="btn btn-sm btn-warning" title="Editar" onclick="window.editUbicacion(${ubicacion.id})">
                        <i class="ki-filled ki-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Eliminar" onclick="window.deleteUbicacion(${ubicacion.id})">
                        <i class="ki-filled ki-trash"></i>
                    </button>
                </td>
            `;

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
                fetch(`/ubicaciones/${id}`, { // Use direct API URL
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.status === 204) {
                        return {}; // Handle 204 No Content
                    }
                    if (!response.ok) {
                         // Attempt to parse JSON error response
                         return response.json().then(err => { throw err; }).catch(() => {
                              // Fallback to generic error if JSON parsing fails
                              throw new Error(`HTTP error! status: ${response.status}`);
                         });
                    }
                    return response.json(); // For other success statuses
                })
                .then(data => {
                    Swal.fire(
                        '¡Eliminado!',
                        'La ubicación ha sido eliminada.',
                        'success'
                    );
                    fetchUbicaciones(); // Refresh the table
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
        editingUbicacionId = id;

        resetForm(); // Reset form and validation state

        if (modalTitle) modalTitle.textContent = 'Editar Ubicación';
        if (submitButton) {
            submitButton.querySelector('.indicator-label').textContent = 'Guardar Cambios';
            submitButton.classList.remove('btn-primary');
            submitButton.classList.add('btn-warning');
        }

        // Add loading indicator to button or form if desired
        // submitButton.setAttribute('data-kt-indicator', 'on');
        // submitButton.disabled = true;


        fetch(`/ubicaciones/${id}`, { // Use direct API URL
             headers: {
                 'Accept': 'application/json'
             }
        })
        .then(response => {
            // submitButton.removeAttribute('data-kt-indicator'); // Hide loading
            // submitButton.disabled = false;
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
                 // If using a library like Select2, trigger change: $(tipoSelect).trigger('change');
            }

            const estadoSelect = document.getElementById('estado');
            if(estadoSelect) {
                 estadoSelect.value = ubicacion.estado || 'Activo'; // Default to 'Activo' if null
            }

            const destacadaSelect = document.getElementById('destacada');
            if(destacadaSelect) {
                 destacadaSelect.value = ubicacion.destacada ? '1' : '0';
            }

            const descripcionTextarea = document.getElementById('descripcion');
             if(descripcionTextarea) descripcionTextarea.value = ubicacion.descripcion || '';

            // Handle image preview (manual fallback)
             const imageInputDiv = formUbicacion.querySelector('[data-image-input="true"]');
             if (imageInputDiv) {
                  const previewElement = imageInputDiv.querySelector('.image-input-preview');
                  const placeholderElement = imageInputDiv.querySelector('.image-input-placeholder');
                  const removeBtn = imageInputDiv.querySelector('[data-image-input-remove]');

                  if (ubicacion.imagen_path) {
                       const imageUrl = '/storage/' + ubicacion.imagen_path; // Adjust URL path if needed
                       if (previewElement) previewElement.style.backgroundImage = `url(${imageUrl})`;
                       imageInputDiv.classList.add('image-input-changed');
                        if (placeholderElement) placeholderElement.style.display = 'none';
                       if(removeBtn) removeBtn.style.display = 'flex';
                  } else {
                       // Reset to placeholder state
                       if (previewElement) previewElement.style.backgroundImage = '';
                       imageInputDiv.classList.remove('image-input-changed');
                        if (placeholderElement) placeholderElement.style.display = 'flex';
                       if(removeBtn) removeBtn.style.display = 'none';
                  }
             }

            // Determine coordinates to show on the map when the modal opens
            const coordsToShowMap = (ubicacion.latitud && ubicacion.longitud) ?
                                    { lat: parseFloat(ubicacion.latitud), lng: parseFloat(ubicacion.longitud) } :
                                    defaultCoords;

            // Store coordinates temporarily on the modal element.
            // The modal's 'show' listener will read this and initialize the map.
            let modalElement = modalForm ? KTModal.getInstance(modalForm) : null;
             if (modalElement) {
                 modalElement._coordsToShowMap = coordsToShowMap; // Store coords
                modalElement.show(); // Show the modal
             } else {
                 console.error("Modal instance not found when trying to show for edit.");
             }

        })
        .catch(error => {
             // submitButton.removeAttribute('data-kt-indicator'); // Hide loading
             // submitButton.disabled = false;
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
             // Note: Select2 adds a hidden select and wraps the original. Validation
             // should target the original select element.
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
        // Check if mapSelectorDiv and the hidden inputs exist before validating map coords
         if (mapSelectorDiv && latitudeHiddenInput && longitudeHiddenInput) {
            const latValue = latitudeHiddenInput.value;
            const lonValue = longitudeHiddenInput.value;

            if (latValue === '' || lonValue === '' || isNaN(parseFloat(latValue)) || isNaN(parseFloat(lonValue))) {
                isValid = false;
                mapSelectorDiv.style.borderColor = 'red';
                 if (mapCoordsFeedback) {
                      mapCoordsFeedback.textContent = 'Por favor, selecciona una ubicación en el mapa.'; // Match HTML message
                      mapCoordsFeedback.style.display = 'block';
                 }
                  // Find the label for the map section and add text-danger class
                 const mapLabel = formUbicacion.querySelector('.form-label[for="mapSelector"]'); // Assuming you might add a 'for' or similar
                 if (!mapLabel) {
                      // Fallback: find the label text "Selecciona la ubicación en el mapa:"
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
                mapSelectorDiv.style.borderColor = '#ccc'; // Reset border
                if (mapCoordsFeedback) mapCoordsFeedback.style.display = 'none';
                 const mapLabel = formUbicacion.querySelector('.form-label.text-danger'); // Remove if it was added
                  if (mapLabel) mapLabel.classList.remove('text-danger'); // Use a more specific selector if needed
            }
         } else {
             // If map elements are missing, maybe show a console error, but don't fail validation
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

        // Create FormData object to easily include files and other form data
        const formData = new FormData(formUbicacion);

        let method = 'POST';
        let url = '/ubicaciones'; // Endpoint for creation

        // If editing, change method and URL
        if (editingUbicacionId) {
            method = 'POST'; // Use POST for FormData with _method=PUT
            url = `/ubicaciones/${editingUbicacionId}`; // Endpoint for update
            formData.append('_method', 'PUT'); // Laravel convention for PUT/PATCH requests via form
        }

        // Include CSRF token in headers for non-FormData POST/PUT,
        // but FormData already handles standard form fields including the @csrf input.
        // Adding it to headers is belt-and-suspenders and fine.
        const headers = {
            'Accept': 'application/json', // Expect JSON response
             // No 'Content-Type': 'multipart/form-data' header when using FormData; fetch sets it automatically
        };

        // Add CSRF token to headers if available
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
                 // Handle validation errors (status 422) specifically
                 if (response.status === 422) {
                      const errors = await response.json();
                      displayValidationErrors(errors.errors); // Call a new function to display errors
                      Swal.fire({
                           icon: 'error',
                           title: 'Error de validación',
                           text: 'Por favor, revisa los campos marcados.',
                           confirmButtonText: 'Entendido'
                      });
                      // Do NOT hide the modal on validation errors
                      return; // Stop here
                 }
                 // Handle other HTTP errors
                 throw new Error(`HTTP error! status: ${response.status}`);
            }

            // Handle success response
            const result = await response.json(); // Or response.text() if your backend doesn't return JSON on success

            Swal.fire(
                '¡Guardado!',
                `Ubicación ${editingUbicacionId ? 'actualizada' : 'creada'} correctamente.`,
                'success'
            );

            // Hide the modal
            let modalElement = modalForm ? KTModal.getInstance(modalForm) : null;
            if (modalElement) {
                modalElement.hide(); // This will also trigger the 'hide' listener and resetForm()
            }

            // Refresh the data table
            fetchUbicaciones();

        } catch (error) {
            console.error('Error saving ubicacion:', error);
            const errorMessage = error.message || 'Ocurrió un error al guardar la ubicación.';
            Swal.fire(
                '¡Error!',
                errorMessage,
                'error'
            );
             // Do NOT hide the modal on general errors, user might want to retry
        } finally {
            // Hide loading indicator and re-enable button in all cases (success, validation error, other error)
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

          // Map backend field names to frontend input IDs/handling
          const fieldMap = {
               'nombre': { id: 'nombre', isMapCoord: false },
               'tipo_id': { id: 'tipo_id', isMapCoord: false },
               'estado': { id: 'estado', isMapCoord: false },
               'latitude': { id: 'latitudeHidden', isMapCoord: true }, // Map coords to their hidden inputs
               'longitude': { id: 'longitudeHidden', isMapCoord: true },
               // Add other fields here if needed
          };

          for (const fieldName in errors) {
               if (errors.hasOwnProperty(fieldName)) {
                    const fieldErrors = errors[fieldName]; // Array of messages for this field
                    const errorText = fieldErrors.join(', '); // Join multiple messages

                    const mappedField = fieldMap[fieldName];

                    if (mappedField) {
                         if (mappedField.isMapCoord) {
                              // Handle map coordinate errors
                              if (mapSelectorDiv) mapSelectorDiv.style.borderColor = 'red';
                              if (mapCoordsFeedback) {
                                   mapCoordsFeedback.textContent = errorText;
                                   mapCoordsFeedback.style.display = 'block';
                              }
                              // Also mark the map label if you added text-danger in validateForm
                              const mapLabel = formUbicacion.querySelector('.form-label.text-danger'); // Find if it was already marked
                              if (!mapLabel) { // If not already marked (e.g., no client-side validation ran)
                                   const labels = formUbicacion.querySelectorAll('.form-label');
                                   for (const label of labels) {
                                        if (label.textContent.includes('Selecciona la ubicación en el mapa')) {
                                             label.classList.add('text-danger');
                                             break;
                                        }
                                   }
                              }

                         } else {
                              // Handle standard input/select errors
                              const inputElement = document.getElementById(mappedField.id);
                              if (inputElement) {
                                   inputElement.classList.add('is-invalid');
                                   // Find the feedback element (assuming it's sibling or nearby)
                                   let feedbackElement = inputElement.nextElementSibling;
                                    while(feedbackElement && !feedbackElement.classList.contains('invalid-feedback')) {
                                         feedbackElement = feedbackElement.nextElementSibling;
                                    }
                                   // If not found as sibling, try searching within the form
                                    if (!feedbackElement) {
                                         feedbackElement = formUbicacion.querySelector(`#${mappedField.id} + .invalid-feedback`);
                                    }


                                   if (feedbackElement) {
                                        feedbackElement.textContent = errorText;
                                        feedbackElement.style.display = 'block';
                                   }

                                   // Add text-danger class to the label
                                   const labelElement = formUbicacion.querySelector(`label[for="${mappedField.id}"]`);
                                   if (labelElement) labelElement.classList.add('text-danger');
                              } else {
                                  console.warn(`Validation error for unknown element ID: ${mappedField.id}`);
                              }
                         }
                    } else {
                         // Handle errors for fields not explicitly mapped (e.g., 'imagen_destacada')
                         // For file input, Metronic's ImageInput might need specific error handling.
                         // A general approach is to log or show a generic message.
                         console.warn(`Backend validation error for unmapped field "${fieldName}": ${errorText}`);
                         // You might want to show a general error message for unmapped fields
                         // or try to find the relevant part of the form to highlight.
                    }
               }
          }
     }
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

        // Get modal instance and set up show listener for map initialization
        let modalElement = modalForm ? KTModal.getInstance(modalForm) : null;

        if (modalElement) {
            modalElement.on('show', () => {
                // Use coordinates stored during edit preparation, or default coords
                const initialCoords = (modalElement._coordsToShowMap) ? modalElement._coordsToShowMap : defaultCoords;
                initMapSelector(initialCoords);
                 // Clear the temporary coords after use
                 delete modalElement._coordsToShowMap;
            });

             // Add listener for modal hide to reset the form
             modalElement.on('hide', () => {
                  resetForm();
             });

        } else {
            console.error("Elemento modal #createUbicacionModal no encontrado o KTModal instance failed.");
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

        // Search Input (with debounce)
        let debounceTimer;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    searchQuery = this.value;
                    currentPage = 1; // Reset to first page on new search
                    fetchUbicaciones();
                }, 300); // 300ms delay
            });
        } else {
             console.warn("Elemento #buscarUbicaciones no encontrado.");
        }


        // Per Page Select
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                itemsPerPage = parseInt(this.value);
                currentPage = 1; // Reset to first page on per-page change
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
    });

</script>


@endpush 