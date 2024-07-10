<div class="block justify-center mt-4 pt-8 max-h-max pb-8">
    <h1 class="text-center text-xl my-4 font-bold text-indigo-900"> REALIZAR SERVICIO DE CARTA ACLARATORIA</h1>
    <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4">
        <div class="bg-indigo-200 rounded-lg py-4 px-2 grid grid-cols-1 gap-8 sm:grid-cols-1">
            <div class="flex items-center justify-center">
                <x-jet-label value="Material:" class="mr-2" />
                <select wire:model="material"
                    class="bg-gray-50 border-indigo-500 rounded-md outline-none ml-1 block w-1/3"
                    wire:loading.attr="disabled">
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

                <div class="max-w-5xl m-auto rounded-lg shadow-md my-4">
                    <div class="flex items-center justify-between bg-gray-400 py-4 px-6 rounded-t-lg">
                        <span class="text-lg font-semibold text-white dark:text-gray-400">Datos de la Carta Aclaratoria</span>
                    </div>
                    <div class="bg-white mb-6 px-8 py-2 rounded-lg">
                        <div class="grid grid-cols-3 gap-4 py-2">
                            <div>
                                <x-jet-label value="Titulo:" />
                                <x-jet-input type="text" wire:model="titulo"
                                    class="bg-gray-50 rounded-md outline-none block w-full" />
                                <x-jet-input-error for="titulo" />
                            </div>
                            <div>
                                <x-jet-label value="Partida:" />
                                <x-jet-input type="text" wire:model="partida"
                                    class="bg-gray-50 rounded-md outline-none block w-full" />
                                <x-jet-input-error for="partida" />
                            </div>
                            <div>
                                <x-jet-label value="Placa:" />
                                <x-jet-input type="text" wire:model="placa"
                                    class="bg-gray-50 rounded-md outline-none block w-full" />
                                <x-jet-input-error for="placa" />
                            </div>
                        </div>
                        <div class="mt-2"></div>

                        @if ($material == 1 || $material == 3)
                            <!-- DICE -->
                            <div>
                                <div class="flex items-center space-x-2">
                                    <x-jet-label value="DICE:" />
                                    <a wire:click="addData"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-indigo-300 font-bold text-white cursor-pointer hover:bg-indigo-400 hover:animate-pulse">
                                        <i class="fa-sharp fa-solid fa-plus"></i>
                                        <span
                                            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                                            Agregar
                                        </span>
                                    </a>
                                </div>

                                <div>
                                    @foreach ($diceData as $index => $data)
                                        <div class="flex items-center gap-4 mt-2">
                                            <div class="flex-1">
                                                <x-jet-input type="text" placeholder="Numero"
                                                    wire:model="diceData.{{ $index }}.numero"
                                                    class="bg-gray-50 rounded-md outline-none block w-full" />
                                                <x-jet-input-error for="diceData.{{ $index }}.numero" />
                                            </div>
                                            <div class="flex-1">
                                                <x-jet-input type="text" placeholder="Titulo"
                                                    wire:model="diceData.{{ $index }}.titulo"
                                                    class="bg-gray-50 rounded-md outline-none block w-full" list="items"/>
                                                    <datalist id="items">
                                                        <option value="Combustible">Combustible</option>
                                                        <option value="Peso neto (kg)">Peso neto (kg)</option>
                                                        <option value="Peso bruto (kg)">Peso bruto (kg)</option>
                                                        <option value="Carga útil (kg)">Carga útil (kg)</option>
                                                    </datalist>
                                                <x-jet-input-error for="diceData.{{ $index }}.titulo" />
                                                
                                            </div>
                                            <div class="flex-1">
                                                <x-jet-input type="text" placeholder="Descripcion"
                                                    wire:model="diceData.{{ $index }}.descripcion"
                                                    class="bg-gray-50 rounded-md outline-none block w-full" />
                                                <x-jet-input-error for="diceData.{{ $index }}.descripcion" />
                                            </div>
                                            <div class="ml-4">
                                                <button wire:click="removeDiceData({{ $index }})"
                                                    class="group flex py-2 px-2 text-center items-center rounded-md bg-red-500 font-bold text-white cursor-pointer hover:bg-red-700 hover:animate-pulse">
                                                    <i class="fas fa-times-circle"></i>
                                                    <span
                                                        class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute translate-y-full opacity-0 m-4 mx-auto z-50">
                                                        Eliminar
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            <!-- DEBE DECIR -->
                            <div>
                                <div class="flex items-center space-x-2 mt-2">
                                    <x-jet-label value="DEBE DECIR:" />
                                    {{--
                                    <a wire:click="addDebeDecirData"
                                        class="group flex py-2 px-2 text-center items-center rounded-md bg-indigo-300 font-bold text-white cursor-pointer hover:bg-indigo-400 hover:animate-pulse">
                                        <i class="fa-sharp fa-solid fa-plus"></i>
                                        <span
                                            class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                                            Agregar
                                        </span>
                                    </a>
                                    --}}
                                </div>

                                <div>
                                    @foreach ($debeDecirData as $index => $data)
                                        <div class="flex items-center gap-4 mt-2">
                                            <div class="flex-1">
                                                <x-jet-input type="text" placeholder="Numero"
                                                    wire:model="debeDecirData.{{ $index }}.numero"
                                                    class="bg-gray-50 rounded-md outline-none block w-full" />
                                                <x-jet-input-error for="debeDecirData.{{ $index }}.numero" />
                                            </div>
                                            <div class="flex-1">
                                                <x-jet-input type="text" placeholder="Titulo"
                                                    wire:model="debeDecirData.{{ $index }}.titulo"
                                                    class="bg-gray-50 rounded-md outline-none block w-full" list="items"/>
                                                    <datalist id="items">
                                                        <option value="Combustible">Combustible</option>
                                                        <option value="Peso neto (kg)">Peso neto (kg)</option>
                                                        <option value="Peso bruto (kg)">Peso bruto (kg)</option>
                                                        <option value="Carga útil (kg)">Carga útil (kg)</option>
                                                    </datalist>
                                                <x-jet-input-error for="debeDecirData.{{ $index }}.titulo" />
                                            </div>
                                            <div class="flex-1">
                                                <x-jet-input type="text" placeholder="Descripcion"
                                                    wire:model="debeDecirData.{{ $index }}.descripcion"
                                                    class="bg-gray-50 rounded-md outline-none block w-full" />
                                                <x-jet-input-error for="debeDecirData.{{ $index }}.descripcion" />
                                            </div>
                                            <div class="ml-4">
                                                <button wire:click="removeDebeDecirData({{ $index }})"
                                                    class="group flex py-2 px-2 text-center items-center rounded-md bg-red-500 font-bold text-white cursor-pointer hover:bg-red-700 hover:animate-pulse">
                                                    <i class="fas fa-times-circle"></i>
                                                    <span
                                                        class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute translate-y-full opacity-0 m-4 mx-auto z-50">
                                                        Eliminar
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>


                            </div>

                            <div class="mt-4"></div>
                        @endif

                        @if ($material == 4)
                            <div>
                                <x-jet-label value="Dice Modificación:" />
                                <x-textarea
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    wire:model="diceModificacion" style="height: 130px;" />
                                <x-jet-input-error for="diceModificacion" />
                            </div>
                            <div>
                                <x-jet-label value="Debe Decir Modificación:" />
                                <x-textarea
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    wire:model="debeDecirModificacion" style="height: 130px;" />
                                <x-jet-input-error for="debeDecirModificacion" />
                            </div>
                        @endif
                    </div>
                </div>

                <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                    <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                        <div>
                            <button wire:click="certificarta" wire:loading.attr="disabled" wire.target="certificarta"
                                class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                <p class="text-sm font-medium leading-none text-white">
                                    <span wire:loading wire:target="certificarta">
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

                            <a href="{{ route('ServicioCarta') }}"
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
