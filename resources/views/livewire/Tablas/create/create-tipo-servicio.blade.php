<div>
    <button   wire:click="$set('open',true)"
    class="bg-indigo-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer"> 
        Nuevo registro&nbsp;<i class="fas fa-plus-circle"></i>
   </button>

   <x-jet-dialog-modal wire:model="open" wire:loading.attr="disabled">
    <x-slot name="title" class="font-bold">
        <h1 class="text-xl font-bold"><i class="fa-solid fa-plus text-white"></i> &nbsp;Nuevo registro</h1>
    </x-slot>

    <x-slot name="content">
        <div class="mb-4">
            <x-jet-label value="Descripcion:" />
            <x-jet-input wire:model="descripcion" type="text" class="w-full" />
            <x-jet-input-error for="descripcion" />
        </div>   
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
            Cancelar
        </x-jet-secondary-button>
        <x-jet-button wire:click="crearTipoServicio" wire:loading.attr="disabled" wire:target="crearTipoServicio">
            Guardar
        </x-jet-button>

    </x-slot>

</x-jet-dialog-modal>
</div>
