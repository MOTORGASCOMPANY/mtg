<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <div class="bg-gray-200 px-8 py-4 rounded-xl w-full">
            <div class="p-2 w-64 my-4 md:w-full">
                <h2 class="text-indigo-600 font-bold text-3xl">
                    <i class="fa-solid fa-square-poll-vertical fa-xl"></i>
                    &nbsp;REPORTE RENTABILIDAD
                </h2>
            </div>
            <div class="flex flex-wrap items-center space-x-2">

                <div x-data="tallerFilter" class="flex bg-white items-center p-2 rounded-md mb-4">
                    <span class="mr-1">Taller: </span>
                    <div class="relative">
                        <div x-on:click="isOpen = !isOpen" class="cursor-pointer">
                            <input wire:model="taller" type="text" placeholder="Seleccione" readonly
                                class="bg-gray-50 border-indigo-500 rounded-md outline-none px-4 py-2 w-full md:w-80">
                        </div>
                        <div x-show="isOpen" x-on:click.away="isOpen = false"
                            class="absolute z-10 mt-2 bg-white border rounded-md shadow-md max-h-96 overflow-y-auto w-full md:w-80">
                            <input x-model="search" type="text" placeholder="Buscar Taller..."
                                class="w-full px-4 py-2 bg-gray-50 border-indigo-500 rounded-md outline-none">
                            <template x-for="taller in filteredTalleres" :key="taller.id">
                                <label :for="'taller_' + taller.id" class="block px-4 py-2 cursor-pointer">
                                    <input :id="'taller_' + taller.id" type="checkbox" :value="taller.id"
                                        @change="toggleTaller(taller.id)" class="mr-2">
                                    <span x-text="taller.nombre"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>

                <div x-data="inspectorFilter" class="flex bg-white items-center p-2 rounded-md mb-4">
                    <span class="mr-1">Inspector: </span>
                    <div class="relative">
                        <div x-on:click="isOpen = !isOpen" class="cursor-pointer">
                            <input wire:model="ins" type="text" placeholder="Seleccione" readonly
                                class="bg-gray-50 border-indigo-500 rounded-md outline-none px-4 py-2 w-full md:w-80">
                        </div>
                        <div x-show="isOpen" x-on:click.away="isOpen = false"
                            class="absolute z-10 mt-2 bg-white border rounded-md shadow-md max-h-96 overflow-y-auto w-full md:w-80">
                            <input x-model="search" type="text" placeholder="Buscar Inspector..."
                                class="w-full px-4 py-2 bg-gray-50 border-indigo-500 rounded-md outline-none">
                            <template x-for="inspector in filteredInspectores" :key="inspector.id">
                                <label :for="'inspector_' + inspector.id" class="block px-4 py-2 cursor-pointer">
                                    <input :id="'inspector_' + inspector.id" type="checkbox" :value="inspector.id"
                                        @change="toggleInspector(inspector.id)" class="mr-2">
                                    <span x-text="inspector.name"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
                    <span class="mr-1">Servicio: </span>
                    <select wire:model="servicio"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                        <option value="">SELECCIONE</option>
                        @isset($tipos)
                            @foreach ($tipos as $tipo)
                                <option class="" value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="flex bg-white items-center p-2 w-48 rounded-md mb-4">
                    <span>Desde: </span>
                    <x-date-picker wire:model="fechaInicio" placeholder="Fecha de inicio"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                </div>

                <div class="flex bg-white items-center p-2 w-48 rounded-md mb-4">
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
                <x-jet-input-error for="taller" />
                <x-jet-input-error for="ins" />
                <x-jet-input-error for="servicio" />
                <x-jet-input-error for="fechaInicio" />
                <x-jet-input-error for="fechaFin" />
            </div>

            <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg"
                wire:loading>
                CARGANDO <i class="fa-solid fa-spinner animate-spin"></i>
            </div>
        </div>

        @if ($ingresosPorTaller)
            <div>
                <div class="m-auto flex justify-center items-center bg-gray-200 rounded-md w-full p-4 mt-4">
                    <button wire:click="$emit('exportaData')"
                        class="bg-green-400 px-6 py-4 w-1/3 text-sm rounded-md text-sm text-white font-semibold tracking-wide cursor-pointer ">
                        <p class="truncate"><i class="fa-solid fa-file-excel fa-lg"></i> Desc. Excel </p>
                    </button>
                </div>
                <div id='data_1'>

                    {{-- TABLA INGRESOS TOTALES POR TALLER --}}
                    <div class="bg-gray-200 rounded-md w-full p-4 mt-4">
                        <div class="p-2 w-full justify-between m-auto flex items-space-around">
                            <h3 class="text-indigo-600 text-lg font-bold mb-0">Ingresos Totales por Taller</h3>
                        </div>
                        <div class="overflow-x-auto m-auto w-full">
                            <div class="inline-block min-w-full py-2 sm:px-6">
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr class="bg-indigo-200">
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    #
                                                </th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Taller
                                                </th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Ingresos Totales
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ingresosPorTaller as $key => $ingreso)
                                                <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $ingreso['taller'] }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $ingreso['ingresos_totales'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- TABLA PARA SABER CANTIDAD DE SERVICIOS REALIZADOS POR TALLER --}}
                        <div class="p-2 w-full justify-between m-auto flex items-space-around">
                            <h3 class="text-indigo-600 text-lg font-bold mb-0">Número de Certificaciones Realizadas por
                                Taller</h3>
                        </div>
                        <div class="overflow-x-auto m-auto w-full">
                            <div class="inline-block min-w-full py-2 sm:px-6">
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr class="bg-indigo-200">
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    #
                                                </th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Taller
                                                </th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Total Certificaciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($certificacionesPorTaller as $key => $certificacion)
                                                <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $certificacion['taller'] }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $certificacion['total_certificaciones'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- TABLA PARA SABER COSTOS TOTALES POR TALLER --}}
                        <div class="p-2 w-full justify-between m-auto flex items-space-around">
                            <h3 class="text-indigo-600 text-lg font-bold mb-0">Costos Totales por Taller</h3>
                        </div>
                        <div class="overflow-x-auto m-auto w-full">
                            <div class="inline-block min-w-full py-2 sm:px-6">
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr class="bg-indigo-200">
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    #
                                                </th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Taller</th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Sueldo Inspector</th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Gratificación</th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Costo Hojas</th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Costo Chips</th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Costo Anual Cofide</th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Costo Inicial Cofide</th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Costos Totales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($costosPorTaller as $key => $costo)
                                                <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $key + 1 }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $costo['taller'] }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $costo['sueldos_inspector'] }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $costo['gratificacion'] }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $costo['hojas'] }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $costo['chips'] }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $costo['servicios_anual_cofide'] }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $costo['servicios_inicial_cofide'] }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $costo['costos_totales'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- TABLA PARA SABER RENTABILIDAD DEL TALLER --}}
                    <div class="bg-gray-200 rounded-md w-full p-4 mt-4">
                        <div class="p-2 w-full justify-between m-auto flex items-space-around">
                            <h3 class="text-indigo-600 text-lg font-bold mb-0">Rentabilidad del taller</h3>
                        </div>
                        <div class="flex items-center mb-0 pl-8">
                            {{-- ACTIVAR IGV --}}
                            <x-jet-label for="ajustarIngresos" class="mr-2" value="IGV (18%)" />
                            <x-jet-input type="checkbox" id="ajustarIngresos" wire:model="ajustarIngresos"
                                class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500 ml-2 mr-4" />
                            {{-- ACTIVAR PLANILLA (ESSALUD Y CTS) --}}
                            <x-jet-label for="ajustarCostos" class="mr-2" value="(Essalud y CTS)" />
                            <x-jet-input type="checkbox" id="ajustarCostos" wire:model="ajustarCostos"
                                class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500 ml-2 mr-4" />
                            {{-- GASTOS ADMINISTRATIVOS --}}
                            {{-- ACTIVAR GASTOS ADMINISTRATIVOS --}}
                            <x-jet-label for="gastosAdministrativos" class="mr-2" value="Gastos Administrativos" />
                            <x-jet-input type="number" id="gastosAdministrativos" wire:model="gastosAdministrativos"
                                class="w-20 p-2 border border-gray-300 rounded outline-none focus:ring-indigo-600 focus:ring-1 dark:bg-gray-600 dark:border-gray-500 ml-2 mr-4" />

                        </div>
                        <div class="overflow-x-auto m-auto w-full">
                            <div class="inline-block min-w-full py-2 sm:px-6">
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr class="bg-indigo-200">
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    #
                                                </th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Taller</th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Ingresos Totales</th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Costos Totales</th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Rentabilidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rentabilidadPorTaller as $key => $rentabilidad)
                                                <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $key + 1 }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $rentabilidad['taller'] }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $rentabilidad['ingresos_totales'] }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $rentabilidad['costos_totales'] }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        S/{{ $rentabilidad['rentabilidad'] }}</td>
                                                </tr>
                                            @endforeach
                                            <tr class="border-b dark:border-neutral-500 bg-green-200">
                                                <td colspan="4"
                                                    class="border-r px-6 py-2 dark:border-neutral-500 font-bold text-right">
                                                    @if ($totalRentabilidad <= 0)
                                                        RENTABILIDAD NEGATIVA
                                                    @else
                                                        RENTABILIDAD POSITIVA
                                                    @endif
                                                </td>
                                                <td class="border-r px-6 py-2 dark:border-neutral-500 font-bold">
                                                    S/{{ number_format($totalRentabilidad, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABLA INGRESOS POR TIPO DE SERVICIO POR TALLER --}}
                    <div class="bg-gray-200 rounded-md w-full p-4 mt-4">
                        <div class="p-2 w-full justify-between m-auto flex items-space-around">
                            <h3 class="text-indigo-600 text-lg font-bold mb-0">Ingresos por Tipo de Servicio en Cada
                                Taller
                            </h3>
                        </div>
                        <div class="overflow-x-auto m-auto w-full">
                            <div class="inline-block min-w-full py-2 sm:px-6">
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr class="bg-indigo-200">
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    #
                                                </th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Taller
                                                </th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Tipo de Servicio
                                                </th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Cant de Servicio
                                                </th>
                                                <th scope="col" class="border-r px-6 py-2 dark:border-neutral-500">
                                                    Ingresos Total * Servicio
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ingresosPorServicio as $key => $ingreso)
                                                <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $ingreso['taller'] }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $ingreso['servicio'] }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-2 dark:border-neutral-500">
                                                        {{ $ingreso['cantidad'] }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                        S/{{ $ingreso['ingresos_totales'] }}
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

            </div>
        @else
            <p class="text-center text-gray-500"></p>
        @endif


    </div>

    {{-- JS --}}
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
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('inspectorFilter', () => ({
                    isOpen: false,
                    search: '',
                    inspectores: @json($inspectores),
                    selectedInspectores: @entangle('ins').defer,
                    get filteredInspectores() {
                        if (this.search === '') {
                            return this.inspectores;
                        }
                        return this.inspectores.filter(inspector =>
                            inspector.name.toLowerCase().includes(this.search.toLowerCase())
                        );
                    },
                    toggleInspector(id) {
                        if (this.selectedInspectores.includes(id)) {
                            this.selectedInspectores = this.selectedInspectores.filter(inspectorId =>
                                inspectorId !== id);
                        } else {
                            this.selectedInspectores.push(id);
                        }
                        this.$wire.set('ins', this.selectedInspectores);
                    }
                }));

                Alpine.data('tallerFilter', () => ({
                    isOpen: false,
                    search: '',
                    talleres: @json($talleres),
                    selectedTalleres: @entangle('taller').defer,
                    get filteredTalleres() {
                        if (this.search === '') {
                            return this.talleres;
                        }
                        return this.talleres.filter(taller =>
                            taller.nombre.toLowerCase().includes(this.search.toLowerCase())
                        );
                    },
                    toggleTaller(id) {
                        if (this.selectedTalleres.includes(id)) {
                            this.selectedTalleres = this.selectedTalleres.filter(tallerId =>
                                tallerId !== id);
                        } else {
                            this.selectedTalleres.push(id);
                        }
                        this.$wire.set('taller', this.selectedTalleres);
                    }
                }));
            });
        </script>
    @endpush
</div>
