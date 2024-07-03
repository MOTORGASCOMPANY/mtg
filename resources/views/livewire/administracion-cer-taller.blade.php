<div>
    <x-table-administracion-certificaciones>
        <div class="bg-white md:py-7 w-full">
            <div class="sm:flex items-center justify-between">
                <div class="flex items-center space-x-2">

                    <div class="flex bg-gray-200 items-center p-2 rounded-md mb-4 ">
                        <span>Taller: </span>
                        <select wire:model="ta"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                            <option value="">SELECCIONE</option>
                            @isset($talleres)
                                @foreach ($talleres as $taller)
                                    <option class="" value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="flex bg-gray-200 items-center p-2 rounded-md mb-4 ">
                        <span>Material: </span>
                        <select wire:model=""
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate">
                            <option value="">SELECCIONE</option>
                            @foreach ($materiales as $mate)
                                <option class="" value="{{ $mate->id }}">{{ $mate->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex bg-gray-200 items-center p-2 w-48 rounded-md mb-4 ">
                        <span>Desde: </span>
                        <x-date-picker wire:model="fecIni" placeholder="Fecha de inicio"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                    </div>

                    <div class="flex bg-gray-200 items-center p-2 w-48 rounded-md mb-4 ">
                        <span>Hasta: </span>
                        <x-date-picker wire:model="fecFin" placeholder="Fecha de Fin"
                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full overflow-x-auto table-responsive">
            @if ($certificaciones->count())

                <table class="w-full whitespace-nowrap">
                    <thead class="bg-slate-600 border-b font-bold text-white">
                        <tr>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                #
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Inspector
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Taller
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Material
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                N° Formato
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Fecha
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                Documentos
                            </th>
                            <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($certificaciones as $certificacion)
                            <tr tabindex="0"
                                class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-200">
                                <td class="pl-5">
                                    <div class="flex items-center">
                                        <div
                                            class="bg-indigo-200 rounded-sm w-5 h-5 flex flex-shrink-0 justify-center items-center relative text-indigo-900">
                                            {{ $certificacion->id }}
                                        </div>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        <p class="text-sm font-medium leading-none text-gray-600 mr-2">
                                            {{ $certificacion->inspector->name ?? null }}
                                        </p>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                            {{ $certificacion->taller->nombre ?? null }}
                                        </p>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        @switch($certificacion->material->tipo->id)
                                            @case(1)
                                                <p
                                                    class="text-sm leading-none text-gray-600 ml-2 p-2 bg-green-200 rounded-full">
                                                    FORMATO GNV
                                                </p>
                                            @break

                                            @case(3)
                                                <p class="text-sm leading-none text-gray-600 ml-2 p-2 bg-blue-200 rounded-full">

                                                    FORMATO GLP
                                                </p>
                                            @break

                                            @default
                                                <p class="text-sm leading-none text-gray-600 ml-2">
                                                    No se encontro datos
                                                </p>
                                        @endswitch
                                    </div>
                                </td>
                                <td class="pl-12">
                                    <div class="flex items-center">
                                        <p class="text-sm font-bold  text-indigo-700 ml-2">
                                            {{ $certificacion->material->numSerie ?? null }}
                                        </p>
                                    </div>
                                </td>
                                <td class="pl-2">
                                    <div class="flex items-center">
                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                            {{ $certificacion->created_at->format('d/m/Y  h:i a') }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="relative px-5 text-center" x-data="{ menu: false }">
                                        <button type="button" x-on:click="menu = ! menu" id="menu-button"
                                            aria-expanded="true" aria-haspopup="true" data-te-ripple-init
                                            data-te-ripple-color="light"
                                            class="hover:animate-pulse inline-block rounded-full bg-amber-400 p-2 uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:bg-amber-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-amber-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-amber-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="h-4 w-4">
                                                <path fill-rule="evenodd"
                                                    d="M19.5 21a3 3 0 003-3V9a3 3 0 00-3-3h-5.379a.75.75 0 01-.53-.22L11.47 3.66A2.25 2.25 0 009.879 3H4.5a3 3 0 00-3 3v12a3 3 0 003 3h15zm-6.75-10.5a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V10.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div x-show="menu" x-on:click.away="menu = false"
                                            class="origin-top-right absolute right-12 mt-2 w-56 rounded-md shadow-lg bg-gray-300 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-40"
                                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                            tabindex="-1">
                                            <div class="" role="none">
                                                <a href="{{ $certificacion->rutaVistaCertificado }}" target="__blank"
                                                    rel="noopener noreferrer"
                                                    class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-t-md hover:cursor-pointer">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Ver Certificado.</span>
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pl-4">
                                    <div class="relative flex justify-center px-5">
                                        <div class="inline-block text-left" x-data="{ menu: false }">
                                            <button x-on:click="menu = ! menu" type="button"
                                                class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                                                id="menu-button" aria-expanded="true" aria-haspopup="true">
                                                <span class="sr-only"></span>
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </button>
                                            <div x-show="menu" x-on:click.away="menu = false"
                                                class="origin-top-right absolute right-12 mt-2 w-56 rounded-md shadow-lg bg-gray-300 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-40"
                                                role="menu" aria-orientation="vertical"
                                                aria-labelledby="menu-button" tabindex="-1">
                                                <div class="" role="none">
                                                    <a wire:click="$emit('deleteCertificacion',{{ $certificacion->id }})"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-b-md hover:cursor-pointer">
                                                        <i class="fas fa-eraser"></i>
                                                        <span>Eliminar</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="h-3"></tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-3">
                    {{ $certificaciones->links() }}
                </div>
            @else
                <div class="px-6 py-4">
                    No existe ningún registro coincidente
                </div>
            @endif

    </x-table-administracion-certificaciones>

    {{-- JS --}}
    @push('js')
        <script>
            Livewire.on('deleteCertificacion', certificacionId => {
                Swal.fire({
                    title: '¿Estas seguro de eliminar este certificado?',
                    text: "una vez eliminado este registro, no podras recuperarlo.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('administracion-cer-taller', 'delete', certificacionId);

                        Swal.fire(
                            'Listo!',
                            'Servicio eliminado correctamente.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush
</div>
