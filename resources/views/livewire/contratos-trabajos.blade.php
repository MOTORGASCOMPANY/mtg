<div class="container mx-auto mt-8">
    <div class="block justify-center mt-2 pt-8 max-h-max pb-8">
        <h1 class="text-center text-xl my-2 font-bold text-indigo-600"> REALIZAR CONTRATO</h1>

        <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-md my-4">
            <div class="bg-indigo-200 rounded-lg py-4  grid grid-cols-1 gap-8 justify-center">
                <div class="flex items-center">
                    <div class="ml-60 text-center">
                        <x-jet-label value="Seleccione Inspector:" for="Inspector" />
                    </div>
                    <div class="ml-2">
                        <select wire:model="idUser" wire:change="seleccionarInspector()"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full">
                            <option value="0">Seleccione</option>
                            @foreach ($inspectores as $inspector)
                                <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-jet-input-error for="idUser" />
                </div>
            </div>
        </div>

        @if ($mostrarCampos)
            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                <div class="grid grid-cols-1"> {{-- md:grid-cols-2 --}}

                    <div class="mb-6 px-8 py-2">
                        <div class="flex items-center justify-between bg-gray-400 py-4 px-6 rounded-t-lg">
                            <span class="text-lg font-semibold text-white dark:text-gray-400">Datos del Empleado</span>
                        </div>
                        <div class="mb-6 px-8 py-2">

                            <div class="grid grid-cols-2 gap-4 py-2">
                                <div>
                                    <x-jet-label value="Dni:" />
                                    <x-jet-input type="text"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="dniEmpleado" />
                                    <x-jet-input-error for="dniEmpleado" />
                                </div>
                                <div>
                                    <x-jet-label value="Domicilio:" />
                                    <x-jet-input type="text"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="domicilioEmpleado" />
                                    <x-jet-input-error for="domicilioEmpleado" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 py-2">
                                <div>
                                    <x-jet-label value="Celular:" />
                                    <x-jet-input type="number"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="celularEmpleado" />
                                    <x-jet-input-error for="celularEmpleado" />
                                </div>
                                <div>
                                    <x-jet-label value="Correo:" />
                                    <x-jet-input type="email"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="correoEmpleado" />
                                    <x-jet-input-error for="correoEmpleado" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 py-2">
                                <div>
                                    <x-jet-label value="Fecha Inicio:" />
                                    <x-jet-input type="date"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="fechaInicio" />
                                    <x-jet-input-error for="fechaInicio" />
                                </div>
                                <div>
                                    <x-jet-label value="Fecha Expiración:" />
                                    <x-jet-input type="date"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="fechaExpiracion" />
                                    <x-jet-input-error for="fechaExpiracion " />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 py-2">
                                <div>
                                    <x-jet-label value="Cargo:" />
                                    <x-jet-input type="text"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="cargo" />
                                    <x-jet-input-error for="cargo" />
                                </div>
                                <div>
                                    <x-jet-label value="Monto:" />
                                    <x-jet-input type="number"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="pago" />
                                    <x-jet-input-error for="pago" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 py-2">
                                <div>
                                    <x-jet-label value="Cumpleaños:" />
                                    <x-jet-input type="date"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full "
                                        wire:model="cumpleañosEmpleado" />
                                    <x-jet-input-error for="cumpleañosEmpleado" />
                                </div>
                            </div>
                            {{--
                             <div class="grid grid-cols-2 gap-4 py-2">
                                <div>
                                    <x-jet-label value="Contrato Anterior (si aplica):" />
                                    <select wire:model="renovacion_id"
                                        class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full">
                                        <option value="">Seleccione</option>
                                        @foreach ($contratosPrevios as $contrato)
                                            <option value="{{ $contrato->id }}">ID:{{ $contrato->id }} ({{ $contrato->fechaInicio }} al {{ $contrato->fechaExpiracion }})</option>
                                        @endforeach
                                    </select>
                                    <x-jet-input-error for="renovacion_id" />
                                </div>
                             </div>
                            --}}
                        </div>
                    </div>
                    
                    {{--
                     <div class="mb-6 px-8 py-2">
                        @if ($contratoPreview)
                            <div class="bg-gray-400 py-4 px-6 rounded-t-lg">
                                <span class="text-lg font-semibold text-white dark:text-gray-400">Vista Previa del
                                    Contrato</span>
                            </div>
                            @include('contrato', [
                                'nombreEmpleado' => $contratoPreview['nombreEmpleado'],                                
                                'dniEmpleado' => $contratoPreview['dniEmpleado'],
                                'domicilioEmpleado' => $contratoPreview['domicilioEmpleado'],                                
                                'fechaInicio' => $contratoPreview['fechaInicio'],
                                'fechaExpiracion' => $contratoPreview['fechaExpiracion'],
                                'cargo' => $contratoPreview['cargo'],
                                'pago' => $contratoPreview['pago'],
                            ])
                        @endif
                     </div>
                    --}}
                </div>
            </div>

            <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
                <div class="my-2 flex flex-col md:flex-row justify-evenly items-center">
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
        @endif

        @if ($contrato)
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
                            <a href="{{ $contrato->rutaVistaContratoTrabajo }}" target="__blank"
                                rel="noopener noreferrer"
                                class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-t-md hover:cursor-pointer">
                                <i class="fas fa-eye"></i>
                                <span>Ver Certificado.</span>
                            </a>
                            <a href="{{ $contrato->rutaDescargaContratoTrabajo }}" target="__blank"
                                rel="noopener noreferrer"
                                class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                <i class="fas fa-download"></i>
                                <span>desc. Certificado</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('Empleados') }}"
                        class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-red-400 hover:bg-red-500 focus:outline-none rounded">
                        <p class="text-sm font-medium leading-none text-white">
                            <i class="fas fa-archive"></i>&nbsp;Finalizar
                        </p>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
