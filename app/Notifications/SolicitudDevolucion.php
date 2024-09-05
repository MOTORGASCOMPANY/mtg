<?php

namespace App\Notifications;

use App\Models\Anulacion;
use App\Models\Material;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class SolicitudDevolucion extends Notification
{
    use Queueable;
    public $anulaciones, $materiales, $usuario;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    
    public function __construct($anulaciones, $materiales, User $usuario)
    {
        $this->anulaciones = $anulaciones;
        $this->materiales = $materiales;
        $this->usuario = $usuario;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Se ha recibido una nueva solicitud de devolución de formatos:')
            ->action('Ver Solicitud', url('/'))
            ->line('Gracias por usar nuestra aplicación.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'motivo' => 'Solicitud de devolucion',
            'anulaciones' => $this->anulaciones->map(function($anulacion) {
                return [
                    'id' => $anulacion->id,
                    'tipo_material' => $anulacion->idTipoMaterial,
                    'anio' => $anulacion->anioActivo,
                    'motivo' => $anulacion->motivo,
                ];
            }),
            'materiales' => $this->materiales->map(function($material) {
                return [
                    'id' => $material->id,
                    'numSerie' => $material->numSerie,
                ];
            }),
            'idInspector' => $this->usuario->id,
        ];
    }
}
