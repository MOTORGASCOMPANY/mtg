<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemorandoController extends Controller
{
    public function marcarMemorando($idNotificacion) {
        $notification = Auth()->user()->notifications->find($idNotificacion);
        
        if ($notification && isset($notification->data['idMemorando'])) {
            $memoId = $notification->data['idMemorando'];
    
            Auth()->user()->unreadNotifications->when($idNotificacion, function ($query) use ($idNotificacion) {
                return $query->where('id', $idNotificacion);
            })->markAsRead();
    
    
            return redirect()->route('vistaSolicitudMemorando', ['memoId' => $memoId]);
        }
    }

    public function marcarTodasLasNotificaciones(){
        Auth()->user()->unreadNotifications->markAsRead();
        redirect()->route('memorando');
    }


    /*public function marcarMemorando($idNotificacion) {
        $notification = Auth()->user()->notifications->find($idNotificacion);
        
        if ($notification && isset($notification->data['idMemorando'])) {
            $memoId = $notification->data['idMemorando'];
    
            $notification->markAsRead();
    
            return redirect()->route('vistaSolicitudMemorando', ['memoId' => $memoId]);
        } else {
            return redirect()->back()->with('error', 'La notificación o el id del memorando no están definidos correctamente.');
        }
    }*/

}
