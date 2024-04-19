<div>
    <button data-tooltip-target="tooltip-dark" type="button" wire:click="$set('addDocument',true)"
        class="mt-8 group flex py-4 px-4 text-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
        <i class="fas fa-folder-plus"></i>
        <span
            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
            Agregar
        </span>
    </button>
    <x-jet-dialog-modal wire:model="addDocument">
        <x-slot name="title">
            <h1 class="text-xl font-bold">Agregar organigrama</h1>
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label value="Documento:" />
                <x-jet-input type="text" class="w-full" wire:model="documento" />
                <x-jet-input-error for="documento" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Archivo:" class="font-bold" />
                <x-file-pond name="doc" id="doc" wire:model="doc"
                    acceptedFileTypes="['application/pdf',]" aceptaVarios="false" />
                <x-jet-input-error for="doc" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('addDocument',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button loading:attribute="disabled" wire:click="agregardocumento" wire:target="agragregardocumentoegardoc">
                Guardar
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
