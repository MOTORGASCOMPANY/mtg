<div class="block justify-center mt-12 pt-8 max-h-max pb-8">
            <h1 class="text-center text-xl my-4 font-bold text-indigo-900"> REALIZAR SERVICIO MODIFICACION</h1>
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
                        <select wire:model="servicio"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
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
                        <x-jet-input-error for="servicio" />
                    </div>

                </div>
            </div>


            @if ($servicio)
        @switch($tipoServicio->id)           

            @case(5)
                <x-formato-sugerido2 />
                @livewire('form-modificacion', ['tipoServicio' => $tipoServicio, 'nombreDelInvocador' => "servicio-modi"])

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
                                    <div>
                                        <button wire:click="certificarmodificacion" wire:loading.attr="disabled"
                                            wire.target="certificarmodificacion"
                                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                                            <p class="text-sm font-medium leading-none text-white">
                                                <span wire:loading wire:target="certificarmodificacion">
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

                                        <a href="{{ route('ServicioModi') }}"
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
</div>
