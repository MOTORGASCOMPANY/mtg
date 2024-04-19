<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\DocumentoEmpleado;
use App\Models\DocumentoManual;
use App\Models\Organigrama;
use Illuminate\Http\Request;

class DocumentosController extends Controller
{
    public function downloadDocumentoTaller($id)
    {
        $doc=Documento::findOrFail($id);

        if($doc){
            $path=storage_path('app/'.$doc->ruta);
            return response()->download($path);            
        }else{
            return 404;
        }
    }

    //Nuevo para manual funciones
    public function downloadManual($id)
    {
        $doc=DocumentoManual::findOrFail($id);

        if($doc){
            $path=storage_path('app/'.$doc->ruta);
            return response()->download($path);            
        }else{
            return 404;
        }
    }

    //para documentos empleados
    public function downloadEmpleado($id)
    {
        $doc=DocumentoEmpleado::findOrFail($id);

        if($doc){
            $path=storage_path('app/'.$doc->ruta);
            return response()->download($path);            
        }else{
            return 404;
        }
    }

    //para organigrama
    public function downloadOrganigrama($id)
    {
        $doc=Organigrama::findOrFail($id);

        if($doc){
            $path=storage_path('app/'.$doc->ruta);
            return response()->download($path);            
        }else{
            return 404;
        }
    }

    
}
