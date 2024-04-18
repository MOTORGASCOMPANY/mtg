<?php

namespace App\Console\Commands;

use App\Models\Imagen;
use App\Traits\ImageTrait;
use Illuminate\Console\Command;

class MigrarDocumentos extends Command
{
    use ImageTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrar:documentos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra todos los documentos adjuntos de los expedientes a un object storage en Digital Ocean';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Iniciando migración de archivos...');

        Imagen::where('migrado', 0)->chunk(1000, function ($imagenes) {
            foreach ($imagenes as $file) {
                $this->migrarArchivoDeExpedienteLocal($file);
            }
        });

        $this->info('Migración de archivos completada.');
    }
}
