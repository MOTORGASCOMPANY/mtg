<div>
    @if ($vacacionesAsignadas->count())
        <table class="w-full whitespace-nowrap">
            <thead class="bg-slate-600 border-b font-bold text-white">
                <tr>
                    <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                        #
                    </th>
                    <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                        Empleado
                    </th>
                    <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                        Tipo
                    </th>
                    <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                        Dias Tomados
                    </th>
                    <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                        Fecha Inicio
                    </th>
                    <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                        Razon
                    </th>
                    <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                        Especial
                    </th>
                    <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                        Observación
                    </th>
                    <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($vacacionesAsignadas as $index => $vac)
                    <tr tabindex="0"
                        class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-300">
                        <td class="pl-5">
                            <div class="flex items-center">
                                <p class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                    {{ $vac->id }}
                                </p>
                            </div>
                        </td>
                        <td class="pl-2">
                            <div class="flex items-center">
                                <p class="text-sm leading-none text-gray-600 ml-2">
                                    {{ $vac->Vacacion->contrato->empleado->name }}
                                </p>
                            </div>
                        </td>
                        <td class="pl-2">
                            <div class="flex items-center">
                                <p class="text-sm leading-none text-gray-600 ml-2">
                                    {{ $vac->tipo }}
                                </p>
                            </div>
                        </td>
                        <td class="pl-12">
                            <div class="flex items-center">
                                <p class="text-sm leading-none text-gray-600 ml-2">
                                    {{ $vac->d_tomados }}
                                </p>
                            </div>
                        </td>
                        <td class="pl-2">
                            <div class="flex items-center">
                                <p class="text-sm leading-none text-gray-600 ml-2">
                                    {{ $vac->f_inicio }}
                                </p>
                            </div>
                        </td>                        
                        <td class="pl-2">
                            <div class="flex items-center">
                                <p class="text-sm leading-none text-gray-600 ml-2">
                                    {{ $vac->razon }}
                                </p>
                            </div>
                        </td>
                        <td class="pl-12">
                            <div class="flex items-center">
                                <x-jet-checkbox class="h-4 w-4 text-indigo-600 rounded-lg" disabled :checked="$vac->especial" />
                            </div>
                        </td>
                        <td class="pl-2">
                            <div class="flex items-center">
                                <p class="text-sm leading-none text-gray-600 ml-2">
                                    {{ $vac->observacion }}
                                </p>
                            </div>
                        </td>
                        <td class="">
                            <div class="flex space-x-2">
                                <button wire:click=""
                                    class="group flex py-2 px-2 text-center items-center rounded-md bg-yellow-300 font-bold text-white cursor-pointer hover:bg-yellow-400 hover:animate-pulse">
                                    <i class="fas fa-eye"></i>
                                    <span
                                        class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                        Ver
                                    </span>
                                </button>
                                @hasanyrole('administrador|Administrador del sistema')
                                    <button wire:click="abrirModal({{ $vac->id }})"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-orange-300 font-bold text-white cursor-pointer hover:bg-orange-400 hover:animate-pulse">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span
                                            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute  translate-y-full opacity-0 m-4 mx-auto z-50">
                                            Editar
                                        </span>
                                    </button>
                                    <button wire:click="$emit('eliminarVacacion',{{ $vac->id }})"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-red-400 font-bold text-white cursor-pointer hover:bg-red-500 hover:animate-pulse">
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
    @else
        <div class="w-full items-center mt-2 justify-center text-center py-2 ">
            <h1 class="text-xs text-gray-500 ">Aun no se ha cargado ningúna vacacion del Empleado</h1>
        </div>
    @endif


    <x-jet-dialog-modal wire:model="openEdit">
        <x-slot name="title">
            <h1 class="text-xl font-bold">Editando vacacion del Empleado</h1>
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-3 gap-4 py-2">
                <div class="col-span-2">
                    <x-jet-label value="Tipo de Vacación" />
                    <x-jet-input wire:model="vacacion_asignada.tipo" type="text"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full" />
                    <x-jet-input-error for="vacacion_asignada.tipo" />
                </div>
                <div class="col-span-1">
                    <x-jet-label value="Dias Tomados" />
                    <x-jet-input wire:model="vacacion_asignada.d_tomados" type="number"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full" />
                    <x-jet-input-error for="vacacion_asignada.d_tomados" />
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4 py-2">
                <div class="col-span-1">
                    <x-jet-label value="Fecha de inicio" />
                    <x-jet-input wire:model="vacacion_asignada.f_inicio" type="date"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full" />
                    <x-jet-input-error for="vacacion_asignada.f_inicio" />
                </div>
                <div class="col-span-2">
                    <x-jet-label value="Razon:" />
                    <x-jet-input wire:model="vacacion_asignada.razon" type="text"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full" />
                    <x-jet-input-error for="vacacion_asignada.razon" />
                </div>
            </div>
            <div>
                <x-jet-label value="Observación:" />
                <x-textarea class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full" 
                wire:model="vacacion_asignada.observacion" type="text" style="height: 100px;" />
                <x-jet-input-error for="vacacion_asignada.observacion" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('openEdit',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button loading:attribute="disabled" wire:click="editarVacacion" wire:target="editarVacacion">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>


    @push('js')
        <script>
            Livewire.on('eliminarVacacion', id => {
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

                        Livewire.emitTo('registro-vacacion', 'deleteVacacion', id);

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
