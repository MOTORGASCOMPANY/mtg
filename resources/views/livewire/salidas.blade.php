<div>
    <div wire:loading.remove wire:ignore.self>       
        <div class="sm:px-6 w-full pt-12 pb-4" >
            <x-custom-table>
                <x-slot name="titulo">
                    <h2 class="text-indigo-600 font-bold text-3xl uppercase">
                        <i class="fa-solid fa-truck-fast fa-xl text-indigo-600"></i>
                        &nbsp;Salida de materiales
                    </h2>                    
                </x-slot>

                <x-slot name="btnAgregar" class="mt-6 ">
                    <a class="bg-indigo-500 px-6  py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer"
                        href="{{ route('asignacion') }}">
                        Nueva Asignación &nbsp;<i class="fas fa-plus"></i>
                    </a>
                </x-slot>

                <x-slot name="contenido">
                    @if (count($salidas))
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full leading-normal rounded-md">
                                        <thead>
                                            <tr>
                                                <th class=" w-24 cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
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
                                                <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                    wire:click="order('numero')">
                                                    Numero
                                                    @if ($sort == 'numero')
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
                                                    wire:click="order('idUsuarioSalida')">
                                                    Creado por
                                                    @if ($sort == 'idUsuarioSalida')
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
                                                    wire:click="order('idUsuarioAsignado')">
                                                    Asignado a
                                                    @if ($sort == 'idUsuarioAsignado')
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
                                                <th class="cursor-pointer hover:font-bold hover:text-indigo-500  px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                    wire:click="order('motivo')">
                                                    Motivo
                                                    @if ($sort == 'motivo')
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
                                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Cargo
                                                </th>
                                                <th
                                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($salidas as $item)
                                                <tr>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center">
                                                            <p class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                                                {{ $item->id }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center">
                                                            <p class="text-slate-900 font-semibold whitespace-no-wrap">
                                                                {{ $item->numero }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center">
                                                            <p class="whitespace-no-wrap">
                                                                {{ $item->usuarioCreador->name }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center">
                                                            <p class="whitespace-no-wrap">
                                                                {{ $item->usuarioAsignado->name }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center">
                                                            @switch($item->estado)
                                                                @case(1)
                                                                    <p
                                                                        class="text-xs rounded-full leading-none p-1 font-bold text-blue-700 bg-blue-200">
                                                                        En envio
                                                                    </p>
                                                                @break

                                                                @case(2)
                                                                    <p
                                                                        class="text-xs rounded-full leading-none p-1 font-bold text-white bg-red-400">
                                                                        Rechazado
                                                                    </p>
                                                                @break

                                                                @case(3)
                                                                    <p
                                                                        class="text-xs rounded-full leading-none p-1 font-bold text-green-700 bg-green-200">
                                                                        Recepcionado
                                                                    </p>
                                                                @break

                                                                @default
                                                                    <p class="text-xs rounded-full leading-none text-gray-600 ml-2">
                                                                        Sin datos
                                                                    </p>
                                                            @endswitch
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center">
                                                            <p class="whitespace-no-wrap">
                                                                {{ $item->motivo ?? "Sin datos" }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center">
                                                            <p class="whitespace-no-wrap uppercase">
                                                                {{ $item->created_at->format('d-m-Y h:m:i a') }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center" id="{{rand()}}">
                                                            <a class="focus:ring-2 focus:ring-offset-2 focus:ring-gray-600 text-sm leading-none text-white py-3 px-5 bg-amber-400 rounded hover:bg-amber-600 focus:outline-none"
                                                                target="__blank"
                                                                href="{{ route('generaCargo', ['id' => $item->id]) }}"
                                                                rel="noopener noreferrer">Ver cargo <i
                                                                    class="fas fa-file-pdf"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center justify-center"
                                                            x-data="{ menu: false }">
                                                            <button
                                                                class="focus:ring-2 rounded-md focus:outline-none hover:text-indigo-500"
                                                                role="button" x-on:click="menu = ! menu" id="menu-button"
                                                                aria-expanded="true" aria-haspopup="true"
                                                                data-te-ripple-init data-te-ripple-color="light"
                                                                aria-label="option">
                                                                <i class="fa-solid fa-ellipsis fa-xl"></i>
                                                            </button>
                                                            <div x-show="menu" x-on:click.away="menu = false" class="dropdown-content flex flex-col  bg-white shadow w-48 absolute z-30 right-0 mt-20 mr-6">
                                                                @if ($item->estado == 1)                                                                   
                                                                        @switch($item->motivo)
                                                                            @case("Asignación de Materiales")
                                                                                <button wire:click="$emit('deleteSalidaAsignacion',{{ $item->id }})"
                                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                                    <i class="fas fa-trash"></i>
                                                                                    <span>Cancelar envio</span>
                                                                                </button>
                                                                            @break
                                                                            @case("Prestamo de Materiales")
                                                                                <button wire:click="$emit('deleteSalidaPrestamo',{{ $item->id }})"
                                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                                    <i class="fas fa-trash"></i>
                                                                                    <span>Cancelar prestamo</span>
                                                                                </button>
                                                                            @break
                                                                            @default
                                                                                <button wire:click="$emit('deleteSalidaAsignacion',{{ $item->id }})"
                                                                                    class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                                    <i class="fas fa-trash"></i>
                                                                                    <span>Cancelar envio</span>
                                                                                </button>                                                                            
                                                                    @endswitch                                                                   
                                                                @endif
                                                                <a
                                                                    class="focus:outline-none flex items-center space-x-4  focus:text-indigo-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                    <i class="fas fa-eye"></i>
                                                                    <span>Ver detalle</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if ($salidas->hasPages())
                            <div>
                                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                        <div class="px-5 py-5 bg-white border-t">
                                            {{ $salidas->links() }}
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
        
    </div>

    <div class="hidden w-full h-screen flex flex-col justify-center items-center bg-gray-200 " wire:loading.remove.class="hidden">     
        <div class="flex">
            <img src="{{ asset('images/mtg.png') }}" alt="Logo Motorgas Company" width="150" height="150">
        </div>
        <div class="text-center">
            <i class="fa-solid fa-circle-notch fa-xl animate-spin text-indigo-800 "></i>
          
            <p class="text-center text-black font-bold italic">CARGANDO...</p>
        </div>
        <div class="flex">
        </div>
    </div>    

    @push('js')
        <script>
            Livewire.on('deleteSalidaAsignacion', sal => {
                Swal.fire({
                    title: '¿Seguro que quieres eliminar esta salida?',
                    text: "Luego de eliminar no se podran recuperar los datos",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#dd333f',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText:'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('salidas', 'eliminaSalidaAsignacion', sal);
                        /*
                        Swal.fire(
                            '¡Listo!',
                            'Salida eliminada correctamente.',
                            'success'
                        )
                        */
                    }
                })
            });
        </script>
        <script>
            Livewire.on('deleteSalidaPrestamo', sal => {
                Swal.fire({
                    title: '¿Seguro que quieres eliminar esta salida?',
                    text: "Luego de eliminar no se podran recuperar los datos",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#dd333f',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText:'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('salidas', 'eliminaSalidaPrestamo', sal);
                        /*
                        Swal.fire(
                            '¡Listo!',
                            'Salida eliminada correctamente.',
                            'success'
                        )
                        */
                    }
                })
            });
        </script>
    @endpush
</div>
