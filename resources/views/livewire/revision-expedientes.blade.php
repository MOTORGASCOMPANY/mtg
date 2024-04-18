<div>
    <div wire:init="loadExpedientes" >


        <div class="container mx-auto py-12" id="todo">
            <x-tablerev>
                <x-slot name="inspectores">
                    <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4 ">
                        <span>Inspector: </span>
                        <select wire:model="ins"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                            <option value="">SELECCIONE</option>
                            @isset($inspectores)
                                @foreach ($inspectores as $inspector)
                                    <option class="" value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </x-slot>
                <x-slot name="talleres">
                    <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4 ">
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
                </x-slot>
                <x-slot name="services">
                    <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4 ">
                        <span>Servicio: </span>
                        <select wire:model="tipoSer"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                            <option value="">SELECCIONE</option>
                            @isset($tipos)
                                @foreach ($tipos as $tipo)
                                    <option class="" value="{{ $tipo->descripcion }}">{{ $tipo->descripcion }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </x-slot>
                <div wire:loading wire:target="ta,ins,es,tipoSer"
                    class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                    cargando expedientes...
                </div>
                @if (count($expedientes))
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-x-auto">
                                <table class="min-w-full leading-normal rounded-md">
                                    <thead>
                                        <tr>
                                            <th class="cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('nombre')">
                                                Taller
                                                @if ($sort == 'nombre')
                                                    @if ($direction = 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fa-solid fa-arrow-down-a-z float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th class="cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('name')">
                                                Inspector
                                                @if ($sort == 'name')
                                                    @if ($direction = 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fa-solid fa-arrow-down-a-z float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th class=" w-24 cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('placa')">
                                                Placa
                                                @if ($sort == 'placa')
                                                    @if ($direction = 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fa-solid fa-arrow-down-a-z float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('certificado')">
                                                Certificado

                                                @if ($sort == 'certificado')
                                                    @if ($direction = 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fa-solid fa-arrow-down-a-z float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th class="cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('created_at')">
                                                Fecha
                                                @if ($sort == 'created_at')
                                                    @if ($direction = 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fa-solid fa-arrow-down-a-z float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th class="cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('descripcion')">
                                                Servicio
                                                @if ($sort == 'descripcion')
                                                    @if ($direction = 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fa-solid fa-arrow-down-a-z float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th class="cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('estado')">
                                                Estado
                                                @if ($sort == 'estado')
                                                    @if ($direction = 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fa-solid fa-arrow-down-a-z float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expedientes as $item)
                                            <tr>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm truncate">
                                                    <div class="flex items-center">
                                                        <p class="text-gray-900 ">
                                                            {{ $item->nombre }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="text-gray-900 ">
                                                            {{ $item->name }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="text-gray-900 ">
                                                            {{ strtoupper($item->placa) }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="text-gray-900 whitespace-no-wrap">
                                                            {{ $item->certificado }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        {{ date('d/m/Y  h:i a', strtotime($item->created_at)) }}</p>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="text-gray-900 whitespace-no-wrap">
                                                            {{ $item->descripcion }}
                                                        </p>
                                                    </div>
                                                </td>
                                                @switch($item->estado)
                                                    @case(1)
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <span
                                                                class="relative inline-block px-3 py-1 font-semibold text-orange-900 leading-tight">
                                                                <span aria-hidden
                                                                    class="absolute inset-0 bg-orange-200 opacity-50 rounded-full"></span>
                                                                <span class="relative">Por revisar</span>
                                                            </span>
                                                        </td>
                                                    @break

                                                    @case(2)
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <span
                                                                class="relative inline-block px-3 py-1 font-semibold text-blue-900 leading-tight">
                                                                <span aria-hidden
                                                                    class="absolute inset-0 bg-blue-200 opacity-50 rounded-full"></span>
                                                                <span class="relative">Observado</span>
                                                            </span>
                                                        </td>
                                                    @break

                                                    @case(3)
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <span
                                                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                                <span aria-hidden
                                                                    class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                                <span class="relative">Aprobado</span>
                                                            </span>
                                                        </td>
                                                    @break

                                                    @case(4)
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <span
                                                                class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                                <span aria-hidden
                                                                    class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                                <span class="relative">Desaprobado</span>
                                                            </span>
                                                        </td>
                                                    @break

                                                    @default
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <span
                                                                class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                <span aria-hidden
                                                                    class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                                <span class="relative">Aprobado</span>
                                                            </span>
                                                        </td>
                                                @endswitch

                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    {{-- @livewire('edit-usuario', ['usuario' => $usuario], key($usuario->id)) --}}
                                                    <div class="flex justify-end">
                                                        <a wire:click="edit({{ $item->id }})"
                                                            class="py-3 px-4 text-center rounded-md bg-amber-300 font-bold text-black cursor-pointer hover:bg-amber-400">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if ($expedientes->hasPages())
                        <div wire:loading.remove wire:target="ta,ins,es,tipoSer">
                            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                    <div class="px-5 py-5 bg-white border-t">
                                        {{ $expedientes->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div wire:loading.remove wire:target="ta,ins,es,tipoSer"
                        class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md border border-indigo shadow-lg shadow-indigo-400/50">
                        No se encontro ningun registro.
                    </div>
                @endif
            </x-tablerev>
        </div>

        <x-jet-dialog-modal wire:model="editando" wire:loading.attr="disabled" wire:target="deleteFile">
            <x-slot name="title" class="font-bold">
                <h1 class="text-xl font-bold">Revision de Expediente</h1>
            </x-slot>
            <x-slot name="content">
                <div class="mb-4  justify-between md:flex md:flex-row justify-content-center sm:block">
                    <h3 class="text-sm font-bold ">Servicio : </h3>
                    <span class="relative inline-block px-3  font-semibold text-black-900 leading-tight">
                        <span aria-hidden class="absolute inset-0 bg-lime-300 opacity-50 rounded-full"></span>
                        <span class="relative">{{ $tipoServicio }}</span>
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
                @if (count($files))

                    <section class="my-4 pb-4 overflow-hidden border-dotted border-2 text-gray-700 ">
                        <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                            <div class="flex flex-wrap -m-1 md:-m-2">
                                @foreach ($files as $fil)
                                    <div class="flex flex-wrap p-1 relative">
                                        <div class="w-full items-center justify-center ">
                                            @if ($fil->migrado == 0)
                                            <img alt="gallery"
                                            class="mx-auto flex object-cover object-center w-full rounded-lg"
                                            src="{{ Storage::url($fil->ruta) }}">
                                            @else
                                            <img alt="gallery"
                                            class="mx-auto flex object-cover object-center w-full rounded-lg"
                                            src="{{ 'https://motorgas.ams3.digitaloceanspaces.com/'.$fil->ruta }}">
                                            @endif
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
                    @hasrole('administrador')
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
                                                    <a wire:click.prevent="download({{$fil->id}})" wire:loading.class="cursor-not-allowed">
                                                        <i class="fas fa-download mt-1 mx-auto hover:text-indigo-400" wire:loading.remove wire:target="download({{$fil->id}})"></i>
                                                        <svg class="animate-spin h-5 w-5 mx-auto mt-1 text-indigo-600" wire:loading wire:target="download({{$fil->id}})" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V2.55A9.95 9.95 0 0012 2c-1.871 0-3.624.518-5.122 1.423M4.64 4.64l1.415 1.415M19.95 4.95l-1.415 1.415"></path>
                                                        </svg>
                                                    </a>
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
                <div class="my-4">
                    <x-jet-label value="Estado:" for="estado" />
                    <select wire:model="expediente.estado"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full "
                        id="estado">
                        <option value="">Seleccione</option>
                        <option value="1">Por Revisar</option>
                        <option value="2">Observado</option>
                        <option value="3">Aprobado</option>
                        <option value="4">Desaprobado</option>
                    </select>
                    <x-jet-input-error for="expediente.estado" />
                </div>
                @if ($expediente->estado == 2)
                    <div class="m-2">
                        <x-jet-input-error for="conteo" />
                        @foreach ($observaciones as $obs)
                            @if ($obs['tipo'] == 1)
                                <div class="form-check">
                                    <input wire:click="agregaObservacion({{ $obs['id'] }});"
                                        class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white outline-transparent checked:bg-indigo-600 checked:border-indigo-600 outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                        type="checkbox" value="" id="{{ $obs['id'] }}">
                                    <label class="form-check-label inline-block text-gray-800 text-sm">
                                        {{ $obs['detalle'] }}
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </div>


                    @if ($observacionesEx)
                        <h1 class="mt-4">Listado de observaciones:</h1>
                        <hr class="my-2">
                        <div class="m-2">
                            @foreach ($observacionesEx as $obse)
                                @if ($obse['tipo'] == 1)
                                    <div class="flex flex-row bg-red-200 my-3 rounded-xl p-2 items-center justify-between">
                                        <p>{{ $obse['detalle'] }}</p><a
                                            wire:click="deleteObservacion({{ $obse['id'] }})"
                                            class="cursor-pointer mx-2"><i class="fas fa-times"></i></a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <hr class="my-2">
                    <div class="flex items-center justify-center w-full">
                        <label for="activo" class="hover:text-indigo-500 hover:cursor-pointer">
                            <input wire:model="activo" id="activo" type="checkbox"
                                class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white outline-transparent checked:bg-indigo-600 checked:border-indigo-600 outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer">
                            Agregar Comentario
                        </label>
                    </div>

                    @if ($activo)
                        <div class="m-2">
                            <x-jet-label value="Comentario:" for="comentario" />
                            <textarea class="w-full" wire:model="comentario" cols="30" rows="4"></textarea>
                            <x-jet-input-error for="comentario" />
                        </div>
                    @endif
                @endif
            </x-slot>
            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('editando',false)" class="mx-2">
                    Cancelar
                </x-jet-secondary-button>
                <x-jet-button wire:click="actualizar" wire:loading.attr="disabled" wire:target="update">
                    Guardar
                </x-jet-button>
            </x-slot>

        </x-jet-dialog-modal>

        @push('js')
            <script>
                Livewire.on('quitaCheck', () => {
                    var textinputs = document.querySelectorAll('input[type=checkbox]');
                    for (var i = 0; i < textinputs.length; ++i) {
                        textinputs[i].checked = false;
                    }
                });
            </script>
            <script>
                Livewire.on('activaCheck', () => {
                    var check = document.querySelector('#activo');
                    check.checked = true;

                });
            </script>
            <script>
                window.livewire.on('startDownload', (ruta) => {
                    window.open('download/' + ruta, '_blank');
                });
            </script>
        @endpush
    </div>

    {{--PANTALLA DE CARGA
    <div class="hidden w-full h-screen flex flex-col justify-center items-center bg-gray-200 " wire:loading.remove.class="hidden">
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
    --}}
</div>

