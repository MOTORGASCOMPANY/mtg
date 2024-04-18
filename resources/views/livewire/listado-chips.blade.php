<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <x-custom-table>
            <x-slot name="titulo">
                <h2 class="text-indigo-600 font-bold text-3xl uppercase">
                    <i class="fa-solid fa-file-circle-check fa-xl text-indigo-600"></i>
                    &nbsp;Listado de Chips
                </h2>
            </x-slot>
            <x-slot name="btnAgregar" class="mt-6 ">
            </x-slot>
            <x-slot name="contenido">
                @if ($chipsConsumidos->count() > 0)
                    <table class="w-full whitespace-nowrap">
                        <thead class="bg-slate-600 border-b font-bold text-white">
                            <tr>
                                <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                    #
                                </th>
                                <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                    Inspector
                                </th>
                                <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                    ID
                                </th>                                
                                <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                    Servicio
                                </th>
                                {{-- para agregar placa o id
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Placa / Id
                                </th> --}}
                                <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                    Estado
                                </th>
                                <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                    Ubicación
                                </th>
                                <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                    Grupo
                                </th>
                                <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left" wire:click="sortBy('updated_at')">
                                Fecha
                                @if ($sort == 'updated_at')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                    @else
                                        <i class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                @endif
                            </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($chipsConsumidos as $key => $chip)
                                <tr tabindex="0" class="focus:outline-none h-12 border border-slate-300 rounded hover:bg-gray-200">
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-indigo-200 rounded-sm w-5 h-5 flex flex-shrink-0 justify-center items-center relative text-indigo-900">
                                                {{ $key + 1 }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $chip->nombreInspector }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-yellow-900 p-1 bg-yellow-200 rounded-md">
                                                {{ $chip->id }}

                                            </p>
                                        </div>
                                    </td>                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if (Str::startsWith($chip->ubicacion, 'En poder del cliente '))
                                                <p
                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-blue-200 rounded-full">
                                                    Chip por deterioro
                                                </p>
                                            @else
                                                <p
                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                    Conversión a GNV + chip
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                    {{-- para agregar placa o id
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{$chip->id}}
                                    </td>
                                    --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($chip->estado == 4)
                                            Consumido
                                        @else
                                            {{ $chip->estado }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $chip->ubicacion }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $chip->grupo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($chip->updated_at)->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $chipsConsumidos->links() }}
                    </div>
                @else
                    <p>No hay chips consumidos por inspectores.</p>
                @endif
            </x-slot>
        </x-custom-table>
    </div>
</div>
