<div class="container mx-auto py-12">    
    <div class="flex flex-row  justify-between items-center">
        <h2 class="mt-8 font-bold text-lg text-indigo-600"> MANUAL DE FUNCIONES</h2>
        @hasanyrole('administrador|supervisor|Administrador del sistema')
        @livewire('create-manual-funciones')
        @endhasanyrole
    </div>
    <hr class="my-4">
        <div>
            @livewire('documentos-manual')
        </div>
</div>