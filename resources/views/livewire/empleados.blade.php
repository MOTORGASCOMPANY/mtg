<div class="bg-gray py-4 md:py-7 px-4 md:px-8 xl:px-10">
    <div class="mt-7 overflow-x-auto">
        <div class=" items-center md:block sm:block">
            <div class="px-2 w-64 mb-4 md:w-full">
                <h2 class="text-indigo-900 font-bold text-3xl">Registro de Empleados</h2>
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
                @hasanyrole('administrador|Administrador del sistema')
                    <button wire:click="agregar"
                        class="bg-indigo-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer">
                        Crear Contrato
                    </button>
                @endhasanyrole
            </div>
        </div>

        @if ($empleados->count() > 0)
            <table class="w-full whitespace-nowrap">
                <thead class="bg-slate-600 border-b font-bold text-white">

                    <tr>
                        <th scope="col" class=" bg-gray-100" colspan="6"></th>
                        <th scope="col" class="text-sm font-medium font-semibold text-black vacaciones-cell"
                            colspan="3">
                            <div class="flex justify-center items-center">
                                <span>Vacaciones</span>
                            </div>
                        </th>
                        <th scope="col" class="bg-gray-100">
                            <div class="flex justify-center items-center">
                                <span></span>
                            </div>
                        </th>
                    </tr>

                    <tr>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-3 text-left"
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
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-3 text-left">
                            Empleado
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-4 py-3 text-left">
                            Dni
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-3 text-left">
                            Domicilio
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-4 py-3 text-left">
                            Fecha
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-4 py-3 text-left">
                            Area
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-black  py-3 vacaciones-cell">
                            <div class="flex justify-center items-center flex-col">
                                <span>Ganados</span>
                            </div>
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-black py-3 vacaciones-cell">
                            <div class="flex justify-center items-center flex-col">
                                <span>Tomados</span>
                            </div>
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-black py-3 vacaciones-cell">
                            <div class="flex justify-center items-center flex-col">
                                <span>Restantes</span>
                            </div>
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-12 py-3 text-left">
                            <div class="flex justify-center items-center">
                                <span>Acciones</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($empleados as $emple)
                        <tr tabindex="0"
                            class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-300">
                            <td class="pl-5">
                                <div class="flex items-center">
                                    <p class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                        {{ $emple->id }} {{-- $loop->iteration --}}
                                    </p>
                                </div>
                            </td>


                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $emple->empleado->name ?? 'N.A' }}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $emple->dniEmpleado }}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $emple->domicilioEmpleado }}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ \Carbon\Carbon::parse($emple->created_at)->format('d-m-Y') }}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $emple->cargo }}
                                    </p>
                                </div>
                            </td>
                            <td class="vacaciones-cell">
                                <div class="flex justify-center items-center">
                                    <p class="text-sm leading-none text-white-600">
                                        {{ $emple->vacaciones->dias_ganados ?? 'N.A' }}
                                    </p>
                                </div>
                            </td>
                            <td class="vacaciones-cell">
                                <div class="flex justify-center items-center">
                                    <p class="text-sm leading-none text-white-600">
                                        {{ $emple->vacaciones->dias_tomados ?? 'N.A' }}
                                    </p>
                                </div>
                            </td>
                            <td class="vacaciones-cell">
                                <div class="flex justify-center items-center">
                                    <p class="text-sm leading-none text-white-600">
                                        {{ $emple->vacaciones->dias_restantes ?? 'N.A' }}
                                    </p>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <button wire:click="verContrato({{ $emple->id }})"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
                                        <i class="fas fa-eye"></i>
                                        <span
                                            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                            Contrato
                                        </span>
                                    </button>
                                    <a wire:click="redirectContrato({{ $emple->id }})"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-green-300 font-bold text-white cursor-pointer hover:bg-green-400 hover:animate-pulse">
                                        <i class="fas fa-folder-plus"></i>
                                        <span
                                            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                                            Datos/Doc
                                        </span>
                                    </a>
                                    @hasanyrole('administrador|Administrador del sistema')
                                        <button wire:click="redirectVacacion({{ $emple->id }})"
                                            class="group flex py-2 px-2 text-center items-center rounded-md bg-yellow-500 font-bold text-white cursor-pointer hover:bg-ywllow-700 hover:animate-pulse">
                                            <i class="fa fa-plane" aria-hidden="true"></i>
                                            <span
                                                class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute  translate-y-full opacity-0 m-4 mx-auto z-50">
                                                Vacaciones
                                            </span>
                                        </button>
                                        <button wire:click="$emit('deleteContrato',{{ $emple->id }})"
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
                {{ $empleados->links() }}
            </div>
        @else
            <div class="text-center mt-4 text-gray-500">
                <p>No tienes empleados en este momento.</p>
            </div>
        @endif
    </div>

    {{-- JS --}}
    @push('js')
        <script>
            Livewire.on('deleteContrato', contratoId => {
                Swal.fire({
                    title: '¿Estas seguro de eliminar este contrato?',
                    text: "una vez eliminado este contrato, no podras recuperarlo.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('empleados', 'eliminarContrato', contratoId);

                        Swal.fire(
                            'Listo!',
                            'Contrato eliminado correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

    {{-- CSS --}}
    @push('styles')
        <style>
            .vacaciones-cell {
                background-color: rgb(235, 243, 122);
                color: rgb(0, 0, 0);
                border: 1px solid rgb(156, 154, 45);
            }

            .encabezado {
                background-color: rgb(255, 255, 255);
            }
        </style>
    @endpush

</div>
