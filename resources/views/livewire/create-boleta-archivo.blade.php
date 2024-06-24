<div>
    <button data-tooltip-target="tooltip-dark" type="button" wire:click="$set('addDocument',true)"
        class="group flex py-4 px-4 text-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
        <i class="fas fa-folder-plus"></i>
        <span
            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
            Agregar Comprobante
        </span>
    </button>

    <x-jet-dialog-modal wire:model="addDocument">
        <x-slot name="title">
            <h1 class="text-xl font-bold">Agregar documento</h1>
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label for="nombre" value="Nombre del Documento:" class="font-bold" />
                <x-jet-input id="nombre" type="text" class="mt-1 block w-full" wire:model="nombre" />
                <x-jet-input-error for="nombre" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Archivo:" class="font-bold" />
                <x-file-pond name="documento" id="documento" wire:model="documento"
                    acceptedFileTypes="['application/pdf', 'image/*']" />
                <x-jet-input-error for="documento" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('addDocument',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button loading:attribute="disabled" wire:click="agregarDocumento" wire:target="agregarDocumento">
                Guardar
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
