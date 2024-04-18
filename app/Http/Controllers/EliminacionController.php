<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Eliminacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EliminacionController extends Controller
{
    public function marcarEliminacion($idNotificacion) {
        $notification = Auth()->user()->notifications->find($idNotificacion);
    
        if ($notification && isset($notification->data['idEliminacion'])) {
            $eliId = $notification->data['idEliminacion'];
            $idUsuario = $notification->data['idInspector'];
            $idServicio = $notification->data['idServicio'];
    
            Auth()->user()->unreadNotifications->when($idNotificacion, function ($query) use ($idNotificacion) {
                return $query->where('id', $idNotificacion);
            })->markAsRead();

            return redirect()->route('vistaSolicitudEli', ['eliId' => $eliId, 'cerId' => $idServicio, 'userId'=>$idUsuario] );    
        }
    }


    public function marcarTodasLasNotificaciones(){
        Auth()->user()->unreadNotifications->markAsRead();
        redirect()->route('eliminar');
    }
}
