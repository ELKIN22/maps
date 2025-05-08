<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ubicacion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\ImagenUbicacion;
use Illuminate\Validation\Rule;
use App\Models\TipoUbi;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UbicacionesController extends Controller
{

    /**
     * Prefix used for public storage URLs.
     * @var string
     */
    private const STORAGE_URL_PREFIX = '/storage/';

    /**
         * Get the relative storage path from a potentially prefixed URL path.
         *
         * @param string|null $path The full URL path (e.g., /storage/ubicaciones/file.jpg) or null.
         * @return string|null The relative path (e.g., ubicaciones/file.jpg) or null.
    */
    private function getRelativePath(?string $path): ?string
    {
        if ($path && Str::startsWith($path, self::STORAGE_URL_PREFIX)) {
            return Str::substr($path, Str::length(self::STORAGE_URL_PREFIX));
        }
        return $path;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10); 

        $query = Ubicacion::with('tipo');


        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', '%' . $search . '%');
            });
        }

        $ubicaciones = $query->paginate($perPage);

        return response()->json($ubicaciones);
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'tipo_id' => ['required', 'integer', Rule::exists('tipos_ubicacion', 'id')],
            'destacada' => ['required', 'boolean'],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['required', 'string', Rule::in(['Activo', 'Inactivo'])],
            'imagen_destacada' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $latitude = number_format((float) $validatedData['latitude'], 6, '.', '');
        $longitude = number_format((float) $validatedData['longitude'], 6, '.', '');

        $imagePathWithPrefix = null; 
        if ($request->hasFile('imagen_destacada')) {
            $relativePath = $request->file('imagen_destacada')->store('ubicaciones', 'public');
            if ($relativePath) {
                $imagePathWithPrefix = self::STORAGE_URL_PREFIX . $relativePath;
            }
        }

        $ubicacion = Ubicacion::create([
            'nombre' => $validatedData['nombre'],
            'latitud' => $latitude,
            'longitud' => $longitude,
            'tipo_id' => $validatedData['tipo_id'],
            'destacada' => (bool) $validatedData['destacada'],
            'descripcion' => $validatedData['descripcion'] ?? null,
            'estado' => $validatedData['estado'],
            'imagen_destacada' => $imagePathWithPrefix,
        ]);

        return response()->json($ubicacion, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Ubicacion::with('tipo','imagenes')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id){
         $ubicacion = Ubicacion::find($id);

         if (!$ubicacion) {
             return response()->json(['message' => 'Ubicación no encontrada'], 404);
         }

        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'tipo_id' => ['required', 'integer', Rule::exists('tipos_ubicacion', 'id')],
            'destacada' => ['required', 'boolean'],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['required', 'string', Rule::in(['Activo', 'Inactivo'])],
            'imagen_destacada' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'imagen_destacada_remove' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $currentImagePathWithPrefix = $ubicacion->imagen_destacada; // Already has /storage/ or is null
        $newImagePathWithPrefix = $currentImagePathWithPrefix; // Default to current

        // --- Image Handling ---
        $relativePathToDelete = $this->getRelativePath($currentImagePathWithPrefix); // Get relative path for deletion

        if ($request->hasFile('imagen_destacada')) {
            // Delete old image if exists
            if ($relativePathToDelete && Storage::disk('public')->exists($relativePathToDelete)) {
                Storage::disk('public')->delete($relativePathToDelete);
            }
            // Store new image and create path with prefix
            $newRelativePath = $request->file('imagen_destacada')->store('ubicaciones', 'public');
            $newImagePathWithPrefix = $newRelativePath ? self::STORAGE_URL_PREFIX . $newRelativePath : null;

        } elseif ($request->input('imagen_destacada_remove') == 1 || $request->input('imagen_destacada_remove') === true) {
             // Delete old image if exists
            if ($relativePathToDelete && Storage::disk('public')->exists($relativePathToDelete)) {
                Storage::disk('public')->delete($relativePathToDelete);
            }
            $newImagePathWithPrefix = null; // Set path to null for removal
        }
        // --- End Image Handling ---

        $latitude = number_format((float) $validatedData['latitude'], 6, '.', '');
        $longitude = number_format((float) $validatedData['longitude'], 6, '.', '');

        $ubicacion->fill([
            'nombre' => $validatedData['nombre'],
            'latitud' => $latitude,
            'longitud' => $longitude, // Corrected: use $longitude
            'tipo_id' => $validatedData['tipo_id'],
            'destacada' => (bool) $validatedData['destacada'],
            'descripcion' => $validatedData['descripcion'] ?? null,
            'estado' => $validatedData['estado'],
            'imagen_destacada' => $newImagePathWithPrefix, // Store path WITH prefix or null
        ]);

        $ubicacion->save();
        $ubicacion->load('tipo');
        return response()->json($ubicacion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ubicacion = Ubicacion::find($id);

        if (!$ubicacion) {
            return response()->json(['message' => 'Ubicación no encontrada'], 404);
        }

        if ($ubicacion->imagen_destacada && Storage::disk('public')->exists($ubicacion->imagen_destacada)) {
            Storage::disk('public')->delete($ubicacion->imagen_destacada);
        }

        $ubicacion->delete();
        return response()->noContent();
    }


    public function buscarUbicaciones(string $busqueda)
    {
     
        $busqueda = trim($busqueda);
    
        if ($busqueda === '') {
            return response()->json([]);
        }
    
        $ubicaciones = Ubicacion::with('tipo','imagenes')->when($busqueda === '@', function ($query) {
                $query->where('destacada', true);
            }, function ($query) use ($busqueda) {
                $query->where('nombre', 'LIKE', "%{$busqueda}%");
            })
            ->limit(25)
            ->get();
    
        return response()->json($ubicaciones);
    }


     /**
     * Almacena una nueva imagen para la galería de una ubicación específica.
     * Ruta: POST /ubicaciones/{ubicacion}/gallery
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ubicacion  $ubicacion (Inyectado por Route Model Binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function galleryStore(Request $request, Ubicacion $ubicacion)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error de validación.', 'errors' => $validator->errors()], 422);
        }

        try {
            $imageFile = $request->file('image');
            $directory = "ubicacion_imagenes/{$ubicacion->id}"; 
            $filename = Str::uuid() . '.' . $imageFile->getClientOriginalExtension();

          
            $relativePath = $imageFile->storeAs($directory, $filename, 'public');

            if (!$relativePath) {
                 throw new \Exception("No se pudo guardar la imagen en el almacenamiento.");
            }

            $maxOrder = ImagenUbicacion::where('ubicacion_id', $ubicacion->id)
                                        ->select(DB::raw('COALESCE(MAX(orden), 0) as max_orden'))
                                        ->value('max_orden');
            $nextOrder = $maxOrder + 1;

            $imagenUbicacion = ImagenUbicacion::create([
                'ubicacion_id' => $ubicacion->id,
                'url' => $relativePath, 
                'orden' => $nextOrder,
            ]);

            $publicUrl = Storage::disk('public')->url($relativePath);

            return response()->json([
                'id' => $imagenUbicacion->id,
                'url' => $publicUrl, 
                'orden' => $imagenUbicacion->orden,
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno al guardar la imagen.'], 500);
        }
    }

    /**
     * Elimina una imagen específica de la galería de una ubicación.
     * Ruta: DELETE /ubicaciones/{ubicacion}/gallery/{imagen}
     *
     * @param  \App\Models\Ubicacion  $ubicacion (Inyectado)
     * @param  \App\Models\ImagenUbicacion  $imagen (Inyectado)
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function galleryDestroy(Ubicacion $ubicacion, ImagenUbicacion $imagen)
    {
        if ($imagen->ubicacion_id !== $ubicacion->id) {
            return response()->json(['message' => 'Acceso denegado: La imagen no pertenece a esta ubicación.'], 403);
        }

        try {
            $relativePath = $imagen->url;

            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            } else {
                Log::warning("Archivo de galería no encontrado para eliminar (Imagen ID: {$imagen->id}): " . $relativePath);
            }

            $imagen->delete();

            return response()->noContent();

        } catch (\Exception $e) {

            return response()->json(['message' => 'Error interno al eliminar la imagen.'], 500);
        }
    }

    /**
     * Reordena las imágenes de la galería de una ubicación.
     * Ruta: PUT /ubicaciones/{ubicacion}/gallery/reorder
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ubicacion  $ubicacion (Inyectado)
     * @return \Illuminate\Http\JsonResponse
     */
    public function galleryReorder(Request $request, Ubicacion $ubicacion)
    {
        // 1. Validar entrada: array 'order' con IDs existentes que pertenezcan a la ubicación
        $validator = Validator::make($request->all(), [
            'order' => 'required|array',
            'order.*' => [
               'required',
               'integer',
               Rule::exists('imagenes_ubicacion', 'id')->where(function ($query) use ($ubicacion) {
                   $query->where('ubicacion_id', $ubicacion->id);
               }),
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Datos de orden inválidos.', 'errors' => $validator->errors()], 422);
        }

        $orderedImageIds = $validator->validated()['order'];

        // Verificar IDs duplicados en la solicitud
        if (count($orderedImageIds) !== count(array_unique($orderedImageIds))) {
            return response()->json(['message' => 'La lista de orden contiene IDs duplicados.'], 422);
        }

        // Verificar si la cantidad de IDs recibidos coincide con la cantidad de imágenes de la ubicación
        // Esto es una comprobación adicional opcional pero útil.
        $imageCount = ImagenUbicacion::where('ubicacion_id', $ubicacion->id)->count();
        if (count($orderedImageIds) !== $imageCount) {
             Log::warning("Intento de reordenar galería para Ubicacion ID {$ubicacion->id} con cantidad de IDs incorrecta. Recibidos: " . count($orderedImageIds) . ", Esperados: {$imageCount}");
             // Puedes decidir si devolver un error o continuar. Continuar podría dejar imágenes sin orden actualizado.
             // return response()->json(['message' => 'La cantidad de imágenes en la solicitud no coincide con la galería.'], 400); // Bad Request
        }


        DB::beginTransaction(); // Iniciar transacción

        try {
            // --- PASO 1: Asignar valores de orden temporales y únicos ---
            // Usaremos valores negativos basados en el ID para asegurar unicidad temporal.
            // O podrías usar un offset grande: $index + 1 + $imageCount * 2;
            foreach ($orderedImageIds as $index => $imageId) {
                ImagenUbicacion::where('id', $imageId)
                    // ->where('ubicacion_id', $ubicacion->id) // Ya validado
                    ->update(['orden' => -($index + 1)]); // Asignar orden temporal negativo
            }

            // --- PASO 2: Asignar los valores de orden finales correctos ---
            foreach ($orderedImageIds as $index => $imageId) {
                ImagenUbicacion::where('id', $imageId)
                    // ->where('ubicacion_id', $ubicacion->id) // Ya validado
                    ->update(['orden' => $index + 1]); // Asignar orden final (1, 2, 3...)
            }

            DB::commit(); // Confirmar la transacción si todo fue bien

            return response()->json(['message' => 'Orden de imágenes actualizado correctamente.'], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de cualquier error
            Log::error("Error al reordenar imágenes de galería (Ubicacion ID: {$ubicacion->id}): " . $e->getMessage());
            // Devolver el mensaje de error real puede ser útil para depurar, pero considera la seguridad.
            // return response()->json(['message' => 'Error interno al guardar el orden.', 'error_details' => $e->getMessage()], 500);
            return response()->json(['message' => 'Error interno al guardar el orden.'], 500);
        }
    }
    
  
}
