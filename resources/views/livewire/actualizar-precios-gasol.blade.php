<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <div class="bg-gray-200  px-8 py-4 rounded-xl w-full ">

            <div class=" items-center md:block sm:block">
                <div class="p-2 w-64 my-4 md:w-full">
                    <h2 class="text-indigo-600 font-bold text-3xl">
                        <i class="fa-solid fa-square-poll-vertical fa-xl"></i>
                        &nbsp;REPORTE ACTUALIZAR GASOLUTION
                    </h2>
                </div>

                <div class="w-full  items-center md:flex md:flex-row md:justify-between ">
                    {{--
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
                    --}}

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
                        class="bg-indigo-400 px-6 py-4 w-full md:w-auto rounded-md text-white font-semibold tracking-wide cursor-pointer mb-4">
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

        <!-- Tabla ACTUALIZAR -->
        @if (isset($resultadosdetalle))

            <div wire.model="resultados">
                <div class="p-2 flex justify-end m-auto flex items-space-around">
                    <a wire:click="ver({{ json_encode(collect($resultadosdetalle)->pluck('id')->toArray()) }}, {{ json_encode(collect($resultadosdetalle)->pluck('servicio')->unique()->toArray()) }})"
                        class="group flex py-4 px-4 text-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
                        <i class="fas fa-edit"></i>
                        <span
                            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                            Editar Precios
                        </span>
                    </a>
                </div>

                @foreach ($grupoinspectores as $nombre => $certificacion)
                    <div class="bg-gray-200  px-8 py-4 rounded-xl w-full mt-4">

                        <div class="p-2 w-full justify-between m-auto flex items-space-around">
                            <h2 class="text-indigo-600 text-xl font-bold mb-4">{{ $nombre }}</h2>
                        </div>
                        <div class="overflow-x-auto m-auto w-full">
                            <div class="inline-block min-w-full py-2 sm:px-6">
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                        <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr class="bg-indigo-200">
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">#
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">ID
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Taller
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Inspector
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Vehículo</th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Servicio</th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Fecha
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Estado
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Pagado
                                                </th>
                                                <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                    Precio
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($certificacion as $key => $data)
                                                <tr class="border-b dark:border-neutral-500 bg-orange-200">
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                        {{ $data['id'] }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                        {{ $data['taller'] ?? 'N.A' }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                        {{ $data['inspector'] ?? 'N.A' }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                        {{ $data['placa'] ?? 'En tramite' }}
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                        {{ $data['servicio'] ?? 'N.E' }}</td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                        {{ $data['fecha'] ?? 'S.F' }}</td>
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                        <div class="flex items-center justify-center">
                                                            @switch($data['estado'])
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
                                                        @if ($data['pagado'] == 0)
                                                            Sin cobrar
                                                        @elseif ($data['pagado'] == 1)
                                                            Cobrado
                                                        @else
                                                            Cert. Pendiente
                                                        @endif

                                                    <td
                                                        class="whitespace-nowrap border-r px-6 py-3 dark:border-neutral-500">
                                                        {{ $data['precio'] ?? 'S.P' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="border-b dark:border-neutral-500 bg-green-200">
                                                <td colspan="9"
                                                    class="border-r px-6 py-3 dark:border-neutral-500 font-bold text-right">
                                                    Total:
                                                </td>
                                                <td class="border-r px-6 py-3 dark:border-neutral-500 font-bold">
                                                    {{ number_format(collect($certificacion)->sum('precio'), 2) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-4">
                                        <ul class="grid grid-cols-2 gap-4">
                                            @foreach (collect($certificacion)->groupBy('servicio') as $Servicio => $detalle)
                                                <li
                                                    class="flex items-center justify-between bg-gray-100 p-3 rounded-md shadow">
                                                    <span
                                                        class="text-blue-400">{{ 'Cantidad de ' . $Servicio }}</span>
                                                    <span class="text-green-500">{{ $detalle->count() }}
                                                        servicios</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        @endif
    </div>



    {{-- MODAL PARA EDITAR PRECIOS --}}
    <x-jet-dialog-modal wire:model="editando" wire:loading.attr="disabled">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold">Editar Precios</h1>
        </x-slot>

        <x-slot name="content">
            <div>
                <h1 class="font-bold text-lg">Servicios:</h1>
                <hr class="my-4">

                @if (is_array($tiposServicios) && count($tiposServicios) > 0)
                    <div class="mb-4" wire:loading.attr="disabled" wire:target="updatePrecios">

                        @foreach ($tiposServicios as $tipoServicio)
                            <div class="flex flex-row justify-between bg-indigo-100 my-2 items-center rounded-lg p-2">
                                <div class="">
                                    <label class="form-check-label inline-block text-gray-800">
                                        {{ $tipoServicio }}
                                    </label>
                                </div>
                                <div class="flex flex-row items-center">
                                    <x-jet-label value="Precio:" class="mr-2" />
                                    <x-jet-input type="number" class="w-6px"
                                        wire:model="updatedPrices.{{ $tipoServicio }}" />
                                </div>
                            </div>
                            <x-jet-input-error for="updatedPrices.{{ $tipoServicio }}" />
                        @endforeach
                    </div>
                @else
                    <hr>
                    <div class="w-full items-center mt-2 justify-center text-center py-2 ">
                        <h1 class="text-xs text-gray-500 ">El Inspector no cuenta con servicios registrados</h1>
                    </div>
                @endif

            </div>

        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('editando',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="updatePrecios" wire:loading.attr="disabled" wire:target="updatePrecios">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>


    {{-- ESCUCHA EVENTO Y REFREZCA LA TABLA --}}
    {{-- JS --}}
    @push('js')
        <script>
            Livewire.on('datosRecargados', () => {
                Livewire.emit('refresh-table');
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
