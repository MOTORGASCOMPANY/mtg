<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\CreateSolicitud;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ListenerSolicitud
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        User::role(["administrador"])       
        ->each(function(User $user) use ($event){
            Notification::send($user,new CreateSolicitud($event->solicitud));
        });
        
    }
}
