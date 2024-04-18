<div>
    <button data-tooltip-target="tooltip-dark" type="button" wire:click="$set('addDocument',true)"
        class="mt-8 group flex py-4 px-4 text-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
        <i class="fas fa-folder-plus"></i>
        <span
            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
            Agregar Manual
        </span>
    </button>
    <x-jet-dialog-modal wire:model="addDocument">
        <x-slot name="title">
            <h1 class="text-xl font-bold">Agregar manual de funciones</h1>
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label value="tipo de manual:" />
                <select wire:model="tipoSel" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                    <option value="">Seleccione</option>
                    @if ($tiposDisponibles->isNotEmpty())
                        @foreach ($tiposDisponibles as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombreTipo }}</option>
                        @endforeach
                    @endif
                </select>
                <x-jet-input-error for="tipoSel" />
            </div>

            <div class="mb-4">
                <x-jet-label value="Fecha de inicio:" />
                <x-date-picker wire:model="fechaInicial" placeholder="Fecha de inicio"
                    class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full" />
                <x-jet-input-error for="fechaInicial" />
            </div>

            <div class="mb-4">
                <x-jet-label value="Fecha de Caducidad:" />
                <x-date-picker wire:model="fechaCaducidad" placeholder="Fecha de Fin"
                    class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full" />
                <x-jet-input-error for="fechaCaducidad" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Archivo:" class="font-bold" />
                <x-file-pond name="documento" id="documento" wire:model="documento"
                    acceptedFileTypes="['application/pdf',]" aceptaVarios="false" />
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
