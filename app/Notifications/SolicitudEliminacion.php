<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Livewire\Usuarios;
use App\Models\Certificacion;
use App\Models\Eliminacion;
use App\Models\User;

class SolicitudEliminacion extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $eliminacion, $servicio, $usuario;
     public function __construct(Eliminacion $eliminacion, Certificacion $servicio, User $usuario)
     {
        $this->eliminacion = $eliminacion;
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
            ->line('Se ha recibido una nueva solicitud de eliminacion:')
            ->action('Ver Eliminacion', url('/'))
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
            'idEliminacion' => $this->eliminacion->id,
            'idInspector' => $this->usuario->id,
            'idServicio' =>$this->servicio->id,
        ];
    }
}
