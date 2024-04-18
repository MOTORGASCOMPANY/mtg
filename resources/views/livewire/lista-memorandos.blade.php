<div class="bg-gray py-4 md:py-7 px-4 md:px-8 xl:px-10">
    <div class="mt-7 overflow-x-auto">
        <div class=" items-center md:block sm:block">
            <div class="px-2 w-64 mb-4 md:w-full">
                <h2 class="text-indigo-900 font-bold text-3xl">Registro de Memorandos</h2>
            </div>
            <div class="w-full items-center md:flex  md:justify-between">
                <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
                    <span>Mostrar</span>
                    <select wire:model="cant"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block ">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>Entradas</span>
                </div>
                <div class="flex bg-gray-50 items-center lg:w-3/6 p-2 rounded-md mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                    <input class="bg-gray-50 outline-none block rounded-md border-indigo-500 w-full" type="text"
                        wire:model="search" placeholder="buscar...">
                </div>

                @hasanyrole('administrador|supervisor|Administrador del sistema')
                    <button wire:click="agregar"
                        class="bg-indigo-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer">
                        Agregar
                    </button>
                @endhasanyrole
            </div>
        </div>

        @if ($memorandos->count() > 0)
            <table class="w-full whitespace-nowrap">
                <thead class="bg-slate-600 border-b font-bold text-white">
                    <tr>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            #
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            Remitente
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                            wire:click="order('destinatario->name')">
                            Inspector
                            @if ($this->sort == 'destinatario->name')
                                @if ($this->direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-0.5"></i>
                            @endif
                        </th>
                        {{--
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            Motivo
                        </th>
                        --}}
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                            wire:click="order('fecha')">
                            Fecha de creación
                            @if ($sort == 'fecha')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                @else
                                    <i class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-0.5"></i>
                            @endif
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($memorandos as $memorando)
                        <tr tabindex="0"
                            class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-300">
                            <td class="pl-5">
                                <div class="flex items-center">
                                    <p class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                        {{ $loop->iteration }}
                                    </p>
                                </div>
                            </td>


                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $memorando->remitente }}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $memorando->destinatario->name }}
                                    </p>
                                </div>
                            </td>
                            {{--
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $memorando->motivo }}
                                    </p>
                                </div>
                            </td>
                            --}}
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $memorando->fecha }}
                                    </p>
                                </div>
                            </td>


                            <td>
                                <div x-data="{ dropdownMenu: false }" class="relative">
                                    <!-- Dropdown toggle button -->
                                    <button @click="dropdownMenu = ! dropdownMenu"
                                        class="flex items-center p-2 border border-indigo-500  bg-gray-200 rounded-md">
                                        <span class="mr-4">Seleccione <i class="fas fa-sort-down -mt-2"></i></span>
                                    </button>
                                    <!-- Dropdown list -->
                                    <div x-show="dropdownMenu"
                                        class="absolute py-2 mt-2  bg-slate-300 rounded-md shadow-xl w-70 z-20 ">
                                        <button wire:click="verMemorando({{ $memorando->id }})"
                                            class="block px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-300 hover:text-white">
                                            <i class="fas fa-eye"></i> Enlace
                                        </button>
                                        @hasanyrole('administrador|supervisor|Administrador del sistema')
                                        <button wire:click="eliminarMemorando({{ $memorando->id }})"
                                            class="block px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-300 hover:text-white">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                        @endhasanyrole

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $memorandos->links() }}
            </div>
        @else
            <div class="text-center mt-4 text-gray-500">
                <p>No tienes memorandos en este momento.</p>
            </div>
        @endif
    </div>
</div>
