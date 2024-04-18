{{--
<div>
    @if ($expedientes)
        {{$expedientes}}
    @endif
</div>
--}}
<div wire:loading.attr="disabled" >
    <div class="mx-auto py-2 sm:px-6 w-full" id="todo">

        <x-table-revision-talleres>
            <x-slot name="tipos">
                <div class="flex bg-gray-300 items-center p-2 rounded-md">
                    <span>Servicio: </span>
                    <select wire:model="servicio" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                        <option value="">SELECCIONE</option>
                        @isset($tipos)
                        @foreach($tipos as $tipo)
                            <option class="" value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
                        @endforeach
                        @endisset
                    </select>
                </div>
            </x-slot>

            @if(isset($expedientes))
                @if(count($expedientes)>0)
                <div wire:loading wire:target="es,servicio,fecIni,fecFin,search" class=" w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                    <i class="fas fa-circle-notch animate-spin text-indigo-700"></i>  &nbsp;  Cargando datos espere por favor.
                </div>
                <table class="w-full whitespace-nowrap"  wire:loading.remove wire:target="es,servicio,fecIni,fecFin,search">
                    <thead class="bg-slate-700 border-b font-bold text-white">
                        <tr>
                            <th scope="col" class="text-sm font-medium  px-6 py-4 text-left hover:text-indigo-300 hover:cursor-pointer" wire:click="order('id')">
                                #
                                @if ($sort == 'id')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                    @else
                                        <i class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                @endif
                            <th scope="col" class="text-sm font-medium font-semibold px-6 py-4 text-left hover:text-indigo-300 hover:cursor-pointer" wire:click="order('usuario_idusuario')">
                                Inspector
                                @if ($sort == 'usuario_idusuario')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                @endif
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold px-6 py-4 text-left hover:text-indigo-300 hover:cursor-pointer" wire:click="order('servicio_idservicio')">
                            Servicio
                                @if ($sort == 'servicio_idservicio')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                @endif
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold px-6 py-4 text-left hover:text-indigo-300 hover:cursor-pointer" wire:click="order('placa')">
                                Placa
                                @if ($sort == 'placa')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                @endif
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold px-6 py-4 text-left hover:text-indigo-300 hover:cursor-pointer" wire:click="order('certificado')">
                                # Certificado
                                @if ($sort == 'certificado')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                    @else
                                        <i class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                @endif
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold px-6 py-4 text-left hover:text-indigo-300 hover:cursor-pointer" wire:click="order('created_at')">
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
                            <th scope="col" class="text-sm font-medium font-semibold px-6 py-4 text-left hover:text-indigo-300 hover:cursor-pointer"
                            wire:click="order('estado')">
                                Estado
                                @if ($sort == 'estado')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                @endif
                            </th>

                            <th scope="col" class="text-sm font-medium font-semibold px-6 py-4 text-left">
                                Documentos
                            </th>

                            <th scope="col" class="text-sm font-medium font-semibold px-6 py-4 text-left">
                                Acciones
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expedientes as $key => $item)
                            <tr tabindex="0" class="focus:outline-none h-16 border border-slate-300 rounded bg-gray-100 hover:bg-gray-300/30">
                                <td class="pl-5">
                                    <div class="flex items-center">
                                        <div class="w-5 h-5 flex justify-center items-center">
                                            <p class="bg-green-200 px-1 rounded-full text-sm text-gray-500 ">{{ $item->id }}</p>

                                        </div>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        <p class="text-base font-medium leading-none text-gray-700 mr-2">
                                            {{ $item->nombre_inspector }}</p>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                            {{ $item->nombre_servicio }}</p>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        <p class="text-sm leading-none text-indigo-600 ml-2 font-bold">
                                            {{ $item->placa}}
                                        </p>
                                    </div>
                                </td>
                                <td class="pl-2 text-center">
                                    <div class="flex items-center justify-center">
                                        <p class="text-sm leading-none text-red-600 ml-2">{{ $item->certificado }}</p>
                                    </div>
                                </td>

                                <td class="pl-2">
                                    <p class="py-1  text-sm  leading-none text-amber-700 bg-amber-100 rounded text-center">
                                        {{ $item->created_at->format('d/m/Y  h:m') }}</p>
                                </td>
                                <td class="text-center">
                                    @switch($item->estado)
                                        @case(1)
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-orange-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-orange-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Por revisar</span>
                                            </span>

                                    @break

                                    @case(2)
                                        <span class="relative inline-block px-3 py-1 font-semibold text-blue-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-blue-200 opacity-50 rounded-full"></span>
                                            <span class="relative">Observado</span>
                                        </span>
                                    @break

                                    @case(3)

                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Aprobado</span>
                                            </span>

                                    @break

                                    @case(4)

                                            <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Desaprobado</span>
                                            </span>
                                    @break

                                    @default

                                            <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Aprobado</span>
                                            </span>
                                    @break

                                @endswitch

                                <td class="text-center">
                                    @if (count($item->certificacion))
                                    <div class="relative px-5 text-center" x-data="{ menu: false }">
                                        <button type="button" x-on:click="menu = ! menu" id="menu-button" aria-expanded="true" aria-haspopup="true" data-te-ripple-init data-te-ripple-color="light" class="hover:animate-pulse inline-block rounded-md bg-amber-400 px-4 py-2 uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:bg-amber-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-amber-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-amber-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                                <path fill-rule="evenodd" d="M19.5 21a3 3 0 003-3V9a3 3 0 00-3-3h-5.379a.75.75 0 01-.53-.22L11.47 3.66A2.25 2.25 0 009.879 3H4.5a3 3 0 00-3 3v12a3 3 0 003 3h15zm-6.75-10.5a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V10.5z"
                                                clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div x-show="menu" x-on:click.away="menu = false" class="origin-top-right absolute right-12 mt-2 w-56 rounded-md shadow-lg bg-gray-300 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-40" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                            <div class="" role="none">
                                                <a  href="{{$item->certificacion->first()->ruta_vista_certificado}}" target="__blank" rel="noopener noreferrer"
                                                    class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-t-md hover:cursor-pointer">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Ver Certificado.</span>
                                                </a>

                                                    @if($item->certificacion->first()->Servicio->tipoServicio->id!=8)
                                                    <a  href="{{$item->certificacion->first()->ruta_descarga_certificado}}" target="__blank" rel="noopener noreferrer"
                                                    class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                    <a  href="{{$item->certificacion->first()->ruta_descarga_certificado}}" target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                    @endif
                                                    <i class="fas fa-download"></i>
                                                    <span>desc. Certificado</span>
                                                </a>
                                                @if($item->certificacion->first()->Servicio->tipoServicio->id==1)
                                                    <a  href="{{ route('preConversionGnv',[$item->certificacion->first()->id])}}" target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Preconversion.</span>
                                                    </a>
                                                @endif
                                                @if($item->certificacion->first()->Servicio->tipoServicio->id!=8)
                                                    <a  href="{{$item->certificacion->first()->ruta_vista_ft}}" target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Ficha Tec.</span>
                                                    </a>
                                                    <a  href="{{$item->certificacion->first()->ruta_descarga_ft}}" target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-download"></i>
                                                        <span>desc. Ficha Tec.</span>
                                                    </a>
                                                    <a  href="{{ route('checkListArribaGnv',[$item->certificacion->first()->id])}}" target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Arriba</span>
                                                    </a>
                                                    <a  href="{{ route('checkListAbajoGnv',[$item->certificacion->first()->id])}}" target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-b-md justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Abajo</span>
                                                    </a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    @else
                                        <span class="p-2 bg-red-500 rounded-full text-sm text-white">Sin datos</span>
                                    @endif
                                </td>



                                <td class="text-center">
                                    <div class="relative  pt-2 items-center" x-data="{ menu: false }">
                                        <button class="focus:ring-2 rounded-md focus:outline-none" role="button" x-on:click="menu = ! menu" id="menu-button" aria-expanded="true" aria-haspopup="true" data-te-ripple-init data-te-ripple-color="light"
                                            aria-label="option">
                                            <svg class="dropbtn"
                                                xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M4.16667 10.8332C4.62691 10.8332 5 10.4601 5 9.99984C5 9.5396 4.62691 9.1665 4.16667 9.1665C3.70643 9.1665 3.33334 9.5396 3.33334 9.99984C3.33334 10.4601 3.70643 10.8332 4.16667 10.8332Z"
                                                    stroke="#9CA3AF" stroke-width="1.25" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M10 10.8332C10.4602 10.8332 10.8333 10.4601 10.8333 9.99984C10.8333 9.5396 10.4602 9.1665 10 9.1665C9.53976 9.1665 9.16666 9.5396 9.16666 9.99984C9.16666 10.4601 9.53976 10.8332 10 10.8332Z"
                                                    stroke="#9CA3AF" stroke-width="1.25" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M15.8333 10.8332C16.2936 10.8332 16.6667 10.4601 16.6667 9.99984C16.6667 9.5396 16.2936 9.1665 15.8333 9.1665C15.3731 9.1665 15 9.5396 15 9.99984C15 10.4601 15.3731 10.8332 15.8333 10.8332Z"
                                                    stroke="#9CA3AF" stroke-width="1.25" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                        <div x-show="menu" x-on:click.away="menu = false" class="dropdown-content bg-white shadow w-56 absolute z-30 right-0 mr-6">
                                            <div tabindex="0" wire:click="revisar({{$item}})"
                                                class="focus:outline-none focus:text-slate-600 text-xs w-full hover:bg-slate-700 py-2 px-6 cursor-pointer hover:text-white">
                                                <p>Ver Expediente</p>
                                            </div>
                                            <div tabindex="1"
                                                class="focus:outline-none focus:text-slate-600 text-xs w-full hover:bg-slate-700 py-2 px-6 cursor-pointer hover:text-white">
                                                <p>Delete</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="h-3"></tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class=" w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                    No se encontraron resultados.
                </div>
                @endif

                </x-table-revision-talleres>
                @if ($expedientes->hasPages())
                <div class="sm:px-6 w-full py-1 overflow-x-auto" wire:loading.remove wire:target="ta,ins,es,tipoSer">
                    <div class="inline-block min-w-full rounded-b-md overflow-hidden">
                        <div class="px-5 py-3 bg-white">
                            {{ $expedientes->links() }}
                        </div>
                    </div>
                </div>
                @endif
            @endif
    </div>

    <x-jet-dialog-modal wire:model="revisando" wire:loading.attr="disabled" >
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold">Revision de Expediente</h1>
        </x-slot>
        <x-slot name="content">
            @if($expediente)
            <div class="mb-4  justify-between md:flex md:flex-row justify-content-center sm:block">
                <h3 class="text-sm font-bold ">Servicio : </h3>
                <span class="relative inline-block px-3  font-semibold text-black-900 leading-tight">
                    <span aria-hidden class="absolute inset-0 bg-lime-300 opacity-50 rounded-full"></span>
                    <span class="relative">{{ $expediente->nombre_servicio}}</span>
                </span>
                <h3 class="text-sm font-bold ">Placa : </h3>
                <span class="relative inline-block px-3  font-semibold text-black-900 leading-tight">
                    <span aria-hidden class="absolute inset-0 bg-blue-300 opacity-50 rounded-full"></span>
                    <span class="relative">{{ $expediente->placa }}</span>
                </span>
                <h3 class="text-sm font-bold ">Certificado : </h3>
                <p class="text-sm font-bold text-red-500">{{ $expediente->certificado }}</p>
            </div>

            <h1 class="pt-2  font-semibold sm:text-lg text-gray-900">
                Fotografias:
            </h1>
            <hr />
            @if (count($expediente->Fotos))
               <section class="my-4 pb-4 overflow-hidden border-dotted border-2 text-gray-700 ">
                    <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @foreach ($expediente->Fotos as $fil)
                                <div class="flex flex-wrap p-1 relative">
                                    <div class="w-full items-center justify-center ">
                                        <img alt="gallery" class="mx-auto flex object-cover object-center w-full rounded-lg" src="{{ Storage::url($fil->ruta) }}">
                                    </div>
                                    <div class="absolute mt-2 w-full bottom-3 flex justify-center items-center">
                                        <a class="group max-w-max relative mx-1 flex flex-col items-center justify-center rounded-full bg-white border border-gray-500 p-1 text-gray-500 hover:bg-gray-200 hover:text-gray-600" href="#">
                                            <!-- Text/Icon goes here -->
                                            <p class="flex m-auto"><i class="fas fa-info-circle"></i></p>
                                            <!-- Tooltip here -->
                                            <div class="[transform:perspective(50px)_translateZ(0)_rotateX(10deg)] group-hover:[transform:perspective(0px)_translateZ(0)_rotateX(0deg)] absolute bottom-0 mb-6 origin-bottom transform rounded text-white opacity-0 transition-all duration-300 group-hover:opacity-100 z-10">
                                                <div class="flex w-56 flex-col items-center">
                                                    <div class="rounded bg-gray-900 p-2 text-xs text-center shadow-lg">Información:
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
                @hasanyrole(['administrador','Administrador taller'])
                <div class="w-full my-4 p-2 rounded-lg border border-gray-200">
                    <div class="my-2 flex flex-row justify-center items-center">
                        <a href="{{route("descargaFotosExp",["id"=>$expediente->id])}}"
                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                            <p class="text-sm font-medium leading-none text-white"><i class="fas fa-download animate-bounce"></i>
                                &nbsp;Descargar Fotos</p>
                        </a>
                    </div>
                </div>
                @endhasanyrole
            @else
                <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                    <ul id="gall" class="flex flex-1 flex-wrap -m-1">
                        <li id="empty"
                            class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32"
                                src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                alt="no data" />
                            <span class="text-small text-gray-500">Aun no se cargó fotografías.</span>
                        </li>
                    </ul>
                </section>
            @endif

            <h1 class="pt-2  font-semibold sm:text-lg text-gray-900">
                Documentos:
            </h1>
            <hr />

            @if (count($expediente->Documentos))
                <section class="mt-4  overflow-hidden border-dotted border-2 text-gray-700 "
                    id="sections">
                    <div class="container px-5 py-2 mx-auto lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @foreach ($expediente->Documentos as $fil)
                                <div class="flex flex-wrap w-1/5 ">
                                    <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                        <img alt="gallery" class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg" src="/images/{{$fil->extension}}.png">
                                        <div class="block">
                                            <p class="truncate text-sm" >{{ $fil->nombre }}</p>
                                            <div class="flex flex-row">
                                                <a class="group max-w-max relative mx-1 flex flex-col items-center justify-center rounded-full border border-gray-500 p-1 text-gray-500 hover:bg-gray-200 hover:text-gray-600" href="#">
                                                    <!-- Text/Icon goes here -->
                                                    <p class="flex justify-center items-center"><i class="fas fa-info-circle"></i></p>
                                                    <!-- Tooltip here -->
                                                    <div class="[transform:perspective(50px)_translateZ(0)_rotateX(10deg)] group-hover:[transform:perspective(0px)_translateZ(0)_rotateX(0deg)] absolute bottom-0 mb-6 origin-bottom transform rounded text-white opacity-0 transition-all duration-300 group-hover:opacity-100 z-10">
                                                        <div class="flex w-56 flex-col items-center">
                                                            <div class="rounded bg-gray-900 p-2 text-xs text-center shadow-lg">Información:
                                                                <p class="text-xs">Cargado el: {{ $fil->created_at }}</p>
                                                            </div>
                                                            <div class="clip-bottom h-2 w-4 bg-gray-900 text-xs">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a wire:click="download('{{$fil->ruta}}')"><i class="fas fa-download mt-1 mx-auto hover:text-indigo-400"></i></a>
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
                            <span class="text-small text-gray-500">Aun no se cargó ningún documento.</span>
                        </li>
                    </ul>
                </section>
            @endif
            {{--
            --}}
        @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('revisando',false)" class="mx-2">
                Cerrar
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>

@push('js')
    <script>
        window.livewire.on('startDownload', (ruta) => {
            console.log(ruta);
            window.open('download/'+ruta,'_blank');
        });
    </script>
@endpush

</div>
