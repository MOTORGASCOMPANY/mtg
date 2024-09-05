<div>
    @if ($anulacion->isNotEmpty())
        <div class="block items-center mt-8">
            <h1 class="mt-16 text-2xl text-center font-bold text-indigo-500 uppercase"> DEVOLUCION DE FORMATOS </h1>
            <div class="flex justify-center">
                <div class="bg-white rounded-xl p-8 w-4/6 shadow-lg">
                    <p>Solicitado por: <strong class="px-2 bg-sky-200 rounded-xl">{{ $user->name }}</strong></p>
                    <p>Motivo: <strong class="px-2 bg-amber-200 rounded-xl">{{ $motivoGrupo }}</strong></p>
                    <p>Fecha: <strong class="px-2 bg-sky-200 rounded-xl">{{ $fechaGrupo }}</strong></p>
                    <div class="flex flex-col justify-center items-center text-center">
                        <h2 class="text-lg font-bold mb-2">
                            <span class="text-indigo-500">Materiales</span>
                        </h2>
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:mx-0.5">
                                <div class="py-2 inline-block min-w-full ">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full">
                                            <thead class="bg-indigo-300 border-b">
                                                <tr>
                                                    <th scope="col"
                                                        class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                        #
                                                    </th>
                                                    <th scope="col"
                                                        class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                        ID
                                                    </th>
                                                    <th scope="col"
                                                        class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                        Tipo de Material
                                                    </th>
                                                    <th scope="col"
                                                        class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                        Formato
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($materialDetails as $index => $item)
                                                    <tr class="bg-gray-100 border-b">
                                                        <td
                                                            class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            {{ $index + 1 }}
                                                        </td>
                                                        <td
                                                            class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            {{ $item->id }}
                                                        </td>
                                                        <td
                                                            class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            {{ $this->tipoMaterial($item->idTipoMaterial) }}
                                                        </td>
                                                        <td
                                                            class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            {{ $item->numSerie }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- 
                        <ul>
                            @foreach ($material as $mat)
                                <li>ID: {{ $mat }}</li>
                            @endforeach
                        </ul>
                        --}}
                    </div>


                    <div class="flex items-center justify-center mt-4" role="none">
                        @if ($materialDetails->contains('devuelto', null))
                            <button wire:click="$emit('actualizarMateriales')"
                                class="p-3 bg-indigo-500 rounded-xl text-white text-sm hover:font-bold hover:bg-indigo-700"
                                title="Anular servicio">
                                <i class="fa-solid fa-rectangle-xmark"></i>
                                Actualizar Materiales
                            </button>
                        @else
                            <button class="p-3 bg-gray-400 rounded-xl text-white text-sm" style="cursor: not-allowed;"
                                disabled title="Ya se encuentra anulado">
                                <i class="fa-solid fa-rectangle-xmark"></i>
                                Actualizacion Realizada
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
            Livewire.on('actualizarMateriales', () => {
                Swal.fire({
                    title: '¿Seguro que quieres actualizar estos materiales?',
                    text: "Al anular estos materiales se actualizará su estado",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, actualizar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('vista-solicitud-devolucion', 'actualizar');

                        Swal.fire(
                            '¡Listo!',
                            'Materiales actualizados correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>
