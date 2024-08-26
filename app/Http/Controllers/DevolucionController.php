<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class DevolucionController extends Controller
{

    public function marcarDevolucion($idNotificacion)
    {
        //$notification = Auth()->user()->notifications->find($idNotificacion);
        $user = Auth()->user();
        $notification = $user->notifications->find($idNotificacion);

        if ($notification && isset($notification->data['anulaciones'])) {
            /*$anuIds = $notification->data['anulaciones']; 
              $materialIds = $notification->data['materiales']; 
              $idUsuario = $notification->data['idInspector'];
            */

            // Extraer solo los IDs de anulaciones y materiales
            $anuIds = array_column($notification->data['anulaciones'], 'id');
            $materialIds = array_column($notification->data['materiales'], 'id');
            $idUsuario = $notification->data['idInspector'];


            // Obtener todos los IDs de los administradores
            $adminUsers = User::role('administrador')->pluck('id');

            // Obtener todas las notificaciones relacionadas con la data para todos los administradore
            $notificationsToMark = DatabaseNotification::whereIn('notifiable_id', $adminUsers)
                ->where('type', $notification->type)
                ->get();
            //dd($notificationsToMark);

            // Marcar todas las notificaciones como leídas
            foreach ($notificationsToMark as $adminNotification) {
                $adminNotification->update(['read_at' => now()]);
            }

            //return redirect()->route('vistaDevolucion', ['anuId' => $anuId, 'matId' => $idMaterial, 'userId' => $idUsuario]);
            // Serializar los arrays antes de la redirección
            return redirect()->route('vistaDevolucion', [
                'anuId' => json_encode($anuIds),
                'matId' => json_encode($materialIds),
                'userId' => $idUsuario,
            ]);
        }
    }


    public function marcarTodasLasNotificaciones()
    {
        Auth()->user()->unreadNotifications->markAsRead();
        redirect()->route('devolucion'); //return
    }
}
