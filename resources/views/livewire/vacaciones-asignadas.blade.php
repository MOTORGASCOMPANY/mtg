<div class="container mx-auto mt-8">
    <div class="block justify-center mt-2 pt-8 max-h-max pb-8">
        <h1 class="text-center text-xl my-2 font-bold text-indigo-600">ASIGNAR VACACIONES</h1>

        {{--
        <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-md my-4">
            <div class="bg-indigo-200 rounded-lg py-4 grid grid-cols-1 gap-8 justify-center">
                <div class="flex items-center">
                    <div class="ml-60 text-center">
                        <x-jet-label value="Seleccione Usuario:" for="usuario" />
                    </div>
                    <div class="ml-2">
                        <select wire:model="selectedUser"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full">
                            <option value="">Seleccione</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->empleado->id }}">{{ $usuario->empleado->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-jet-input-error for="selectedUser" />
                </div>
            </div>
        </div>
        --}}

        
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
</div>
