<div>
    <div class="container block justify-center m-auto py-12">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl text-center font-bold text-indigo-500 uppercase flex-grow">Devolucion Formatos Dañados </h1>
        </div>
        <div class="rounded-xl m-4 bg-white p-8 mx-auto max-w-max shadow-lg">
            <div class="flex flex-row gap-2">
                <div class="w-full">
                    <x-jet-label value="Tipo Material:" for="Tipo Material" />
                    <select wire:model="tipoMaterial"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                        <option value="">Seleccione</option>
                        <option value="1">Formato GNV</option>
                        {{--<option value="2">CHIP</option>--}}
                        <option value="3">Formato GLP</option>
                        <option value="4">Modificación</option>
                    </select>
                    <x-jet-input-error for="tipoMaterial" />
                </div>
                <div class="w-full">
                    <x-jet-label value="Año Activo:" for="Año Activo" />
                    <select wire:model="anioActivo"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                        <option value="">Seleccione</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select>
                    <x-jet-input-error for="anioActivo" />
                </div>

                <div class="pt-7">
                    <a wire:click="agregarAlCarrito"
                        class="ml-6 bg-amber-500 px-6 py-3  mt-4 rounded-md text-white font-semibold tracking-wide hover:cursor-pointer">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>


        @if ($estado)
            <div class="rounded-xl m-4 bg-white p-8 mx-auto max-w-max shadow-lg">
                <div class="flex flex-row gap-2">
                    <div class="w-full">
                        <!-- Campo Desde -->
                        <x-jet-label value=" Serie Desde:" />
                        <input class="bg-gray-50 outline-none block rounded-md border-indigo-500 w-full "
                            wire:model="desde" placeholder="Desde...">
                        <x-jet-input-error for="desde" />
                    </div>
                    <div class="w-full">
                        <!-- Campo Hasta -->
                        <x-jet-label value=" Serie Hasta:" />
                        <input class="bg-gray-50 outline-none block rounded-md border-indigo-500 w-full "
                            wire:model="hasta" placeholder="Hasta...">
                        <x-jet-input-error for="hasta" />
                    </div>
                </div>

                @if (count($carrito) > 0)
                    <div class="flex flex-col justify-center items-center text-center mt-4">
                        <h2 class="text-lg font-bold mb-2">
                            <span class="text-indigo-500">Materiales</span>
                        </h2>
                        {{-- 
                         <ul>
                            @foreach ($carrito as $index => $item)
                                <li class="mb-2">
                                    {{ $item['idTipoMaterial'] }} - ({{ $item['numSerieDesde'] }} -
                                    {{ $item['numSerieHasta'] }})
                                </li>
                            @endforeach
                         </ul>
                        --}}
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:mx-0.5">
                                <div class="py-2 inline-block min-w-full ">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full">
                                            <thead class="bg-indigo-300 border-b">
                                                <tr>
                                                    <th scope="col"
                                                        class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                        #
                                                    </th>
                                                    <th scope="col"
                                                        class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                        Tipo
                                                        de Material</th>
                                                    <th scope="col"
                                                        class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                        Serie Desde</th>
                                                    <th scope="col"
                                                        class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                                        Serie Hasta</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($carrito as $index => $item)
                                                    <tr class="bg-gray-100 border-b">
                                                        <td
                                                            class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            {{ $index + 1 }}</td>
                                                        <td
                                                            class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            {{ $item['nombreTipo'] }}
                                                        </td>
                                                        <td
                                                            class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            {{ $item['numSerieDesde'] }}</td>
                                                        <td
                                                            class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            {{ $item['numSerieHasta'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Botón Aceptar -->
                    <div class="flex justify-center">
                        <button wire:click="aceptar" wire:loading.attr="disabled" wire.target="aceptar"
                            class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                            <p class="text-sm font-medium leading-none text-white">
                                <span wire:loading wire:target="aceptar">
                                    <i class="fas fa-spinner animate-spin"></i>
                                    &nbsp;
                                </span>
                                &nbsp;Registrar Devolución
                            </p>
                        </button>
                    </div>
                @endif
            </div>
        @endif

        @if ($certificacion)
            <div class="max-w-lg m-auto bg-white rounded-lg shadow-md my-4 py-4">
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
                            @foreach ($certificacion->groupBy('cart_id') as $group)
                                <a href="{{ $group->first()->RutaVistaCertificado }}" target="__blank"
                                    rel="noopener noreferrer"
                                    class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-t-md hover:cursor-pointer">
                                    <i class="fas fa-eye"></i>
                                    <span>Ver Cargo.</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('Devolucion') }}"
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
