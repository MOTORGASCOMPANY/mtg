<div class="flex box-border">
    <div class="container mx-auto py-12">
        <x-table-precios>
            @if (!empty($users))
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full leading-normal rounded-md">
                                <thead class="bg-slate-600 border-b font-bold text-white">
                                    <tr>
                                        <th scope="col"
                                            class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                            ID
                                        </th>
                                        </th>
                                        <th scope="col"
                                            class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                            Nombre
                                        </th>
                                        <th scope="col"
                                            class="text-sm font-medium font-semibold text-white  py-4 text-left">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-300">
                                    @foreach ($users as $item)
                                        <tr tabindex="0"
                                            class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-300">
                                            <td class="pl-5">
                                                <div class="flex items-center">
                                                    <p
                                                        class="bg-indigo-200 rounded-sm w-5 h-5 flex flex-shrink-0 justify-center items-center relative text-indigo-900">
                                                        {{ strtoupper($item->id) }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="pl-2">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-medium leading-none text-gray-600 mr-2">
                                                        {{ $item->name }}
                                                    </p>
                                                </div>
                                            </td>

                                            <td class="pl-2">
                                                <div class="">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        <button wire:click="agregarServicios({{ $item->id }})"
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
                @if ($users->hasPages())
                    <div>
                        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                <div class="px-5 py-5 bg-white border-t">
                                    {{ $users->links() }}
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
        </x-table-precios>
    </div>


    {{-- MODAL PARA AGREGAR PRECIOS DE INSPECTORES POR TIPOSERVICIO --}}
    <x-jet-dialog-modal wire:model="editar" wire:loading.attr="disabled">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold">Agregar Precios</h1>
        </x-slot>
        <x-slot name="content">
            <div>
                @foreach ($tiposServicio as $tipoServicio)
                    <div class="flex flex-row justify-between bg-indigo-100 my-2 items-center rounded-lg p-2">
                        <div class="">
                            <label class="form-check-label inline-block text-gray-800">
                                {{ $tipoServicio->descripcion }}
                            </label>
                        </div>
                        <div class="flex flex-row items-center">
                            <x-jet-label value="precio:" />
                            <x-jet-input type="number" id="precio_{{ $tipoServicio->id }}" class="w-6px"
                                wire:model="serviciosNuevos.{{ $tipoServicio->id }}" />
                        </div>

                    </div>
                    <div class="flex flex-row">
                        <x-jet-input-error for="tiposServicio.precio" />
                    </div>
                    <x-jet-input-error for="tiposServicio" />
                @endforeach
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('editar',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:loading.attr="disabled" wire:target="guardarServicios" wire:click="guardarServicios">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>
