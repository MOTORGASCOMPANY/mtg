<div class="flex  w-full pt-12 justify-center">
    <section class="bg-white dark:bg-gray-900 mt-2 border rounded-md shadow-lg">
        <div class="container px-6 py-5 mx-auto">
            <div class="relative">
                <h1 class="text-3xl font-bold text-center text-gray-800 lg:text-4xl dark:text-white">
                    Inventario de
                    <span class="text-indigo-500">Materiales</span>
                </h1>
                <div class="absolute right-0 top-0 flex flex-col items-end">
                    <button class="p-3 bg-indigo-500 rounded-xl text-white text-sm hover:font-bold hover:bg-indigo-700"
                        wire:click="procesarDevolucion">
                        <i class="fa-solid fa-right-left"></i>
                        Devolución Materiales
                    </button>
                    @if ($mostrarDoc)
                        <div class="flex flex-col ml-4 space-y-2">
                            @foreach ($certificacion->groupBy('cart_id') as $group)
                                <a href="{{ $group->first()->RutaVistaCertificado }}" target="__blank"
                                    rel="noopener noreferrer"
                                    class="block px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-md hover:cursor-pointer">
                                    <i class="fas fa-eye"></i>
                                    <span>Ver Cargo.</span>
                                </a>
                            @endforeach
                            <a href="{{ route('inventario') }}"
                                class="block px-4 py-2 text-sm text-white bg-red-400 hover:bg-red-500 rounded-md focus:outline-none">
                                <p class="text-sm font-medium leading-none">
                                    <i class="fas fa-archive"></i>&nbsp;Finalizar
                                </p>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 mt-6 xl:mt-5 xl:gap-10 md:grid-cols-2 xl:grid-cols-4">

                {{--              GNVS                  --}}
                <div
                    class="w-full border border-indigo-400 max-w-sm px-4 py-3 bg-white rounded-md shadow-md dark:bg-gray-800 dark:shadow-indigo-400">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-800 dark:text-gray-400 font-bold"><i
                                class="fas fa-file"></i>&nbsp;
                            FORMATOS GNV</span>
                        <span
                            class="px-3 py-1 text-sm text-green-800 uppercase bg-green-200 rounded-full dark:bg-blue-300 dark:text-blue-900"><i
                                class="fa-solid fa-clipboard-check"></i></span>
                    </div>
                    <div class="mt-4">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 text-md font-semibold text-gray-600 dark:text-gray-300">
                                En stock:
                            </p>
                            @if ($todos->where('idTipoMaterial', 1)->where('estado', 3)->count() > 0)
                                <span class=" mr-2 bg-green-200 px-1 rounded-full text-green-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 1)->where('estado', 3)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-green-200 p-1 rounded-full text-green-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 1)->where('estado', 3)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 text-md font-semibold text-gray-600 dark:text-gray-300">
                                Consumido:
                            </p>
                            @if ($todos->where('idTipoMaterial', 1)->where('estado', 4)->count() > 0)
                                <span class=" mr-2 bg-orange-200 px-1 rounded-full text-orange-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 1)->where('estado', 4)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-orange-200 px-1 rounded-full text-orange-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 1)->where('estado', 4)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Anulado:
                            </p>
                            @if ($todos->where('idTipoMaterial', 1)->where('estado', 5)->count() > 0)
                                <span class=" mr-2 bg-red-200 px-1 rounded-full text-red-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 1)->where('estado', 5)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-red-200 px-1 rounded-full text-red-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 1)->where('estado', 5)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 text-md font-semibold text-gray-600 dark:text-gray-300">Pendiente de Cambio:
                            </p> <span class=" mr-2 bg-gray-200 p-3 rounded-full"></span>
                        </div>
                    </div>
                </div>

                {{--              GLPS                  --}}
                <div
                    class="border border-indigo-400 w-full max-w-sm px-4 py-3 bg-white rounded-md shadow-md dark:bg-gray-800 dark:shadow-indigo-400">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-800 dark:text-gray-400 font-bold"> <i class="fas fa-file"></i>
                            &nbsp;FORMATOS GLP</span>
                        <span
                            class="px-3 py-1 text-sm text-green-800 uppercase bg-green-200 rounded-full dark:bg-blue-300 dark:text-blue-900"><i
                                class="fa-solid fa-clipboard-check"></i></span>
                    </div>
                    <div class="mt-4">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                En stock:
                            </p>
                            @if ($todos->where('idTipoMaterial', 3)->where('estado', 3)->count() > 0)
                                <span class=" mr-2 bg-green-200 px-1 rounded-full text-green-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 3)->where('estado', 3)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 3)->where('estado', 3)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 text-md font-semibold text-gray-600 dark:text-gray-300">
                                Consumido:
                            </p>
                            @if ($todos->where('idTipoMaterial', 3)->where('estado', 4)->count() > 0)
                                <span class=" mr-2 bg-orange-200 px-1 rounded-full text-orange-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 3)->where('estado', 4)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 3)->where('estado', 4)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Anulado:
                            </p>
                            @if ($todos->where('idTipoMaterial', 3)->where('estado', 5)->count() > 0)
                                <span class=" mr-2 bg-red-200 px-1 rounded-full text-red-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 3)->where('estado', 5)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 3)->where('estado', 5)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Pendiente de Cambio:
                            </p>
                            <span class=" mr-2 bg-gray-200 p-3 rounded-full"></span>
                        </div>
                    </div>
                </div>

                {{--              CHIPS                 --}}
                <div
                    class="border border-indigo-400 w-full max-w-sm px-4 py-3 bg-white rounded-md shadow-md dark:bg-gray-800 dark:shadow-indigo-400">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-800 dark:text-gray-400 font-bold"> <i
                                class="fas fa-microchip"></i>
                            CHIPS</span>
                        <span
                            class="px-3 py-1 text-sm text-green-800 uppercase bg-green-200 rounded-full dark:bg-blue-300 dark:text-blue-900"><i
                                class="fa-solid fa-clipboard-check"></i></span>
                    </div>

                    <div class="mt-4">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                En stock:
                            </p>
                            @if ($todos->where('idTipoMaterial', 2)->where('estado', 3)->count() > 0)
                                <span class=" mr-2 bg-green-200 px-1 rounded-full text-green-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 2)->where('estado', 3)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 2)->where('estado', 3)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Consumido:
                            </p>
                            @if ($todos->where('idTipoMaterial', 2)->where('estado', 4)->count() > 0)
                                <span class=" mr-2 bg-orange-200 px-1 rounded-full text-orange-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 2)->where('estado', 4)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 2)->where('estado', 4)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                otro:
                            </p>
                            @if ($todos->where('idTipoMaterial', 2)->where('estado', 5)->count() > 0)
                                <span class=" mr-2 bg-red-200 px-1 rounded-full text-red-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 2)->where('estado', 5)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 2)->where('estado', 5)->count() }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{--              MODIFICACION           --}}
                <div
                    class="border border-indigo-400 w-full max-w-sm px-4 py-3 bg-white rounded-md shadow-md dark:bg-gray-800 dark:shadow-indigo-400">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-800 dark:text-gray-400 font-bold"> <i class="fas fa-file"></i>
                            &nbsp;MODIFICACIÓN</span>
                        <span
                            class="px-3 py-1 text-sm text-green-800 uppercase bg-green-200 rounded-full dark:bg-blue-300 dark:text-blue-900"><i
                                class="fa-solid fa-clipboard-check"></i></span>
                    </div>
                    <div class="mt-4">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                En stock:
                            </p>
                            @if ($todos->where('idTipoMaterial', 4)->where('estado', 3)->count() > 0)
                                <span class=" mr-2 bg-green-200 px-1 rounded-full text-green-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 4)->where('estado', 3)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 4)->where('estado', 3)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 text-md font-semibold text-gray-600 dark:text-gray-300">
                                Consumido:
                            </p>
                            @if ($todos->where('idTipoMaterial', 4)->where('estado', 4)->count() > 0)
                                <span class=" mr-2 bg-orange-200 px-1 rounded-full text-orange-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 4)->where('estado', 4)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 4)->where('estado', 4)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Anulado:
                            </p>
                            @if ($todos->where('idTipoMaterial', 4)->where('estado', 5)->count() > 0)
                                <span class=" mr-2 bg-red-200 px-1 rounded-full text-red-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 3)->where('estado', 5)->count() }}
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{ $todos->where('idTipoMaterial', 4)->where('estado', 5)->count() }}
                                </span>
                            @endif
                        </div>
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Pendiente de Cambio:
                            </p>
                            <span class=" mr-2 bg-gray-200 p-3 rounded-full"></span>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="flex items-center justify-center space-x-4 py-5">
            <div>
                <x-jet-label value="Tipo Material:" for="Tipo Material" />
                <select wire:model="tipoMaterial"
                    class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                    <option value="">Seleccione</option>
                    <option value="1">Formato GNV</option>
                    <option value="2">CHIP</option>
                    <option value="3">Formato GLP</option>
                    <option value="4">Modificación</option>
                </select>
                <x-jet-input-error for="tipoMaterial" />
            </div>
            <div>
                <x-jet-label value="Estado:" for="estado" />
                <select wire:model="estado"
                    class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                    <option value="">Seleccione</option>
                    <option value="3">Disponible</option>
                    <option value="4">Consumido</option>
                    <option value="5">Anulado</option>
                </select>
                <x-jet-input-error for="estado" />
            </div>
            <div class="mt-5">
                <button class="p-3 bg-indigo-500 rounded-xl text-white text-sm hover:font-bold hover:bg-indigo-700"
                    wire:click="consultar">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
        </div>

        <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg"
            wire:loading>
            CARGANDO <i class="fa-solid fa-spinner animate-spin"></i>
        </div>

        @if (isset($resultado))
            @if ($resultado->count())
                <div class="max-h-96 overflow-y-auto">
                    <table class="w-5/6 m-auto my-6 text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-xs text-gray-700 uppercase rounded-t-lg dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-indigo-300 sticky top-0 z-10">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 bg-indigo-300 sticky top-0 z-10">
                                    # Serie
                                </th>
                                <th scope="col" class="px-6 py-3 bg-indigo-300 sticky top-0 z-10">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 bg-indigo-300 sticky top-0 z-10">
                                    Ubicación
                                </th>
                                @if ($estado == 5)
                                    <th scope="col" class="px-6 py-3 bg-indigo-300 sticky top-0 z-10">
                                        Entregado
                                    </th>
                                @endif
                                <th scope="col" class="px-6 py-3 bg-indigo-300 sticky top-0 z-10">
                                    Ultima act.
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resultado as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{-- $item->tipo->descripcion --}}{{ $loop->iteration }}
                                    </th>
                                    <td class="px-6 py-4 ">
                                        {{ $item->numSerie ?? 'No data' }}
                                    </td>
                                    <td class="px-6 py-4 ">
                                        @switch($item->estado)
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
                                                    class="inline-block whitespace-nowrap rounded-full bg-gray-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-gray-800">
                                                    Anulado
                                                </span>
                                            @break

                                            @default
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 ">
                                        {{ $item->ubicacion }}
                                    </td>
                                    @if ($estado == 5)
                                        <td class="pl-12">
                                            <div class="flex items-center">
                                                <x-jet-checkbox class="h-4 w-4 text-indigo-600 rounded-lg" disabled
                                                    :checked="$item->devuelto" />
                                            </div>
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 ">
                                        {{ $item->updated_at->format('d-m-Y H:i:s a') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 border rounded-md bg-indigo-400 shadow-lg mb-4" wire:loading.class="hidden">
                    <p class="text-center text-gray-100 font-semibold">
                        No se encontraron resultados
                    </p>
                </div>
            @endif

        @endif
    </section>




</div>
