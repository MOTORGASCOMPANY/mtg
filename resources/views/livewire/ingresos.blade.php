<div>
    <div class="container mx-auto py-12">

        <x-table-ingresos :tipos="$tipos">
            @if (count($ingresos))
                <div>
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-x-auto">
                                <table class="min-w-full leading-normal rounded-md">
                                    <thead>
                                        <tr>
                                            <th class=" w-48 cursor-pointer hover:font-bold hover:text-indigo-500 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                wire:click="order('numguia')">
                                                N° Guia
                                                @if ($sort == 'numguia')
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
                                                wire:click="order('idUsuario')">
                                                INGRESADO POR
                                                @if ($sort == 'idUsuario')
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
                                                wire:click="order('motivo')">
                                                Motivo
                                                @if ($sort == 'motivo')
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
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ingresos as $item)
                                            <tr>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="text-gray-900 ">
                                                            {{ $item->numeroguia }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="text-gray-900 whitespace-no-wrap">
                                                            {{ $item->usuario->name }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <p class="text-gray-900 whitespace-no-wrap">{{ $item->created_at }}
                                                    </p>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="text-gray-900 whitespace-no-wrap">
                                                            {{ $item->motivo }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    {{-- @livewire('edit-usuario', ['usuario' => $usuario], key($usuario->id)) --}}
                                                    <div class="flex justify-end">
                                                        <a wire:click="edit({{ $item }})"
                                                            class="py-3 px-4 text-center rounded-md bg-lime-300 font-bold text-white cursor-pointer hover:bg-lime-400">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a wire:click="validaEstadoMateriales({{ $item->id }})"
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

                    {{--
                    @if ($ingresos->hasPages())
                        <div>
                            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                    <div class="px-5 py-5 bg-white border-t">
                                        {{ $ingresos->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    --}}
                @else
                    <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                        No se encontro ningun registro.
                    </div>
            @endif
        </x-table-ingresos>
    </div>
</div>

<x-jet-dialog-modal wire:model="editando">
    <x-slot name="title" class="font-bold">
        <h1>INGRESO</h1>
    </x-slot>

    <x-slot name="content">

        @if ($ingreso)
            <div class="px-8 block ">
                <div class="flex flex-row justify-between items-center mb-4">
                    <label for="numeroGuia">
                        N° de Guia:
                    </label>
                    <span name="numeroGuia" id="numeroGuia"
                        class="p-1 bg-orange-300 rounded-xl">{{ $ingreso->numeroguia }}</span>
                </div>
                <div class="flex flex-row justify-between items-center mb-4">
                    <label>
                        Motivo:
                    </label>
                    <span class="bg-lime-300  px-2 rounded-xl">{{ $ingreso->motivo }}</span>
                </div>
            </div>

            {{--
            @if (count($ingreso->detalles) > 0)
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
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
                                                Producto
                                            </th>
                                            <th scope="col"
                                                class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                Cantidad
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ingreso->detalles as $key => $detalle)
                                            <tr class="bg-gray-100 border-b">
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ $key + 1 }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ $detalle['tipo'] }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ $detalle['cantidad'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            --}}

            @if ($ingreso->materiales->count() > 0)
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                @switch($ingreso->TipoMaterial->tipo->id)
                                    @case(1)
                                    <table class="min-w-full">
                                        <thead class="bg-indigo-300 border-b">
                                            <tr>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    #
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Producto
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Cantidad
                                                </th>
    
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Series
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                           
                                                <tr class="bg-gray-100 border-b">
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        1
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->TipoMaterial->tipo->descripcion }}
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->FormatosGnv->count() }}
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->InicioSerieGnv.' - '.$ingreso->FinalSerieGnv }}
                                                    </td>
                                                </tr>                                            
                                        </tbody>
                                    </table>
                                        @break
                                    @case(2)
                                    <table class="min-w-full">
                                        <thead class="bg-indigo-300 border-b">
                                            <tr>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    #
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Producto
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Cantidad
                                                </th>
    
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Series
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                           
                                                <tr class="bg-gray-100 border-b">
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        1
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->TipoMaterial->tipo->descripcion }}
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->Chips->count() }}
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        N.A
                                                    </td>
                                                </tr>                                            
                                        </tbody>
                                    </table>     
                                        @break
                                    @case(3)
                                    <table class="min-w-full">
                                        <thead class="bg-indigo-300 border-b">
                                            <tr>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    #
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Producto
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Cantidad
                                                </th>
    
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Series
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                           
                                                <tr class="bg-gray-100 border-b">
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        1
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->TipoMaterial->tipo->descripcion }}
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->FormatosGlp->count() }}
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->InicioSerieGlp.' - '.$ingreso->FinalSerieGlp }}
                                                    </td>
                                                </tr>                                            
                                        </tbody>
                                    </table> 
                                    @case(4)
                                    <table class="min-w-full">
                                        <thead class="bg-indigo-300 border-b">
                                            <tr>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    #
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Producto
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Cantidad
                                                </th>
    
                                                <th scope="col"
                                                    class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                    Series
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                           
                                                <tr class="bg-gray-100 border-b">
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        1
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->TipoMaterial->tipo->descripcion }}
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->FormatosModi->count() }}
                                                    </td>
                                                    <td
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $ingreso->InicioSerieModi.' - '.$ingreso->FinalSerieModi }}
                                                    </td>
                                                </tr>                                            
                                        </tbody>
                                    </table> 
                                        @break
                                    @default
                                        
                                @endswitch
                                

                            </div>
                        </div>
                    </div>
                </div>

            @endif
        @endif

    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('editando',false)" class="mx-2">
            Cerrar
        </x-jet-secondary-button>       
    </x-slot>

</x-jet-dialog-modal>


@push('js')
    <script>
        Livewire.on('deleteIngreso', ingresoId => {
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

                    Livewire.emitTo('ingresos', 'delete', ingresoId);

                    Swal.fire(
                        'Listo!',
                        'ingreso eliminado corrrectamente.',
                        'success'
                    )
                }
            })
        });
    </script>
@endpush


</div>
