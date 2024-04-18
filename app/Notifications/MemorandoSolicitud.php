<?php

namespace App\Notifications;

use App\Http\Livewire\Usuarios;
use App\Models\Memorando;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;


class MemorandoSolicitud extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $memorando;

    public function __construct(Memorando $memorando)
    {
        $this->memorando = $memorando;
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
            ->line('Tiene un nuevo memorandum')
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
            'idMemorando' => $this->memorando->id, 
        ];
    }

}
