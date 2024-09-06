<div>
    <div class="sm:px-6 w-full pt-12 pb-4">

        <div class="bg-gray-200 px-8 py-4 rounded-xl w-full">
            <div class="p-2 w-64 my-4 md:w-full">
                <h2 class="text-indigo-600 font-bold text-3xl">
                    <i class="fa-solid fa-square-poll-vertical fa-xl"></i>
                    &nbsp;REPORTE GENERAL TALLER RESUMEN
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
                <div class="flex bg-white items-center p-2 w-48 rounded-md mb-4 ">
                    <span>Desde: </span>
                    <x-date-picker wire:model="fechaInicio" placeholder="Fecha de inicio"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                </div>

                <div class="flex bg-white items-center p-2 w-48 rounded-md mb-4 ">
                    <span>Hasta: </span>
                    <x-date-picker wire:model="fechaFin" placeholder="Fecha de Fin"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                </div>

                <button wire:click="procesar"
                    class="bg-green-400 px-6 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
                    <p class="truncate"> Generar reporte </p>
                </button>
            </div>
            <div class="w-auto my-4">
                <x-jet-input-error for="taller" />
                <x-jet-input-error for="fechaInicio" />
                <x-jet-input-error for="fechaFin" />
            </div>
            <div class="w-full text-center font-semibold text-gray-100 p-4 mb-4 border rounded-md bg-indigo-400 shadow-lg"
                wire:loading>
                CARGANDO <i class="fa-solid fa-spinner animate-spin"></i>
            </div>

        </div>

        {{-- Tabla resumen --}}
        @if (isset($aux))
            <div class="bg-gray-200 px-8 py-4 rounded-xl w-full mt-4">
                <table class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                    <thead class="border-b font-medium dark:border-neutral-500">
                        <tr class="bg-indigo-200">
                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">#</th>
                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">TALLERES</th>
                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">ENCARGADOS</th>
                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500"></th>
                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">FAC O BOLT</th>
                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">OBSERVACIONES</th>
                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aux as $data)
                            <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                <td class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                    {{ $data['taller'] }}
                                </td>
                                <td class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                    {{ $data['encargado'] ?? 'NA' }}
                                </td>
                                <td class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                    TALLER
                                </td>
                                <td class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500"></td>
                                <td class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500"></td>
                                <td class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                    {{ number_format($data['total'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="border-b dark:border-neutral-500 bg-green-200">
                            <td colspan="6"
                                class="border-r px-6 py-3 dark:border-neutral-500 font-bold text-right">
                                Total:
                            </td>
                            <td class="border-r px-6 py-3 dark:border-neutral-500 font-bold">
                                S/{{ number_format(collect($aux)->sum('total'), 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif


    </div>
    @push('js')
        <script>
            document.addEventListener('alpine:init', () => {
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
