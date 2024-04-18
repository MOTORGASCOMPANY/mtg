<div wire:init="loadExpedientes" wire:loading.attr="disabled" wire:target="render">


    <div class="container mx-auto py-12">
        <x-table>
            @if (count($expedientes))
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal rounded-md">
                            <thead>
                                <tr>
                                    <th class=" w-24 cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                        wire:click="order('placa')">
                                        Placa
                                        @if ($sort == 'placa')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                            @else
                                                <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                        @endif
                                    </th>
                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                        wire:click="order('certificado')">
                                        Certificado
                                        @if ($sort == 'certificado')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                            @else
                                                <i class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                        @endif
                                    </th>
                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                        wire:click="order('created_at')">
                                        Fecha
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
                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                        wire:click="order('servicio_idservicio')">
                                        Servicio
                                        @if ($sort == 'servicio_idservicio')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                            @else
                                                <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                        @endif
                                    </th>
                                    <th class="cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                        wire:click="order('estado')">
                                        Estado
                                        @if ($sort == 'estado')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                            @else
                                                <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort float-right mt-0.5"></i>
                                        @endif
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expedientes as $key=>$item)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <p class="text-gray-900 ">
                                                {{ strtoupper($item->placa) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ $item->certificado }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{
                                            date("d/m/Y  h:i a", strtotime($item->created_at))
                                            }}
                                            </p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ $item->nombre_servicio }}
                                            </p>
                                        </div>
                                    </td>
                                    @switch($item->estado)
                                        @case(1)
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span
                                                    class="relative inline-block px-3 py-1 font-semibold text-orange-900 leading-tight">
                                                    <span aria-hidden
                                                        class="absolute inset-0 bg-orange-200 opacity-50 rounded-full"></span>
                                                    <span class="relative">Por revisar</span>
                                                </span>
                                            </td>
                                        @break

                                        @case(2)
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span
                                                    class="relative inline-block px-3 py-1 font-semibold text-blue-900 leading-tight">
                                                    <span aria-hidden
                                                        class="absolute inset-0 bg-blue-200 opacity-50 rounded-full"></span>
                                                    <span class="relative">Observado</span>
                                                </span>
                                            </td>
                                        @break

                                        @case(3)
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span
                                                    class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                    <span aria-hidden
                                                        class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                    <span class="relative">Aprobado</span>
                                                </span>
                                            </td>
                                        @break

                                        @case(4)
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span
                                                    class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                    <span aria-hidden
                                                        class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                    <span class="relative">Desaprobado</span>
                                                </span>
                                            </td>
                                        @break

                                        @default
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span
                                                    class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                    <span aria-hidden
                                                        class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                    <span class="relative">Aprobado</span>
                                                </span>
                                            </td>
                                    @endswitch

                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{-- @livewire('edit-usuario', ['usuario' => $usuario], key($usuario->id)) --}}
                                        <div class="flex justify-end">
                                            <a wire:click="edit({{ $item->id }})"
                                                class="py-3 px-4 text-center rounded-md bg-lime-300 font-bold text-white cursor-pointer hover:bg-lime-400">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a wire:click="$emit('deleteExpediente',{{ $item->id }})"
                                                class="py-3 px-5 text-center ml-2 rounded-md bg-indigo-300 font-bold text-white cursor-pointer hover:bg-indigo-400">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if ($expedientes->hasPages())
                <div>
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <div class="px-5 py-5 bg-white border-t">
                                {{ $expedientes->links() }}
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
        </x-table>


    </div>

    <x-jet-dialog-modal wire:model="editando" wire:loading.attr="disabled" wire:target="deleteFile">
        <x-slot name="title" class="font-bold">
            <h1>Editar Expediente</h1>
        </x-slot>

        <x-slot name="content">
            @if ($expediente)
            <div>
                <span class="flex justify-end font-ligth text-sm">ultima actualizacion:{{$expediente->updated_at}}</span>
            </div>

                @if ($expediente->estado == 2)
                    @if ($observaciones)
                        <h1>Observaciones: </h1>
                        <div class="mb-4 border-2 rounded-lg border-red-700 p-2">
                            @foreach ($observaciones as $obs)
                                <div class="flex flex-row bg-red-200 my-2 rounded-xl p-2 justify-between">
                                    <p class="text-red-900">{{ $obs['detalle'] }}</p>
                                </div>
                            @endforeach

                        </div>
                        @if ($comentario)
                            <h1>Comentario: </h1>
                            <div class="flex flex-column  bg-amber-200 my-2 rounded-xl p-2 justify-between">
                                <p class="text-black-900 font-bold">{{ $comentario }}</p>
                            </div>
                        @endif
                        <hr class="my-4">
                    @endif
                @endif
            @endif

            <div class="mb-4">
                <x-jet-label value="Taller:" for="taller" />
                <select wire:model="tallerSeleccionado" wire:click="listaServicios"
                    class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                    <option value="0">Seleccione</option>
                    @foreach ($talleres as $taller)
                        <option value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="tallerSeleccionado" />
            </div>
            @if ($servicios != null)
                <div class="mb-4">
                    <x-jet-label value="Servicio:" for="servicio" />
                    <select wire:model="servicioSeleccionado"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                        <option value="">Seleccione</option>
                        @foreach ($servicios as $serv)
                            <option value="{{ $serv['id'] }}">{{ $serv['descripcion'] }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="servicioSeleccionado" />
                </div>
            @else
                <div class="mb-4">
                    <x-jet-label value="Servicio:" for="servicio" />
                    <select wire:model="servicioSeleccionado"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                        <option value="">Seleccione un taller</option>
                    </select>
                    <x-jet-input-error for="servicioSeleccionado" />
                </div>
            @endif
            <div class="mb-4">
                <x-jet-label value="Placa:" />
                <x-jet-input type="text" class="w-full" wire:model="expediente.placa" maxlength="7" />
                <x-jet-input-error for="expediente.placa" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Certificado:" />
                <x-jet-input type="text" class="w-full" wire:model="expediente.certificado" maxlength="7" />
                <x-jet-input-error for="expediente.certificado" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Fotos:" />
                <x-jet-input wire:model="fotosnuevas" type="file" accept=".jpg,.png,.jpeg,.gif,.bmp,.tif,.tiff"
                    multiple id="fotos-{{ $identificador }}" class="w-full" />
                <x-jet-input-error for="fotosnuevas" />
                <x-jet-input-error for="fotosnuevas.*" />
            </div>
            <div wire:loading wire:target="fotosnuevas,deleteFileUpload"
                class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                Procesando sus imagenes, espere un momento...
            </div>
            <h1 class="pt-2  font-semibold sm:text-lg text-gray-900">
                Galeria de fotos:
            </h1>
            <hr />
            @if (count($files) || count($fotosnuevas))
                <section class="mt-4 overflow-hidden border-dotted border-2 text-gray-700 "
                    id="{{ 'section-' . $identificador }}" wire:model="fotosnuevas">
                    <div class="container px-5 py-2 mx-auto lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @foreach ($files as $fil)
                                <div class="flex flex-wrap w-1/3 ">
                                    <div class="w-full p-1 items-center justify-center">
                                        @if ($fil->migrado==0)
                                            <img alt="gallery"
                                            class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg"
                                            src="{{ Storage::url($fil->ruta) }}">
                                        @else
                                            <img alt="gallery"
                                            class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg"
                                            src="{{ Storage::disk('do')->url($fil->ruta) }}">
                                        @endif
                                        <a class="flex" wire:click="deleteFile({{ $fil->id }})">
                                            <i class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            @if (count($fotosnuevas))
                                @foreach ($fotosnuevas as $key => $otro)
                                    <div class="flex flex-wrap w-1/3 ">
                                        <div class="w-full p-1 items-center justify-center">
                                            <img alt="gallery"
                                                class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg shadow-lg border-2 border-lime-500 hover:shadow-lime-500/50 "
                                                src="{{ $otro->temporaryUrl() }}">
                                            <a class="flex" wire:click="deleteFileUpload({{ $key }})"><i
                                                    class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </section>
            @else
                <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                    <ul id="gallerys-{{ $identificador }}" class="flex flex-1 flex-wrap -m-1">
                        <li id="empty"
                            class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32"
                                src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                alt="no data" />
                            <span class="text-small text-gray-500">Aun no seleccionaste ningún archivo</span>
                        </li>
                    </ul>
                </section>
            @endif
            <div class="mt-6 mb-4">
                <x-jet-label value="Documentos:" />
                <x-jet-input wire:model="documentosnuevos" type="file" accept=".pdf,.xls,.xlsx,.doc,.docx,.txt"
                    multiple id="documentos-{{ $identificador }}" class="w-full" />
                <x-jet-input-error for="documentosnuevos" />
                <x-jet-input-error for="documentosnuevos.*" />
            </div>
            <div wire:loading wire:target="documentosnuevos"
                class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                Procesando sus archivos, espere un momento...
            </div>
            <h1 class="pt-1  font-semibold sm:text-lg text-gray-900">
                Galeria de documentos:
            </h1>
            <hr />
            @if (count($documentos) || count($documentosnuevos))
                <section class="mt-4  overflow-hidden border-dotted border-2 text-gray-700 "
                    id="{{ 'sections-' . $identificador }} " wire:model="files">
                    <div class="container px-5 py-2 mx-auto lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @foreach ($documentos as $fil)

                                <div class="flex flex-wrap w-1/5 ">
                                    <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                        <img alt="gallery"
                                            class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg"
                                            src="/images/{{ $fil->extension }}.png">
                                        <p class="truncate text-sm">{{ $fil->nombre }}</p>
                                        <a class="flex" wire:click="deleteDocument({{ $fil->id }})"><i
                                                class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                    </div>
                                </div>
                            @endforeach
                            @if (count($documentosnuevos))
                                @foreach ($documentosnuevos as $key => $fil)
                                    @switch($fil->extension())
                                        @case('pdf')
                                            <div class="flex flex-wrap w-1/5 ">
                                                <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                                    <img alt="gallery"
                                                        class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg"
                                                        src="/images/pdf.png">
                                                    <p class="truncate text-sm"> {{ $fil->getClientOriginalName() }}</p>
                                                    <a class="flex"
                                                        wire:click="deleteDocumentUpload({{ $key }})"><i
                                                            class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                                </div>
                                            </div>
                                        @break

                                        @case('xls')
                                            <div class="flex flex-wrap w-1/5 ">
                                                <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                                    <img alt="gallery"
                                                        class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg"
                                                        src="/images/xls.png">
                                                    <p class="truncate text-sm"> {{ $fil->getClientOriginalName() }}</p>
                                                    <a class="flex"
                                                        wire:click="deleteDocumentUpload({{ $key }})"><i
                                                            class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                                </div>
                                            </div>
                                        @break

                                        @case('xlsx')
                                            <div class="flex flex-wrap w-1/5 ">
                                                <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                                    <img alt="gallery"
                                                        class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg"
                                                        src="/images/xlsx.png">
                                                    <p class="truncate text-sm"> {{ $fil->getClientOriginalName() }}</p>
                                                    <a class="flex"
                                                        wire:click="deleteDocumentUpload({{ $key }})"><i
                                                            class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                                </div>
                                            </div>
                                        @break

                                        @case('docx')
                                            <div class="flex flex-wrap w-1/5 ">
                                                <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                                    <img alt="gallery"
                                                        class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg"
                                                        src="/images/docx.png">
                                                    <p class="truncate text-sm"> {{ $fil->getClientOriginalName() }}</p>
                                                    <a class="flex"
                                                        wire:click="deleteDocumentUpload({{ $key }})"><i
                                                            class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                                </div>
                                            </div>
                                        @break

                                        @default
                                    @endswitch
                                @endforeach
                            @endif
                        </div>
                    </div>
                </section>
            @else
                <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                    <ul id="gallery-{{ $identificador }}" class="flex flex-1 flex-wrap -m-1">
                        <li id="empty"
                            class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32"
                                src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                alt="no data" />
                            <span class="text-small text-gray-500">Aun no seleccionaste ningún archivo</span>
                        </li>
                    </ul>
                </section>
            @endif
        </x-slot>

        <x-slot name="footer">

            <x-jet-secondary-button wire:click="$set('editando',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="actualizar" wire:loading.attr="disabled"
                wire:target="update,documentosnuevos,fotosnuevas">
                Actualizar
            </x-jet-button>


        </x-slot>

    </x-jet-dialog-modal>


    @push('js')
        <script>
            Livewire.on('deleteExpediente', expedienteId => {
                Swal.fire({
                    title: '¿Seguro que quieres eliminar este registro?',
                    text: "Luego de eliminar no podras recuperarlo.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('expedientes', 'delete', expedienteId);

                        Swal.fire(
                            'Listo!',
                            'Expediente eliminado correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>
