<div>
    @switch($estado)
        @case('nuevo')
            <x-form-vehiculo-glp/>
        @break

        @case('cargado')
            <x-form-vehiculo-glp-deshabilitado />
        @break

        @case('editando')
            <x-form-vehiculo-glp-actualizar />
        @break

        @default
            <x-form-vehiculo-glp />
    @endswitch

    @if ($vehiculo)
        @livewire('form-equipos', ['vehiculo' => $vehiculo, 'tipoServicio' => $tipoServicio, 'nombreDelInvocador' => $nombreDelInvocador])
    @endif

    <x-jet-dialog-modal wire:model="busqueda">
        <x-slot name="title">
            <h1 class="text-3xl font-medium">vehículos</h1>
        </x-slot>
        <x-slot name="content">
            @if ($vehiculos)
                <p class="text-indigo-900">Se encontrarón <span
                        class="px-2 bg-indigo-400 rounded-full">{{ $vehiculos->count() }}</span> vehículos</p>
                <div class="my-5">
                    @foreach ($vehiculos as $key => $veh)
                        <div
                            class="flex justify-between items-center border-b border-slate-200 py-3 px-2 border-l-4  border-l-transparent bg-gradient-to-r from-transparent to-transparent hover:border-l-4 hover:border-l-indigo-300  hover:from-slate-100 transition ease-linear duration-150">
                            <div class="inline-flex items-center space-x-2">
                                <div>
                                    <i class="fas fa-car"></i>
                                </div>
                                <div>{{ $veh->placa }}</div>
                                <div>{{ $veh->marca }}</div>
                                <div>{{ $veh->modelo }}</div>
                                <div class="px-2 text-xs text-slate-600">
                                    {{ $veh->created_at->format('d/m/Y  h:m:s') }}</div>
                            </div>
                            <div>
                                <i wire:click="seleccionaVehiculo({{ $veh }})"
                                    class="fas fa-plus-circle fa-lg hover: cursor-pointer hover: shadow-lg"
                                    style="color:#6366f1;"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-slate-500 text-center">Selecciona uno de estos vehiculos para agregarlo a tu
                    certificado.</p>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('busqueda',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>


</div>

