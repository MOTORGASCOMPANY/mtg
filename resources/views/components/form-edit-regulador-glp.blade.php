<div>
    <div class="mb-4">
        <x-jet-label value="Marca:"/>
        <x-jet-input type="text" class="w-full"  wire:model="equipo.marca" />
        <x-jet-input-error for="equipoMarca"/>
    </div>
    <div class="mb-4">
        <x-jet-label value="N° de serie:"/>
        <x-jet-input type="text" class="w-full" wire:model="equipo.numSerie" />
        <x-jet-input-error for="equipoSerie"/>
    </div>
    <div class="mb-4">
        <x-jet-label value="Modelo:"/>
        <x-jet-input type="text" class="w-full"  wire:model="equipo.modelo"/>
        <x-jet-input-error for="equipoModelo"/>
    </div>
</div>
