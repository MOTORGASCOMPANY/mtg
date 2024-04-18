<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    //aqui controlas lo que pasa cuando haces click a una notificacion como haz creado un nuevo tipo de notificacion te recomiendo que primero aqui implementes un filtro por tipo de noti
    // y luego de eso ya aplicas el comportamiento dependiendo de eso

    //esta funcion recibe un id de notificacion y un id de solicitud
    public function marcarUnaNotificación($idNotificacion,$idSolicitud){
        //luego si el usuario aun lo la vio la marca como leida.
        Auth()->user()->unreadNotifications->when($idNotificacion,function($query) use
        ($idNotificacion){
            return$query->where('id',$idNotificacion);
        })->markAsRead();
        //busca la solicitud porq en mi caso es una solicitud
        $solicitud=Solicitud::find($idSolicitud);
        //redirecciona al componente para ver el detalle de la solicitud
        return redirect()->route('vistaSolicitud',$solicitud);
    }

    public function marcarTodasLasNotificaciones(){
        Auth()->user()->unreadNotifications->markAsRead();
        redirect()->route('solicitud');
    }
}
