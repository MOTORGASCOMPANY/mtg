<div class="bg-gray py-4 md:py-7 px-4 md:px-8 xl:px-10">
    <div class="mt-7 overflow-x-auto">
        <div class=" items-center md:block sm:block">
            <div class="px-2 w-64 mb-4 md:w-full">
                <h2 class="text-indigo-500 font-bold text-3xl">Registro de Estado de cuenta y Comprobantes</h2>
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

                @hasanyrole('administrador|Administrador del sistema')
                    <button wire:click="agregar"
                        class="bg-indigo-600 px-6 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">
                        Importar
                    </button>
                @endhasanyrole
            </div>
        </div>

        @if ($boletas->count() > 0)
            <table class="w-full whitespace-nowrap">
                <thead class="bg-slate-600 border-b font-bold text-white">
                    <tr>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                            wire:click="order('id')">
                            ID
                            @if ($sort == 'id')
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
                            Taller / Inspector
                        </th>
                        {{-- 
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            Inspector
                        </th>
                        --}}
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            F. Inicio
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            F. Fin
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            Anual
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            Duplicado
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            Inicial
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            Desmonte
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            Monto
                        </th>
                        {{--  
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            Observación
                        </th>
                        --}}
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                            <div class="flex justify-center items-center">
                                <span>Acciones</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($boletas as $bol)
                        <tr tabindex="0"
                            class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-300">
                            <td class="pl-5">
                                <div class="flex items-center">
                                    <p class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                        {{ $bol->id }} {{-- $loop->iteration --}}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        @if ($bol->taller == null)
                                            {{ $bol->certificador ?? 'NE' }}
                                        @elseif($bol->certificador == null)
                                            {{ $bol->taller ?? 'NE' }}
                                        @else
                                            
                                        @endif
                                    </p>
                                </div>
                            </td>
                            {{--  
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $bol->certificador ?? 'NE' }}
                                    </p>
                                </div>
                            </td>
                            --}}
                            <td>
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ \Carbon\Carbon::parse($bol->fechaInicio)->format('d-m-Y') }}
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ \Carbon\Carbon::parse($bol->fechaFin)->format('d-m-Y') }}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-5">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $bol->anual ?? '0' }}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-5">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $bol->duplicado ?? '0' }}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-5">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $bol->inicial ?? '0' }}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-5">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $bol->desmonte ?? '0' }}
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $bol->monto }}
                                    </p>
                                </div>
                            </td>
                            {{-- 
                            <td>
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $bol->observacion }}
                                    </p>
                                </div>
                            </td>
                            --}}
                            <td class="text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a wire:click="redirectBoletas({{ $bol->id }})"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-indigo-300 font-bold text-white cursor-pointer hover:bg-indigo-400 hover:animate-pulse">
                                        <i class="fas fa-folder-plus"></i>
                                        <span
                                            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                                            Bol/Vau
                                        </span>
                                    </a>
                                    @hasanyrole('administrador|Administrador del sistema')
                                        <button wire:click="$emit('deleteBoleta',{{ $bol->id }})"
                                            class="group flex py-2 px-2 text-center items-center rounded-md bg-red-500 font-bold text-white cursor-pointer hover:bg-red-700 hover:animate-pulse">
                                            <i class="fas fa-times-circle"></i>
                                            <span
                                                class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute  translate-y-full opacity-0 m-4 mx-auto z-50">
                                                Eliminar
                                            </span>
                                        </button>
                                    @endhasanyrole
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $boletas->links() }}
            </div>
        @else
            <div class="text-center mt-4 text-gray-500">
                <p>No tienes boletas en este momento.</p>
            </div>
        @endif
    </div>

    {{-- JS --}}
    @push('js')
        <script>
            Livewire.on('deleteBoleta', boletaId => {
                Swal.fire({
                    title: '¿Estas seguro de eliminar esta boleta?',
                    text: "una vez eliminado esta boleta, no podras recuperarlo.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('lista-boletas', 'eliminarBoleta', boletaId);

                        Swal.fire(
                            'Listo!',
                            'Boleta eliminada correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush



</div>
