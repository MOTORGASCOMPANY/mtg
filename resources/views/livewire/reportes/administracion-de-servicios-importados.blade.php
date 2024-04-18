<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <x-custom-table>
            <x-slot name="titulo">
                <h2 class="text-indigo-600 font-bold text-3xl">                    
                    <i class="fa-solid fa-square-poll-horizontal fa-xl"></i>
                    &nbsp;Servicios realizados Gasolution
                </h2>
            </x-slot>

            <x-slot name="btnAgregar">

            </x-slot>

            <x-slot name="contenido">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="flex items-center space-x-2 px-8">
                        <div class="flex bg-white items-center p-2 w-1/2 md:w-48 rounded-md mb-4 ">
                            <span>Desde: </span>
                            <x-date-picker wire:model="fechaInicio" placeholder="Fecha de inicio"
                                class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                        </div>
                        <div class="flex bg-white items-center p-2 w-1/2 md:w-48 rounded-md mb-4 ">
                            <span>Hasta: </span>
                            <x-date-picker wire:model="fechaFin" placeholder="Fecha de Fin"
                                class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate" />
                        </div>
                    </div>
                    
                </div>
                @if (count($servicios_importados))
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
                                                wire:click="order('taller')">
                                                Taller
                                                @if ($sort == 'taller')
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
                                                wire:click="order('certificador')">
                                                Inspector
                                                @if ($sort == 'certificador')
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
                                                wire:click="order('tipoServicio')">
                                                Servicio
                                                @if ($sort == 'tipoServicio')
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
                                                wire:click="order('fecha')">
                                                Fecha
                                                @if ($sort == 'fecha')
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
                                                En sistema
                                                @if ($sort == 'estado')
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
                                                wire:click="order('externo')">
                                                Es Externo
                                                @if ($sort == 'externo')
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
                                                wire:click="order('precio')">
                                                Precio
                                                @if ($sort == 'precio')
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
                                        @foreach ($servicios_importados as $item)
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
                                                        <p class="text-slate-900 font-semibold whitespace-no-wrap truncate">
                                                            {{ $item->taller }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="whitespace-no-wrap truncate">
                                                            {{ $item->certificador }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="whitespace-no-wrap uppercase">
                                                            {{ $item->placa }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="whitespace-no-wrap">
                                                            {{ $item->TipoServicio->descripcion }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="whitespace-no-wrap">
                                                            {{ 
                                                                date("Y-m-d H:i a", strtotime($item->fecha))
                                                            }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center text-center justify-center">
                                                        @switch($item->estado)
                                                            @case(1)
                                                                <i class="fa fa-check-circle fa-lg text-green-400"></i>
                                                                @break
                                                            @case(2)                                                                
                                                                <i class="fa-regular fa-circle-xmark fa-lg text-red-400"></i>
                                                                @break
                                                            @default                                                                
                                                        @endswitch
                                                        
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center text-center justify-center">                                                       
                                                            
                                                       
                                                        @switch($item->extero)
                                                            @case(1)
                                                                <i class="fa fa-check-circle fa-lg text-green-400"></i>
                                                                @break
                                                            @case(0)                                                                
                                                                <i class="fa-regular fa-circle-xmark fa-lg text-red-500"></i>
                                                                @break
                                                            @default
                                                                
                                                        @endswitch
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center">
                                                        <p class="whitespace-no-wrap">
                                                            {{ $item->precio ? $item->precio :'Sin datos' }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <div class="flex items-center justify-center">
                                                        <p class="text-gray-900 whitespace-no-wrap">
                                                            <button wire:click="editar({{ $item->id }})"
                                                                class="px-2 py-2 bg-indigo-600 rounded-md flex items-center justify-center">
                                                                <i class="fas fa-pen text-white"></i>
                                                            </button>
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if ($servicios_importados->hasPages())
                        <div>
                            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                    <div class="px-5 py-5 bg-white border-t">
                                        {{ $servicios_importados->links() }}
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

    {{-- MODAL PARA EDITAR ROL --}}
    <x-jet-dialog-modal wire:model="editando" wire:loading.attr="disabled">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold"><i class="fa-solid fa-pen text-white"></i> &nbsp;Editar Servicio</h1>
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label value="precio:" />
                <x-jet-input wire:model="servicio.precio" type="text" class="w-full" />
                <x-jet-input-error for="servicio.precio" />
            </div>            
            <x-jet-input-error for="selectedPermisos" />
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
</div>
