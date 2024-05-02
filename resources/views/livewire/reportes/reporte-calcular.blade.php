<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <div class="bg-gray-200  px-8 py-4 rounded-xl w-full ">

            <div class=" items-center md:block sm:block">
                <div class="p-2 w-64 my-4 md:w-full">
                    <h2 class="text-indigo-600 font-bold text-3xl">
                        <i class="fa-solid fa-square-poll-vertical fa-xl"></i>
                        &nbsp;REPORTE SEMANAL DE MOTORGAS-COMPANY
                    </h2>
                </div>

                <div class="w-full  items-center md:flex md:flex-row md:justify-between ">
                    <div x-data="{ isOpen: false }" class="flex bg-white items-center p-2 rounded-md mb-4">
                        <span>Taller: </span>
                        <div class="relative">
                            <div x-on:click="isOpen = !isOpen" class="cursor-pointer">
                                <input wire:model="taller" type="text" placeholder="Seleccione" readonly
                                    class="bg-gray-50 border-indigo-500 rounded-md outline-none ml-1 block w-96">
                            </div>
                            <div x-show="isOpen" x-on:click.away="isOpen = false"
                                class="absolute z-10 mt-2 bg-white border rounded-md shadow-md max-h-96 overflow-y-auto">
                                @isset($talleres)
                                    @foreach ($talleres as $tallerItem)
                                        <label for="taller_{{ $tallerItem->id }}" class="block px-4 py-2 cursor-pointer">
                                            <input id="taller_{{ $tallerItem->id }}" wire:model="taller" type="checkbox"
                                                value="{{ $tallerItem->id }}" class="mr-2">
                                            {{ $tallerItem->nombre }}
                                        </label>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>

                    <div x-data="{ isOpen: false }" class="flex bg-white items-center p-2 rounded-md mb-4">
                        <span>Inspector: </span>
                        <div class="relative">
                            <div x-on:click="isOpen = !isOpen" class="cursor-pointer">
                                <input wire:model="ins" type="text" placeholder="Seleccione" readonly
                                    class="bg-gray-50 border-indigo-500 rounded-md outline-none ml-1 block w-96">
                            </div>
                            <div x-show="isOpen" x-on:click.away="isOpen = false"
                                class="absolute z-10 mt-2 bg-white border rounded-md shadow-md max-h-96 overflow-y-auto">
                                @foreach ($inspectores as $inspector)
                                    <label for="inspector_{{ $inspector->id }}" class="block px-4 py-2 cursor-pointer">
                                        <input id="inspector_{{ $inspector->id }}" wire:model="ins" type="checkbox"
                                            value="{{ $inspector->id }}" class="mr-2">
                                        {{ $inspector->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <div class="flex bg-white items-center p-2 w-1/2 md:w-48 rounded-md mb-4 ">
                            <span>Desde: </span>
                            <x-date-picker wire:model="fechaInicio" placeholder="Fecha de inicio"
                                class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                        </div>
                        <div class="flex bg-white items-center p-2 w-1/2 md:w-48 rounded-md mb-4 ">
                            <span>Hasta: </span>
                            <x-date-picker wire:model="fechaFin" placeholder="Fecha de Fin"
                                class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                        </div>
                    </div>

                    <button wire:click="procesar"
                        class="bg-indigo-400 hover:bg-indigo-500 px-4 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                        <p class="truncate"> Semanal </p>
                    </button>
                    {{--
                    <button wire:click="taller"
                        class="bg-blue-400 hover:bg-blue-500 px-4 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                        <p class="truncate"> Taller </p>
                    </button>
                    --}}

                </div>
                <div class="w-auto my-4">
                    <x-jet-input-error for="taller" />
                    <x-jet-input-error for="ins" />
                    <x-jet-input-error for="fechaInicio" />
                    <x-jet-input-error for="fechaFin" />
                </div>
                <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg"
                    wire:loading>
                    CARGANDO <i class="fa-solid fa-spinner animate-spin"></i>
                </div>
            </div>
        </div>


        {{-- TABLA SEMANAL --}}
        @if (isset($grupoTipo))

            <div wire.model="resultados">
                <div class="bg-gray-200 px-8 py-4 rounded-xl w-full mt-4">
                    <h2 class="text-indigo-600 text-xl font-bold mb-4">Semanal</h2>
                    @if (!empty($grupoTipo))
                        <div class="overflow-x-auto m-auto w-full">
                            <div class="inline-block min-w-full py-2 sm:px-6">
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr class="bg-indigo-200">
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Motorgas
                                                    Company
                                                </th>
                                                @foreach (['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'] as $day)
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">
                                                        {{ $day }}
                                                    </th>
                                                @endforeach
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($grupoTipo as $servicio => $detalle)
                                                <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                    <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                        {{ $servicio }}
                                                    </td>
                                                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                        <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                            @if (isset($detalle[$day]))
                                                                {{ count($detalle[$day]) }}
                                                            @else
                                                                0
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    <td class="border-r px-6 py-4 dark:border-neutral-500">
                                                        {{ $detalle['Total'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="border-b dark:border-neutral-500 bg-green-200">
                                                <td colspan="8" 
                                                    class="border-r px-6 py-3 dark:border-neutral-500 font-bold text-right">
                                                    Total:
                                                </td>
                                                <td class="border-r px-6 py-3 dark:border-neutral-500 font-bold">
                                                    {{ collect($grupoTipo)->sum('Total')}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>


</div>
