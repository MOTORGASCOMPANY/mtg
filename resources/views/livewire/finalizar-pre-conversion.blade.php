<div>

    <div class="container block justify-center m-auto pt-12" wire:loading.remove wire:target="finalizar">

        <h1 class="text-3xl text-center font-bold text-indigo-600 uppercase">
            <i class="fas fa-check "></i>
            Finalizar Pre-Conversión
        </h1>

        <div
            class="rounded-xl m-4 bg-white p-8 mx-auto max-w-max-xl shadow-lg block space-y-2 md:space-y-0 md:flex md:space-x-2">

            <div class="w-full md:w-2/6  ">
                <div class="border bg-gray-100 rounded-md p-2 w-full">
                    <h3 class="font-bold text-indigo-400 text-center italic uppercase">Datos del servicio:</h3>
                    <p class="text-gray-600"><i class="fa-solid fa-file-contract"></i> N° Formato: <span
                            class="font-bold">{{ $certificacion->Hoja->numSerie }}</span></p>
                    <p class="text-gray-600"><i class="fa-solid fa-car-side"></i> VIN/serie del Vehículo: <span
                            class="font-bold">{{ $certificacion->Vehiculo->numSerie }}</span></p>
                    <p class="text-gray-600"><i class="fa-solid fa-warehouse"></i> Taller: <span
                            class="font-bold">{{ $certificacion->Taller->nombre }}</span></p>
                    <p class="text-gray-600"><i class="fa-solid fa-user"></i> Inspector: <span
                            class="font-bold">{{ $certificacion->Inspector->name }}</span></p>
                </div>
            </div>
            <div class="w-full md:w-4/6 border bg-indigo-100 rounded-md h-auto p-4">

                <h3 class="font-bold text-indigo-400 italic uppercase mt-2">Datos de equipos:</h3>
                @if ($vehiculo->Equipos)
                    <div wire:model="equipos">
                        @foreach ($vehiculo->Equipos as $e)
                            @if (isset($e->idTipoEquipo))
                                @switch($e->idTipoEquipo)
                                    @case(1)
                                        <div class="block  w-full bg-white border p-2 rounded-lg shadow-md m-auto my-4">
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
                                                </div>
                                            </div>
                                        </div>
                                    @break

                                    @case(2)
                                        <div class="block  w-full bg-white border p-2 rounded-lg shadow-md m-auto my-4">
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
                                                    {{--
                                                        <a class="bg-red-300 p-4 rounded-xl hover:bg-red-500 hover:cursor-pointer"
                                                            wire:click="delete({{ $e }})">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                        --}}
                                                </div>
                                            </div>
                                        </div>
                                    @break

                                    @case(3)
                                        <div class="block  w-full bg-white border p-2 rounded-lg shadow-md m-auto my-4">
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

                                                </div>
                                            </div>
                                        </div>
                                    @break

                                    @case(4)
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
                                                <div class=" w-1/6 flex justify-end items-center space-x-2">
                                                    <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                        wire:click="edit({{ $e }})">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    {{--
                                                    <a class="bg-red-300 p-4 rounded-xl hover:bg-red-500 hover:cursor-pointer"
                                                        wire:click="delete({{ $e }})">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    --}}
                                                </div>
                                            </div>
                                        </div>
                                    @break

                                    @case(5)
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
                                                    <p>Modelo: <strong>{{ $e->modelo }}</strong></p>
                                                </div>
                                                <div class="bg w-1/6 flex justify-end items-center space-x-2">
                                                    <a class="bg-amber-300 p-4 rounded-xl hover:bg-amber-500 hover:cursor-pointer"
                                                        wire:click="edit({{ $e }})">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    {{--
                                                    <a class="bg-red-300 p-4 rounded-xl hover:bg-red-500 hover:cursor-pointer"
                                                        wire:click="delete({{ $e }})">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    --}}
                                                </div>
                                            </div>
                                        </div>
                                    @break

                                    @default
                                @endswitch
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="w-4/6 text-center p-2 text-sm text-gray-400 m-auto">No se encontraron Equipos
                        registrados en este vehículo</p>

                @endif


                <h3 class="font-bold text-indigo-400 italic uppercase mb-2">Datos del Vehículo:</h3>
                <div class="flex flex-row w-full justify-space-between space-x-2">

                    <div class="w-full md:w-2/6 flex items-center">
                        <x-jet-label value="Placa:" />
                        <x-jet-input type="text" class="w-full" wire:model="vehiculo.placa" maxlength="7" />
                    </div>
                    <div class="w-full md:w-2/6 flex items-center">
                        <x-jet-label value="Año de fabricación:" />
                        <x-jet-input type="text" class="w-full" wire:model="vehiculo.anioFab" maxlength="7"
                            inputmode="numeric" pattern="[0-9]*" />
                    </div>
                    {{-- validacion para que solo aparezca para gnv y no para glp --}}
                    @if ($tipoServicio == 'Pre-conversión GNV') {{--|| $tipoServicio == 'Pre-conversión GLP'--}}
                    <div class="w-full md:w-2/6 flex justify-center items-center">
                        <input wire:model="conChip" id="checkbox1" type="checkbox" value="1"
                            class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500">
                        <label for="checkbox1"
                            class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer ">
                            Incluye Chip
                        </label>
                    </div>
                    @endif

                </div>
                <x-jet-input-error for="vehiculo.placa" />
                <x-jet-input-error for="vehiculo.anioFab" />


                <div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300  mt-4 p-2">
                    <x-jet-label value="Fotos reglamentarias:" class="font-bold text-lg" />
                    <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" acceptedFileTypes="['image/*',]"
                        aceptaVarios="true">

                    </x-file-pond>
                    <x-jet-input-error for="imagenes" />
                </div>
            </div>
        </div>
        <div class="max-w-8xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
            <div class="my-2 flex flex-row justify-evenly items-center">
                <button wire:click="completar" wire:loading.attr="disabled" wire.target="completar"
                    class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                    <p class="text-sm font-medium leading-none text-white">
                        <span wire:loading wire:target="completar">
                            <i class="fas fa-spinner animate-spin"></i>
                            &nbsp;
                        </span>
                        &nbsp;Completar
                    </p>
                </button>
            </div>
        </div>

    </div>

    <div class="hidden w-full h-screen flex flex-col justify-center items-center bg-gray-200 "
        wire:loading.remove.class="hidden" wire:target="finalizar">
        <div class="flex">
            <img src="{{ asset('images/mtg.png') }}" alt="Logo Motorgas Company" width="150" height="150">
        </div>
        <div class="text-center">
            <i class="fa-solid fa-circle-notch fa-xl animate-spin text-indigo-800 "></i>

            <p class="text-center text-black font-bold italic">CARGANDO...</p>
        </div>
        <div class="flex">
        </div>
    </div>

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
