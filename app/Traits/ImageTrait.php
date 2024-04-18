<?php

namespace App\Traits;

use App\Models\Imagen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\StorageAttributes;

trait ImageTrait
{


    private function migrarArchivoDeExpedienteLocal(Imagen $file)
    {
        //$rutaActual = $file->ruta;
        try {
            // Obtener información del archivo
            $nombreArchivo = $file->nombre;
            $extensionArchivo = $file->extension;
            $rutaArchivoLocal = public_path('storage/expedientes/' . $nombreArchivo . '.' . $extensionArchivo);

            // Verificar si el archivo local existe
            if (!file_exists($rutaArchivoLocal)) {
                throw new \Exception("El archivo local no existe en la ruta: $rutaArchivoLocal");
            }

            // Leer el contenido del archivo
            $contenidoArchivo = file_get_contents($rutaArchivoLocal);

            // Subir el archivo a DigitalOcean Spaces
            $nuevaRuta = 'expedientes/' . $nombreArchivo . '.' . $extensionArchivo;
            Storage::disk('do')->put($nuevaRuta, $contenidoArchivo);
            Storage::disk('do')->setVisibility($nuevaRuta, 'public');

            // Verificar que el archivo se haya subido correctamente
            if (!Storage::disk('do')->exists($nuevaRuta)) {
                throw new \Exception("No se pudo subir el archivo a DigitalOcean Spaces.");
            }

            // Eliminar el archivo local
            unlink($rutaArchivoLocal);

            // Actualizar los metadatos en la base de datos
            $file->update([
                'ruta' => $nuevaRuta,
                'migrado' => 1,
                // Actualiza otros metadatos según sea necesario
            ]);

            // Registrar la migración exitosa
            Log::channel('migracion_expedientes')->notice("Se migró correctamente el archivo con ID: $file->id hacia Digital Ocean con la ruta: $nuevaRuta");

            return $nuevaRuta; // Devolver la nueva ruta del archivo en DigitalOcean Spaces
        } catch (\Exception $e) {
            // Manejar cualquier error que pueda ocurrir durante la migración
            Log::channel('migracion_expedientes')->error("Error al migrar archivo con ID: $file->id. Error: " . $e->getMessage());
            return false;
        }
    }



}
