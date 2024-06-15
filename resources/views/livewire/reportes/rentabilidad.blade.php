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

                <button wire:click="generarReporte()"
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

        @if ($mostrarResultados)
            <div>
                {{-- TABLA INGRESOS TOTALES POR TALLER --}}
                <div class="bg-gray-200 rounded-md w-full p-4 mt-4">
                    <div class="p-2 w-full justify-between m-auto flex items-space-around">
                        <h2 class="text-indigo-600 text-xl font-bold mb-4">Ingresos Totales por Taller</h2>
                    </div>
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
                                                Taller
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Ingresos Totales
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ingresosPorTaller as $key => $ingreso)
                                            <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $key + 1 }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $ingreso->nombre_taller }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    S/{{ $ingreso->ingresos_totales }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABLA NUMERO DE CERTIFICACIONES REALIZADAS POR TALLER --}}
                <div class="bg-gray-200 rounded-md w-full p-4 mt-4">
                    <div class="p-2 w-full justify-between m-auto flex items-space-around">
                        <h2 class="text-indigo-600 text-xl font-bold mb-4">Número de Certificaciones Realizadas por
                            Taller</h2>
                    </div>
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
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Taller
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Total Certificaciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($certificacionesPorTaller as $key => $certificacion)
                                            <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $key + 1 }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $certificacion->nombre_taller }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $certificacion->total_certificaciones }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABLA INGRESOS POR TIPO DE SERVICIO POR TALLER --}}
                <div class="bg-gray-200 rounded-md w-full p-4 mt-4">
                    <div class="p-2 w-full justify-between m-auto flex items-space-around">
                        <h2 class="text-indigo-600 text-xl font-bold mb-4">Ingresos por Tipo de Servicio en Cada Taller
                        </h2>
                    </div>
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
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Taller
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Tipo de Servicio
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Ingresos Totales
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ingresosPorServicio as $key => $ingreso)
                                            <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $key + 1 }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $ingreso->nombre_taller }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $ingreso->tipo_servicio }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    S/{{ $ingreso->ingresos_totales }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABLA INGRESO MENSUALES POR TALLER --}}
                <div class="bg-gray-200 rounded-md w-full p-4 mt-4">
                    <div class="p-2 w-full justify-between m-auto flex items-space-around">
                        <h2 class="text-indigo-600 text-xl font-bold mb-4">Ingresos mensuales por Taller</h2>
                    </div>
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
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Taller
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Mes
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Ingresos Mensuales
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ingresosMensuales as $key => $ingreso)
                                            <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $key + 1 }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $ingreso->nombre_taller }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $ingreso->mes }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                    {{ $ingreso->ingresos_mensuales }}
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
            <p class="text-center text-gray-500"></p>
        @endif


    </div>

    {{-- JS --}}
    @push('js')
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
