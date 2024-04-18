<div>
    <div class="mb-4">
        <x-jet-label value="Marca:" />
        <x-jet-input type="text" class="w-full" wire:model="equipo.marca" />
        <x-jet-input-error for="equipo.marca"/>
    </div>
    <div class="mb-4">
        <x-jet-label value="N° de serie:"/>
        <x-jet-input type="text" class="w-full"  wire:model="equipo.numSerie"/>
        <x-jet-input-error for="equipo.numSerie"/>
    </div>
    {{--
    <div class="mb-4">
        <x-jet-label value="Capacidad:"/>
        <x-jet-input type="number" class="w-full" wire:model="equipo.capacidad" inputmode="numeric"  pattern="[0-9]*"/>
        <x-jet-input-error for="equipo.capacidad"/>
    </div>
    <div class="mb-4">
        <x-jet-label value="Fecha de Fabricación:"/>
        <x-jet-input type="date" class="w-full" wire:model="equipo.fechaFab" />
        <x-jet-input-error for="equipo.fechaFab"/>
    </div>
    <div class="mb-4">
        <x-jet-label value="Peso:"/>
        <x-jet-input type="number" class="w-full" wire:model="equipo.peso" inputmode="numeric"/>
        <x-jet-input-error for="equipo.peso"/>
    </div>
    --}}
    <div class="mb-4">
        <x-jet-label value="Modelo"/>
        <x-jet-input type="text" class="w-full"  wire:model="equipo.modelo"/>
        <x-jet-input-error for="equipo.modelo"/>
    </div>
</div>
