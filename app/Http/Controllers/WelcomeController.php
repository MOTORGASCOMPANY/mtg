<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        $comunicado = session('comunicado', null);
        return view('comunicado', compact('comunicado'));
    }

    public function store(Request $request)
    {
        /*$request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|string',
        ]);*/

        session(['comunicado' => [
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'imagen' => $request->imagen,
            'user_id' => Auth::id(),
            'activo' => true,
        ]]);

        return redirect()->route('dashboard')->with('success', 'Comunicado creado exitosamente.');
    }     

    public function update(Request $request)
    {
        /*$request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|string',
        ]);*/

        session(['comunicado' => [
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'imagen' => $request->imagen,
            'user_id' => Auth::id(),
            'activo' => true,
        ]]);

        return redirect()->route('dashboard')->with('success', 'Comunicado actualizado exitosamente.');
    }

    public function edit()
    {
        $comunicado = session('comunicado', null);
        return view('edit', compact('comunicado'));
    }

    // Método para desactivar el comunicado
    public function deactivate()
    {
        if (session()->has('comunicado')) {
            $comunicado = session('comunicado');
            $comunicado['activo'] = false;
            session(['comunicado' => $comunicado]);
        }

        return redirect()->route('dashboard')->with('success', 'Comunicado desactivado exitosamente.');
    }

    //Metodo para cargar imagenes 
    public function uploadImage(Request $request)
    {
        $request->validate([
            'new_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('new_image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/images'), $imageName);

        return redirect()->route('comunicado.index');
    }
}
