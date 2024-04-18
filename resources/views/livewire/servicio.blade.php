<div class="block justify-center mt-8 max-h-max">
    <h1 class="text-center text-xl my-4 font-bold text-indigo-900"> REALIZAR NUEVO SERVICIO</h1>
    <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4">
        <div class=" bg-indigo-200 rounded-lg py-4 px-2 grid grid-cols-1 gap-8 sm:grid-cols-2">
            <div>
                <x-jet-label value="Taller:" for="serv" />
                <select wire:model="taller"
                    class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                    <option value="">Seleccione</option>
                    @foreach ($talleres as $taller)
                        <option value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="taller" />
            </div>
            <div>
                <x-jet-label value="Servicio:" for="serv" />
                <select wire:model="serv" class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                    wire:loading.attr="disabled" wire:target="taller">
                    @if (isset($servicios))
                        <option value="">Seleccione </option>
                        @foreach ($servicios as $item)
                            <option value="{{ $item->id }}">{{ $item->tipoServicio->descripcion }}</option>
                        @endforeach
                    @else
                        <option value="">Seleccione un taller</option>
                    @endif
                </select>
                <x-jet-input-error for="serv" />
            </div>

        </div>
    </div>

    @if ($tipoServicio)

        <div
            class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4 px-8 flex flex-row justify-between items-center">
            <div class="w-4/6 items-center">
                <h1 class="font-bold"><span class="p-1 bg-green-300 rounded-lg">Formato Sugerido:</span></h1>
            </div>
            <div class="w-2/6 flex justify-end">
                <x-jet-input type="text" wire:model="numSugerido" type="text" />
                <x-jet-input-error for="numSugerido" />
            </div>
        </div>

        @switch($tipoServicio->id)
            @case(1)
                {{-- DATOS DEL VEHICULO --}}
                @if (isset($vehiculoServicio))
                    @if ($formularioVehiculo)
                        <x-form-vehiculo-actualizar />
                    @else
                        <x-form-vehiculo-deshabilitado />
                    @endif
                @else
                    <x-form-vehiculo-habilitado />
                @endif

                @if ($vehiculoServicio)
                    {{-- DATOS DE LOS EQUIPOS GNV --}}

                    @switch($tipoServicio->id)
                        @case(1)
                            <x-form-datos-equipos-gnv>
                                @if ($cantEquipos)
                                    <x-slot name="cabecera" class="bg-green-400">
                                        <x-slot name="titulo">
                                            Datos de los equipos de GNV
                                        </x-slot>
                                        <x-slot name="icono">
                                            <i class="fas fa-check-circle fa-lg"></i>
                                        </x-slot>
                                    </x-slot>
                                @else
                                    <x-slot name="cabecera" class="bg-gray-400">
                                        <x-slot name="titulo">
                                            Datos de los equipos de GNV
                                        </x-slot>
                                        <x-slot name="icono">
                                            <i class="fas fa-archive fa-lg"></i>
                                        </x-slot>
                                    </x-slot>
                                @endif

                                @if ($equipos->count())
                                    <x-slot name="equip">
                                        <div wire:model="equipos">
                                            @foreach ($equipos as $e)
                                                @if (isset($e->idTipoEquipo))
                                                    @switch($e->idTipoEquipo)
                                                        @case(1)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
                                                                <div class="flex flex-row w-full">
                                                                    <div class="block  w-5/6">
                                                                        <span
                                                                            class="bg-teal-200 text-teal-800 text-xs px-2 inline-block rounded-full  uppercase font-semibold tracking-wide">
                                                                            <i class="fas fa-microchip"></i>&nbsp;{{ $e->tipo->nombre }}
                                                                        </span>
                                                                        <p>Serie: <strong>{{ $e->numSerie }}</strong></p>
                                                                    </div>
                                                                    <div class="w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @break

                                                        @case(2)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
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
                                                                    <div class=" w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @break

                                                        @case(3)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
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
                                                                    <div class="bg w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
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
                                        <p class="w-4/6 text-center p-2 text-sm text-gray-400 m-auto">No se encontraron Equipos
                                            registrados en este vehículo</p>
                                    </x-slot>
                                @endif

                            </x-form-datos-equipos-gnv>
                        @break

                        @case(2)
                            <x-form-datos-equipos-gnv>

                                @if ($cantEquipos)
                                    <x-slot name="cabecera" class="bg-green-400">
                                        <x-slot name="titulo">
                                            Datos de los equipos de GNV
                                        </x-slot>
                                        <x-slot name="icono">
                                            <i class="fas fa-check-circle fa-lg"></i>
                                        </x-slot>
                                    </x-slot>
                                @else
                                    <x-slot name="cabecera" class="bg-gray-400">
                                        <x-slot name="titulo">
                                            Datos de los equipos de GNV
                                        </x-slot>
                                        <x-slot name="icono">
                                            <i class="fas fa-archive fa-lg"></i>
                                        </x-slot>
                                    </x-slot>
                                @endif

                                @if ($equipos->count())
                                    <x-slot name="equip">
                                        <div wire:model="equipos">
                                            @foreach ($equipos as $e)
                                                @if (isset($e->idTipoEquipo))
                                                    @switch($e->idTipoEquipo)
                                                        @case(1)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
                                                                <div class="flex flex-row w-full">
                                                                    <div class="block  w-5/6">
                                                                        <span
                                                                            class="bg-teal-200 text-teal-800 text-xs px-2 inline-block rounded-full  uppercase font-semibold tracking-wide">
                                                                            <i class="fas fa-microchip"></i>&nbsp;{{ $e->tipo->nombre }}
                                                                        </span>
                                                                        <p>Serie: <strong>{{ $e->numSerie }}</strong></p>
                                                                    </div>
                                                                    <div class="w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @break

                                                        @case(2)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
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
                                                                    <div class=" w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @break

                                                        @case(3)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
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
                                                                    <div class="bg w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
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
                                        <p class="w-4/6 text-center p-2 text-sm text-gray-400 m-auto">No se encontraron equipos
                                            registrados en este vehículo</p>
                                    </x-slot>
                                @endif

                            </x-form-datos-equipos-gnv>
                        @break

                        @default
                    @endswitch
                @endif
                 
                <div class="w-4/6 mx-auto my-8">
                    <x-jet-label value="Fotos reglamentarias:"/>
                    <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" multiple acceptedFileTypes="['image/*',]"  >   
                          
                    </x-file-pond>          
                    <x-jet-input-error for="imagenes"/>
                   
                </div>

                {{-- BOTONES --}}

                <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                    <div class="my-2 flex flex-row justify-evenly items-center">
                        @if (!isset($servicioCertificado))
                            <a wire:click="certificar"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-file-signature"></i>
                                    &nbsp;Generar Certificado</p>
                            </a>
                        @endif
                        @if (isset($servicioCertificado))
                            <a href="{{ $ruta }}" target="__blank"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-cyan-400 hover:bg-cyan-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-eye"></i> &nbsp;ver
                                    Certificado</p>
                            </a>
                            <a href="{{ $rutaDes }}" target="__blank"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-cyan-600 hover:bg-cyan-700 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-file-download"></i>
                                    &nbsp;Descargar Certificado</p>
                            </a>
                            <a href="{{ route('fichaTecnicaGnv', [$servicioCertificado->id]) }}" target="__blank"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-blue-400 hover:bg-blue-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-eye"></i> &nbsp;Ver
                                    Ficha T.</p>
                            </a>
                            <a href="{{ route('descargarFichaTecnicaGnv', [$servicioCertificado->id]) }}"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-eye"></i>
                                    &nbsp;Descargar Ficha T.</p>
                            </a>
                            <a href="{{ route('servicio') }}"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-red-400 hover:bg-red-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-archive"></i>
                                    &nbsp;Finalizar</p>
                            </a>
                        @endif
                    </div>
                </div>
            @break

            @case(2)
                {{-- DATOS DEL VEHICULO --}}
                @if (isset($vehiculoServicio))
                    @if ($formularioVehiculo)
                        <x-form-vehiculo-actualizar />
                    @else
                        <x-form-vehiculo-deshabilitado />
                    @endif
                @else
                    <x-form-vehiculo-habilitado />
                @endif

                @if ($vehiculoServicio)
                    {{-- DATOS DE LOS EQUIPOS GNV --}}

                    @switch($tipoServicio->id)
                        @case(1)
                            <x-form-datos-equipos-gnv>
                                @if ($cantEquipos)
                                    <x-slot name="cabecera" class="bg-green-400">
                                        <x-slot name="titulo">
                                            Datos de los equipos de GNV
                                        </x-slot>
                                        <x-slot name="icono">
                                            <i class="fas fa-check-circle fa-lg"></i>
                                        </x-slot>
                                    </x-slot>
                                @else
                                    <x-slot name="cabecera" class="bg-gray-400">
                                        <x-slot name="titulo">
                                            Datos de los equipos de GNV
                                        </x-slot>
                                        <x-slot name="icono">
                                            <i class="fas fa-archive fa-lg"></i>
                                        </x-slot>
                                    </x-slot>
                                @endif

                                @if ($equipos->count())
                                    <x-slot name="equip">
                                        <div wire:model="equipos">
                                            @foreach ($equipos as $e)
                                                @if (isset($e->idTipoEquipo))
                                                    @switch($e->idTipoEquipo)
                                                        @case(1)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
                                                                <div class="flex flex-row w-full">
                                                                    <div class="block  w-5/6">
                                                                        <span
                                                                            class="bg-teal-200 text-teal-800 text-xs px-2 inline-block rounded-full  uppercase font-semibold tracking-wide">
                                                                            <i class="fas fa-microchip"></i>&nbsp;{{ $e->tipo->nombre }}
                                                                        </span>
                                                                        <p>Serie: <strong>{{ $e->numSerie }}</strong></p>
                                                                    </div>
                                                                    <div class="w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @break

                                                        @case(2)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
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
                                                                    <div class=" w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @break

                                                        @case(3)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
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
                                                                    <div class="bg w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
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
                                        <p class="w-4/6 text-center p-2 text-sm text-gray-400 m-auto">No se encontraron Equipos
                                            registrados en este vehículo</p>
                                    </x-slot>
                                @endif

                            </x-form-datos-equipos-gnv>
                        @break

                        @case(2)
                            <x-form-datos-equipos-gnv>

                                @if ($cantEquipos)
                                    <x-slot name="cabecera" class="bg-green-400">
                                        <x-slot name="titulo">
                                            Datos de los equipos de GNV
                                        </x-slot>
                                        <x-slot name="icono">
                                            <i class="fas fa-check-circle fa-lg"></i>
                                        </x-slot>
                                    </x-slot>
                                @else
                                    <x-slot name="cabecera" class="bg-gray-400">
                                        <x-slot name="titulo">
                                            Datos de los equipos de GNV
                                        </x-slot>
                                        <x-slot name="icono">
                                            <i class="fas fa-archive fa-lg"></i>
                                        </x-slot>
                                    </x-slot>
                                @endif

                                @if ($equipos->count())
                                    <x-slot name="equip">
                                        <div wire:model="equipos">
                                            @foreach ($equipos as $e)
                                                @if (isset($e->idTipoEquipo))
                                                    @switch($e->idTipoEquipo)
                                                        @case(1)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
                                                                <div class="flex flex-row w-full">
                                                                    <div class="block  w-5/6">
                                                                        <span
                                                                            class="bg-teal-200 text-teal-800 text-xs px-2 inline-block rounded-full  uppercase font-semibold tracking-wide">
                                                                            <i class="fas fa-microchip"></i>&nbsp;{{ $e->tipo->nombre }}
                                                                        </span>
                                                                        <p>Serie: <strong>{{ $e->numSerie }}</strong></p>
                                                                    </div>
                                                                    <div class="w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @break

                                                        @case(2)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
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
                                                                    <div class=" w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @break

                                                        @case(3)
                                                            <div
                                                                class="block  w-5/6 bg-white border border-black p-2 rounded-lg shadow-lg m-auto mb-4">
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
                                                                    <div class="bg w-1/6 flex justify-end items-center">
                                                                        <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                                            wire:click="eliminaEquipo({{ $e }})">
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
                                        <p class="w-4/6 text-center p-2 text-sm text-gray-400 m-auto">No se encontraron equipos
                                            registrados en este vehículo</p>
                                    </x-slot>
                                @endif

                            </x-form-datos-equipos-gnv>
                        @break

                        @default
                    @endswitch
                @endif
                
                <div class="w-4/6 mx-auto my-8">
                    <x-jet-label value="Fotos reglamentarias:"/>
                    <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" multiple acceptedFileTypes="['image/*',]"  >   
                          
                    </x-file-pond>          
                    <x-jet-input-error for="imagenes"/>
                   
                </div>

                {{-- BOTONES --}}

                <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                    <div class="my-2 flex flex-row justify-evenly items-center">
                        @if (!isset($servicioCertificado))
                            <a wire:click="certificar"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-file-signature"></i>
                                    &nbsp;Generar Certificado</p>
                            </a>
                        @endif
                        @if (isset($servicioCertificado))
                            <a href="{{ $ruta }}" target="__blank"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-cyan-400 hover:bg-cyan-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-eye"></i> &nbsp;ver
                                    Certificado</p>
                            </a>
                            <a href="{{ $rutaDes }}" target="__blank"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-cyan-600 hover:bg-cyan-700 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-file-download"></i>
                                    &nbsp;Descargar Certificado</p>
                            </a>
                            <a href="{{ route('fichaTecnicaGnv', [$servicioCertificado->id]) }}" target="__blank"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-blue-400 hover:bg-blue-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-eye"></i> &nbsp;Ver
                                    Ficha T.</p>
                            </a>
                            <a href="{{ route('descargarFichaTecnicaGnv', [$servicioCertificado->id]) }}"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-eye"></i>
                                    &nbsp;Descargar Ficha T.</p>
                            </a>
                            <a href="{{ route('servicio') }}"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-red-400 hover:bg-red-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-archive"></i>
                                    &nbsp;Finalizar</p>
                            </a>
                        @endif
                    </div>
                </div>
            @break

            @case(8)
                @if (!isset($servicioCertificado))
                    <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4 px-8 flex flex-row justify-center items-center ">
                        <div class="w-3/6 block justify-center items-center space-x-2 md:flex">
                            <div class="flex items-center justify-center space-x-2 ">
                                <x-jet-label value="Placa:" for="placa" />
                                <x-jet-input type="text" wire:model="placa" type="text" maxlength="6" wire:keydown.enter="buscarCertificacion" />
                            </div>
                            <div class="pt-2 md:pt-0 flex m-auto w-full justify-center">
                                <button wire:click="buscarCertificacion"
                                    class="p-2 bg-indigo-400 rounded-lg border m-auto border-indigo-300 hover:bg-indigo-500 text-white hover:text-gray-200 shadow-lg">
                                    <i class="fas fa-search"></i>&nbsp;Buscar
                                </button>
                            </div>
                            <div class="md:pt-2 w-full">
                                <x-jet-input-error for="placa" />
                            </div>
                            
                        </div>
                        
                    </div>
                @endif

                @if ($servicioCertificado)
                    
                    <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4">                       
                            <div class="c-card block bg-white shadow-md rounded-lg overflow-hidden">                                
                                <div class="p-4">

                                    <span class="inline-block px-2 py-1 leading-none bg-amber-200 text-amber-800 rounded-full font-semibold  tracking-wide text-xs">
                                        {{$servicioCertificado->Servicio->tipoServicio->descripcion}}
                                    </span>
                                    
                                    <div class="my-2 flex flex row justify-between pr-4">
                                        <h2 class=" font-bold">
                                            <i class="fas fa-car"></i> &nbsp; <span class="text-indigo-600">{{$servicioCertificado->Vehiculo->placa}}</span>
                                        </h2>
                                        <p class=" font-bold">
                                            <i class="fas fa-file"></i>&nbsp; 
                                            <span class="text-red-500 font-bold">{{$servicioCertificado->serieFormato}} - {{$servicioCertificado->Hoja->añoActivo}}</span>
                                        </p>
                                    </div>
                                   
                                    <h3>
                                        <i class="my-2 fas fa-warehouse"></i> &nbsp;{{$servicioCertificado->Taller->nombre}}
                                    </h3>                                    
                                    
                                </div>
                                <div class="p-4 border-t  text-xs text-gray-700">
                                    <span class="flex items-center">
                                        <i class="far fa-address-card fa-fw text-gray-900 mr-2"></i> {{$servicioCertificado->Inspector->name}} 
                                    </span>
                                    <span class="flex items-center mb-1">
                                        <i class="far fa-clock fa-fw mr-2 text-gray-900"></i> 
                                        @if(isset($fechaCerti))
                                            @if($fechaCerti>1)
                                                certificado hace {{$fechaCerti}} días.
                                            @else
                                                certificado hace {{$fechaCerti}} día.
                                            @endif
                                        @endif
                                    </span>
                                   
                                </div>
                                @if(!$certDuplicado)                                
                                    <div class="p-2 border-t flex items-center justify-center " >
                                        <i class="fas fa-times-circle fa-2x hover:cursor-pointer hover: shadow-lg rounded-full text-red-400 hover:text-red-500 hover:shadow-sm hover:shadow-red-500" wire:click="reseteaBusquedaCert"></i>
                                    </div>
                                @endif

                            </div>
                        
                    </div>
                    
                @endif

                @if (!isset($certDuplicado))
                    @if ($servicioCertificado)
                        <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                            <div class="my-2 flex flex-row justify-evenly items-center">
                                <a wire:click="duplicarCertificado"
                                    class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                    <p class="text-sm font-medium leading-none text-white"><i class="far fa-copy"></i>
                                        &nbsp;Duplicar</p>
                                </a>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                        <div class="my-2 flex flex-row justify-evenly items-center">
                            <a href="{{ $ruta }}" target="__blank"
                                class="hover:cursor-pointer  focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i class="far fa-eye"></i> &nbsp;Ver
                                    Duplicado</p>
                            </a>
                            <a href="{{ route('servicio') }}"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-red-400 hover:bg-red-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white">
                                    <i class="fas fa-archive"></i>&nbsp;Finalizar
                                </p>
                            </a>
                        </div>
                    </div>
                @endif
            @break

            @default
        @endswitch






    @endif


    {{-- Modal agregar equipos --}}
    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            AGREGAR EQUIPO
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


    {{-- Modal Busqueda de Vehiculos --}}
    <x-jet-dialog-modal wire:model="busqueda">
        <x-slot name="title">

            <h1 class="text-3xl font-medium">vehículos</h1>

        </x-slot>
        <x-slot name="content">
            @if ($vehiculos)
                <p class="text-indigo-900">Se encontrarón <span
                        class="px-2 bg-indigo-400 rounded-full">{{ $vehiculos->count() }}</span> vehículos</p>
                <div class="my-5">
                    @foreach ($vehiculos as $key => $vehiculo)
                        <div
                            class="flex justify-between items-center border-b border-slate-200 py-3 px-2 border-l-4  border-l-transparent bg-gradient-to-r from-transparent to-transparent hover:border-l-4 hover:border-l-indigo-300  hover:from-slate-100 transition ease-linear duration-150">
                            <div class="inline-flex items-center space-x-2">
                                <div>
                                    <i class="fas fa-car"></i>
                                </div>
                                <div>{{ $vehiculo->placa }}</div>
                                <div>{{ $vehiculo->marca }}</div>
                                <div>{{ $vehiculo->modelo }}</div>
                                <div class="px-2 text-xs text-slate-600">
                                    {{ $vehiculo->created_at->format('d/m/Y  h:m:s') }}</div>
                            </div>
                            <div>
                                <i wire:click="seleccionaVehiculo({{ $key }})"
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

    {{-- Modal Busqueda de Certificaciones --}}
    <x-jet-dialog-modal wire:model="busquedaCert">
        <x-slot name="title">
            <h1 class="text-3xl font-medium">Certificaciones</h1>
        </x-slot>
        <x-slot name="content">
            @if (isset($certificaciones))
                <p class="text-indigo-900">Se encontrarón
                    <span class="px-2 bg-indigo-400 rounded-full"><a
                            class="text-white">{{ $certificaciones->count() }}</a></span> certificaciones
                </p>
                <div class="my-5">
                    @foreach ($certificaciones as $key => $certi)
                        <div
                            class="flex justify-between items-center border-b border-slate-200 py-3 px-2 border-l-4  border-l-transparent bg-gradient-to-r from-transparent to-transparent hover:border-l-4 hover:border-l-indigo-300  hover:from-slate-100 transition ease-linear duration-150">
                            <div class="inline-flex text-xs items-center space-x-2 md:text-base">
                                <div class="px-1 border-r-2 border-slate-300 ">
                                    <i class="fas fa-file"></i>&nbsp;{{ $certi->serieFormato }}
                                </div>
                                <div class="px-1 border-r-2 border-slate-300">
                                    <i class="fas fa-car"></i>&nbsp;{{ $certi->Vehiculo->placa }}
                                </div>
                                <div class="px-1 border-r-2 border-slate-300">
                                    <i class="fas fa-wrench"></i>&nbsp;<span
                                        class="p-1 bg-green-200 rounded-full">{{ $certi->Servicio->tipoServicio->descripcion }}</span>
                                </div>

                                <div class="px-2 text-xs text-slate-600">
                                    <i class="far fa-calendar-alt"></i> &nbsp;
                                    {{ $certi->created_at->format('d/m/Y  h:m:s') }}
                                </div>
                            </div>
                            <div>
                                <i wire:click="seleccionaCertificacion({{ $key }})"
                                    class="fas fa-plus-circle fa-lg md:fa-2x rounded-full hover: cursor-pointer hover: shadow-lg"
                                    style="color:#6366f1;"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-slate-500 text-center">Selecciona una de estas certificaciones para duplicar
                    certificado.</p>
            @endif



        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('busquedaCert',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
