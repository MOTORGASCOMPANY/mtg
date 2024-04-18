
<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <div class="bg-gray-200  px-8 py-4 rounded-xl w-full ">

            <div class=" items-center md:block sm:block">
                <div class="p-2 w-64 my-4 md:w-full">
                    <h2 class="text-indigo-600 font-bold text-3xl">
                        <i class="fa-solid fa-square-poll-vertical fa-xl"></i>
                        &nbsp;REPORTE GENERAL DE SERVICIOS GNV
                    </h2>
                </div>
                <div class="w-full  items-center md:flex md:flex-row md:justify-between ">
                    <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
                        <span>Taller: </span>
                        <select wire:model="taller"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                            <option value="">SELECCIONE</option>
                            @isset($talleres)
                                @foreach ($talleres as $taller)
                                    <option value="{{ $taller }}">{{ $taller }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="flex bg-white items-center p-2 rounded-md mb-4">
                        <span>Inspector: </span>
                        <select wire:model="ins"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                            <option value="">SELECCIONE</option>
                            @isset($inspectores)
                                @foreach ($inspectores as $inspector)
                                    <option value="{{ $inspector }}">{{ $inspector }}</option>
                                @endforeach
                            @endisset
                        </select>
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

                    <button wire:click="generarReporte"
                        class="bg-indigo-600 px-6 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                        <p class="truncate"> Generar reporte </p>
                    </button>
                </div>
                <div class="w-auto my-4">
                    <x-jet-input-error for="taller" />
                    <x-jet-input-error for="ins" />
                    <x-jet-input-error for="fechaInicio" />
                    <x-jet-input-error for="fechaFin" />
                </div>
            </div>
        </div>

        @if (!empty($data))
            <div class="flex flex-row my-4 py-4 rounded-md bg-gray-200 space-x-2 px-4">
                <div class="flex text-white p-2 rounded-md bg-sky-500 hover:shadow-lg hover:shadow-sky-300 hover:cursor-pointer">                     
                    <p class="text-sm">Servicios: <span class="text-xl font-bold">{{ count($data) }}</span></p>
                </div>
                <div class="flex text-white p-2 rounded-md bg-green-600 hover:shadow-lg hover:shadow-green-300 hover:cursor-pointer items-center">
                    <p class="text-sm">Total a pagar: <span class="text-xl font-bold">{{'S/ '.$total}}</span></p>                    
                </div>
                
            </div>
            <div class="flex flex-row my-4 py-4 rounded-md bg-white px-4 justify-center">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 mx-12 w-full">
                    <div class="inline-block min-w-full py-2 sm:px-6 ">
                        <div class="overflow-hidden">
                            <table class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                <thead class="border-b font-medium dark:border-neutral-500">
                                    <tr class="bg-indigo-200">
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            Inspector
                                        </th>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            Taller
                                        </th>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            Placa
                                        </th>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            Servicio
                                        </th>

                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            Fecha certificación Gasolution
                                        </th>
                                        
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            Realizado con sistema
                                        </th>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            Precio
                                        </th>

                                    </tr>
                                </thead>                                
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr class="border-b dark:border-neutral-500">
                                            <td
                                                class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">
                                                {{ isset($item['serv_mtg']->inspector) ? $item['serv_mtg']->inspector : $item['serv_gas']->certificador }}
                                            </td>
                                            <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                {{ isset($item['serv_mtg']->taller) ? $item['serv_mtg']->taller : $item['serv_gas']->taller }}
                                            </td>
                                            <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                {{ isset($item['serv_mtg']->placa) ? $item['serv_mtg']->placa : $item['serv_gas']->placa }}
                                            </td>

                                            <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                {{ isset($item['serv_gas']->TipoServicio->descripcion) ? $item['serv_gas']->TipoServicio->descripcion : 'no data' }}
                                            </td>

                                            <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                {{ isset($item['serv_gas']->fecha) ? $item['serv_gas']->fecha : 'No Data' }}
                                            </td>
                                            {{--
                        <td
                          class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                          {{ isset($item["serv_mtg"]->precio)? $item["serv_mtg"]->precio : 'No data' }}
                        </td>
                        --}}
                                            <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                {{ isset($item['serv_mtg']) ? '✔' : '❌' }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500 overflow-x-auto">
                                                {{ $item['serv_gas']->precio }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>
</div>


  