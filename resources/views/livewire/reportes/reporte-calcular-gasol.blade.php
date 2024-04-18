<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <div class="bg-gray-200  px-8 py-4 rounded-xl w-full ">

            <div class=" items-center md:block sm:block">
                <div class="p-2 w-64 my-4 md:w-full">
                    <h2 class="text-indigo-600 font-bold text-3xl">
                        <i class="fa-solid fa-square-poll-vertical fa-xl"></i>
                        &nbsp;REPORTE GENERAL DETALLADO
                    </h2>
                </div>

                <div class="w-full  items-center md:flex md:flex-row md:justify-between ">
                    {{--
                    <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
                        <span>Taller: </span>
                        <select wire:model="taller"   
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                            <option value="">SELECCIONE</option>
                            @isset($talleres)
                                @foreach ($talleres as $taller)
                                    <option value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>   
                    --}}

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

                    <button wire:click="calcularReporte"
                        class="bg-green-400 px-6 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                        <p class="truncate"> Generar reporte </p>
                    </button>
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

        <!-- Tabla detallado -->
        @if (isset($reportePorInspector))
            <div wire.model="resultados">
                <div class="m-auto flex justify-center items-center bg-gray-300 rounded-md w-full p-4 mt-4">
                    <button wire:click="exportarExcel"
                        class="bg-green-400 px-6 py-4 w-1/3 text-sm rounded-md text-sm text-white font-semibold tracking-wide cursor-pointer ">
                        <p class="truncate"><i class="fa-solid fa-file-excel fa-lg"></i> Desc. Excel </p>
                    </button>
                </div>
                @foreach ($reportePorInspector as $inspectorId => $certificacionesInspector)
                    <div class="bg-gray-200  px-8 py-4 rounded-xl w-full mt-4">
                        <div class="p-2 w-full justify-between m-auto flex items-space-around">
                            @php $nombreInspector = $certificacionesInspector[0]->nombre ?? 'Nombre no disponible' @endphp
                            <h2 class="text-indigo-600 text-xl font-bold mb-4">{{ $nombreInspector }}</h2>
                        </div>

                        @if (!empty($certificacionesInspector) && count($certificacionesInspector) > 0)
                            <div class="overflow-x-auto m-auto w-full">
                                <div class="inline-block min-w-full py-2 sm:px-6">
                                    <div class="overflow-hidden">
                                        <table
                                            class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                            <thead class="border-b font-medium dark:border-neutral-500">
                                                <tr class="bg-indigo-200">
                                                    {{-- <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                            <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll({{ $inspector->id }})" />
                                                            </th> --}}
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">#
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">ID
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Taller
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Inspector
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Hoja
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Vehículo</th>
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Servicio</th>
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Fecha
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Estado
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Pagado
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Precio
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($certificacionesInspector as $key => $item)
                                                    <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                        {{-- <td class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                                <input type="checkbox" wire:model="selectedRows.{{ $inspectorId }}.{{ $key }}" />
                                                                </td> --}}
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            {{ $key + 1 }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            {{ is_object($item) ? $item->id ?? 'N.A' : 'N.A' }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            {{ $item->taller ?? 'N.A' }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            {{ $item->nombre ?? 'N.A' }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            {{ $item->matenumSerie ?? 'N.A' }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            @if ($item->tiposervicio == 'Chip por deterioro')
                                                                @php
                                                                    $ubicacionParts = explode(
                                                                        '/',
                                                                        $item->mateubicacion,
                                                                    );
                                                                    $secondPart = isset($ubicacionParts[1])
                                                                        ? trim($ubicacionParts[1])
                                                                        : 'N.A';
                                                                    echo $secondPart;
                                                                @endphp
                                                            @else
                                                                {{ $item->placa ?? 'En tramite' }}
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            {{ $item->tiposervicio ?? 'N.E' }}</td>
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            {{ $item->created_at ?? 'S.F' }}</td>
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            <div class="flex items-center justify-center">
                                                                @switch(is_object($item) ? $item->estado : null)
                                                                    @case(1)
                                                                        <i class="far fa-check-circle fa-lg"
                                                                            style="color: forestgreen;"></i>
                                                                    @break

                                                                    @case(2)
                                                                        <i class="far fa-times-circle fa-lg"
                                                                            style="color: red;"></i>
                                                                    @break

                                                                    @case(3)
                                                                        <i
                                                                            class="fa-regular fa-circle-pause fa-lg text-amber-400"></i>
                                                                    @break

                                                                    @default
                                                                        NA
                                                                @endswitch
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            {{-- --}}
                                                            @if (is_object($item) && property_exists($item, 'pagado'))
                                                                @if ($item->pagado == 0)
                                                                    Sin cobrar
                                                                @elseif ($item->pagado == 1)
                                                                    Cobrado el
                                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                                                @else
                                                                    Cert. Pendiente
                                                                @endif
                                                            @else
                                                                Cert. Pendiente
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                            {{ $item->precio ?? 'S.P' }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <tr class="border-b dark:border-neutral-500 bg-green-200">
                                                    <td colspan="10" {{-- {{$mostrar ? '9':'8'}} --}}
                                                        class="border-r px-6 py-3 dark:border-neutral-500 font-bold text-right">
                                                        Total: {{-- ({{ $certificacionesInspector[0]->nombre }}) --}}
                                                    </td>
                                                    <td class="border-r px-6 py-3 dark:border-neutral-500 font-bold">
                                                        {{ number_format(collect($certificacionesInspector)->sum('precio'), 2) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            <ul class="grid grid-cols-2 gap-4">
                                                @foreach (collect($certificacionesInspector)->groupBy('tiposervicio') as $tipoServicio => $detalle)
                                                    <li
                                                        class="flex items-center justify-between bg-gray-100 p-3 rounded-md shadow">
                                                        <span
                                                            class="text-blue-400">{{ 'Cantidad de ' . $tipoServicio }}</span>
                                                        <span class="text-green-500">{{ $detalle->count() }}
                                                            servicios</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-center text-gray-500">No hay certificaciones para este taller.</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <!-- Tabla discrepancias -->
            <div class="bg-gray-200  px-8 py-4 rounded-xl w-full mt-4">
                <h2 class="text-indigo-600 text-xl font-bold mb-4">Discrepancias</h2>

                @if (!empty($detallesPlacasFaltantes) && count($detallesPlacasFaltantes) > 0)
                    <div class="overflow-x-auto m-auto w-full">
                        <div class="inline-block min-w-full py-2 sm:px-6">
                            <div class="overflow-hidden">
                                <table
                                    class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                    <thead class="border-b font-medium dark:border-neutral-500">
                                        <tr class="bg-indigo-200">
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">#
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Taller
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Inspector
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Placa
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Servicio
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Fecha
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Precio
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detallesPlacasFaltantes as $item)
                                            <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $item['taller'] ?? 'N.A' }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $item['certificador'] ?? 'N.A' }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $item['placa'] ?? 'N.A' }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    @php
                                                        $tipoServicio = $item['tipoServicio'] ?? null;
                                                        $nombreTipoServicio = '';

                                                        switch ($tipoServicio) {
                                                            case 1:
                                                                $nombreTipoServicio = 'Conversión a GNV';
                                                                break;
                                                            case 2:
                                                                $nombreTipoServicio = 'Revisión anual GNV';
                                                                break;
                                                            case 6:
                                                                $nombreTipoServicio = 'Desmonte de Cilindro';
                                                                break;
                                                            default:
                                                                $nombreTipoServicio = 'N.A';
                                                                break;
                                                        }
                                                    @endphp

                                                    {{ $nombreTipoServicio }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $item['fecha'] ?? 'N.A' }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $item['precio'] ?? 'N.A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center text-gray-500">No hay discrepancias.</p>
                @endif
            </div>
        @endif






    </div>

</div>
