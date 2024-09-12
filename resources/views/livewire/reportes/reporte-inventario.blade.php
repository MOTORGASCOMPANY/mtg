<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <div class="bg-gray-200 px-8 py-4 rounded-xl w-full">
            <div class="p-2 w-64 my-4 md:w-full">
                <h2 class="text-indigo-600 font-bold text-3xl">
                    <i class="fa-solid fa-square-poll-vertical fa-xl"></i>
                    &nbsp;REPORTE DE INVENTARIOS
                </h2>
            </div>
            <div class="flex flex-wrap items-center space-x-2">
                {{-- FILTRO PARA INSPECTOR --}}
                <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
                    <span>Inspector: </span>
                    <select wire:model="inspector"
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
                    <select wire:model="tipoMaterial"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                        <option value="">Seleccione</option>
                        <option value="1">Formato GNV</option>
                        <option value="2">CHIP</option>
                        <option value="3">Formato GLP</option>
                        <option value="4">Modificación</option>
                    </select>
                </div>
                {{-- FILTRO PARA ESTADO --}}
                <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
                    <span>Estado: </span>
                    <select wire:model="estado"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                        <option value="">Seleccione</option>
                        <option value="1">En Almacen</option>
                        <option value="2">Proceso de envio </option>
                        <option value="3">Poseción de Inspector</option>
                        <option value="4">Consumido</option>
                        <option value="5">Anulado</option>
                        <option value="6">Stock sin firmar</option>
                    </select>
                </div>
                {{-- FILTRO PARA FECHA DESDE - HASTA --}}
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

                <button wire:click="consultar()"
                    class="bg-indigo-400 px-6 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                    <p class="truncate"> Consultar </p>
                </button>
            </div>

            <div class="w-auto my-4">
                <x-jet-input-error for="inspector" />
                <x-jet-input-error for="tipoMaterial" />
                <x-jet-input-error for="estado" />
                <x-jet-input-error for="fechaInicio" />
                <x-jet-input-error for="fechaFin" />
            </div>

            <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg"
                wire:loading>
                CARGANDO <i class="fa-solid fa-spinner animate-spin"></i>
            </div>

        </div>

        @if (isset($resultado))
            <div wire.model="">
                <div class="m-auto flex justify-center items-center bg-gray-200 rounded-md w-full p-4 mt-4">
                    <button wire:click="$emit('exportaData')"
                        class="bg-green-400 px-6 py-4 w-1/3 text-sm rounded-md text-sm text-white font-semibold tracking-wide cursor-pointer ">
                        <p class="truncate"><i class="fa-solid fa-file-excel fa-lg"></i> Desc. Excel </p>
                    </button>
                </div>
                <div class="bg-gray-200  px-8 py-4 rounded-xl w-full mt-4 text-center">
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-x-6 lg:gap-x-0 items-center">
                        <div class="mb-12 lg:mb-0 relative">
                            <i class="fa-solid fa-cubes fa-3x text-amber-600 mx-auto mb-6"></i>
                            <h5 class="text-lg font-medium text-blue-600 font-bold mb-4">{{ $resultado->count() }}
                            </h5>
                            <h6 class="font-medium text-gray-500">Total</h6>
                            <hr class="absolute right-0 top-0 w-px bg-gray-200 h-full hidden lg:block" />
                        </div>


                        <div class="mb-12 md:mb-0 relative">
                            <i class="fa-solid fa-circle-check fa-3x text-green-600 mx-auto mb-6"></i>
                            <h5 class="text-lg font-medium text-blue-600 font-bold mb-4">
                                {{ $resultado->where('estado', 3)->count() }}</h5>
                            <h6 class="font-medium text-gray-500">Disponibles</h6>
                            <hr class="absolute right-0 top-0 w-px bg-gray-200 h-full hidden lg:block" />
                        </div>

                        <div class="relative">
                            <i class="fa-solid fa-ticket fa-3x text-gray-600 font-bold mb-4"></i>
                            <h5 class="text-lg font-medium text-blue-600 font-bold mb-4">
                                {{ $resultado->where('estado', 4)->count() }}</h5>
                            <h6 class="font-medium text-gray-500 mb-0">Cosumidos</h6>
                            <hr class="absolute right-0 top-0 w-px bg-gray-200 h-full hidden lg:block" />
                        </div>
                        <div class="mb-12 lg:mb-0 relative">
                            <i class="fa-solid fa-circle-xmark text-red-600 fa-3x mx-auto mb-6"></i>
                            <h5 class="text-lg font-medium text-blue-600 font-bold mb-4">
                                {{ $resultado->where('estado', 5)->count() }}</h5>
                            <h6 class="font-medium text-gray-500">Anulados</h6>
                        </div>
                    </div>
                </div>

                <div id='data_1' class="bg-gray-200  px-8 py-4 rounded-xl w-full mt-4">
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
                                                Material
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                # Serie
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Estado
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Ubicación
                                            </th>
                                            {{--
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Fecha
                                            </th>
                                            --}}
                                            @if ($estado == 5)
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Entregado
                                                </th>
                                            @endif
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Ultima act.
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($resultado as $key => $resul)
                                            <tr class="border-b dark:border-neutral-500 bg-gray-100">
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $key + 1 }}
                                                </td>
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $resul->tipo->descripcion }}
                                                </td>
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $resul->numSerie ?? 'No data' }}
                                                </td>
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    @switch($resul->estado)
                                                        @case(1)
                                                            <span
                                                                class="inline-block whitespace-nowrap rounded-full bg-indigo-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-indigo-700">
                                                                Almacenado
                                                            </span>
                                                        @break

                                                        @case(2)
                                                            <span
                                                                class="inline-block whitespace-nowrap rounded-full bg-blue-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-blue-700">
                                                                En envio
                                                            </span>
                                                        @break

                                                        @case(3)
                                                            <span
                                                                class="inline-block whitespace-nowrap rounded-full bg-green-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-green-700">
                                                                Disponible
                                                            </span>
                                                        @break

                                                        @case(4)
                                                            <span
                                                                class="inline-block whitespace-nowrap rounded-full bg-gray-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-gray-800">
                                                                Consumido
                                                            </span>
                                                        @break

                                                        @case(5)
                                                            <span
                                                                class="inline-block whitespace-nowrap rounded-full bg-gray-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-red-800">
                                                                Anulado
                                                            </span>
                                                        @break

                                                        @default
                                                    @endswitch
                                                </td>
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $resul->ubicacion }}
                                                </td>
                                                {{-- 
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $resul->created_at->format('d-m-Y') }}
                                                </td>
                                                --}}
                                                @if ($estado == 5)
                                                    <td  class="border-r px-6 py-4 dark:border-neutral-500">
                                                        <x-jet-checkbox class="h-4 w-4 text-indigo-600 rounded-lg"
                                                            disabled :checked="$resul->devuelto" />
                                                    </td>
                                                @endif
                                                <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $resul->updated_at->format('d-m-Y') }}
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
            <div class="text-center mt-4 text-gray-600">

            </div>
        @endif
    </div>
    @push('js')
        <script>
            Livewire.on('exportaData', () => {
                // Obtener los datos de la tabla
                data = document.getElementById('data_1').innerHTML;
                console.log(data);
                // Emitir el evento exportarExcel con los datos de la tabla
                Livewire.emit('exportarExcel', data);
            });
        </script>
    @endpush
</div>
