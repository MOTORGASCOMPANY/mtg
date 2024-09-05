<div class="bg-white py-4 md:py-7 px-4 md:px-8 xl:px-10">
    <div class="mt-7 overflow-x-auto">
        <h1 class="text-2xl text-indigo-500 font-bold italic text-center py-8"><span class="text-none">🔔</span>
            REGISTRO DE NOTIFICACIONES</h1>

        @if ($notificacionesPendientes->isNotEmpty())
            <table class="w-full whitespace-nowrap">
                <thead class="bg-indigo-300 border-b font-bold">
                    <tr>
                        <th scope="col" class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                            #
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                            Tipo de Notificación
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                            Inspector
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                            N° Formato
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                            Placa
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                            Fecha
                        </th>
                        <th scope="col" class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                            Realizado
                        </th>
                        {{-- 
                        <th scope="col" class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                            Cargo
                        </th>
                        --}}
                        @hasanyrole('administrador|Administrador del sistema')
                            <th scope="col" class="text-sm font-medium font-semibold text-gray-900 px-6 py-4 text-left">
                                Acciones
                            </th>
                        @endhasanyrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notificacionesPendientes as $key => $notificacion)
                        <tr tabindex="0" class="focus:outline-none h-16 border border-gray-100 rounded">
                            <td class="pl-5">
                                <div class="flex items-center">
                                    <div
                                        class="bg-indigo-200 rounded-sm w-5 h-5 flex flex-shrink-0 justify-center items-center relative">
                                        {{ $key + 1 }}
                                    </div>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-base  leading-none text-gray-700 mr-2">
                                        @if ($notificacion->type === 'App\Notifications\AnulacionSolicitud')
                                            Solicitud de Anulación
                                        @elseif ($notificacion->type === 'App\Notifications\SolicitudEliminacion')
                                            Solicitud de Eliminación
                                        @elseif ($notificacion->type === 'App\Notifications\CreateSolicitud')
                                            Solicitud de Materiales
                                        @elseif ($notificacion->type === 'App\Notifications\SolicitudDevolucion')
                                            Devolucion de Materiales
                                        @else
                                            {{ $notificacion->type }}
                                        @endif
                                    </p>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-base  leading-none text-gray-700 mr-2">
                                        {{ $notificacion->nombreInspector ?? 'NA' }}</p>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-sm leading-none text-gray-600 ml-2 p-2 bg-indigo-200 rounded-full">
                                        {{ $notificacion->numero ?? 'NE' }}
                                    </p>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-base  leading-none text-gray-700 mr-2">
                                        {{ $notificacion->placa ?? 'NE' }}</p>
                                </div>
                            </td>
                            <td class="pl-2">
                                <div class="flex items-center">
                                    <p class="text-base leading-none text-gray-700 mr-2">
                                        {{ $notificacion->created_at->format('d/m/Y') }}</p>
                                </div>
                            </td>
                            <td class="pl-8">
                                <div class="flex items-center">
                                    {{-- X TODAVIA NO ESTA REALIZADO || ✔ YA FUE REALIZADO  --}}
                                    @if ($notificacion->type === 'App\Notifications\AnulacionSolicitud')
                                        @switch($notificacion->estado)
                                            @case(1)
                                                <i class="far fa-times-circle fa-lg" style="color: red;"></i>
                                            @break

                                            @case(2)
                                                <i class="far fa-check-circle fa-lg" style="color: forestgreen;"></i>
                                            @break

                                            @case(3)
                                                <i class="far fa-times-circle fa-lg" style="color: red;"></i>
                                            @break

                                            @default
                                        @endswitch
                                    @elseif($notificacion->type === 'App\Notifications\SolicitudEliminacion')
                                        @if ($notificacion->estado == 1 || $notificacion->estado == 3)
                                            <i class="far fa-times-circle fa-lg" style="color: red;"></i>
                                        @elseif($notificacion->estado == null)
                                            <i class="far fa-check-circle fa-lg" style="color: forestgreen;"></i>
                                        @endif
                                    @elseif($notificacion->type === 'App\Notifications\SolicitudDevolucion')
                                        @php
                                            $allMaterialsReturned = true;
                                            foreach ($notificacion->material as $mat) {
                                                if ($mat['devuelto'] == null) {
                                                    $allMaterialsReturned = false;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if ($allMaterialsReturned)
                                            <i class="far fa-check-circle fa-lg" style="color: forestgreen;"></i>
                                        @else
                                            <i class="far fa-times-circle fa-lg" style="color: red;"></i>
                                        @endif
                                    @elseif($notificacion->type === 'App\Notifications\CreateSolicitud')
                                        <i class="fa-solid fa-file-circle-plus" style="color: rgb(216, 219, 46);"></i>
                                    @endif
                                </div>
                            </td>
                            {{-- 
                            <td>
                                @foreach ($notificacionesPendientes as $notificacion)
                                    <div>
                                        <button wire:click="RutaVistaAnulacion('{{ $notificacion->id }}')">
                                            Ver cargo
                                        </button>
                                    </div>
                                @endforeach
                            </td>
                            --}}
                            @hasanyrole('administrador|Administrador del sistema')
                                <td>
                                    <div x-data="{ dropdownMenu: false }" class="relative">
                                        <!-- Dropdown toggle button -->
                                        <button @click="dropdownMenu = ! dropdownMenu"
                                            class="flex items-center p-2 border border-indigo-500  bg-gray-200 rounded-md">
                                            <span class="mr-4">Seleccione <i class="fas fa-sort-down -mt-2"></i></span>
                                        </button>
                                        <!-- Dropdown list -->
                                        <div x-show="dropdownMenu"
                                            class="absolute py-2 mt-2  bg-slate-300 rounded-md shadow-xl w-70 z-20 ">
                                            <button wire:click="verNotificacion('{{ $notificacion->id }}')"
                                                class="block px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-300 hover:text-white">
                                                <i class="fas fa-eye"></i> Enlace
                                            </button>

                                            <button wire:click="eliminarNotificacion('{{ $notificacion->id }}')"
                                                class="block px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-300 hover:text-white">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>


                                        </div>
                                    </div>
                                </td>
                            @endhasanyrole
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center mt-4 text-gray-500">
                <p>No tienes notificaciones pendientes en este momento.</p>
            </div>
        @endif
    </div>
</div>
