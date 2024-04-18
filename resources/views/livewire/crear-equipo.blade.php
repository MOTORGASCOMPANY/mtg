<div class="w-full flex flex-row justify-center items-center m-auto py-6">
    <a wire:click="$set('open',true)" class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-center justify-start px-6 py-3 bg-amber-400 hover:bg-amber-500 focus:outline-none rounded">
        <p class="text-sm font-medium leading-none text-white"><i class="fas fa-plus-square fa-xl"></i>&nbsp;Agregar Equipos</p>
    </a>
    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            <h1 class="font-bold text-lg">AGREGAR EQUIPO AL VEHICULO {{$vehiculo->placa}} - {{$tipoServicio->descripcion}}</h1>
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label value="Tipo:" for="taller" />
                <select wire:model="tipoEquipo"
                    class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                    <option value="">Seleccione</option>
                    @if (isset($tiposDisponibles))
                        @foreach ($tiposDisponibles as $tipoE)
                            @if ($tipoE['estado'] == 1)
                                <option value="{{ $tipoE['id'] }}">{{ $tipoE['nombre'] }}</option>
                            @else
                                <option value="{{ $tipoE['id'] }}" disabled>{{ $tipoE['nombre'] }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
                <x-jet-input-error for="tipoEquipo" />
            </div>
            @if (isset($tipoEquipo))
                @switch($tipoEquipo)
                    @case(1)
                        <x-form-chip-gnv>
                        </x-form-chip-gnv>
                    @break

                    @case(2)
                        <x-form-reductor-gnv>
                        </x-form-reductor-gnv>
                    @break

                    @case(3)
                        <x-form-tanque-gnv>
                        </x-form-tanque-gnv>
                    @break

                    @case(4)
                        <x-form-regulador-glp>
                        </x-form-regulador-glp>
                    @break
                    @case(5)
                        <x-form-cilindro-glp>
                        </x-form-cilindro-glp>
                    @break

                    @default
                        <div class="p-4 bg-indigo-300 text-center rounded-xl">
                            <p>Seleccione un tipo de equipo</p>
                        </div>
                @endswitch
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="guardaEquipo" wire:loading.attr="disabled" wire:target="guardaEquipo">
                Guardar
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
