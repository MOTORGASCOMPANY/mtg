<div>
    <div class="w-full pt-3">
        <div class="w-full pt-2  mt-2 px-4 text-center mx-auto">
            <h1 class="text-2xl text-indigo-500 font-bold italic text-center py-8"><span class="text-none">📕</span>REPORTE DE DOCUMENTOS PROXIMOS A VENCER</h1>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="flex bg-white items-center p-2 w-1/2 md:w-48 rounded-md mb-4">
                        <span>Desde: </span>
                        <x-date-picker wire:model="fechaInicio" placeholder="Fecha de inicio"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                    </div>
                    <div class="flex bg-white items-center p-2 w-1/2 md:w-48 rounded-md mb-4">
                        <span>Hasta: </span>
                        <x-date-picker wire:model="fechaFin" placeholder="Fecha de Fin"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                    </div>
                    <button wire:click="generarReporte2"
                        class="bg-indigo-600 px-6 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                        <p class="truncate"> Generar reporte </p>
                    </button>
                </div>
                <div class="flex bg-white items-center p-2 rounded-md mb-4">
                    <span>Documento: </span>
                    <select wire:model="tipoDocumentoId"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                        <option value="">SELECCIONE</option>
                        @isset($tipodocumentos)
                            @foreach ($tipodocumentos as $tipo)
                                <option class="" value="{{ $tipo->id }}">{{ $tipo->nombreTipo }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="flex bg-white items-center p-2 rounded-md mb-4 ">
                    <span>Taller: </span>
                    <select wire:model="tallerId"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                        <option value="">SELECCIONE</option>
                        @isset($talleres)
                            @foreach ($talleres as $taller)
                                <option class="" value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <button wire:click="venceHoy"
                    class="bg-green-400 px-6 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                    <p class="truncate"> Vence Hoy </p>
                </button>
            </div>


            <div class="w-auto my-4">
                <x-jet-input-error for="fechaInicio" />
                <x-jet-input-error for="fechaFin" />
            </div>
            <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg" wire:loading wire:target="generarReporte2">
                CARGANDO <i class="fa-solid fa-spinner animate-spin"></i>
            </div>
            @if (isset($documentos))
                @if ($documentos->count())
                    <div class="flex flex-col my-4 py-4 rounded-md bg-white px-4 justify-center">
                        <div class="m-auto flex justify-center items-center bg-gray-300 rounded-md w-full p-4">
                            <button wire:click=""
                                class="bg-green-400 px-6 py-4 w-1/3 text-sm rounded-md text-sm text-white font-semibold tracking-wide cursor-pointer ">
                                <p class="truncate"><i class="fa-solid fa-file-excel fa-lg"></i> Desc. Excel </p>
                            </button>
                        </div>
                        <div class="inline-block min-w-full py-2 sm:px-6">
                            <div class="overflow-hidden">
                                <table class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                    <thead class="border-b font-medium dark:border-neutral-500">
                                        <tr class="bg-indigo-200">
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                #
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Taller
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Documento
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Combustible
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Vence
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documentos as $key => $item)
                                            <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                                    {{ $key + 1 }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">
                                                    @foreach ($item->talleres as $taller)
                                                        {{ $taller->nombre }}
                                                    @endforeach
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">
                                                    {{ $item->TipoDocumento->nombreTipo }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">                                                    
                                                    @foreach ($item->documentostaller as $comb)
                                                        {{ $comb->combustible }}
                                                    @endforeach
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">
                                                    {{ $item->fechaExpiracion->format('d-m-Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg"
                        wire:loading.class="hidden">
                        No se encontraron documentos proximos a vencer.
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
