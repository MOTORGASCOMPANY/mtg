<div class="mt-8">
    <div class="sm:px-6 w-full pt-12 pb-4">
        <div class="bg-gray-200 px-8 py-4 rounded-xl w-full">
            <div class="p-2 w-64 my-4 md:w-full">
                <h2 class="text-indigo-600 font-bold text-3xl">
                    <i class="fa-solid fa-square-poll-vertical fa-xl"></i>
                    &nbsp;REPORTE SALIDA DE MATERIALES
                </h2>
            </div>
            <div class="flex flex-wrap items-center space-x-2">
                {{-- FILTRO PARA CREADO POR --}}
                <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
                    <span>Creado: </span>
                    <select wire:model="ins2"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                        <option value="">SELECCIONE</option>
                        @foreach ($inspectores2 as $mot)
                            <option value="{{ $mot->id }}">{{ $mot->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- FILTRO PARA ASIGNADO A --}}
                <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
                    <span>Asignado: </span>
                    <select wire:model="ins"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                        <option value="">SELECCIONE</option>
                        @foreach ($inspectores as $inspector)
                            <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- FILTRO PARA MATERIAL --}}
                <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
                    <span>Material: </span>
                    <select wire:model="mat"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                        <option value="">SELECCIONE</option>
                        @foreach ($tipos as $tip)
                            <option value="{{ $tip->id }}">{{ $tip->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- FILTRO PARA FECHAS DESDE - HASTA --}}
                <div class="flex bg-white items-center p-2 w-48 rounded-md mb-4 ">
                    <span>Desde: </span>
                    <x-date-picker wire:model="fechaInicio" placeholder="Fecha de inicio"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                </div>
                <div class="flex bg-white items-center p-2 w-48 rounded-md mb-4 ">
                    <span>Hasta: </span>
                    <x-date-picker wire:model="fechaFin" placeholder="Fecha de Fin"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                </div>

                <button wire:click="procesar()"
                    class="bg-green-400 px-6 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                    <p class="truncate"> Generar reporte </p>
                </button>
            </div>
            <div class="w-auto my-4">
                <x-jet-input-error for="ins" />
                <x-jet-input-error for="fechaInicio" />
                <x-jet-input-error for="fechaFin" />
            </div>
            <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg"
                wire:loading>
                CARGANDO <i class="fa-solid fa-spinner animate-spin"></i>
            </div>

        </div>

        @if ($resultados)
            <div wire.model="">
                <div class="bg-gray-200  px-8 py-4 rounded-xl w-full mt-4">
                    <div class="overflow-x-auto m-auto w-full">
                        <div class="inline-block min-w-full py-2 sm:px-6">
                            <div class="overflow-hidden">
                                <table class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                    <thead class="border-b font-medium dark:border-neutral-500">
                                        <tr class="bg-indigo-200">
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                #
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                CREADO POR
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                ASIGNADO A
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                MOTIVO
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                ESTADO
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                FECHA
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                CARGO
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($resultados as $resultado)
                                            <tr class="border-b dark:border-neutral-500 bg-gray-100">
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $resultado->usuarioCreador->name ?? 'N/A' }}
                                                </td>
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $resultado->usuarioAsignado->name ?? 'N/A' }}
                                                </td>
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $resultado->motivo }}
                                                </td>
                                                </td>
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    @switch($resultado->estado)
                                                        @case(1)
                                                            En envio
                                                        @break

                                                        @case(2)
                                                            Rechazado
                                                        @break

                                                        @case(3)
                                                            Recepcionado
                                                        @break

                                                        @default
                                                            Sin datos
                                                    @endswitch
                                                </td>
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $resultado->created_at }}
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-gray-100 text-sm">
                                                    <div class="flex items-center" id="{{ rand() }}">
                                                        <a class="focus:ring-2 focus:ring-offset-2 focus:ring-gray-600 text-sm leading-none text-white py-3 px-5 bg-amber-400 rounded hover:bg-amber-600 focus:outline-none"
                                                            target="__blank"
                                                            href="{{ route('generaCargo', ['id' => $resultado->id]) }}"
                                                            rel="noopener noreferrer">Ver cargo <i
                                                                class="fas fa-file-pdf"></i>
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
                </div>
            </div>
        @else
        @endif
    </div>

</div>
