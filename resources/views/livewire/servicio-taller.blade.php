<div class="block justify-center mt-12 pt-8 max-h-max pb-8">
    <h1 class="text-center text-xl my-4 font-bold text-indigo-900"> REALIZAR SERVICIO DE INSPECCION DE TALLER</h1>
    {{-- DIV PARA SELECCIONAR TALLER y TIPO MATERIAL --}}
    <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4">
        <div class=" bg-indigo-200 rounded-lg py-4 px-2 grid grid-cols-1 gap-8 sm:grid-cols-2">
            <div>
                <x-jet-label value="Taller:" />
                <select wire:model="taller"
                    class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                    <option value="">Seleccione</option>
                    @foreach ($talleres as $taller)
                        <option value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="taller" />
            </div>
            <div>
                <x-jet-label value="Material:" />
                <select wire:model="material"
                    class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full "
                    wire:loading.attr="disabled" wire:target="taller">
                    <option value="">Seleccione</option>
                    @foreach ($materiales as $mat)
                        <option value="{{ $mat->id }}">{{ $mat->descripcion }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="material" />
            </div>
        </div>
    </div>
    @if ($estado)
        @switch($estado)
            @case('esperando')
                <div
                    class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4 px-8 flex flex-row justify-between items-center">
                    <div class="w-4/6 items-center">
                        <h1 class="font-bold"><span class="p-1 bg-green-300 rounded-lg">Formato Sugerido:</span></h1>
                    </div>
                    <div>
                        <x-jet-input type="text" wire:model="pertenece" placeholder="# Pertenece" disabled />
                    </div>
                    <div class="w-2/6 flex justify-end">
                        <x-jet-input type="text" wire:model.debounce.500ms="numSugerido" placeholder="# Formato" />
                        <x-jet-input-error for="numSugerido" />
                    </div>
                </div>

                <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                    <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                        <div class="w-full md:w-2/6 flex justify-center items-center">                                        
                            <x-jet-input type="checkbox" wire:model="serviexterno" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                            <x-jet-label value="Inicial" class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                            <x-jet-input-error for="serviexterno" />
                        </div>
                        <div>                            
                            <button wire:click="certificartaller" wire:loading.attr="disabled" wire.target="certificartaller"
                                class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white">
                                    <span wire:loading wire:target="certificartaller">
                                        <i class="fas fa-spinner animate-spin"></i>
                                        &nbsp;
                                    </span>
                                    &nbsp;Certificar
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
            @break

            @case('certificado')
                @if ($certificacion)
                    <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                        <div class="my-2 flex flex-row justify-evenly items-center" x-data="{ menu: false }">
                            <button type="button" x-on:click="menu = ! menu" id="menu-button" aria-expanded="true"
                                aria-haspopup="true" data-te-ripple-init data-te-ripple-color="light"
                                class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-2 bg-indigo-400 text-white hover:bg-indigo-500 focus:outline-none rounded">
                                Documentos &nbsp; <i class="fas fa-angle-down"></i>
                            </button>
                            <div x-show="menu" x-on:click.away="menu = false"
                                class="dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95 absolute  dropdown-content bg-white shadow w-56 z-30 mt-6 border border-slate-800 rounded-md"
                                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="" role="none">
                                    <a href="{{ $certificacion->rutaVistaCertificado }}" target="__blank"
                                        rel="noopener noreferrer"
                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-t-md hover:cursor-pointer">
                                        <i class="fas fa-eye"></i>
                                        <span>Ver Certificado.</span>
                                    </a>
                                </div>
                            </div>

                            <a href="{{ route('ServicioTaller') }}"
                                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-red-400 hover:bg-red-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white">
                                    <i class="fas fa-archive"></i>&nbsp;Finalizar
                                </p>
                            </a>
                        </div>
                    </div>
                @endif
            @break

            @default
        @endswitch
    @endif
</div>
