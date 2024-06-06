<div>
    <button data-tooltip-target="tooltip-dark" type="button" wire:click="$set('addDocument',true)"
        class="group flex py-4 px-4 text-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
        <i class="fa-solid fa-cart-plus"></i>
        <span
            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
            Agregar Vacación
        </span>
    </button>

    <x-jet-dialog-modal wire:model="addDocument">
        <x-slot name="title">
            <h1 class="text-xl font-bold">Asignar Vacaciones</h1>
        </x-slot>
        <x-slot name="content">
            <div>
                <div class="grid grid-cols-2 gap-4 py-1">
                    <div>
                        <x-jet-label value="Vacaciones Disponibles:" />
                        <select wire:model="idVacacion"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full">
                            <option value="">Seleccione</option>
                            @foreach ($vacaciones as $vacacion)
                                <option value="{{ $vacacion->id }}">
                                    {{-- $vacacion->contrato->cargo --}}Días restantes:
                                    {{ $vacacion->dias_restantes }}
                                </option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="idVacacion" />
                    </div>
                    <div>
                        <x-jet-label value="Razón:" />
                        <x-jet-input type="text"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full"
                            wire:model="razon" />
                        <x-jet-input-error for="razon" />
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 py-2">
                    <div>
                        <x-jet-label value="Tipo:" />
                        <x-jet-input type="text"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full " wire:model="tipo"
                            list="items" />
                        <datalist id="items">
                            <option value="VACACION">VACACION</option>
                            <option value="PERMISO">PERMISO</option>
                            <option value="FALTA">FALTA</option>
                        </datalist>
                        <x-jet-input-error for="tipo" />
                    </div>
                    <div>
                        <x-jet-label value="Días Tomados:" />
                        <x-jet-input type="number"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full"
                            wire:model="d_tomados" />
                        <x-jet-input-error for="d_tomados" />
                    </div>
                    <div>
                        <x-jet-label value="Fecha de Inicio:" />
                        <x-jet-input type="date"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full"
                            wire:model="f_inicio" />
                        <x-jet-input-error for="f_inicio" />
                    </div>
                </div>
                <div>
                    <x-jet-label value="Observación:" />
                    <x-textarea class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full"
                        wire:model="observacion" style="height: 100px;" />
                    <x-jet-input-error for="observacion" />
                </div>
                <div class="w-full ml-0 md:w-2/6 flex justify-start items-center">                                        
                    <x-jet-label value="¿Es especial?" class="py-2 ml-2 mr-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer" />
                    <x-jet-input type="checkbox" wire:model="especial" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500 ml-2" />                    
                    <x-jet-input-error for="especial" />
                </div>
                
                {{--
                <div class="py-2">
                    <x-jet-label value="¿Es especial?" />
                    <x-jet-checkbox wire:model="especial" />
                    <x-jet-input-error for="especial" />
                </div>
                --}}

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('addDocument',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button loading:attribute="disabled" wire:click="asignarVacacion" wire:target="asignarVacacion">
                Guardar
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>

    {{--
    <div class="block justify-center mt-2 pt-8 max-h-max pb-8">
        <h1 class="text-center text-xl my-2 font-bold text-indigo-600">ASIGNAR VACACIONES</h1>
        
            <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-md my-4">
                <div class="mb-6 px-8 py-2">
                    <div class="flex items-center justify-between bg-gray-400 py-4 px-6 rounded-t-lg">
                        <span class="text-lg font-semibold text-white">Datos de la Vacación</span>
                    </div>
                    <div class="mb-6 px-8 py-2">
                        <div class="grid grid-cols-2 gap-4 py-2">
                            <div>
                                <x-jet-label value="Vacaciones Disponibles:" />
                                <select wire:model="idVacacion"
                                    class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full">
                                    <option value="">Seleccione</option>
                                    @foreach ($vacaciones as $vacacion)
                                        <option value="{{ $vacacion->id }}">
                                            {{ $vacacion->contrato->cargo }} - Días restantes:
                                            {{ $vacacion->dias_restantes }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-jet-input-error for="idVacacion" />
                            </div>
                            <div>
                                <x-jet-label value="Tipo:" />
                                <x-jet-input type="text"
                                    class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                    wire:model="tipo" list="items" />
                                <datalist id="items">
                                    <option value="VACACION">VACACION</option>
                                    <option value="PERMISO">PERMISO</option>
                                    <option value="FALTA">FALTA</option>
                                </datalist>
                                <x-jet-input-error for="tipo" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 py-2">
                            <div>
                                <x-jet-label value="Razón:" />
                                <x-jet-input type="text"
                                    class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full"
                                    wire:model="razon" />
                                <x-jet-input-error for="razon" />
                            </div>
                            <div>
                                <x-jet-label value="Días Tomados:" />
                                <x-jet-input type="number"
                                    class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full"
                                    wire:model="d_tomados" />
                                <x-jet-input-error for="d_tomados" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 py-2">
                            <div>
                                <x-jet-label value="Fecha de Inicio:" />
                                <x-jet-input type="date"
                                    class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full"
                                    wire:model="f_inicio" />
                                <x-jet-input-error for="f_inicio" />
                            </div>
                            <div>
                                <x-jet-label value="Observación:" />
                                <textarea class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full" wire:model="observacion"></textarea>
                                <x-jet-input-error for="observacion" />
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>

            <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-md my-4 py-4">
                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                    <div>
                        <button wire:click="asignarVacacion" wire:loading.attr="disabled" wire.target="asignarVacacion"
                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                            <p class="text-sm font-medium leading-none text-white">
                                <span wire:loading wire:target="asignarVacacion">
                                    <i class="fas fa-spinner animate-spin"></i>
                                    &nbsp;
                                </span>
                                &nbsp;Asignar Vacación
                            </p>
                        </button>
                    </div>
                </div>
            </div>

    </div>
    --}}
</div>
