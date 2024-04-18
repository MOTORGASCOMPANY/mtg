<div>
    <div class="mb-4">
        <x-jet-label value="Marca:" />
        <x-jet-input type="text" class="w-full" wire:model="equipoMarca" />
        <x-jet-input-error for="equipoMarca"/>
    </div>
    <div class="mb-4">
        <x-jet-label value="Modelo:" />
        <x-jet-input type="text" class="w-full" wire:model="equipoModelo" />
        <x-jet-input-error for="equipoModelo"/>
    </div>
    <div class="mb-4">
        <x-jet-label value="N° de serie:"/>
        <x-jet-input type="text" class="w-full"  wire:model="equipoSerie"/>
        <x-jet-input-error for="equipoSerie"/>
    </div>
    {{--
    <div class="mb-4">
        <x-jet-label value="Capacidad:"/>
        <x-jet-input type="number" class="w-full" wire:model="equipoCapacidad" inputmode="numeric"  pattern="[0-9]*"/>
        <x-jet-input-error for="equipoCapacidad"/>
    </div>
    <div class="mb-4">
        <x-jet-label value="Fecha de Fabricación:"/>
        <x-jet-input type="date" class="w-full" wire:model="equipoFechaFab" />
        <x-jet-input-error for="equipoFechaFab"/>
    </div>
    <div class="mb-4">
        <x-jet-label value="Peso:"/>
        <x-jet-input type="number" class="w-full" wire:model="equipoPeso" inputmode="numeric"  pattern="[0-9]*"/>
        <x-jet-input-error for="equipoPeso"/>
    </div>
    --}}
</div>
