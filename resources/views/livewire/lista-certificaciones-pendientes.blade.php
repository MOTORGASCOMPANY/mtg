<div>
    <div wire:loading.remove wire:target="certificar" >       
        <div class="sm:px-6 w-full pt-12 pb-4" >
            <x-custom-table>
                <x-slot name="titulo">
                    <h2 class="text-indigo-600 font-bold text-3xl uppercase">                        
                        <i class="fa-solid fa-file-circle-question fa-xl text-indigo-600"></i>
                        &nbsp;Certificaciones pendientes
                    </h2>                    
                </x-slot>

                <x-slot name="btnAgregar" class="mt-6 ">
                    
                </x-slot>

                <x-slot name="contenido">                   
                    @if (count($certis))
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8" wire:loading.remove wire:target="search">
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
                                                    wire:click="order('idInspector')">
                                                    Inspector
                                                    @if ($sort == 'idInspector')
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
                                                    wire:click="order('idTaller')">
                                                    Taller
                                                    @if ($sort == 'idTaller')
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
                                                    wire:click="order('idVehiculo')">
                                                    Placa
                                                    @if ($sort == 'idVehiculo')
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
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($certis as $item)
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
                                                            <p class="whitespace-no-wrap">
                                                                {{ $item->Inspector->name }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center">
                                                            <p class="whitespace-no-wrap">
                                                                {{ $item->Taller->nombre}}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center">
                                                            <p class="p-2 border  rounded-md font-black text-md">
                                                                {{ $item->Vehiculo->placa}}
                                                            </p>
                                                        </div>
                                                    </td>                                                    
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <div class="flex items-center justify-center">
                                                            @switch($item->estado)
                                                                @case(1)
                                                                    <p
                                                                        class="text-xs rounded-full leading-none p-1 font-bold text-blue-700 bg-blue-200 ">
                                                                        Pendiente
                                                                    </p>
                                                                @break

                                                                @case(2)
                                                                    <p
                                                                        class="text-xs rounded-full leading-none p-1 font-bold text-green-600 bg-green-200">
                                                                        Realizada
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
                                                            <p class="whitespace-no-wrap uppercase">
                                                                {{ $item->created_at->format('d-m-Y h:m:i a') }}
                                                            </p>
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
                                                                    <button wire:click="muestraModal({{$item->id}})"
                                                                        class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                        <i class="fa-solid fa-file-signature"></i>
                                                                        <span>Certificar</span>
                                                                    </button>  
                                                                    <button 
                                                                        class="focus:outline-none flex items-center space-x-4 focus:text-lime-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                        <i class="fas fa-trash"></i>
                                                                        <span>Eliminar</span>
                                                                    </button>                                                                                                                                          
                                                                @endif
                                                                @if ($item->estado == 2)  
                                                                <a href="{{ route("certificadoAnualGnv",['id'=>$item->idCertificacion])}}" class="focus:outline-none flex items-center space-x-4  focus:text-indigo-400 text-xs w-full hover:bg-indigo-600 py-2 px-6 cursor-pointer hover:text-white">
                                                                    <i class="fas fa-eye"></i>
                                                                    <span>ver certificado</span>
                                                                </a>
                                                                @endif
                                                                
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
                        <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md w-full" wire:loading wire:target="search">
                            <i class="fa-solid fa-circle-notch fa-xl animate-spin text-indigo-800 "></i>          
                            <p class="text-center text-black font-bold italic">CARGANDO...</p>
                        </div>
                        @if ($certis->hasPages())
                            <div>
                                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                        <div class="px-5 py-5 bg-white border-t">
                                            {{ $certis->links() }}
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

    <div class="hidden w-full h-screen flex flex-col justify-center items-center bg-gray-200 " wire:loading.remove.class="hidden" wire:target="certificar">     
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

    <x-jet-dialog-modal wire:model="open" wire:loading.attr="disabled">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold"><i class="fa-solid fa-plus text-white"></i> &nbsp;Nueva Certificación</h1>
        </x-slot>

        <x-slot name="content">
            <div class="mb-4 flex flex-row space-x-2 w-full">
                <div class="w-1/2">
                    <x-jet-label value="Combustible:" />
                    <x-jet-input type="text" class="w-full" wire:model="combustible" list="items"/>
                    <datalist id="items">
                        <option value="GASOLINA">GASOLINA</option>                   
                        <option value="BI-COMBUSTIBLE GNV">BI-COMBUSTIBLE GNV</option>
                        <option value="BI-COMBUSTIBLE GLP">BI-COMBUSTIBLE GLP</option>
                        <option value="GNV">GNV</option>
                        <option value="GLP">GLP</option>
                    </datalist>
                    <x-jet-input-error for="combustible" />
                </div >
                <div class="w-1/2">
                    <x-jet-label value="Nuevo peso neto:" />
                    <x-jet-input wire:model="pesoNeto" class="w-full" type="number" inputmode="numeric"/>
                    <x-jet-input-error for="pesoNeto" />
                </div>                
            </div>
            <div class="mb-4">
                <x-jet-label value="N° Formato:" />
                <x-jet-input wire:model="numSugerido" type="text" class="w-full" />
                <x-jet-input-error for="numSugerido" />
            </div>               
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="certificar" wire:loading.attr="disabled" wire:target="certificar">
                Certificar
            </x-jet-button>

        </x-slot>

    </x-jet-dialog-modal>
</div>
