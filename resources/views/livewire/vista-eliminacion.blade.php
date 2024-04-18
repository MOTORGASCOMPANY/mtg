<div>
    @if ($eliminacion)
        <div class="block items-center mt-8">
            <h1 class="mt-16 text-2xl text-center font-bold text-indigo-500 uppercase"> Eliminacion </h1>
            <div class="flex justify-center">
                <div class="bg-white rounded-xl p-8 w-4/6 shadow-lg">
                    <div class="flex flex-wrap items-center">
                        <p class="mr-4">Solicitado por: <strong
                                class="px-2 bg-sky-200 rounded-xl">{{ $user->name }}</strong></p>
                        <p class="mr-4">N° Formato: <span
                                class="px-2 bg-amber-200 rounded-xl">{{ $certi->Hoja->numSerie ?? 'NE' }}</span></p>
                        <p>Fecha: <span class="px-2 bg-amber-200 rounded-xl">{{ $eliminacion->created_at }}</span></p>
                    </div>

                    <div class="flex items-center justify-center mt-4" role="none">
                        {{--
                        <button wire:click="$emit('deleteCertificacion', {{ $certi ? $certi->id : null }})" 
                            class="p-3 bg-indigo-500 rounded-xl text-white text-sm hover:font-bold hover:bg-indigo-700">
                            <i class="fa-solid fa-rectangle-xmark"></i>
                            Eliminar servicio
                        </button>
                        --}}
                        @if ($certi && $certi->Hoja && $certi->Hoja->estado !== 3)
                            <button wire:click="$emit('deleteCertificacion', {{ $certi->id ?? null }})"
                                class="p-3 bg-indigo-500 rounded-xl text-white text-sm hover:font-bold hover:bg-indigo-700"
                                title="Eliminar servicio">
                                <i class="fa-solid fa-rectangle-xmark"></i>
                                Eliminar servicio
                            </button>
                        @else
                            <button class="p-3 bg-gray-400 rounded-xl text-white text-sm" style="cursor: not-allowed;"
                                disabled title="Ya se encuentra eliminado">
                                <i class="fa-solid fa-rectangle-xmark"></i>
                                Eliminar servicio
                            </button>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    @endif

    <script>
        Livewire.on('deleteCertificacion', certificacionId => {
            Swal.fire({
                title: '¿Estas seguro de eliminar este servicio?',
                text: "una vez eliminado este registro, no podras recuperarlo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {

                    Livewire.emitTo('vista-eliminacion', 'delete', certificacionId);

                    Swal.fire(
                        'Listo!',
                        'Servicio eliminado correctamente.',
                        'success'
                    )
                }
            })
        });
    </script>

</div>
