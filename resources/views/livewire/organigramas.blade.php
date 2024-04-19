<div class="container mx-auto py-12">    
    <div class="flex flex-row  justify-between items-center">
        <h2 class="mt-8 font-bold text-lg text-indigo-600">MAPA ORGANIGRAMA</h2>
        @hasanyrole('administrador|supervisor|Administrador del sistema')
        @livewire('create-organigrama')
        @endhasanyrole
    </div>
    <hr class="my-4">
        <div>
            @livewire('documentos-organigrama')
        </div>
</div>