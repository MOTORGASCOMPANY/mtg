<div class="space-y-4">
    @if ($boleta->boletaarchivo->count())
        {{--
        <div class="flex justify-end">
            <button data-tooltip-target="tooltip-dark" type="button" wire:click="generatePdf"
                class="group flex py-4 px-4 text-center rounded-md bg-indigo-300 font-bold text-white cursor-pointer hover:bg-indigo-400 hover:animate-pulse">
                <i class="fa-solid fa-file-pdf"></i>
                <span
                    class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                    Pdf
                </span>
            </button>
        </div>
        --}}

        @foreach ($boleta->boletaarchivo as $doc)
            <div
                class=" bg-indigo-200 flex flex-col items-center justify-center relative overflow-hidden w-full border shadow-md rounded-md hover:cursor-pointer ">
                <div class="bg-indigo-100 p-4 w-full flex justify-between items-center">
                    <div class="flex items-center gap-2 ">
                        <p class="ml-4 text-lg text-indigo-600 leading-7 font-semibold">
                            {{ $doc->nombre }}
                        </p>
                    </div>
                </div>
                <div class="w-full bg-white">
                    <div class="flex flex-row w-full divide-x divide-gray-400/20">
                        <div class="px-8 py-4 bg-indigo-100/30 w-1/2 md:w-2/3">
                            <p class="text-gray-500 text-xs">
                                <i class="fas fa-calendar-check"></i>
                                Nombre:
                                <span class="font-bold"> {{ $doc->nombre . '.' . $doc->extension }}
                                </span>
                            </p>
                        </div>

                        <div class="bg-indigo-100/30 w-1/2 md:w-1/3 flex justify-center space-x-2 items-center px-3">
                            <a href="{{ Storage::url($doc->ruta) }}" target="__blank" rel="noopener noreferrer"
                                class="group flex py-2 px-2 text-center items-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
                                <i class="fas fa-eye"></i>

                                <span
                                    class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                    ver
                                </span>
                            </a>

                            <button wire:click="abrirModal({{ $doc->id }})"
                                class="group flex py-2 px-2 text-center items-center rounded-md bg-amber-300 font-bold text-white cursor-pointer hover:bg-amber-400 hover:animate-pulse">
                                <i class="fas fa-pen"></i>
                                <span
                                    class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                    Editar
                                </span>
                            </button>
                            <button wire:click="$emit('deleteDocumento',{{ $doc->id }})"
                                class="group flex py-2 px-2 text-center items-center rounded-md bg-red-500 font-bold text-white cursor-pointer hover:bg-red-700 hover:animate-pulse">
                                <i class="fas fa-times-circle"></i>
                                <span
                                    class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute  translate-y-full opacity-0 m-4 mx-auto z-50">
                                    Eliminar
                                </span>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="w-full items-center mt-2 justify-center text-center py-2 ">
            <h1 class="text-xs text-gray-500 ">Aun no se ha cargado ningún documento</h1>
        </div>
    @endif

    @if ($documento)
        <x-jet-dialog-modal wire:model="openEdit">
            <x-slot name="title">
                <h1 class="text-xl font-bold">Editando documento</h1>
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-jet-label for="nombre" value="Nombre del Documento:" class="font-bold" />
                    <x-jet-input id="nombre" type="text" class="mt-1 block w-full"
                        wire:model="documento.nombre" />
                    <x-jet-input-error for="nombre" />
                </div>
                <div class="mb-4">
                    <x-jet-label value="Archivo:" class="font-bold" />
                    <x-file-pond wire:model="nuevoPdf" acceptedFileTypes="['application/pdf', 'image/*']"
                        aceptaVarios="false" />
                    <x-jet-input-error for="nuevoPdf" />
                </div>
                @if (!$nuevoPdf)
                    <iframe width="100%" height="400" class="mt-6" src="{{ Storage::url($documento->ruta) }}"
                        frameborder="0"></iframe>
                @endif

            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('openEdit',false)" class="mx-2">
                    Cancelar
                </x-jet-secondary-button>
                <x-jet-button loading:attribute="disabled" wire:click="editarDocumento" wire:target="editarDocumento">
                    Actualizar
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    @endif

    @push('js')
        <script>
            Livewire.on('deleteDocumento', documentoId => {
                Swal.fire({
                    title: '¿Seguro que quieres eliminar este documento?',
                    text: "Luego de eliminar no podras recuperarlo.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('boletas-archivos', 'eliminar', documentoId);

                        Swal.fire(
                            'Listo!',
                            'Documento eliminado correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>
