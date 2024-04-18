<div>
    <button wire:click="$set('open',true)"
        class="bg-indigo-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer">
        Nuevo rol &nbsp;<i class="fas fa-plus"></i>
    </button>

    <x-jet-dialog-modal wire:model="open" wire:loading.attr="disabled">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold"><i class="fa-solid fa-plus text-white"></i> &nbsp;Nuevo Rol</h1>
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label value="Nombre:" />
                <x-jet-input wire:model="nombre" type="text" class="w-full" />
                <x-jet-input-error for="nombre" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="crearRol" wire:loading.attr="disabled" wire:target="crearRol">
                Guardar
            </x-jet-button>

        </x-slot>

    </x-jet-dialog-modal>
</div>
