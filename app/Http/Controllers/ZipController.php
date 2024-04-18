<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expediente;
use App\Models\Imagen;

use File;
use Zip;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ZipController extends Controller
{
    public function descargaFotosExpediente($id)
    {
        $expediente = Expediente::findOrFail($id);
        $fileName = $expediente->placa . '.zip';
        $zipPath = storage_path('app/' . $fileName);

        $imagenes = Imagen::where('Expediente_idExpediente', $expediente->id)
            ->whereIn('extension', ['jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'bmp'])
            ->get();

        // Crear un nuevo archivo ZIP
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'No se pudo crear el archivo ZIP');
        }

        // Agregar cada imagen al archivo ZIP
        foreach ($imagenes as $imagen) {
            // Determinar la ruta de la imagen, dependiendo de si ha sido migrada o no
            if ($imagen->migrado == 0) {
                $ruta = storage_path('app/' . $imagen->ruta); // Ruta local en el servidor
            } else {
                $ruta = 'expedientes/' . $imagen->nombre . '.' . $imagen->extension; // Ruta en DigitalOcean Spaces
            }

            // Obtener el contenido de la imagen
            if ($imagen->migrado == 0) {
                $contenidoImagen = file_get_contents($ruta); // Obtener contenido de la imagen local
            } else {
                $contenidoImagen = Storage::disk('do')->get($ruta); // Obtener contenido de la imagen desde DO Spaces
            }

            // Determinar el nombre de archivo para el ZIP
            $nombreArchivo = $expediente->placa . '/' . $imagen->nombre . '.' . $imagen->extension;

            // Agregar la imagen al archivo ZIP
            $zip->addFromString($nombreArchivo, $contenidoImagen);
        }

        // Cerrar el archivo ZIP
        $zip->close();

        // Descargar el archivo ZIP
        return response()->download($zipPath, $fileName)->deleteFileAfterSend(true);
    }

    public function descargaFotosAprobados()
    {
    }
}
