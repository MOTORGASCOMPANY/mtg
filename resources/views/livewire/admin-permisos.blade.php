<div>
    <div class="sm:px-6 w-full pt-12 pb-4">
        <x-custom-table>
            <x-slot name="titulo">
                <h2 class="text-indigo-600 font-bold text-3xl">
                    <i class="fa-solid fa-unlock-keyhole fa-xl"></i>
                     &nbsp;Permisos                          
                </h2> 
            </x-slot>

            <x-slot name="btnAgregar">
                @livewire('create-permiso')
            </x-slot>
            
            <x-slot name="contenido">
                @if (count($permisos))
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                                <thead class="bg-slate-600 border-b font-bold text-white">
                                    <tr>
                                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
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
                                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                            wire:click="order('name')">
                                            Nombre
                                            @if ($sort == 'name')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort float-right mt-0.5"></i>
                                            @endif
                                        </th>  
                                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                            wire:click="order('descripcion')">
                                            Descripcion
                                            @if ($sort == 'descripcion')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort float-right mt-0.5"></i>
                                            @endif
                                        </th>  
                                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
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
                                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-300">
                                    @foreach ($permisos as $item)
                                        <tr tabindex="0" class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-200">
                                            <td class="pl-5">
                                                <div class="flex items-center">
                                                    <p class="text-indigo-900 p-1 bg-indigo-200 rounded-md">
                                                        {{ $item->id }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="pl-2">
                                                <div class="flex items-center">
                                                    <p
                                                    class="text-sm font-medium leading-none text-gray-600 mr-2">
                                                        {{ $item->name }}
                                                    </p>
                                                </div>
                                            </td>    
                                            <td class="pl-2">
                                                <div class="flex items-center">
                                                    <p
                                                    class="text-sm leading-none text-gray-600 ml-2">
                                                        {{ $item->descripcion? $item->descripcion : "Sin datos" }}
                                                    </p>
                                                </div>
                                            </td>  
                                            <td class="pl-2">
                                                <div class="flex items-center">
                                                    <p
                                                    class="text-sm leading-none text-gray-600 ml-2">
                                                        {{ $item->created_at->format("d-m-Y h:m:i a") }}
                                                    </p>
                                                </div>
                                            </td>                                        
                                            <td class="pl-2">
                                                <div class="flex items-center justify-center">
                                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                                        <button wire:click="editarPermiso({{$item->id}})"
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

                    @if ($permisos->hasPages())
                        <div>
                            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                    <div class="px-5 py-5 bg-white border-t">
                                        {{ $permisos->links() }}
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
   

    {{-- MODAL PARA EDITAR ROL--}}
    <x-jet-dialog-modal wire:model="editando" wire:loading.attr="disabled">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold"><i class="fa-solid fa-pen text-white"></i> &nbsp;Editar Permiso</h1>
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label value="Nombre:" />
                <x-jet-input wire:model="permiso.name" type="text" class="w-full" />
                <x-jet-input-error for="permiso.name" />
            </div>    
            <div class="mb-4">
                <x-jet-label value="Descripcion:" />
                <x-jet-input wire:model="permiso.descripcion" type="text" class="w-full" />
                <x-jet-input-error for="permiso.descripcion" />
            </div>        
           
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
