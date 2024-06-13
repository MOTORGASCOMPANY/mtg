<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comunicados;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\ContratoTrabajo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $comunicado = Comunicados::where('activo', true)->first();
        return view('dashboard', compact('comunicado'));
    }

    public function showComunicadoForm()
    {
        $comunicado = Comunicados::where('activo', true)->first();
        return view('comunicado', compact('comunicado'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|string',
        ]);

        $data['activo'] = true;
        Comunicados::create($data);

        return redirect()->route('dashboard')->with('success', 'Comunicado creado exitosamente.');
    }

    public function update(Request $request, Comunicados $comunicado)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|string',
        ]);

        $comunicado->update($data);

        return redirect()->route('dashboard')->with('success', 'Comunicado actualizado exitosamente.');
    }

    public function deactivate(Comunicados $comunicado)
    {
        $comunicado->update(['activo' => false]);

        return redirect()->route('dashboard')->with('success', 'Comunicado desactivado exitosamente.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'new_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('new_image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/images'), $imageName);

        return redirect()->route('comunicado.createOrUpdateForm');
    }
}
