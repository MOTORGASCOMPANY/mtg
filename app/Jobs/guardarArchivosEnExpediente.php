<?php

namespace App\Jobs;

use App\Models\Certificacion;
use App\Models\Expediente;
use App\Traits\pdfTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class guardarArchivosEnExpediente implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,pdfTrait;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $expediente,$certificacion;


    public function __construct(Expediente $expe, Certificacion $certi)
    {
        $this->expediente=$expe;
        $this->certificacion=$certi;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $expediente=$this->expediente;
        $certificacion=$this->certificacion;

        $idServicio=$certificacion->Servicio->tipoServicio->id;

        if (in_array($idServicio, [1, 2, 7, 8, 10, 12])) {
            $this->guardarFichaTecnica($certificacion,$expediente);
            $this->guardaCertificado($certificacion,$expediente);
        }elseif (in_array($idServicio, [3, 4, 9])) {
            $this->guardarFichaTecnicaGlp($certificacion,$expediente);
            $this->guardaCertificado($certificacion,$expediente);
        }
    }
}
