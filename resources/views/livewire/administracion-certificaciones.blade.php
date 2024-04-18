<div>
    <x-table-administracion-certificaciones>
        <div class="bg-white md:py-7 w-full">
            <div class="sm:flex items-center justify-between">
                <div class="flex items-center space-x-2">

                    <div class="flex bg-gray-200 items-center p-2 rounded-md mb-4 ">
                        <span>Inspector: </span>
                        <select wire:model="ins"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                            <option value="">SELECCIONE</option>
                            @isset($inspectores)
                                @foreach ($inspectores as $inspector)
                                    <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="flex bg-gray-200 items-center p-2 rounded-md mb-4 ">
                        <span>Servicio: </span>
                        <select wire:model="servicio"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                            <option value="">SELECCIONE</option>
                            @isset($tipos)
                                @foreach ($tipos as $tipo)
                                    <option class="" value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="flex bg-gray-200 items-center p-2 rounded-md mb-4 ">
                        <span>Taller: </span>
                        <select wire:model="ta"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                            <option value="">SELECCIONE</option>
                            @isset($talleres)
                                @foreach ($talleres as $taller)
                                    <option class="" value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="flex bg-gray-200 items-center p-2 w-48 rounded-md mb-4 ">
                        <span>Desde: </span>
                        <x-date-picker wire:model="fecIni" placeholder="Fecha de inicio"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                    </div>

                    <div class="flex bg-gray-200 items-center p-2 w-48 rounded-md mb-4 ">
                        <span>Hasta: </span>
                        <x-date-picker wire:model="fecFin" placeholder="Fecha de Fin"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                    </div>



                </div>
            </div>
        </div>

        <div class="w-full overflow-x-auto table-responsive"> 
            @if ($certificaciones->count())

                <table class="w-full whitespace-nowrap">
                    <thead class="bg-slate-600 border-b font-bold text-white">
                        <tr>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                #
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Inspector
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Taller
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Servicio
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Precio
                            </th>

                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Placa
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                N° Formato
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Fecha
                            </th>

                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Estado
                            </th>

                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Documentos
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white py-4 text-left">
                                Fotos
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">

                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($certificaciones as $certificacion)
                            <tr tabindex="0"
                                class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-200">
                                <td class="pl-5">
                                    <div class="flex items-center">
                                        <div
                                            class="bg-indigo-200 rounded-sm w-5 h-5 flex flex-shrink-0 justify-center items-center relative text-indigo-900">
                                            {{ $certificacion->id }}
                                        </div>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        <p class="text-sm font-medium leading-none text-gray-600 mr-2">
                                            {{ $certificacion->inspector->name ?? 'NE-MODI' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                            {{ $certificacion->taller->nombre }}</p>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        @switch($certificacion->Servicio->tipoServicio->id)
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
                                                <p class="text-sm leading-none text-gray-600 ml-2 p-2 bg-blue-200 rounded-full">
                                                    Modificación
                                                </p>
                                            @break

                                            @case(6)
                                                <p class="text-sm leading-none text-gray-600 ml-2 p-2 bg-blue-200 rounded-full">
                                                    Desmonte de Cilindro
                                                </p>
                                            @break

                                            @case(7)
                                                <p class="text-sm leading-none text-gray-600 ml-2 p-2 bg-blue-200 rounded-full">
                                                    Activación de chip (Anual)
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
                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-yellow-200 rounded-full">
                                                    Chip por deterioro
                                                </p>
                                            @break

                                            @case(12)
                                                <p
                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                    {{ $certificacion->Servicio->tipoServicio->descripcion }}
                                                </p>
                                            @break

                                            @case(13)
                                                <p
                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-orange-200 rounded-full">
                                                    {{ $certificacion->Servicio->tipoServicio->descripcion }}
                                                </p>
                                            @break

                                            @default
                                                <p class="text-sm leading-none text-gray-600 ml-2">
                                                    No se encontro datos
                                                </p>
                                        @endswitch

                                    </div>
                                </td>
                                <td class="">
                                    <div class="flex items-center">
                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                            {{ 'S/. ' . $certificacion->precio }}
                                        </p>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        <p class="text-sm font-bold  text-indigo-700 ml-2">
                                            {{ $certificacion->placa ?? 'N/A' }}</p>
                                    </div>
                                </td>
                                @if (isset($certificacion->Hoja->numSerie))
                                    <td class="">
                                        <div class="flex items-center justify-center">
                                            <p
                                                class="text-sm font-semibold  text-gray-600 p-1 bg-orange-100 rounded-full">
                                                {{ $certificacion->Hoja->numSerie }}</p>
                                        </div>
                                    </td>
                                @else
                                    <td class="">
                                        <div class="flex items-center justify-center">
                                            <p
                                                class="text-sm font-semibold  text-gray-600 p-1 bg-orange-100 rounded-full">
                                                Sin datos</p>
                                        </div>
                                    </td>
                                @endif

                                <td class="pl-2">
                                    <p class="text-gray-600 "> {{ $certificacion->created_at->format('d/m/Y  h:i a') }}
                                    </p>
                                </td>

                                <td class="">
                                    <div class="flex items-center justify-center">
                                        @switch($certificacion->estado)
                                            @case(1)
                                                <i class="far fa-check-circle fa-lg" style="color: forestgreen;"></i>
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
                                <td>
                                    <div class="relative px-5 text-center" x-data="{ menu: false }">
                                        <button type="button" x-on:click="menu = ! menu" id="menu-button"
                                            aria-expanded="true" aria-haspopup="true" data-te-ripple-init
                                            data-te-ripple-color="light"
                                            class="hover:animate-pulse inline-block rounded-full bg-amber-400 p-2 uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:bg-amber-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-amber-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-amber-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="h-4 w-4">
                                                <path fill-rule="evenodd"
                                                    d="M19.5 21a3 3 0 003-3V9a3 3 0 00-3-3h-5.379a.75.75 0 01-.53-.22L11.47 3.66A2.25 2.25 0 009.879 3H4.5a3 3 0 00-3 3v12a3 3 0 003 3h15zm-6.75-10.5a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V10.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div x-show="menu" x-on:click.away="menu = false"
                                            class="origin-top-right absolute right-12 mt-2 w-56 rounded-md shadow-lg bg-gray-300 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-40"
                                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                            tabindex="-1">
                                            <div class="" role="none">
                                                <a href="{{ $certificacion->rutaVistaCertificado }}" target="__blank"
                                                    rel="noopener noreferrer"
                                                    class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-t-md hover:cursor-pointer">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Ver Certificado.</span>
                                                </a>

                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaDescargaCertificado }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                        <a href="{{ $certificacion->rutaDescargaCertificado }}"
                                                            target="__blank" rel="noopener noreferrer"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                @endif
                                                <i class="fas fa-download"></i>
                                                <span>desc. Certificado</span>
                                                </a>
                                                @if ($certificacion->Servicio->tipoServicio->id == 1)
                                                    <a href="{{ route('preConversionGnv', [$certificacion->id]) }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Preconversion.</span>
                                                    </a>
                                                @endif
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaVistaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaDescargaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-download"></i>
                                                        <span>desc. Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaVistaCheckListArriba }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Arriba</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaVistaCheckListAbajo }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-b-md justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Abajo</span>
                                                    </a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex justify-end">
                                        <a wire:click="edit({{ $certificacion->id }})"
                                            class="py-2 px-2 text-center rounded-md bg-indigo-300 font-bold text-black cursor-pointer hover:bg-indigo-400">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                                <td class="pl-4">
                                    <div class="relative flex justify-center px-5">
                                        <div class="inline-block text-left" x-data="{ menu: false }">
                                            <button x-on:click="menu = ! menu" type="button"
                                                class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                                                id="menu-button" aria-expanded="true" aria-haspopup="true">
                                                <span class="sr-only"></span>
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </button>
                                            <div x-show="menu" x-on:click.away="menu = false"
                                                class="origin-top-right absolute right-12 mt-2 w-56 rounded-md shadow-lg bg-gray-300 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-40"
                                                role="menu" aria-orientation="vertical"
                                                aria-labelledby="menu-button" tabindex="-1">
                                                <div class="" role="none">
                                                    @if ($certificacion->Servicio->tipoServicio->id == 11)
                                                        <a wire:click="$emit('deleteCertificacionChip',{{ $certificacion->id }})"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-t-md hover:cursor-pointer">
                                                            <i class="fas fa-trash"></i>
                                                            <span>Eliminar servicio</span>
                                                        </a>
                                                    @else
                                                        <a wire:click="$emit('deleteCertificacion',{{ $certificacion->id }})"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-t-md hover:cursor-pointer">
                                                            <i class="fas fa-trash"></i>
                                                            <span>Eliminar servicio</span>
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="" role="none">
                                                    <a wire:click="$emit('anularCertificacion',{{ $certificacion->id }})"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-b-md hover:cursor-pointer">
                                                        <i class="fas fa-eraser"></i>
                                                        <span>Anular servicio</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="h-3"></tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($certificaciones->hasPages())
                    <div class="w-full  py-2 overflow-x-auto">
                        <div
                            class="inline-block min-w-full shadow-lg border border-slate-300 bg-slate-500/ overflow-hidden">
                            <div class="py-4 px-2 bg-white ">
                                {{ $certificaciones->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="p-4 w-full bg-indigo-300 items-center flex justify-center">
                    <p class="text-indigo-900 font-bold">No se encontro ningúna certificación</p>
                </div>
            @endif
        </div>

    </x-table-administracion-certificaciones>


    {{-- MODAL PARA VER REVISION EXPEDIENTES --}}
    <x-jet-dialog-modal wire:model="editando" wire:loading.attr="disabled" wire:target="deleteFile">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold">Revision de Expediente</h1>
        </x-slot>
        <x-slot name="content">
            <h1 class="pt-2  font-semibold sm:text-lg text-gray-900">
                Fotografias:
            </h1>
            <hr />
            @if (count($files))

                <section class="my-4 pb-4 overflow-hidden border-dotted border-2 text-gray-700 ">
                    <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @foreach ($files as $fil)
                                <div class="flex flex-wrap p-1 relative">
                                    <div class="w-full items-center justify-center ">
                                        <img alt="gallery"
                                            class="mx-auto flex object-cover object-center w-full rounded-lg"
                                            src="{{ Storage::url($fil->ruta) }}">
                                    </div>
                                    <div class="absolute mt-2 w-full bottom-3 flex justify-center items-center">
                                        <a class="group max-w-max relative mx-1 flex flex-col items-center justify-center rounded-full bg-white border border-gray-500 p-1 text-gray-500 hover:bg-gray-200 hover:text-gray-600"
                                            href="#">
                                            <!-- Text/Icon goes here -->
                                            <p class="flex m-auto"><i class="fas fa-info-circle"></i></p>
                                            <!-- Tooltip here -->
                                            <div
                                                class="[transform:perspective(50px)_translateZ(0)_rotateX(10deg)] group-hover:[transform:perspective(0px)_translateZ(0)_rotateX(0deg)] absolute bottom-0 mb-6 origin-bottom transform rounded text-white opacity-0 transition-all duration-300 group-hover:opacity-100 z-10">
                                                <div class="flex w-56 flex-col items-center">
                                                    <div class="rounded bg-gray-900 p-2 text-xs text-center shadow-lg">
                                                        Información:
                                                        <p class="text-xs">Cargado el: {{ $fil->created_at }}</p>
                                                    </div>
                                                    <div class="clip-bottom h-2 w-4 bg-gray-900 text-xs">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                @hasrole('Administrador del sistema|administrador')
                    <div class="w-full my-4 p-2 rounded-lg border border-gray-200">
                        <div class="my-2 flex flex-row justify-center items-center">
                            <a href="{{ route('descargaFotosExp', ['id' => $expediente->id]) }}"
                                class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white"><i
                                        class="fas fa-download animate-bounce"></i>
                                    &nbsp;Descargar Fotos</p>
                            </a>
                        </div>
                    </div>
                @endhasrole
            @else
                <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                    <ul id="gall-{{ $identificador }}" class="flex flex-1 flex-wrap -m-1">
                        <li id="empty"
                            class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32"
                                src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                alt="no data" />
                            <span class="text-small text-gray-500">Aun no seleccionaste ningún archivo</span>
                        </li>
                    </ul>
                </section>
            @endif

            <h1 class="pt-2  font-semibold sm:text-lg text-gray-900">
                Documentos:
            </h1>
            <hr />

            @if (count($documentos))
                <section class="mt-4  overflow-hidden border-dotted border-2 text-gray-700 "
                    id="{{ 'sections-' . $identificador }}">
                    <div class="container px-5 py-2 mx-auto lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @foreach ($documentos as $fil)
                                <div class="flex flex-wrap w-1/5 ">
                                    <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                        <img alt="gallery"
                                            class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg"
                                            src="/images/{{ $fil->extension }}.png">
                                        <div class="block">
                                            <p class="truncate text-sm">{{ $fil->nombre }}</p>
                                            <div class="flex flex-row">
                                                <a class="group max-w-max relative mx-1 flex flex-col items-center justify-center rounded-full border border-gray-500 p-1 text-gray-500 hover:bg-gray-200 hover:text-gray-600"
                                                    href="#">
                                                    <!-- Text/Icon goes here -->
                                                    <p class="flex justify-center items-center"><i
                                                            class="fas fa-info-circle"></i></p>
                                                    <!-- Tooltip here -->
                                                    <div
                                                        class="[transform:perspective(50px)_translateZ(0)_rotateX(10deg)] group-hover:[transform:perspective(0px)_translateZ(0)_rotateX(0deg)] absolute bottom-0 mb-6 origin-bottom transform rounded text-white opacity-0 transition-all duration-300 group-hover:opacity-100 z-10">
                                                        <div class="flex w-56 flex-col items-center">
                                                            <div
                                                                class="rounded bg-gray-900 p-2 text-xs text-center shadow-lg">
                                                                Información:
                                                                <p class="text-xs">Cargado el: {{ $fil->created_at }}
                                                                </p>
                                                            </div>
                                                            <div class="clip-bottom h-2 w-4 bg-gray-900 text-xs">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a wire:click="download('{{ $fil->ruta }}')"><i
                                                        class="fas fa-download mt-1 mx-auto hover:text-indigo-400"></i></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @else
                <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                    <ul class="flex flex-1 flex-wrap -m-1">
                        <li id="empty"
                            class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32"
                                src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                alt="no data" />
                            <span class="text-small text-gray-500">Aun no seleccionaste ningún archivo</span>
                        </li>
                    </ul>
                </section>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('editando',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>


    {{-- JS --}}
    @push('js')
        <script>
            Livewire.on('deleteCertificacion', certificacionId => {
                Swal.fire({
                    title: '¿Estas seguro de eliminar este servicio?',
                    text: "una vez eliminado este registro, no podras recuperarlo.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('administracion-certificaciones', 'delete', certificacionId);

                        Swal.fire(
                            'Listo!',
                            'Servicio eliminado correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>
        <script>
            Livewire.on('deleteCertificacionChip', certificacionId => {
                Swal.fire({
                    title: '¿Estas seguro de eliminar este servicio?',
                    text: "una vez eliminado este registro, no podras recuperarlo.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('administracion-certificaciones', 'deleteChip', certificacionId);

                        Swal.fire(
                            'Listo!',
                            'Servicio eliminado correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>

        <script>
            Livewire.on('anularCertificacion', certificacionId => {
                Swal.fire({
                    title: '¿Seguro que quieres anular este servicio?',
                    text: "Al anular este servicio el formato asociado quedará inutilizable",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, anular'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('administracion-certificaciones', 'anular', certificacionId);

                        Swal.fire(
                            'Listo!',
                            'Servicio anulado correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>
