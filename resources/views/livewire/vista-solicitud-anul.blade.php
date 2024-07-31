<div>
    @if ($anulacion)
        <div class="block items-center mt-8">
            <h1 class="mt-16 text-2xl text-center font-bold text-indigo-500 uppercase"> ANULACION </h1>
            <div class="flex justify-center">
                <div class="bg-white rounded-xl p-8 w-4/6 shadow-lg">
                    <p>Solicitado por: <strong class="px-2 bg-sky-200 rounded-xl">{{ $user->name }}</strong></p>
                    <p>N° Formato: <span class="px-2 bg-amber-200 rounded-xl">{{ $certi->Hoja->numSerie ?? 'NE' }}</span></p>
                    <p>Motivo: <strong class="px-2 bg-sky-200 rounded-xl">{{ $anulacion->motivo }}</strong></p>
                    <p>Fecha: <span class="px-2 bg-amber-200 rounded-xl">{{ $anulacion->created_at }}</span></p>

                    @if (isset($images))
                        <div class="flex flex-wrap p-1 relative">
                            <div class="w-full items-center justify-center ">
                                <img alt="gallery" class="mx-auto flex object-cover object-center w-full rounded-lg"
                                    src="{{ Storage::url($images->ruta) }}"
                                    style="max-width: 500px; max-height: 800px;">
                            </div>
                            <div class="absolute mt-2 w-full bottom-3 flex justify-center items-center">
                                <a class="group max-w-max relative mx-1 flex flex-col items-center justify-center rounded-full bg-white border border-gray-500 p-1 text-gray-500 hover:bg-gray-200 hover:text-gray-600"
                                    href="#">
                                    <!-- Text/Icon goes here -->
                                    <p class="flex m-auto"><i class="fas fa-info-circle"></i></p>
                                    <!-- Tooltip here -->
                                    <div
                                        class="[transform:perspective(50px)_translateZ(0)_rotateX(10deg)] group-hover:[transform:perspective(0px)_translateZ(0)_rotateX(0deg)] absolute bottom-0 mb-6 origin-bottom transform rounded text-white opacity-0 transition-all duration-300 group-hover:opacity-100 z-10">
                                        <div class="flex w-56 flex-col items-center">
                                            <div class="rounded bg-gray-900 p-2 text-xs text-center shadow-lg">
                                                Información:
                                                <p class="text-xs">Cargado el: {{ $images->created_at }}</p>
                                            </div>
                                            <div class="clip-bottom h-2 w-4 bg-gray-900 text-xs">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="flex items-center justify-center mt-4" role="none">
                        @if ($certi && $certi->Hoja && $certi->Hoja->estado !== 5)
                            @if ($certi->Servicio->tipoServicio->id == 10)
                                <button wire:click="$emit('anularCertificacionChip',{{ $certi->id }})"
                                    class="p-3 bg-indigo-500 rounded-xl text-white text-sm hover:font-bold hover:bg-indigo-700"
                                    title="Anular servicio + Chip">
                                    <i class="fa-solid fa-rectangle-xmark"></i>
                                    AnularServicio + Chip
                                </button>
                            @else
                                <button wire:click="$emit('anularCertificacion',{{ $certi->id }})"
                                    class="p-3 bg-indigo-500 rounded-xl text-white text-sm hover:font-bold hover:bg-indigo-700"
                                    title="Anular servicio">
                                    <i class="fa-solid fa-rectangle-xmark"></i>
                                    Anular servicio
                                </button>                                
                            @endif                            
                        @else
                            <button class="p-3 bg-gray-400 rounded-xl text-white text-sm"
                                style="cursor: not-allowed;" disabled
                                title="Ya se encuentra anulado">
                                <i class="fa-solid fa-rectangle-xmark"></i>
                                Anular servicio
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    @endif

    {{-- JS --}}
    @push('js')
        <script>
            Livewire.on('anularCertificacion', certificacionId => {
                Swal.fire({
                    title: '¿Seguro que quieres anular este servicio?',
                    text: "Al anular este servicio el formato asociado quedará inutilizable",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, anular'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('vista-solicitud-anul', 'anular', certificacionId);

                        Swal.fire(
                            'Listo!',
                            'Servicio anulado correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>

        <script>
            Livewire.on('anularCertificacionChip', certificacionId => {
                Swal.fire({
                    title: '¿Seguro que quieres anular este servicio?',
                    text: "Al anular este servicio el formato asociado quedará inutilizable",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, anular'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('vista-solicitud-anul', 'anularchip', certificacionId);

                        Swal.fire(
                            'Listo!',
                            'Servicio anulado correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>
