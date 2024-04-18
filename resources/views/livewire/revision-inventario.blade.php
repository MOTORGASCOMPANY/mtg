<div>
    <div class="container block justify-center m-auto py-12">
        <h1 class="text-2xl text-center font-bold text-indigo-500 uppercase">Consulta de inventario</h1>
        <div class="rounded-xl m-4 bg-white p-8 mx-auto max-w-max shadow-lg">
            <div class="flex flex-row">
                <div class="w-full">
                    <x-jet-label value="Inspector:" for="Inspector" />
                    <select wire:model="inspector"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                        <option value="0">Seleccione</option>
                        @foreach ($inspectores as $inspector)
                            <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="inspector" />
                </div>
                <div class="w-full">
                    <x-jet-label value="Tipo Material:" for="Tipo Material" />
                    <select wire:model="tipoMaterial"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                        <option value="">Seleccione</option>
                        <option value="1">Formato GNV</option>
                        <option value="2">CHIP</option>
                        <option value="3">Formato GLP</option>
                        <option value="4">Modificación</option>
                    </select>
                    <x-jet-input-error for="inspector" />
                </div>
            </div>
            <div class="flex items-center justify-center mt-4">
                <button class="p-3 bg-indigo-500 rounded-xl text-white text-sm hover:font-bold hover:bg-indigo-700"
                    wire:click="consultar">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
        </div>
        <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg" wire:loading>
            CARGANDO  <i class="fa-solid fa-spinner animate-spin"></i>
        </div>

        @if(isset($resultado))

            @if ($resultado->count())
                <div class="w-full border bg-white rounded-md shadow-md" wire:loading.class="hidden">
                    <div class="w-5/6 my-4 m-auto text-center">
                        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-x-6 lg:gap-x-0 items-center">
                            <div class="mb-12 lg:mb-0 relative">
                                <i class="fa-solid fa-cubes fa-3x text-amber-600 mx-auto mb-6"></i>
                                <h5 class="text-lg font-medium text-blue-600 font-bold mb-4">{{ $resultado->count() }}</h5>
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
                    <div class="max-h-96 overflow-y-auto">
                        <table class="w-5/6 m-auto my-6 text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase rounded-t-lg dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-indigo-300 sticky top-0 z-10">
                                        Material
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
                                            {{ $item->tipo->descripcion }}
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

                                                @default
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 ">
                                            {{ $item->ubicacion }}
                                        </td>
                                        <td class="px-6 py-4 ">
                                            {{ $item->updated_at->format('d-m-Y H:i:s a')}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="p-4 border rounded-md bg-indigo-400 shadow-lg mb-4" wire:loading.class="hidden">
                    <p class="text-center text-gray-100 font-semibold">
                        No se encontraron resultados
                    </p>
                </div>
            @endif

        @endif



    </div>
</div>
