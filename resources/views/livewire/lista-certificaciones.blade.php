<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <x-custom-table>
            <x-slot name="titulo">
                <h2 class="text-indigo-600 font-bold text-3xl uppercase">
                    <i class="fa-solid fa-file-circle-check fa-xl text-indigo-600"></i>
                    &nbsp;Listado de Certificaciones
                </h2>
            </x-slot>
            <x-slot name="btnAgregar" class="mt-6 ">
            </x-slot>

            <x-slot name="contenido">
                @if ($certificaciones->count())
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
                                                        <i class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('idServicio')">
                                                Servicio
                                                @if ($sort == 'idServicio')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
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
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('idVehiculo')">
                                                Placa
                                                @if ($sort == 'idVehiculo')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>

                                            <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('created_at')">
                                                Fecha
                                                @if ($sort == 'created_at')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                N° Formato
                                            </th>

                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Estado
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Documentos
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
                                                        <p class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                                            {{ $item->id }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        @switch($item->Servicio->tipoServicio->id)
                                                            @case(1)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    Conversion a GNV
                                                                </p>
                                                            @break

                                                            @case(2)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    Revision anual GNV
                                                                </p>
                                                            @break

                                                            @case(3)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-orange-200 rounded-full">
                                                                    Conversion a GLP
                                                                </p>
                                                            @break

                                                            @case(4)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-orange-200 rounded-full">
                                                                    Revision anual GLP
                                                                </p>
                                                            @break
                                                            @case(5)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-blue-200 rounded-full">
                                                                    Modificación
                                                                </p>
                                                            @break

                                                            @case(8)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    Duplicado GNV
                                                                </p>
                                                            @break

                                                            @case(9)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-orange-200 rounded-full">
                                                                    Duplicado GNV
                                                                </p>
                                                            @break

                                                            @case(10)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    Conversion a GNV + chip
                                                                </p>
                                                            @break
                                                            @case(11)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    Chip por deterioro
                                                                </p>
                                                            @break

                                                            @case(12)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                                    {{ $item->Servicio->tipoServicio->descripcion ?? 'Sin Datos' }}
                                                                </p>
                                                            @break
                                                            @case(13)
                                                                <p
                                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-orange-200 rounded-full">
                                                                    {{ $item->Servicio->tipoServicio->descripcion ?? 'Sin Datos' }}
                                                                </p>
                                                            @break

                                                            @default
                                                                <p class="text-sm leading-none text-gray-600 ml-2">
                                                                    {{ $item->Servicio->tipoServicio->descripcion ?? 'Sin Datos' }}
                                                                </p>
                                                        @endswitch

                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="whitespace-no-wrap">
                                                            {{ $item->Taller->nombre }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        @if (isset($item->Vehiculo->placa))
                                                            <p class="p-2 border  rounded-md font-black text-md">
                                                                {{ $item->Vehiculo->placa }}
                                                            </p>
                                                        @else
                                                            N/A
                                                        @endif
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
                                                        @if (isset($item->Hoja->numSerie))
                                                            <p
                                                                class="text-sm font-semibold  text-gray-600 p-1 bg-orange-100 rounded-full">
                                                                {{ $item->Hoja->numSerie }}</p>
                                                        @else
                                                            <p
                                                                class="text-sm font-semibold  text-gray-600 p-1 bg-orange-100 rounded-full">
                                                                Sin datos</p>
                                                        @endif
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
                                                                <i class="far fa-times-circle fa-lg" style="color: red;"></i>
                                                            @break

                                                            @case(3)
                                                                <i class="fa-regular fa-circle-pause fa-lg text-amber-400"></i>
                                                            @break

                                                            @default
                                                        @endswitch
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center justify-center"
                                                        x-data="{ menus: false }">
                                                        <button
                                                            class="hover:animate-pulse inline-block rounded-full bg-amber-400 p-2 uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:bg-amber-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-amber-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-amber-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"
                                                            role="button" x-on:click="menus = ! menus" id="menu-button"
                                                            aria-expanded="true" aria-haspopup="true"
                                                            data-te-ripple-init data-te-ripple-color="light"
                                                            aria-label="option">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="currentColor" class="h-4 w-4">
                                                                <path fill-rule="evenodd"
                                                                    d="M19.5 21a3 3 0 003-3V9a3 3 0 00-3-3h-5.379a.75.75 0 01-.53-.22L11.47 3.66A2.25 2.25 0 009.879 3H4.5a3 3 0 00-3 3v12a3 3 0 003 3h15zm-6.75-10.5a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V10.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                        <div x-show="menus" x-on:click.away="menus = false"
                                                            class="dropdown-content flex flex-col border bg-white shadow-xl w-48 absolute z-30 right-0 mt-60 mr-48">
                                                            <a href="{{ $item->rutaVistaCertificado }}" target="__blank"
                                                                rel="noopener noreferrer"
                                                                class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                <i class="fas fa-eye"></i>
                                                                <span>Ver Certificado.</span>
                                                            </a>
                                                            @if ($item->Servicio->tipoServicio->id != 8)
                                                                <a href="{{ $item->rutaDescargaCertificado }}"
                                                                    target="__blank" rel="noopener noreferrer"
                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                @else
                                                                    <a href="{{ $item->rutaDescargaCertificado }}"
                                                                        target="__blank" rel="noopener noreferrer"
                                                                        class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                            @endif
                                                            <i class="fas fa-download"></i>
                                                            <span>desc. Certificado</span>
                                                            </a>
                                                            @if ($item->Servicio->tipoServicio->id == 1 || $item->Servicio->tipoServicio->id == 10)
                                                                <a href="{{ route('preConversionGnv', [$item->id]) }}"
                                                                    target="__blank" rel="noopener noreferrer"
                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                    <i class="fas fa-eye"></i>
                                                                    <span>Ver Preconversion.</span>
                                                                </a>
                                                            @endif
                                                            @if ($item->Servicio->tipoServicio->id != 8)
                                                                <a href="{{ $item->rutaVistaFt }}" target="__blank"
                                                                    rel="noopener noreferrer"
                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                    <i class="fas fa-eye"></i>
                                                                    <span>Ver Ficha Tec.</span>
                                                                </a>
                                                                <a href="{{ $item->rutaDescargaFt }}"
                                                                    target="__blank" rel="noopener noreferrer"
                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                    <i class="fas fa-download"></i>
                                                                    <span>desc. Ficha Tec.</span>
                                                                </a>
                                                                <a href="{{ route('checkListArribaGnv', [$item->id]) }}"
                                                                    target="__blank" rel="noopener noreferrer"
                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                    <i class="fas fa-eye"></i>
                                                                    <span>CheckList Arriba</span>
                                                                </a>
                                                                <a href="{{ route('checkListAbajoGnv', [$item->id]) }}"
                                                                    target="__blank" rel="noopener noreferrer"
                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                    <i class="fas fa-eye"></i>
                                                                    <span>CheckList Abajo</span>
                                                                </a>
                                                            @endif
                                                        </div>
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
                                                            class="dropdown-content flex flex-col  border bg-white shadow w-48 absolute z-30 right-0 mt-24 mr-6">
                                                            @if ($item->Servicio->tipoServicio->id == 12 || $item->Servicio->tipoServicio->id == 13 && $item->estado == 3)
                                                                <button
                                                                    wire:click="finalizarPreconversion({{ $item->id }})"
                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                    <i class="fa-solid fa-boxes-packing"></i>
                                                                    <span>Finalizar conversión</span>
                                                                </button>
                                                            @endif
                                                            <button
                                                                wire:click="solicitarAnulacion({{ $item->id }})"
                                                                class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                <i class="fa-solid fa-file-circle-xmark"></i>
                                                                <span>Solicitar anulacion</span>
                                                            </button>
                                                            <button
                                                                wire:click="solicitarEliminacion({{ $item->id }})"
                                                                class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">

                                                                <i class="fa-solid fa-file-circle-minus"></i>
                                                                <span>Solicitar eliminacion</span>
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
                                        {{ $certificaciones->withQueryString()->links() }}
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
    </div>

    <x-jet-dialog-modal wire:model="anular">
        <x-slot name="title">
            <h1 class="text-xl font-bold">Solicitar Anulación</h1>
        </x-slot>
        <x-slot name="content">
            <div>
                <div class="mb-4">
                    <x-jet-label class="block mt-2 text-sm font-medium text-gray-600" value="Motivo:" />
                    <x-jet-input type="text" id="motivo" wire:model="motivo" class="w-full mt-1 form-input" />
                    <x-jet-input-error for="motivo" />
                </div>
                <div class="mb-4">
                    <x-jet-label class="block mt-4 text-sm font-medium text-gray-600" value="Seleccionar Imagen:" />
                    <x-jet-input type="file" id="imagen" wire:model="imagen"/>
                    <x-jet-input-error for="imagen" />
                </div>
                <div class="mb-4">
                    @if ($imagen)
                        <img src="{{ $imagen->temporaryUrl() }}" alt="Vista Previa" class="mt-2 max-w-sm">
                    @endif
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('anular',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="guardarSolicitudAnulacion" wire:loading.attr="disabled"
                wire:target="guardarSolicitudAnulacion">
                Agregar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>
