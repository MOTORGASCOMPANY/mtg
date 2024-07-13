<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        {{-- PARA SELECCIONAR QUE TABLA QUIERO VER --}}
        @if (!$modelo)
            <h1 class="text-center text-xl my-4 font-bold text-indigo-900"> LISTA DE CERTIFICACIONES</h1>
            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4">
                <div class="bg-indigo-200 rounded-lg py-4 px-2 grid grid-cols-1 gap-8 sm:grid-cols-1">
                    <div class="flex items-center justify-center">
                        <x-jet-label value="MODELO:" class="mr-2" />
                        <select wire:model="modelo"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none ml-1 block w-1/3">
                            <option value="">Seleccione</option>
                            <option value="chipsConsumidos">Lista de Chips</option>
                            <option value="desmontes">Lista de Desmontes</option>                     
                            <option value="taller">Inspeccion del Taller</option>
                            <option value="carta">Carta Aclaratoria Sunarp</option>                   
                            <!--option value="certificaciones">Certificaciones Pendientes</option-->         
                        </select>
                        <x-jet-input-error for="modelo" />
                    </div>
                </div>
            </div>
        @endif


        {{-- MOSTRAR LISTA DESMONTE --}}
        @if ($modelo === 'desmontes')
            @if ($desmontes)
                <x-custom-table>
                    <x-slot name="titulo">
                        <h2 class="text-indigo-600 font-bold text-3xl uppercase">
                            <i class="fa-solid fa-file-circle-check fa-xl text-indigo-600"></i>
                            &nbsp;Listado de Desmontes
                        </h2>
                    </x-slot>

                    <x-slot name="btnAgregar" class="mt-6 ">
                    </x-slot>

                    <x-slot name="contenido">
                        @if (count($desmontes))
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8" wire:loading.remove wire:target="search">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full leading-normal rounded-md">
                                            <thead>
                                                <tr>
                                                    <th class=" w-24 cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('id')">
                                                        Id
                                                        @if ($sort == 'id')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Servicio
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('idInspector')">
                                                        Inspector
                                                        @if ($sort == 'idInspector')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('idTaller')">
                                                        Taller
                                                        @if ($sort == 'idTaller')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('placa')">
                                                        Placa
                                                        @if ($sort == 'placa')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('created_at')">
                                                        Fecha de creación
                                                        @if ($sort == 'created_at')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Estado
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($desmontes as $item)
                                                    <tr>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                                                    {{ $item->id }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    {{ $item->Servicio->tipoServicio->descripcion }}
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap">
                                                                    {{ $item->Inspector->name }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-orange-200 rounded-full">
                                                                    {{ $item->Taller->nombre }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="p-2 border  rounded-md font-black text-md">
                                                                    {{ $item->placa }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap uppercase">
                                                                    {{ $item->created_at->format('d-m-Y h:m:i a') }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center">
                                                                @switch($item->estado)
                                                                    @case(1)
                                                                        <i class="far fa-check-circle fa-lg"
                                                                            style="color: forestgreen;"></i>
                                                                    @break

                                                                    @case(2)
                                                                        <i class="far fa-times-circle fa-lg"
                                                                            style="color: red;"></i>
                                                                    @break

                                                                    @case(3)
                                                                        <i
                                                                            class="fa-regular fa-circle-pause fa-lg text-amber-400"></i>
                                                                    @break

                                                                    @default
                                                                @endswitch
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center"
                                                                x-data="{ menu: false }">
                                                                <button
                                                                    class="focus:ring-2 rounded-md focus:outline-none hover:text-indigo-500"
                                                                    role="button" x-on:click="menu = ! menu"
                                                                    id="menu-button" aria-expanded="true"
                                                                    aria-haspopup="true" data-te-ripple-init
                                                                    data-te-ripple-color="light" aria-label="option">
                                                                    <i class="fa-solid fa-ellipsis fa-xl"></i>
                                                                </button>
                                                                <div x-show="menu" x-on:click.away="menu = false"
                                                                    class="dropdown-content flex flex-col  bg-white shadow w-48 absolute z-30 right-0 mt-20 mr-6">
                                                                    <button
                                                                        class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                        <i class="fas fa-trash"></i>
                                                                        <span>Eliminar</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md w-full" wire:loading
                                wire:target="search">
                                <i class="fa-solid fa-circle-notch fa-xl animate-spin text-indigo-800 "></i>
                                <p class="text-center text-black font-bold italic">CARGANDO...</p>
                            </div>
                            @if ($desmontes->hasPages())
                                <div>
                                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                            <div class="px-5 py-5 bg-white border-t">
                                                {{ $desmontes->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                                No se encontro ningun registro.
                            </div>
                        @endif
                    </x-slot>

                </x-custom-table>
            @endif
        @endif

        {{--  MOSTRAR CERTIFICADOS PENDIENTES --}}
        @if ($modelo === 'certificaciones')
            @if ($certificaciones)
                <x-custom-table>
                    <x-slot name="titulo">
                        <h2 class="text-indigo-600 font-bold text-3xl uppercase">
                            <i class="fa-solid fa-file-circle-check fa-xl text-indigo-600"></i>
                            &nbsp;Listado de Certificaciones Pendientes
                        </h2>
                    </x-slot>

                    <x-slot name="btnAgregar" class="mt-6 ">
                    </x-slot>

                    <x-slot name="contenido">
                        @if (count($certificaciones))
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8" wire:loading.remove wire:target="search">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full leading-normal rounded-md">
                                            <thead>
                                                <tr>
                                                    <th class=" w-24 cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('id')">
                                                        Id
                                                        @if ($sort == 'id')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Servicio
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('idInspector')">
                                                        Inspector
                                                        @if ($sort == 'idInspector')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('idTaller')">
                                                        Taller
                                                        @if ($sort == 'idTaller')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('placa')">
                                                        Placa
                                                        @if ($sort == 'placa')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('created_at')">
                                                        Fecha de creación
                                                        @if ($sort == 'created_at')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Estado
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($certificaciones as $item)
                                                    <tr>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                                                    {{ $item->id }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    {{ $item->Servicio->tipoServicio->descripcion }}
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap">
                                                                    {{ $item->Inspector->name }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-orange-200 rounded-full">
                                                                    {{ $item->Taller->nombre }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="p-2 border  rounded-md font-black text-md">
                                                                    {{ $item->Vehiculo->placa }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap uppercase">
                                                                    {{ $item->created_at->format('d-m-Y h:m:i a') }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center">
                                                                @switch($item->estado)
                                                                    @case(1)
                                                                        <i class="far fa-check-circle fa-lg"
                                                                            style="color: forestgreen;"></i>
                                                                    @break

                                                                    @case(2)
                                                                        <i class="far fa-times-circle fa-lg"
                                                                            style="color: red;"></i>
                                                                    @break

                                                                    @case(3)
                                                                        <i
                                                                            class="fa-regular fa-circle-pause fa-lg text-amber-400"></i>
                                                                    @break

                                                                    @default
                                                                @endswitch
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center"
                                                                x-data="{ menu: false }">
                                                                <button
                                                                    class="focus:ring-2 rounded-md focus:outline-none hover:text-indigo-500"
                                                                    role="button" x-on:click="menu = ! menu"
                                                                    id="menu-button" aria-expanded="true"
                                                                    aria-haspopup="true" data-te-ripple-init
                                                                    data-te-ripple-color="light" aria-label="option">
                                                                    <i class="fa-solid fa-ellipsis fa-xl"></i>
                                                                </button>
                                                                <div x-show="menu" x-on:click.away="menu = false"
                                                                    class="dropdown-content flex flex-col  bg-white shadow w-48 absolute z-30 right-0 mt-20 mr-6">
                                                                    <button
                                                                        class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                        <i class="fas fa-trash"></i>
                                                                        <span>Eliminar</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md w-full" wire:loading
                                wire:target="search">
                                <i class="fa-solid fa-circle-notch fa-xl animate-spin text-indigo-800 "></i>
                                <p class="text-center text-black font-bold italic">CARGANDO...</p>
                            </div>
                            @if ($certificaciones->hasPages())
                                <div>
                                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                            <div class="px-5 py-5 bg-white border-t">
                                                {{ $certificaciones->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                                No se encontro ningun registro.
                            </div>
                        @endif
                    </x-slot>

                </x-custom-table>
            @endif
        @endif

        {{--  MOSTRAR INSPECCION DE TALLER --}}
        @if ($modelo === 'taller')
            @if ($taller)
                <x-custom-table>
                    <x-slot name="titulo">
                        <h2 class="text-indigo-600 font-bold text-3xl uppercase">
                            <i class="fa-solid fa-file-circle-check fa-xl text-indigo-600"></i>
                            &nbsp;Listado de Inspeccion de Taller
                        </h2>
                    </x-slot>

                    <x-slot name="btnAgregar" class="mt-6 ">
                    </x-slot>

                    <x-slot name="contenido">
                        @if (count($taller))
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8" wire:loading.remove wire:target="search">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full leading-normal rounded-md">
                                            <thead>
                                                <tr>
                                                    <th class=" w-24 cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('id')">
                                                        Id
                                                        @if ($sort == 'id')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>

                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Taller
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Inspector
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Servicio
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Inicial / Anual
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        N° Formato
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('created_at')">
                                                        Fecha de creación
                                                        @if ($sort == 'created_at')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Estado
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Documentos
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($taller as $item)
                                                    <tr>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                                                    {{ $item->id }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-orange-200 rounded-full">
                                                                    {{ $item->Taller->nombre }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap">
                                                                    {{ $item->Inspector->name }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    Inspeccion de Taller
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center">
                                                                @if ($item->inicial == 0)
                                                                    <p class="whitespace-no-wrap">
                                                                        ANUAL
                                                                    </p>
                                                                @elseif($item->inicial == 1)
                                                                    <p class="whitespace-no-wrap">
                                                                        INICIAL
                                                                    </p>
                                                                @else
                                                                    <p class="whitespace-no-wrap">
                                                                        Sin datos
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </td>

                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center">
                                                                @if (isset($item->Material->numSerie))
                                                                    <p
                                                                        class="text-sm font-semibold  text-gray-600 p-1 bg-indigo-100 rounded-full">
                                                                        {{ $item->Material->numSerie }}</p>
                                                                @else
                                                                    <p
                                                                        class="text-sm font-semibold  text-gray-600 p-1 bg-indigo-100 rounded-full">
                                                                        Sin datos</p>
                                                                @endif
                                                            </div>
                                                        </td>

                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap uppercase">
                                                                    {{ $item->created_at->format('d-m-Y h:m:i a') }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center">
                                                                @switch($item->estado)
                                                                    @case(1)
                                                                        <i class="far fa-check-circle fa-lg"
                                                                            style="color: forestgreen;"></i>
                                                                    @break

                                                                    @case(2)
                                                                        <i class="far fa-times-circle fa-lg"
                                                                            style="color: red;"></i>
                                                                    @break

                                                                    @case(3)
                                                                        <i
                                                                            class="fa-regular fa-circle-pause fa-lg text-amber-400"></i>
                                                                    @break

                                                                    @default
                                                                @endswitch
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center">
                                                                <a href="{{ $item->rutaVistaCertificado }}"
                                                                    target="__blank" rel="noopener noreferrer"
                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-indigo-400 text-xs w-full cursor-pointer hover:text-indigo-400">
                                                                    <i class="fas fa-eye"></i>
                                                                    <span>Ver Insp.</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center"
                                                                x-data="{ menu: false }">
                                                                <button
                                                                    class="focus:ring-2 rounded-md focus:outline-none hover:text-indigo-500"
                                                                    role="button" x-on:click="menu = ! menu"
                                                                    id="menu-button" aria-expanded="true"
                                                                    aria-haspopup="true" data-te-ripple-init
                                                                    data-te-ripple-color="light" aria-label="option">
                                                                    <i class="fa-solid fa-ellipsis fa-xl"></i>
                                                                </button>
                                                                <div x-show="menu" x-on:click.away="menu = false"
                                                                    class="dropdown-content flex flex-col  bg-white shadow w-48 absolute z-30 right-0 mt-20 mr-6">
                                                                    <button
                                                                        class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                        <i class="fas fa-trash"></i>
                                                                        <span>Eliminar</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md w-full" wire:loading
                                wire:target="search">
                                <i class="fa-solid fa-circle-notch fa-xl animate-spin text-indigo-800 "></i>
                                <p class="text-center text-black font-bold italic">CARGANDO...</p>
                            </div>
                            @if ($taller->hasPages())
                                <div>
                                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                            <div class="px-5 py-5 bg-white border-t">
                                                {{ $taller->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                                No se encontro ningun registro.
                            </div>
                        @endif
                    </x-slot>

                </x-custom-table>
            @endif
        @endif

        {{--  MOSTRAR CARTA ACLARATORIA --}}
        @if ($modelo === 'carta')
            @if ($carta)
                <x-custom-table>
                    <x-slot name="titulo">
                        <h2 class="text-indigo-600 font-bold text-3xl uppercase">
                            <i class="fa-solid fa-file-circle-check fa-xl text-indigo-600"></i>
                            &nbsp;Listado de Cartas Aclaratorias
                        </h2>
                    </x-slot>

                    <x-slot name="btnAgregar" class="mt-6 ">
                    </x-slot>

                    <x-slot name="contenido">
                        @if (count($carta))
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8" wire:loading.remove wire:target="search">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full leading-normal rounded-md">
                                            <thead>
                                                <tr>
                                                    <th class=" w-24 cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('id')">
                                                        Id
                                                        @if ($sort == 'id')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Inspector
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Razon
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Servicio
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Placa
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        N° Formato
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                        wire:click="order('created_at')">
                                                        Fecha de creación
                                                        @if ($sort == 'created_at')
                                                            @if ($direction == 'asc')
                                                                <i
                                                                    class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                            @else
                                                                <i
                                                                    class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                                        @endif
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Estado
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Documentos
                                                    </th>
                                                    <th
                                                        class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($carta as $item)
                                                    <tr>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                                                    {{ $item->id }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    {{ $item->Inspector->name }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap">
                                                                    Carta Aclaratoria
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-orange-200 rounded-full">
                                                                    {{ $item->tipo }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="p-2 border  rounded-md font-black text-md">
                                                                    {{ $item->placa }}
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                @if (isset($item->Material->numSerie))
                                                                    <p
                                                                        class="text-sm font-semibold  text-gray-600 p-1 bg-indigo-100 rounded-full">
                                                                        {{ $item->Material->numSerie }}</p>
                                                                @else
                                                                    <p
                                                                        class="text-sm font-semibold  text-gray-600 p-1 bg-indigo-100 rounded-full">
                                                                        Sin datos</p>
                                                                @endif
                                                            </div>
                                                        </td>

                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap uppercase">
                                                                    {{ $item->created_at->format('d-m-Y h:m:i a') }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center">
                                                                @switch($item->estado)
                                                                    @case(1)
                                                                        <i class="far fa-check-circle fa-lg"
                                                                            style="color: forestgreen;"></i>
                                                                    @break

                                                                    @case(2)
                                                                        <i class="far fa-times-circle fa-lg"
                                                                            style="color: red;"></i>
                                                                    @break

                                                                    @case(3)
                                                                        <i
                                                                            class="fa-regular fa-circle-pause fa-lg text-amber-400"></i>
                                                                    @break

                                                                    @default
                                                                @endswitch
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center">
                                                                <a href="{{ $item->rutaVistaCertificado }}"
                                                                    target="__blank" rel="noopener noreferrer"
                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-indigo-400 text-xs w-full cursor-pointer hover:text-indigo-400">
                                                                    <i class="fas fa-eye"></i>
                                                                    <span>Ver Insp.</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center"
                                                                x-data="{ menu: false }">
                                                                <button
                                                                    class="focus:ring-2 rounded-md focus:outline-none hover:text-indigo-500"
                                                                    role="button" x-on:click="menu = ! menu"
                                                                    id="menu-button" aria-expanded="true"
                                                                    aria-haspopup="true" data-te-ripple-init
                                                                    data-te-ripple-color="light" aria-label="option">
                                                                    <i class="fa-solid fa-ellipsis fa-xl"></i>
                                                                </button>
                                                                <div x-show="menu" x-on:click.away="menu = false"
                                                                    class="dropdown-content flex flex-col  bg-white shadow w-48 absolute z-30 right-0 mt-20 mr-6">
                                                                    <button
                                                                        class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                        <i class="fas fa-trash"></i>
                                                                        <span>Eliminar</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md w-full" wire:loading
                                wire:target="search">
                                <i class="fa-solid fa-circle-notch fa-xl animate-spin text-indigo-800 "></i>
                                <p class="text-center text-black font-bold italic">CARGANDO...</p>
                            </div>
                            @if ($carta->hasPages())
                                <div>
                                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                            <div class="px-5 py-5 bg-white border-t">
                                                {{ $carta->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                                No se encontro ningun registro.
                            </div>
                        @endif
                    </x-slot>

                </x-custom-table>
            @endif
        @endif

        {{--  MOSTRAR LISTA CHIPS --}}
        @if ($modelo === 'chipsConsumidos')
            @if ($chipsConsumidos)
                <x-custom-table>
                    <x-slot name="titulo">
                        <h2 class="text-indigo-600 font-bold text-3xl uppercase">
                            <i class="fa-solid fa-file-circle-check fa-xl text-indigo-600"></i>
                            &nbsp;Listado de Chips
                        </h2>
                    </x-slot>

                    <x-slot name="btnAgregar" class="mt-6 ">
                    </x-slot>

                    <x-slot name="contenido">
                        @if (count($chipsConsumidos))
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8" wire:loading.remove wire:target="search">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full leading-normal rounded-md">
                                            <thead>
                                                <tr>
                                                    <th class=" w-24 cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        #
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Inspector
                                                    </th>
                                                    <th class=" w-24 cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Id
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Servicio
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Estado
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Ubicación
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Grupo
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Fecha de creación
                                                    </th>
                                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($chipsConsumidos as $key => $item)
                                                    <tr>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                                                    {{ $key + 1 }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap">
                                                                    {{ $item->nombreInspector }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="p-2 border  rounded-md font-black text-md">
                                                                    {{ $item->id }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    @if (Str::startsWith($item->ubicacion, 'En poder del cliente '))
                                                                        Chip por deterioro
                                                                    @else
                                                                        Conversión a GNV + chip
                                                                    @endif
                                                                </p>                                                                
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap">
                                                                    @if ($item->estado == 4)
                                                                        Consumido
                                                                    @else
                                                                        {{ $item->estado }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="text-sm leading-none text-gray-600 ml-2 p-2 bg-orange-200 rounded-full">   
                                                                    {{ $item->ubicacion }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="p-2 border  rounded-md font-black text-md">
                                                                    {{ $item->grupo }}
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-no-wrap uppercase">
                                                                    {{ $item->updated_at->format('d-m-Y h:m:i a') }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center justify-center"
                                                                x-data="{ menu: false }">
                                                                <button
                                                                    class="focus:ring-2 rounded-md focus:outline-none hover:text-indigo-500"
                                                                    role="button" x-on:click="menu = ! menu"
                                                                    id="menu-button" aria-expanded="true"
                                                                    aria-haspopup="true" data-te-ripple-init
                                                                    data-te-ripple-color="light" aria-label="option">
                                                                    <i class="fa-solid fa-ellipsis fa-xl"></i>
                                                                </button>
                                                                <div x-show="menu" x-on:click.away="menu = false"
                                                                    class="dropdown-content flex flex-col  bg-white shadow w-48 absolute z-30 right-0 mt-20 mr-6">
                                                                    <button
                                                                        class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                        <i class="fas fa-trash"></i>
                                                                        <span>Eliminar</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md w-full" wire:loading
                                wire:target="search">
                                <i class="fa-solid fa-circle-notch fa-xl animate-spin text-indigo-800 "></i>
                                <p class="text-center text-black font-bold italic">CARGANDO...</p>
                            </div>
                            @if ($chipsConsumidos->hasPages())
                                <div>
                                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                            <div class="px-5 py-5 bg-white border-t">
                                                {{ $chipsConsumidos->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                                No se encontro ningun registro.
                            </div>
                        @endif
                    </x-slot>

                </x-custom-table>
            @endif
        @endif


    </div>
</div>
