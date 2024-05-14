<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $contenido = "Contenido del comunicado obtenido desde donde lo tengas guardado";
        return view('vendor.jetstream.components.welcome', ['contenido' => $contenido]);
        //dd($contenido);  

    }
}
