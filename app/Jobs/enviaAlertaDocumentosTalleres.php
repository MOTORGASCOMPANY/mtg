<?php

namespace App\Jobs;

use App\Mail\CustomMail;
use App\Models\Taller;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class enviaAlertaDocumentosTalleres implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $taller;

    public function __construct(Taller $taller)
    {
        $this->taller=$taller;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user=User::where('taller',$this->taller->id);
        $fecha=now()->format("d-m-Y");
        if(!empty($user)){
            Mail::to($user->email)->send( new CustomMail($user));
            Log::info($fecha.': Se envio correo avisos de vencimiento del taller '
            .$this->taller->nombre.' al correo '.$user->email);
        }else{
            Log::info($fecha.': No se encontro remitente para el envio de correo de avisos
            de vencimiento del taller '.$this->taller->nombre);
        }
    }
}
