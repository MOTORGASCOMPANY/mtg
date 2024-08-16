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
                        <th scope="col" class=" bg-gray-100" colspan="9"></th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white" colspan="3">
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
                            F. Base
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-4 py-3 text-left">
                            F. Inicio
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-4 py-3 text-left">
                            F. Fin
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-4 py-3 text-left">
                            Area
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white px-4 py-3 text-left">
                            F. Nacimiento
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white  py-3">
                            <div class="flex justify-center items-center flex-col">
                                <span>Ganados</span>
                            </div>
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white py-3">
                            <div class="flex justify-center items-center flex-col">
                                <span>Tomados</span>
                            </div>
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-white py-3">
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
                            <td>
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ \Carbon\Carbon::parse($emple->fechaInicio)->format('d-m-Y') }}
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ \Carbon\Carbon::parse($emple->fechaIniciodos)->format('d-m-Y') }}
                                    </p>
                                </div>
                            </td>
                            
                            <td>
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ \Carbon\Carbon::parse($emple->fechaExpiracion)->format('d-m-Y') }}
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $emple->cargo }}
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center">
                                    <p class="pl-4 text-sm leading-none text-gray-600 ml-2">
                                        {{ $emple->cumpleaosEmpleado ?? null }}
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="flex justify-center items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $emple->vacaciones->dias_ganados ?? 'N.A' }}
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="flex justify-center items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $emple->vacaciones->dias_tomados ?? 'N.A' }}
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="flex justify-center items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                        {{ $emple->vacaciones->dias_restantes ?? 'N.A' }}
                                    </p>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    {{-- 
                                    <button wire:click="verContrato({{ $emple->id }})"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
                                        <i class="fas fa-eye"></i>
                                        <span
                                            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                            Contrato
                                        </span>
                                    </button>
                                    --}}
                                    <a href="{{ route('contratoTrabajo', ['id' => $emple->id]) }}"
                                        target="_blank"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
                                         <i class="fas fa-eye"></i>
                                         <span
                                             class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                             Contrato
                                         </span>
                                     </a>
                                     
                                    @hasanyrole('administrador|Administrador del sistema')
                                        <button wire:click="abrirModal({{ $emple->id }})"
                                            class="group flex py-2 px-2 text-center items-center rounded-md bg-indigo-300 font-bold text-white cursor-pointer hover:bg-indigo-400 hover:animate-pulse">
                                            <i class="fa fa-pencil"></i>
                                            <span
                                                class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                                Editar
                                            </span>
                                        </button>
                                    @endhasanyrole
                                    <a wire:click="redirectContrato({{ $emple->id }})"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-green-300 font-bold text-white cursor-pointer hover:bg-green-400 hover:animate-pulse">
                                        <i class="fas fa-folder-plus"></i>
                                        <span
                                            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                                            Datos/Doc
                                        </span>
                                    </a>
                                    <button wire:click="redirectVacacion({{ $emple->id }})"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-yellow-500 font-bold text-white cursor-pointer hover:bg-ywllow-700 hover:animate-pulse">
                                        <i class="fa fa-plane" aria-hidden="true"></i>
                                        <span
                                            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute  translate-y-full opacity-0 m-4 mx-auto z-50">
                                            Vacaciones
                                        </span>
                                    </button>
                                    @hasanyrole('administrador|Administrador del sistema')
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

    {{-- EDITAR CONTRATO --}}
    <x-jet-dialog-modal wire:model="openEdit">
        <x-slot name="title">
            <h1 class="text-xl font-bold">Editando contrato</h1>
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4 py-2">
                <div>
                    <x-jet-label value="Dni:" />
                    <x-jet-input type="text"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                        wire:model="emp.dniEmpleado" />
                    <x-jet-input-error for="emp.dniEmpleado" />
                </div>
                <div>
                    <x-jet-label value="Domicilio:" />
                    <x-jet-input type="text"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                        wire:model="emp.domicilioEmpleado" />
                    <x-jet-input-error for="emp.domicilioEmpleado" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 py-2">
                <div>
                    <x-jet-label value="Celular:" />
                    <x-jet-input type="number"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                        wire:model="emp.celularEmpleado" />
                    <x-jet-input-error for="emp.celularEmpleado" />
                </div>
                <div>
                    <x-jet-label value="Correo:" />
                    <x-jet-input type="email"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                        wire:model="emp.correoEmpleado" />
                    <x-jet-input-error for="emp.correoEmpleado" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 py-2">
                <div>
                    <x-jet-label value="Fecha Base:" />
                    <x-jet-input type="date"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                        wire:model="emp.fechaInicio" disabled />
                    <x-jet-input-error for="emp.fechaInicio" />
                </div>
                <div>
                    <x-jet-label value="Fecha de Nacimiento:" />
                    <x-jet-input type="date"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                        wire:model="emp.cumpleaosEmpleado" />
                    <x-jet-input-error for="emp.cumpleaosEmpleado" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 py-2">
                <div>
                    <x-jet-label value="Fecha Inicio:" />
                    <x-jet-input type="date"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                        wire:model="emp.fechaIniciodos"/>
                    <x-jet-input-error for="emp.fechaIniciodos" />
                </div>
                <div>
                    <x-jet-label value="Fecha Expiración:" />
                    <x-jet-input type="date"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                        wire:model="emp.fechaExpiracion" />
                    <x-jet-input-error for="emp.fechaExpiracion " />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 py-2">
                <div>
                    <x-jet-label value="Cargo:" />
                    <x-jet-input type="text"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                        wire:model="emp.cargo" />
                    <x-jet-input-error for="emp.cargo" />
                </div>
                <div>
                    <x-jet-label value="Monto:" />
                    <x-jet-input type="number"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                        wire:model="emp.pago" />
                    <x-jet-input-error for="emp.pago" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('openEdit',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button loading:attribute="disabled" wire:click="editarContrato" wire:target="editarContrato">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>


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



</div>
