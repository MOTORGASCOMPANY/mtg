<div class="block justify-center mt-12 pt-8 max-h-max pb-8">
    <h1 class="text-center text-xl my-4 font-bold text-indigo-900"> REALIZAR NUEVO SERVICIO</h1>

    {{-- DIV PARA SELECCIONAR TALLER Y TIPO DE SERVICIO --}}
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
                <x-jet-label value="Servicio:" />
                <select wire:model="servicio" class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                    wire:loading.attr="disabled" wire:target="taller">
                    @if (isset($servicios))
                        <option value="">Seleccione </option>
                        @foreach ($servicios as $item)
                            <option value="{{ $item->id }}">{{ $item->tipoServicio->descripcion }}</option>
                        @endforeach
                    @else
                        <option value="">Seleccione un taller</option>
                    @endif
                </select>
                <x-jet-input-error for="serv" />
            </div>

        </div>
    </div>

    @if ($servicio)
        @switch($tipoServicio->id)
            @case(1)
                {{-- DIV PARA EL NUMERO DE FORMATO SUGERIDO --}}
                <x-formato-sugerido />
                @livewire('form-vehiculo', ['tipoServicio' => $tipoServicio])

                @if ($estado)
                    @switch($estado)
                        @case('esperando')
                            <div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300 p-4 mt-4">
                                <x-jet-label value="Fotos reglamentarias:" class="font-bold text-xl py-4" />
                                <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" acceptedFileTypes="['image/*',]"
                                    aceptaVarios="true">

                                </x-file-pond>
                                <x-jet-input-error for="imagenes" />
                            </div>
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                                    <div>
                                        <x-jet-input type="date" class="" wire:model="fechaCertificacion" />
                                        <x-jet-input-error for="fechaCertificacion" />
                                    </div>
                                    <div class="w-full md:w-2/6 flex justify-center items-center">                                        
                                        <x-jet-input type="checkbox" wire:model="serviexterno" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                                        <x-jet-label value="Externo" class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                                        <x-jet-input-error for="serviexterno" />
                                    </div>
                                    <div>
                                        <button wire:click="certificar" wire:loading.attr="disabled" wire.target="certificar"
                                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                            <p class="text-sm font-medium leading-none text-white">
                                                <span wire:loading wire:target="certificar">
                                                    <i class="fas fa-spinner animate-spin"></i>
                                                    &nbsp;
                                                </span>
                                                &nbsp;Certificar
                                            </p>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{--
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-row justify-evenly items-center">
                                    <button wire:click="certificar" wire:loading.attr="disabled" wire.target="certificar"
                                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                        <p class="text-sm font-medium leading-none text-white">
                                            <span wire:loading wire:target="certificar">
                                                <i class="fas fa-spinner animate-spin"></i>
                                                &nbsp;
                                            </span>
                                            &nbsp;Certificar
                                        </p>
                                    </button>
                                </div>
                            </div>
                            --}}
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
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                        <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                            rel="noopener noreferrer"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                @endif
                                                <i class="fas fa-download"></i>
                                                <span>desc. Certificado</span>
                                                </a>
                                                @if ($certificacion->Servicio->tipoServicio->id == 1)
                                                    <a href="{{ route('preConversionGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Preconversion.</span>
                                                    </a>
                                                @endif
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaVistaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaDescargaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-download"></i>
                                                        <span>desc. Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ route('checkListArribaGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Arriba</span>
                                                    </a>
                                                    <a href="{{ route('checkListAbajoGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-b-md justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Abajo</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="{{ route('servicio') }}"
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
            @break

            @case(2)
                <x-formato-sugerido />
                @livewire('form-vehiculo', ['tipoServicio' => $tipoServicio])
                @if ($estado)
                    @switch($estado)
                        @case('esperando')
                            <div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300 p-4 mt-4">
                                <x-jet-label value="Fotos reglamentarias:" class="font-bold text-xl py-4" />
                                <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" acceptedFileTypes="['image/*',]"
                                    aceptaVarios="true">
                                </x-file-pond>
                                <x-jet-input-error for="imagenes" />
                            </div>
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                                    <div>
                                        <x-jet-input type="date" class="" wire:model="fechaCertificacion" />
                                        <x-jet-input-error for="fechaCertificacion" />
                                    </div>
                                    <div class="w-full md:w-2/6 flex justify-center items-center">                                        
                                        <x-jet-input type="checkbox" wire:model="serviexterno" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                                        <x-jet-label value="Externo" class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                                        <x-jet-input-error for="serviexterno" />
                                    </div>
                                    <div>
                                        <button wire:click="certificar" wire:loading.attr="disabled" wire.target="certificar"
                                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                            <p class="text-sm font-medium leading-none text-white">
                                                <span wire:loading wire:target="certificar">
                                                    <i class="fas fa-spinner animate-spin"></i>
                                                    &nbsp;
                                                </span>
                                                &nbsp;Certificar
                                            </p>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{--
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-row justify-evenly items-center">
                                    <button wire:click="certificar" wire:loading.attr="disabled" wire.target="certificar"
                                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                        <p class="text-sm font-medium leading-none text-white">
                                            <span wire:loading wire:target="certificar">
                                                <i class="fas fa-spinner animate-spin"></i>
                                                &nbsp;
                                            </span>
                                            &nbsp;Certificar
                                        </p>
                                    </button>
                                </div>
                            </div>
                            --}}
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
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                        <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                            rel="noopener noreferrer"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                @endif
                                                <i class="fas fa-download"></i>
                                                <span>desc. Certificado</span>
                                                </a>
                                                @if ($certificacion->Servicio->tipoServicio->id == 1)
                                                    <a href="{{ route('preConversionGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Preconversion.</span>
                                                    </a>
                                                @endif
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaVistaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaDescargaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-download"></i>
                                                        <span>desc. Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ route('checkListArribaGnv', [$certificacion->id]) }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Arriba</span>
                                                    </a>
                                                    <a href="{{ route('checkListAbajoGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-b-md justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Abajo</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="{{ route('servicio') }}"
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
            @break

            @case(3)
                <x-formato-sugerido />
                @livewire('vehiculo.create-vehiculo-glp', ['tipoServicio' => $tipoServicio])

                @if ($estado)
                    @switch($estado)
                        @case('esperando')
                            <div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300 p-4 mt-4">
                                <x-jet-label value="Fotos reglamentarias:" class="font-bold text-xl py-4" />
                                <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" acceptedFileTypes="['image/*',]"
                                    aceptaVarios="true">

                                </x-file-pond>
                                <x-jet-input-error for="imagenes" />
                            </div>

                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">                                    
                                    <div>
                                        <select wire:model="tallerAuto"
                                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                                            <option value="">Seleccione Taller Autorizado</option>
                                            @foreach ($talleres as $taller2)
                                                @if (in_array($taller2->id, [16, 13, 9, 42, 5, 23, 38, 30, 74, 20, 88, 89, 78, 46, 73, 27]))
                                                    <option value="{{ $taller2->id }}">{{ $taller2->nombre }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for="tallerAuto" />
                                    </div>
                                </div>
                                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                                    <div >
                                        <x-jet-input type="date" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full " wire:model="fechaCertificacion" />
                                        <x-jet-input-error for="fechaCertificacion" />
                                    </div>
                                    <div class="w-full md:w-2/6 flex justify-center items-center">                                        
                                        <x-jet-input type="checkbox" wire:model="serviexterno" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                                        <x-jet-label value="Externo" class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                                        <x-jet-input-error for="serviexterno" />
                                    </div>
                                    <div class="my-2 flex flex-row justify-evenly items-center">
                                        <button wire:click="certificarGlp" wire:loading.attr="disabled" wire.target="certificar"
                                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                            <p class="text-sm font-medium leading-none text-white">
                                                <span wire:loading wire:target="certificarGlp">
                                                    <i class="fas fa-spinner animate-spin"></i>
                                                    &nbsp;
                                                </span>
                                                &nbsp;Certificar
                                            </p>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            {{--
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-row justify-evenly items-center">
                                    <button wire:click="certificarGlp" wire:loading.attr="disabled" wire.target="certificar"
                                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                        <p class="text-sm font-medium leading-none text-white">
                                            <span wire:loading wire:target="certificarGlp">
                                                <i class="fas fa-spinner animate-spin"></i>
                                                &nbsp;
                                            </span>
                                            &nbsp;Certificar
                                        </p>
                                    </button>
                                </div>
                            </div>
                            --}}
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
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                        <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                            rel="noopener noreferrer"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                @endif
                                                <i class="fas fa-download"></i>
                                                <span>desc. Certificado</span>
                                                </a>
                                                @if ($certificacion->Servicio->tipoServicio->id == 1)
                                                    <a href="{{ route('preConversionGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Preconversion.</span>
                                                    </a>
                                                @endif
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaVistaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaDescargaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-download"></i>
                                                        <span>desc. Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ route('checkListArribaGnv', [$certificacion->id]) }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Arriba</span>
                                                    </a>
                                                    <a href="{{ route('checkListAbajoGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-b-md justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Abajo</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="{{ route('servicio') }}"
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
            @break

            @case(4)
                <x-formato-sugerido />
                @livewire('vehiculo.create-vehiculo-glp', ['tipoServicio' => $tipoServicio])

                @if ($estado)
                    @switch($estado)
                        @case('esperando')
                            <div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300 p-4 mt-4">
                                <x-jet-label value="Fotos reglamentarias:" class="font-bold text-xl py-4" />
                                <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" acceptedFileTypes="['image/*',]"
                                    aceptaVarios="true">

                                </x-file-pond>
                                <x-jet-input-error for="imagenes" />
                            </div>
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">                                    
                                    <div>
                                        <select wire:model="tallerAuto" 
                                            class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                                            <option value="">Seleccione Taller Autorizado</option>
                                            @foreach ($talleres as $taller2)
                                                @if (in_array($taller2->id, [16, 13, 9, 42, 5, 23, 38, 30, 74, 20, 88, 89, 78, 46, 73, 27]))
                                                    <option value="{{ $taller2->id }}">{{ $taller2->nombre }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for="tallerAuto" />
                                    </div>
                                </div>
                                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                                    <div >
                                        <x-jet-input type="date" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full " wire:model="fechaCertificacion" />
                                        <x-jet-input-error for="fechaCertificacion" />
                                    </div>
                                    <div class="w-full md:w-2/6 flex justify-center items-center">                                        
                                        <x-jet-input type="checkbox" wire:model="serviexterno" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                                        <x-jet-label value="Externo" class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                                        <x-jet-input-error for="serviexterno" />
                                    </div>
                                    <div>
                                        <button wire:click="certificarGlp" wire:loading.attr="disabled" wire.target="certificar"
                                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                            <p class="text-sm font-medium leading-none text-white">
                                                <span wire:loading wire:target="certificarGlp">
                                                    <i class="fas fa-spinner animate-spin"></i>
                                                    &nbsp;
                                                </span>
                                                &nbsp;Certificar
                                            </p>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{--
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-row justify-evenly items-center">
                                    <button wire:click="certificarGlp" wire:loading.attr="disabled" wire.target="certificar"
                                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                        <p class="text-sm font-medium leading-none text-white">
                                            <span wire:loading wire:target="certificarGlp">
                                                <i class="fas fa-spinner animate-spin"></i>
                                                &nbsp;
                                            </span>
                                            &nbsp;Certificar
                                        </p>
                                    </button>
                                </div>
                            </div>
                            --}}
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
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                        <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                            rel="noopener noreferrer"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                @endif
                                                <i class="fas fa-download"></i>
                                                <span>desc. Certificado</span>
                                                </a>
                                                @if ($certificacion->Servicio->tipoServicio->id == 1)
                                                    <a href="{{ route('preConversionGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Preconversion.</span>
                                                    </a>
                                                @endif
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaVistaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaDescargaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-download"></i>
                                                        <span>desc. Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ route('checkListArribaGnv', [$certificacion->id]) }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Arriba</span>
                                                    </a>
                                                    <a href="{{ route('checkListAbajoGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-b-md justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Abajo</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="{{ route('servicio') }}"
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
            @break

            @case(5)
                <x-formato-sugerido />
                @livewire('form-modificacion', ['tipoServicio' => $tipoServicio])

                @if ($estado)
                    @switch($estado)
                        @case('esperando')
                            <div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300 p-4 mt-4">
                                <x-jet-label value="Fotos reglamentarias:" class="font-bold text-xl py-4" />
                                <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" acceptedFileTypes="['image/*',]"
                                    aceptaVarios="true">

                                </x-file-pond>
                                <x-jet-input-error for="imagenes" />
                            </div>

                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                                    <div>
                                        <x-jet-input type="date" class="" wire:model="fechaCertificacion" />
                                        <x-jet-input-error for="fechaCertificacion" />
                                    </div>
                                    <div class="w-full md:w-2/6 flex justify-center items-center">                                        
                                        <x-jet-input type="checkbox" wire:model="serviexterno" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                                        <x-jet-label value="Externo" class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                                        <x-jet-input-error for="serviexterno" />
                                    </div>
                                    <div>
                                        <button wire:click="certificarmodi" wire:loading.attr="certificarmodi"
                                            wire.target="certificarmodi"
                                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                            <p class="text-sm font-medium leading-none text-white">
                                                <span wire:loading wire:target="certificarmodi">
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
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                        <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                            rel="noopener noreferrer"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                @endif
                                                <i class="fas fa-download"></i>
                                                <span>desc. Certificado</span>
                                                </a>

                                            </div>
                                        </div>

                                        <a href="{{ route('servicio') }}"
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
            @break

            @case(6)
                @livewire('servicio-desmonte', ['servicio' => $servicio, 'taller' => $this->taller])
            @break

            @case(7)
                @livewire('activacion-de-chips', ['tipoServicio' => $tipoServicio, 'idTaller' => $this->taller])
            @break

            @case(8)
                <x-formato-sugerido />
                @if (!$certificado)
                    <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4 px-8 flex flex-row justify-center items-center"
                        id="1215488">
                        <div class="w-4/6 block justify-center items-center space-x-2 md:flex">
                            @if (!$externo)
                                <div class="flex items-center justify-center space-x-2 ">
                                    <x-jet-label value="Placa:" for="placa" />
                                    <x-jet-input type="text" maxlength="7" wire:model="placa"
                                        wire:keydown.enter="buscarCertificacion" />
                                    <x-jet-input-error for="placa" />
                                </div>
                                <div class="pt-2 md:pt-0 flex m-auto w-full justify-center">
                                    <button wire:click="buscarCertificacion" wire:loading.attr="disabled"
                                        wire:target="externo"
                                        class="p-2 bg-indigo-400 rounded-lg border m-auto border-indigo-300 hover:bg-indigo-500 text-white hover:text-gray-200 shadow-lg">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                                <div class="md:pt-2 w-full">
                                    <x-jet-input-error for="placa" />
                                </div>
                            @endif
                            <div class="flex items-center">
                                <input id="checkbox-2" wire:model="externo" type="checkbox"
                                    class="accent-pink-300 border-indigo-300 focus:ring-3 focus:ring-indigo-300 h-4 w-4 rounded" />
                                <label for="checkbox-2" class="text-sm ml-3 font-medium text-gray-900">Dupl.Externo</label>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($externo)
                    @livewire('form-vehiculo', ['tipoServicio' => $tipoServicio])
                    <div
                        class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4 px-8 flex flex-row justify-center items-center ">
                        <div class="w-full block justify-center items-center space-x-2 md:flex">

                            <div class="flex items-center w-full mb-0 sm: mb-2 ">
                                <x-jet-label value="Servicio:" for="servicioExterno" />
                                <select wire:model="servicioExterno"
                                    class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full -mr-2">
                                    <option value="0">Seleccione</option>
                                    <option value="1">Conversión a GNV</option>
                                    <option value="2">Inspeccion anual GNV</option>
                                </select>

                            </div>
                            <div class="flex items-center w-full mb-0 sm: mb-2 ">
                                <x-jet-label value="Taller:" for="tallerExterno" />
                                <x-jet-input type="text" wire:model="tallerExterno" class="w-full" />

                            </div>
                            <div class="flex items-center w-full mb-0 sm: mb-2">
                                <x-jet-label value="Fecha:" for="fecha" />
                                <x-jet-input type="date" wire:model="fechaExterno" class="w-full" />

                            </div>
                        </div>


                    </div>
                    <div class="w-full block items-center text-center">
                        <x-jet-input-error for="servicioExterno" />
                        <x-jet-input-error for="tallerExterno" />
                        <x-jet-input-error for="fechaExterno" />
                    </div>
                @else
                    @if ($certificado)
                        <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4">
                            <div class="c-card block bg-white shadow-md rounded-lg overflow-hidden">
                                <div class="p-4">
                                    <span
                                        class="inline-block px-2 py-1 leading-none bg-amber-200 text-amber-800 rounded-full font-semibold  tracking-wide text-xs">
                                        {{ $certificado->Servicio->tipoServicio->descripcion }}
                                    </span>

                                    <div class="my-2 flex flex row justify-between pr-4">
                                        <h2 class=" font-bold">
                                            <i class="fas fa-car"></i> &nbsp; <span
                                                class="text-indigo-600">{{ $certificado->Vehiculo->placa }}</span>
                                        </h2>
                                        <p class=" font-bold">
                                            <i class="fas fa-file"></i>&nbsp;
                                            <span class="text-red-500 font-bold">{{ $certificado->serieFormato }} -
                                                {{ $certificado->Hoja->añoActivo }}</span>
                                        </p>
                                    </div>

                                    <h3>
                                        <i class="my-2 fas fa-warehouse"></i> &nbsp;{{ $certificado->Taller->nombre }}
                                    </h3>

                                </div>
                                <div class="p-4 border-t  text-xs text-gray-700">
                                    <span class="flex items-center">
                                        <i class="far fa-address-card fa-fw text-gray-900 mr-2"></i>
                                        {{ $certificado->Inspector->name }}
                                    </span>
                                    <span class="flex items-center mb-1">
                                        <i class="far fa-clock fa-fw mr-2 text-gray-900"></i>
                                        @if (isset($fechaCerti))
                                            @if ($fechaCerti > 1)
                                                certificado hace {{ $fechaCerti }} días.
                                            @else
                                                certificado hace {{ $fechaCerti }} día.
                                            @endif
                                        @endif
                                    </span>

                                </div>
                                <div class="p-2 border-t flex items-center justify-center ">
                                    <i class="fas fa-times-circle fa-2x hover:cursor-pointer hover: shadow-lg rounded-full text-red-400 hover:text-red-500 hover:shadow-sm hover:shadow-red-500"
                                        wire:click="reseteaBusquedaCert"></i>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($estado)
                    @switch($estado)
                        @case('esperando')
                            {{--
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-row justify-evenly items-center">
                                    <a wire:click="duplicarCertificado"
                                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                        <p class="text-sm font-medium leading-none text-white"><i class="far fa-copy"></i>
                                            &nbsp;Duplicar</p>
                                    </a>
                                </div>
                            </div>
                            --}}
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                                    <div class="w-full md:w-2/6 flex justify-center items-center">                                        
                                        <x-jet-input type="checkbox" wire:model="serviexterno" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                                        <x-jet-label value="Externo" class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                                        <x-jet-input-error for="serviexterno" />
                                    </div>
                                    <div>
                                        <a wire:click="duplicarCertificado"
                                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                        <p class="text-sm font-medium leading-none text-white"><i class="far fa-copy"></i>
                                            &nbsp;Duplicar</p>
                                    </a>
                                    </div>
                                </div>
                            </div>
                        @break

                        @case('certificado')
                            @if ($certificacion)
                                <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                    <div class="my-2 flex flex-row justify-evenly items-center">
                                        <a href="{{ $certificacion->rutaVistaCertificado }}" target="__blank"
                                            rel="noopener noreferrer"
                                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                            <p class="text-sm font-medium leading-none text-white"><i class="far fa-eye"></i>
                                                &nbsp;Ver Certificado</p>
                                        </a>


                                        <a href="{{ route('servicio') }}"
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
            @break

            @case(9)
                <div
                    class="max-w-5xl m-auto bg-indigo-300 rounded-lg shadow-md my-4 py-4 px-8 flex flex-row justify-center items-center">
                    <div class="items-center">
                        <h1 class="font-bold">Este servicio aún no esta disponible pero estamos trabajando en ello. 🤝</h1>
                    </div>
                </div>
            @break

            @case(10)
                <x-formato-sugerido />
                @livewire('form-vehiculo', ['tipoServicio' => $tipoServicio])

                @if ($estado)
                    @switch($estado)
                        @case('esperando')
                            <div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300 p-4 mt-4">
                                <x-jet-label value="Fotos reglamentarias:" class="font-bold text-xl py-4" />
                                <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" acceptedFileTypes="['image/*',]"
                                    aceptaVarios="true">
                                </x-file-pond>
                                <x-jet-input-error for="imagenes" />
                            </div>
                            {{--
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-row justify-evenly items-center">
                                    <button wire:click="certificarConChip" wire:loading.attr="disabled"
                                        wire.target="certificarConChip"
                                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                        <p class="text-sm font-medium leading-none text-white">
                                            <span wire:loading wire:target="certificar">
                                                <i class="fas fa-spinner animate-spin"></i>
                                                &nbsp;
                                            </span>
                                            &nbsp;Certificar
                                        </p>
                                    </button>
                                </div>
                            </div>
                            --}}
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                                    <div class="w-full md:w-2/6 flex justify-center items-center">                                        
                                        <x-jet-input type="checkbox" wire:model="serviexterno" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                                        <x-jet-label value="Externo" class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                                        <x-jet-input-error for="serviexterno" />
                                    </div>
                                    <div>
                                        <button wire:click="certificarConChip" wire:loading.attr="disabled"
                                        wire.target="certificarConChip"
                                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                        <p class="text-sm font-medium leading-none text-white">
                                            <span wire:loading wire:target="certificar">
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
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                        <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                            rel="noopener noreferrer"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                @endif
                                                <i class="fas fa-download"></i>
                                                <span>desc. Certificado</span>
                                                </a>
                                                @if ($certificacion->Servicio->tipoServicio->id == 1 || $certificacion->Servicio->tipoServicio->id == 10)
                                                    <a href="{{ route('preConversionGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Preconversion.</span>
                                                    </a>
                                                @endif
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaVistaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaDescargaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-download"></i>
                                                        <span>desc. Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ route('checkListArribaGnv', [$certificacion->id]) }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Arriba</span>
                                                    </a>
                                                    <a href="{{ route('checkListAbajoGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-b-md justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Abajo</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="{{ route('servicio') }}"
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
            @break

            @case(11)
                @livewire('chip-por-deterioro', ['taller' => $this->taller, 'servicio' => $this->servicio])
                {{--
                @if ($estado)
                    @switch($estado)
                        @case('esperando')
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-row justify-evenly items-center">
                                    <button wire:click="" wire:loading.attr="disabled"
                                        wire.target=""
                                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                        <p class="text-sm font-medium leading-none text-white">
                                            <span wire:loading wire:target="">
                                                <i class="fas fa-spinner animate-spin"></i>
                                                &nbsp;
                                            </span>
                                            &nbsp;Certificar
                                        </p>
                                    </button>
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
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                        <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                            rel="noopener noreferrer"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                @endif
                                                <i class="fas fa-download"></i>
                                                <span>desc. Certificado</span>
                                                </a>
                                                @if ($certificacion->Servicio->tipoServicio->id == 1)
                                                    <a href="{{ route('preConversionGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Preconversion.</span>
                                                    </a>
                                                @endif
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaVistaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaDescargaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-download"></i>
                                                        <span>desc. Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ route('checkListArribaGnv', [$certificacion->id]) }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Arriba</span>
                                                    </a>
                                                    <a href="{{ route('checkListAbajoGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-b-md justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Abajo</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="{{ route('servicio') }}"
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
                --}}
            @break

            @case(12)
                <x-formato-sugerido />
                @livewire('vehiculo.create-vehiculo', ['tipoServicio' => $tipoServicio])
                @if ($estado)
                    @switch($estado)
                        @case('esperando')
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
                                    <div>
                                        <x-jet-input type="date" class="" wire:model="fechaCertificacion" />
                                        <x-jet-input-error for="fechaCertificacion" />
                                    </div>
                                    <div class="w-full md:w-2/6 flex justify-center items-center">                                        
                                        <x-jet-input type="checkbox" wire:model="serviexterno" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                                        <x-jet-label value="Externo" class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                                        <x-jet-input-error for="serviexterno" />
                                    </div>
                                    <div class="my-2 flex flex-row justify-evenly items-center">
                                        <button wire:click="certificarPreconver" wire:loading.attr="disabled"
                                            wire.target="certificarPreconver"
                                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                            <p class="text-sm font-medium leading-none text-white">
                                                <span wire:loading wire:target="certificarPreconver">
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
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                        <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                            rel="noopener noreferrer"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                @endif
                                                <i class="fas fa-download"></i>
                                                <span>desc. Certificado</span>
                                                </a>
                                                @if ($certificacion->Servicio->tipoServicio->id == 1)
                                                    <a href="{{ route('preConversionGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Preconversion.</span>
                                                    </a>
                                                @endif
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaVistaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaDescargaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-download"></i>
                                                        <span>desc. Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ route('checkListArribaGnv', [$certificacion->id]) }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Arriba</span>
                                                    </a>
                                                    <a href="{{ route('checkListAbajoGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-b-md justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Abajo</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="{{ route('servicio') }}"
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
            @break

            @case(13)
                <x-formato-sugerido />
                @livewire('vehiculo.create-vehiculo', ['tipoServicio' => $tipoServicio])
                @if ($estado)
                    @switch($estado)
                        @case('esperando')
                            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                                <div class="my-2 flex flex-row justify-evenly items-center">
                                    <div>
                                        <x-jet-input type="date" class="" wire:model="fechaCertificacion" />
                                        <x-jet-input-error for="fechaCertificacion" />
                                    </div>
                                    <div class="w-full md:w-2/6 flex justify-center items-center">                                        
                                        <x-jet-input type="checkbox" wire:model="serviexterno" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                                        <x-jet-label value="Externo" class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                                        <x-jet-input-error for="serviexterno" />
                                    </div>
                                    <button wire:click="certificarPreconverGlp" wire:loading.attr="disabled"
                                        wire.target="certificarPreconverGlp"
                                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                        <p class="text-sm font-medium leading-none text-white">
                                            <span wire:loading wire:target="certificarPreconverGlp">
                                                <i class="fas fa-spinner animate-spin"></i>
                                                &nbsp;
                                            </span>
                                            &nbsp;Certificar
                                        </p>
                                    </button>
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
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                    @else
                                                        <a href="{{ $certificacion->rutaDescargaCertificado }}" target="__blank"
                                                            rel="noopener noreferrer"
                                                            class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between rounded-b-md items-center hover:cursor-pointer">
                                                @endif
                                                <i class="fas fa-download"></i>
                                                <span>desc. Certificado</span>
                                                </a>
                                                @if ($certificacion->Servicio->tipoServicio->id == 1)
                                                    <a href="{{ route('preConversionGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Preconversion.</span>
                                                    </a>
                                                @endif
                                                @if ($certificacion->Servicio->tipoServicio->id != 8)
                                                    <a href="{{ $certificacion->rutaVistaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Ver Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ $certificacion->rutaDescargaFt }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-download"></i>
                                                        <span>desc. Ficha Tec.</span>
                                                    </a>
                                                    <a href="{{ route('checkListArribaGnv', [$certificacion->id]) }}"
                                                        target="__blank" rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Arriba</span>
                                                    </a>
                                                    <a href="{{ route('checkListAbajoGnv', [$certificacion->id]) }}" target="__blank"
                                                        rel="noopener noreferrer"
                                                        class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white rounded-b-md justify-between items-center hover:cursor-pointer">
                                                        <i class="fas fa-eye"></i>
                                                        <span>CheckList Abajo</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="{{ route('servicio') }}"
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
            @break

            @default
            @break

        @endswitch
    @endif


    {{-- Modal Busqueda de Certificaciones --}}
    <x-jet-dialog-modal wire:model="busquedaCert">
        <x-slot name="title">
            <h1 class="text-3xl font-medium">Certificaciones</h1>
        </x-slot>
        <x-slot name="content">
            @if (isset($certificaciones))
                <p class="text-indigo-900">Se encontrarón
                    <span class="px-2 bg-indigo-400 rounded-full">
                        <a class="text-white">{{ $certificaciones->count() }}</a>
                    </span> certificaciones
                </p>
                <div class="my-5">
                    @foreach ($certificaciones as $key => $certi)
                        <div
                            class="flex justify-between items-center border-b border-slate-200 py-3 px-2 border-l-4  border-l-transparent bg-gradient-to-r from-transparent to-transparent hover:border-l-4 hover:border-l-indigo-300  hover:from-slate-100 transition ease-linear duration-150">
                            <div class="inline-flex text-xs items-center space-x-2 md:text-base">
                                <div class="px-1 border-r-2 border-slate-300 ">
                                    <i class="fas fa-file"></i>&nbsp;{{ $certi->serieFormato }}
                                </div>
                                <div class="px-1 border-r-2 border-slate-300">
                                    <i class="fas fa-car"></i>&nbsp;{{ $certi->Vehiculo->placa }}
                                </div>
                                <div class="px-1 border-r-2 border-slate-300">
                                    <i class="fas fa-wrench"></i>&nbsp;<span
                                        class="p-1 bg-green-200 rounded-full">{{ $certi->Servicio->tipoServicio->descripcion }}</span>
                                </div>

                                <div class="px-2 text-xs text-slate-600">
                                    <i class="far fa-calendar-alt"></i> &nbsp;
                                    {{ $certi->created_at->format('d/m/Y  h:m:s') }}
                                </div>
                            </div>
                            <div>
                                <i wire:click="seleccionaCertificacion({{ $key }})"
                                    class="fas fa-plus-circle fa-lg md:fa-2x rounded-full hover: cursor-pointer hover: shadow-lg"
                                    style="color:#6366f1;"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-slate-500 text-center">Selecciona una de estas certificaciones para duplicar
                    certificado.</p>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('busquedaCert',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
