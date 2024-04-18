<div>
    <button   wire:click="$set('open',true)"
    class="bg-indigo-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer"> 
        Nueva Area&nbsp;<i class="fas fa-plus-circle"></i>
   </button>

   <x-jet-dialog-modal wire:model="open" wire:loading.attr="disabled">
    <x-slot name="title" class="font-bold">
        <h1 class="text-xl font-bold"><i class="fa-solid fa-plus text-white"></i> &nbsp;Nueva Area</h1>
    </x-slot>

    <x-slot name="content">
        <div class="mb-4">
            <x-jet-label value="Descripcion:" />
            <x-jet-input wire:model="nombreTipo" type="text" class="w-full" />
            <x-jet-input-error for="nombreTipo" />
        </div>   
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
            Cancelar
        </x-jet-secondary-button>
        <x-jet-button wire:click="crearTipoManual" wire:loading.attr="disabled" wire:target="crearTipoManual">
            Guardar
        </x-jet-button>

    </x-slot>

</x-jet-dialog-modal>
</div>
