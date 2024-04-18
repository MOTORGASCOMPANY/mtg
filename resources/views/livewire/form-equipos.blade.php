<div wire:loading.attr="disabled" wire:target="delete">
    <x-form-datos-equipos-gnv>
        @if ($cantEquipos)
            <x-slot name="cabecera" class="bg-green-400">
                <x-slot name="titulo">
                    @switch($tipoServicio->id)
                        @case(1)
                            Datos de los equipos de GNV
                        @break

                        @case(2)
                            Datos de los equipos de GNV
                        @break

                        @case(3)
                            Datos de los equipos de GLP
                        @break

                        @case(4)
                            Datos de los equipos de GLP
                        @break

                        @case(7)
                            Datos de los equipos de GNV
                        @break
                        @case(10)
                            Datos de los equipos de GNV
                        @break
                        @case(12)
                            Datos de los equipos de GNV
                        @break
                        @case(13)
                            Datos de los equipos de GLP
                        @break

                        @default
                    @endswitch

                </x-slot>
                <x-slot name="icono">
                    <i class="fas fa-check-circle fa-lg"></i>
                </x-slot>
            </x-slot>
        @else
            <x-slot name="cabecera" class="bg-gray-400">
                <x-slot name="titulo">
                    @switch($tipoServicio->id)
                        @case(1)
                            Datos de los equipos de GNV
                        @break

                        @case(2)
                            Datos de los equipos de GNV
                        @break

                        @case(3)
                            Datos de los equipos de GLP
                        @break

                        @case(4)
                            Datos de los equipos de GLP
                        @break
                        @case(7)
                        Datos de los equipos de GNV
                        @break
                        @case(10)
                            Datos de los equipos de GNV
                        @break
                        @case(12)
                            Datos de los equipos de GNV
                        @break
                        @case(13)
                            Datos de los equipos de GLP
                        @break

                        @default
                    @endswitch
                </x-slot>
                <x-slot name="icono">
                    <i class="fas fa-archive fa-lg"></i>
                </x-slot>
            </x-slot>
        @endif

        @livewire('crear-equipo', ['vehiculo' => $vehiculo,'tipoServicio'=>$tipoServicio])

        @if ($equipos)
            <x-slot name="equip">
                <div wire:model="equipos">
                    @foreach ($equipos as $e)
                        @if (isset($e->idTipoEquipo))
                            @switch($e->idTipoEquipo)
                                @case(1)
                                    <div class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
                                        <div class="flex flex-row w-full">
                                            <div class="block  w-5/6">
                                                <span
                                                    class="bg-teal-200 text-teal-800 text-xs px-2 inline-block rounded-full  uppercase font-semibold tracking-wide">
                                                    <i class="fas fa-microchip"></i>&nbsp;{{ $e->tipo->nombre }}
                                                </span>
                                                <p>Serie: <strong>{{ $e->numSerie }}</strong></p>
                                            </div>
                                            <div class="w-1/6 flex justify-end items-center space-x-2">
                                                <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                    wire:click="edit({{ $e }})">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a class="bg-red-300 p-4 rounded-xl hover:bg-red-500 hover:cursor-pointer"
                                                    wire:click="delete({{ $e }})">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @break

                                @case(2)
                                    <div class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
                                        <div class="flex flex-row w-full">
                                            <div class="block w-5/6">
                                                <span
                                                    class="bg-sky-200 text-sky-800 text-xs px-2 inline-block rounded-full  uppercase font-semibold tracking-wide">
                                                    <i class="fas fa-tenge"></i>&nbsp;{{ $e->tipo->nombre }}
                                                </span>
                                                <p>Serie: <strong>{{ $e->numSerie }}</strong></p>
                                                <p>Marca: <strong>{{ $e->marca }}</strong></p>
                                                <p>Modelo: <strong>{{ $e->modelo }}</strong></p>
                                            </div>
                                            <div class=" w-1/6 flex justify-end items-center space-x-2">
                                                <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                    wire:click="edit({{ $e }})">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a class="bg-red-300 p-4 rounded-xl hover:bg-red-500 hover:cursor-pointer"
                                                    wire:click="delete({{ $e }})">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @break

                                @case(3)
                                    <div class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
                                        <div class="flex flex-row w-full">
                                            <div class="block bg w-5/6">
                                                <span
                                                    class="bg-orange-400 text-white text-xs px-2 inline-block rounded-full  uppercase font-semibold tracking-wide">
                                                    <i class="fas fa-battery-empty"></i>&nbsp;{{ $e->tipo->nombre }}
                                                </span>
                                                <p>Serie: <strong>{{ $e->numSerie }}</strong></p>
                                                <p>Marca: <strong>{{ $e->marca }}</strong></p>
                                                <p>Capacidad (L): <strong>{{ $e->capacidad }}</strong></p>
                                                <p>Fecha de Fabricación:
                                                    <strong>{{ date('d/m/Y', strtotime($e->fechaFab)) }}</strong>
                                                </p>
                                                <p>Peso (KG): <strong>{{ $e['peso'] }}</strong></p>
                                            </div>
                                            <div class="bg w-1/6 flex justify-end items-center space-x-2">
                                                <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                    wire:click="edit({{ $e }})">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a class="bg-red-300 p-4 rounded-xl hover:bg-red-500 hover:cursor-pointer"
                                                    wire:click="delete({{ $e }})">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @break

                                @case(4)
                                    <div class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
                                        <div class="flex flex-row w-full">
                                            <div class="block w-5/6">
                                                <span
                                                    class="bg-sky-200 text-sky-800 text-xs px-2 inline-block rounded-full  uppercase font-semibold tracking-wide">
                                                    <i class="fas fa-tenge"></i>&nbsp;{{ $e->tipo->nombre }}
                                                </span>
                                                <p>Serie: <strong>{{ $e->numSerie }}</strong></p>
                                                <p>Marca: <strong>{{ $e->marca }}</strong></p>
                                                <p>Modelo: <strong>{{ $e->modelo }}</strong></p>
                                            </div>
                                            <div class=" w-1/6 flex justify-end items-center space-x-2">
                                                <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                    wire:click="edit({{ $e }})">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a class="bg-red-300 p-4 rounded-xl hover:bg-red-500 hover:cursor-pointer"
                                                    wire:click="delete({{ $e }})">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @break

                                @case(5)
                                    <div class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
                                        <div class="flex flex-row w-full">
                                            <div class="block bg w-5/6">
                                                <span
                                                    class="bg-orange-400 text-white text-xs px-2 inline-block rounded-full  uppercase font-semibold tracking-wide">
                                                    <i class="fas fa-battery-empty"></i>&nbsp;{{ $e->tipo->nombre }}
                                                </span>
                                                <p>Serie: <strong>{{ $e->numSerie }}</strong></p>
                                                <p>Marca: <strong>{{ $e->marca }}</strong></p>
                                                <p>Modelo: <strong>{{ $e->modelo }}</strong></p>
                                            </div>
                                            <div class="bg w-1/6 flex justify-end items-center space-x-2">
                                                <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                    wire:click="edit({{ $e }})">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a class="bg-red-300 p-4 rounded-xl hover:bg-red-500 hover:cursor-pointer"
                                                    wire:click="delete({{ $e }})">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @break

                                @default
                            @endswitch
                        @endif
                    @endforeach
                </div>
            </x-slot>
        @else
            <x-slot name="equip">
                <p class="w-4/6 text-center p-2 text-sm text-gray-400 m-auto">Este vehículo no cuenta con equipos registrados</p>
            </x-slot>
        @endif

    </x-form-datos-equipos-gnv>


    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            <h1 class="font-bold text-lg">EDITANDO EQUIPO</h1>
        </x-slot>
        <x-slot name="content">
            @if ($equipo)
                @switch($equipo->idTipoEquipo)
                    @case(1)
                        <x-form-edit-chip-gnv />
                    @break

                    @case(2)
                        <x-form-edit-reductor-gnv />
                    @break

                    @case(3)
                        <x-form-edit-tanque-gnv />
                    @break

                    @case(4)
                        <x-form-edit-regulador-glp />
                    @break

                    @case(5)
                        <x-form-edit-cilindro-glp />
                    @break

                    @default
                        <div class="p-4 bg-indigo-300 text-center rounded-xl">
                            <p>SIN DATOS</p>
                        </div>
                @endswitch
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="actualizar" wire:loading.attr="disabled" wire:target="actualizar">
                Guardar
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
