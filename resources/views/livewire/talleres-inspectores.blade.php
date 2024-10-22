<div class="flex box-border">
    <div class="container mx-auto py-12">
        <x-table-talleresinspectores>
            @if (!empty($asignaciones))
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full leading-normal rounded-md">
                                <thead class="bg-slate-600 border-b font-bold text-white">
                                    <tr>
                                        <th scope="col"
                                            class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                            #
                                        </th>
                                        </th>
                                        <th scope="col"
                                            class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                            Taller
                                        </th>
                                        <th scope="col"
                                            class="text-sm font-medium font-semibold text-white  py-4 text-left">
                                            Inspectores
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-300">
                                    @foreach ($asignaciones as $taller_id => $asignacion)
                                        <tr tabindex="0"
                                            class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-300">
                                            <td class="pl-5">
                                                <div class="flex items-center">
                                                    <p
                                                        class="bg-indigo-200 rounded-sm w-5 h-5 flex flex-shrink-0 justify-center items-center relative text-indigo-900">
                                                        {{$loop->iteration}}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="pl-2">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-medium leading-none text-gray-600 mr-2">
                                                        {{ $asignacion->first()->taller->nombre }}
                                                    </p>
                                                </div>
                                            </td>

                                            <td class="pl-2">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-medium leading-none text-gray-600 mr-2">
                                                        @foreach ($asignacion as $asig)
                                                            {{ $asig->inspector->name }}{{ !$loop->last ? ' - ' : '' }}
                                                            <!-- Mostrar nombres de inspectores -->
                                                        @endforeach
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
            @endif
        </x-table-talleresinspectores>
    </div>

    <!-- Modal para asignar inspectores -->
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">Agregar Inspector al Taller</x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-jet-label value="Taller:" />
                    <select wire:model="taller_id" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                        <option value="">Seleccione</option>
                        @foreach ($talleres as $taller)
                            <option value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="taller_id" />
                </div>
                <div class="flex items-center">
                    <div>
                        <x-jet-label value="Inspector:" />
                        <select wire:model="inspector_id"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                            <option value="">Seleccione</option>
                            @foreach ($inspectores as $inspector)
                                <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="inspector_id" />
                    </div>
                    <div class="ml-2">
                        <x-jet-label value="Carrito:" />
                        <button wire:click="addInspectorToCart"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Inspectores seleccionados -->
            @if ($taller_id && count($selectedInspectors) > 0)
                <div class="mt-4">
                    @foreach ($selectedInspectors as $inspectorId)
                        @php
                            $inspector = $inspectores->find($inspectorId);
                        @endphp
                        <div class="flex justify-between items-center border-b border-gray-200 py-2">
                            <p>{{ $inspector->name }}</p>
                            <button wire:click="removeInspector({{ $inspectorId }})"
                                class="text-red-500 hover:underline">Eliminar</button>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showModal',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button loading:attribute="disabled" wire:click="confirmAddition" wire:target="confirmAddition">
                Guardar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
