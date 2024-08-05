<div>
    <div class="w-full pt-3">
        <div class="w-full pt-2  mt-2 px-4 text-center mx-auto">
            <h1 class="text-2xl text-indigo-500 font-bold italic text-center py-8"><span
                    class="text-none">📍</span>CONSULTA DE MATERIAL</h1>
            <div class="w-full  items-center md:flex  md:justify-center md:space-x-2">
                <div class="flex bg-white items-center p-2 rounded-md mb-4 md:space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                    <input class="bg-gray-50 outline-none block rounded-md border-indigo-500 w-full " wire:model="desde"
                        placeholder="Desde...">

                    <input class="bg-gray-50 outline-none block rounded-md border-indigo-500 w-full " wire:model="hasta"
                        placeholder="Hasta...">

                    <div class="w-full">
                        <select wire:model="tipoMaterial"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                            <option value="">Seleccione Material</option>
                            <option value="1">Formato GNV</option>
                            <option value="2">CHIP</option>
                            <option value="3">Formato GLP</option>
                            <option value="4">Modificación</option>
                        </select>
                        <x-jet-input-error for="tipoMaterial" />
                    </div>
                    <div class="w-full">
                        <select wire:model="anioActivo"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                            <option value="">Seleccione Anio</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                        <x-jet-input-error for="anioActivo" />
                    </div>
                </div>
                <div class="md:space-x-2">

                    <button wire:click="buscar"
                        class="bg-indigo-600 px-6 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                        <p class="truncate"> Realizar Consulta </p>
                    </button>
                    @hasanyrole('Administrador del sistema')
                        @if ($consultaRealizada)
                            <button wire:click="abrirModal"
                                class="bg-indigo-600 px-6 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                                <p class="truncate"> Update </p>
                            </button>
                        @endif
                    @endhasanyrole
                </div>


            </div>

            <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg"
                wire:loading wire:target="buscar">
                CARGANDO <i class="fa-solid fa-spinner animate-spin"></i>
            </div>
            @if (isset($resultados))
                @if ($resultados->count())
                    <div class="flex flex-col my-4 py-4 rounded-md bg-white px-4 justify-center">
                        <div class="overflow-x-auto m-auto w-full">
                            <div class="inline-block min-w-full py-2 sm:px-6">
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr class="bg-indigo-200">
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    #
                                                </th>
                                                {{-- 
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    ID
                                                </th>
                                                --}}
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Inspector
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Estado
                                                </th>

                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    N° Formato
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Placa
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Año
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Grupo
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Ubicacion
                                                </th>
                                                {{-- 
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Fecha Asignación
                                                </th>
                                                --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($resultados as $key => $item)
                                                <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    {{-- 
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                        {{ $item->id }}
                                                    </td>
                                                    --}}
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                        {{ $item->nombreUsuario ?? 'NE' }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                        @if (isset($item->estado))
                                                            @switch($item->estado)
                                                                @case(1)
                                                                    En stock almacen MOTORGAS
                                                                @break

                                                                @case(2)
                                                                    En proceso de envío
                                                                @break

                                                                @case(3)
                                                                    En posesión de {{ $item->nombreUsuario ?? 'NE' }}
                                                                @break

                                                                @case(4)
                                                                    Consumido
                                                                @break

                                                                @case(5)
                                                                    Anulado
                                                                @break

                                                                @case(6)
                                                                    Stock sin firmar
                                                                @break

                                                                @default
                                                                    Otro estado
                                                            @endswitch
                                                        @else
                                                            NE
                                                        @endif
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                        {{ $item->numSerie ?? 'NE' }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                        {{ $item->placa ?? 'SP' }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                        {{ $item->añoActivo ?? 'NE' }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                        {{ $item->grupo ?? 'NE' }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-4  dark:border-neutral-500">
                                                        {{ $item->ubicacion ?? 'NE' }}
                                                    </td>
                                                    {{-- 
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-4  dark:border-neutral-500">
                                                        {{ $item->fechaAsignacion ?? 'NE' }}
                                                    </td>
                                                    --}}
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg"
                        wire:loading.class="hidden">
                        No se encontraron resultados.
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- MODAL PARA ACTUALIZAR ESTADO Y UBICACION --}}
    <x-jet-dialog-modal wire:model="openEdit" wire:loading.attr="disabled">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold">Actualizar Estado</h1>
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <x-jet-label value="Estado: " />
                    <select wire:model="estado"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full ">
                        <option value="">Seleccione</option>
                        <option value="1">Almacen</option>
                        <option value="2">Envio</option>
                        <option value="3">Inspector</option>
                        <option value="4">Consumido</option>
                        <option value="5">Anulado</option>
                    </select>
                    <x-jet-input-error for="estado" />
                </div>
                <div>
                    <x-jet-label value="Ubicación:" />
                    <x-jet-input type="text" class="w-full" wire:model="ubicacion" />
                    <x-jet-input-error for="ubicacion" />
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('openEdit',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="actualizar" wire:loading.attr="disabled" wire:target="update">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
