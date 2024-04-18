<?php

namespace App\Notifications;

use App\Http\Livewire\Usuarios;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Anulacion;
use App\Models\Certificacion;
use App\Models\User;


class AnulacionSolicitud extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $anulacion, $servicio, $usuario;

    public function __construct(Anulacion $anulacion, Certificacion $servicio, User $usuario)
    {
        $this->anulacion = $anulacion;
        $this->servicio = $servicio;
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
            ->line('Se ha recibido una nueva solicitud de anulación:')
            ->action('Ver solicitud', url('/'))
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
            'motivo' => $this->anulacion->motivo,
            'idAnulacion' => $this->anulacion->id,
            'idInspector' => $this->usuario->id,
            'idServicio' =>$this->servicio->id,            
        ];
    }

}
