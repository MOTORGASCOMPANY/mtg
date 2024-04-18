<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <x-custom-table>
            <x-slot name="titulo">
                <h2 class="text-indigo-600 font-bold text-3xl">
                    <i class="fa-solid fa-table fa-xl"></i>
                    &nbsp;Tabla Documentos de empleados
                </h2>
            </x-slot>

            <x-slot name="btnAgregar">
                @livewire('create-tipo-documento-empleado')
            </x-slot>

            <x-slot name="contenido">
                @if (count($tiposDocumentosEmple))
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-x-auto">
                                <table class="w-full whitespace-nowrap">
                                    <thead class="bg-slate-600 border-b font-bold text-white">
                                        <tr>
                                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                                wire:click="order('id')">
                                                Id
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
                                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                                wire:click="order('nombreTipo')">
                                                Nombre
                                                @if ($sort == 'nombreTipo')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                                wire:click="order('created_at')">
                                                Fecha de creación
                                                @if ($sort == 'created_at')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th
                                            scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-300">
                                        @foreach ($tiposDocumentosEmple as $item)
                                            <tr tabindex="0" class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-200">
                                                <td class="pl-5">
                                                    <div class="flex items-center">
                                                        <p class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                                            {{ $item->id }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="pl-2">
                                                    <div class="flex items-center">
                                                        <p class="text-sm font-medium leading-none text-gray-600 mr-2">
                                                            {{ $item->nombreTipo }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="pl-2">
                                                    <div class="flex items-center">
                                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                                            {{ $item->created_at }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="pl-2">
                                                    <div class="flex items-center justify-center space-x-2">                                                        
                                                            <button wire:click="editar({{ $item->id }})"
                                                                class="px-2 py-2 bg-indigo-600 rounded-md flex items-center justify-center">
                                                                <i class="fas fa-pen text-white"></i>
                                                            </button>
                                                            <button wire:click="$emit('deleteRegistro', {{ $item->id }})"
                                                                class="px-2 py-2 bg-red-600 rounded-md flex items-center justify-center">
                                                                <i class="fas fa-trash text-white"></i>
                                                            </button>
                                                                                                                  
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if ($tiposDocumentosEmple->hasPages())
                        <div>
                            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                    <div class="px-5 py-5 bg-white border-t">
                                        {{ $tiposDocumentosEmple->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                        No se encontro ningun registro.
                    </div>
                @endif
            </x-slot>

        </x-custom-table>
    </div>

    <x-jet-dialog-modal wire:model="editando" wire:loading.attr="disabled">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold"><i class="fa-solid fa-pen text-white"></i> &nbsp;Editar registro</h1>
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label value="Nombre:" />
                <x-jet-input wire:model="tipoDocumentoEmple.nombreTipo" type="text" class="w-full" />
                <x-jet-input-error for="tipoDocumentoEmple.nombreTipo" />
            </div>
            <x-jet-input-error for="tipoDocumentoEmple.nombreTipo" />
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('editando',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="actualizar" wire:loading.attr="disabled" wire:target="actualizar">
                Actualizar
            </x-jet-button>

        </x-slot>

    </x-jet-dialog-modal>


    @push('js')
        <script>
            Livewire.on('deleteRegistro', tipoId => {
                Swal.fire({
                    title: '¿Estas seguro de eliminar este registro?',
                    text: "una vez eliminado este registro, no podras recuperarlo.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('tipos-documentos-emple', 'eliminarTipo', tipoId);

                        Swal.fire(
                            '¡Listo!',
                            'registro eliminado correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush
</div>
