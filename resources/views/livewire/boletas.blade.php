<div class="container mx-auto mt-8">
    <div class="block justify-center mt-2 pt-8 max-h-max pb-8">
        <h1 class="text-center text-xl my-2 font-bold text-indigo-600"> REALIZAR BOLETA</h1>

        <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-md my-4">
            <div class="bg-indigo-200 rounded-lg py-4  grid grid-cols-1 gap-8 justify-center">
                <div class="flex items-center">
                    <div class="ml-60 text-center">
                        <x-jet-label value="Seleccione Taller:" for="idTaller" />
                    </div>
                    <div class="ml-2">
                        <select wire:model="idTaller" wire:change="seleccionarTaller()"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full">
                            <option value="0">Seleccione</option>
                            @foreach ($talleres as $taller)
                                <option value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-jet-input-error for="idTaller" />
                </div>
            </div>
        </div>

        @if ($mostrarCampos)
            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                <div class="grid grid-cols-1">

                    <div class="mb-6 px-8 py-2">
                        <div class="flex items-center justify-between bg-gray-400 py-4 px-6 rounded-t-lg">
                            <span class="text-lg font-semibold text-white dark:text-gray-400">Datos de la Boleta</span>
                        </div>
                        <div class="mb-6 px-8 py-2">
                            <div class="grid grid-cols-3 gap-4 py-2">
                                <div>
                                    <x-jet-label value="Fecha Inicio:" />
                                    <x-jet-input type="date"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="fechaInicio" />
                                    <x-jet-input-error for="fechaInicio" />
                                </div>
                                <div>
                                    <x-jet-label value="Fecha Fin:" />
                                    <x-jet-input type="date"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="fechaFin" />
                                    <x-jet-input-error for="fechaFin" />
                                </div>
                                <div>
                                    <x-jet-label value="Monto:" />
                                    <x-jet-input type="number"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full"
                                        wire:model="monto" />
                                    <x-jet-input-error for="monto" />
                                </div>
                            </div>
                            <div>
                                <x-jet-label value="Observación:" />
                                <x-textarea
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    wire:model="observacion" style="height: 200px;" />
                                <x-jet-input-error for="observacion" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                    <div>
                        <button wire:click="guardar" wire:loading.attr="disabled" wire.target="guardar"
                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                            <p class="text-sm font-medium leading-none text-white">
                                <span wire:loading wire:target="guardar">
                                    <i class="fas fa-spinner animate-spin"></i>
                                    &nbsp;
                                </span>
                                &nbsp;Guardar
                            </p>
                        </button>
                        {{-- 
                        <a href="{{ route('ListaBoletas') }}"
                            class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-red-400 hover:bg-red-500 focus:outline-none rounded">
                            <p class="text-sm font-medium leading-none text-white">
                                <i class="fas fa-archive"></i>&nbsp;Finalizar
                            </p>
                        </a>
                        --}}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
