<?php

namespace App\Console\Commands;

use App\Http\Livewire\DocumentosTaller;
use App\Jobs\enviaAlertaDocumentosTalleres;
use App\Models\Documento;
use App\Models\Taller;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EnviarEmailDeAlertaDocumentos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:alerta_documentos_taller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para enviar alertas de mensajes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $docs= DB::table('documento')
        ->join('documentostaller', 'documentostaller.idDocumento', '=', 'documento.id')
        ->join('taller', 'documentostaller.idDocumento', '=', 'taller.id')
        ->select('taller.id','documento.*')
        ->groupByRaw('taller.id');
        foreach ($docs as $doc){
            enviaAlertaDocumentosTalleres::dispatch($doc->idTaller);
        }
    }
}
