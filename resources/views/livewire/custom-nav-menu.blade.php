<!-- component -->
<!--
Change class "fixed" to "sticky" in "navbar" (l. 33) so the navbar doesn't hide any of your page content!
-->
<div>
    <style>
        ul.breadcrumb li+li::before {
            content: "";
            padding-left: 8px;
            padding-right: 4px;
            color: inherit;
        }

        ul.breadcrumb li span {
            opacity: 60%;
        }

        #sidebar {
            -webkit-transition: all 300ms cubic-bezier(0, 0.77, 0.58, 1);
            transition: all 300ms cubic-bezier(0, 0.77, 0.58, 1);
        }

        #sidebar.show {
            transform: translateX(0);
        }

        #sidebar ul li a.active {
            background: #1f2937;
            background-color: #1f2937;
        }
    </style>

    <!-- Navbar start -->
    <nav id="navbar"
        class="fixed top-0 z-40 flex w-full flex-row justify-between bg-gray-500 px-4 shadow-lg border-b border-gray-200">
        {{--
    <ul class="breadcrumb hidden flex-row items-center py-4 text-lg text-white sm:flex">
        <li class="inline">
            <a href="#">Main</a>
        </li>
        <li class="inline">
            <span>Homepage</span>
        </li>
    </ul>
    --}}
        <button id="btnSidebarToggler" type="button" class="py-4 text-2xl text-white hover:text-black">
            <svg id="navClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="h-8 w-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg id="navOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hidden h-8 w-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <a href="{{ route('dashboard') }}" class="py-2 h-1/2">
            <img src="{{ asset('images/images/logojulio.png') }}" width="120" />
        </a>


        <div class="hidden  md:flex  md:items-center">
            <x-jet-dropdown width="48">
                <x-slot name="trigger">
                    <div class="m-4 inline-flex relative w-fit">
                        @if (Auth()->user()->unreadNotifications->count())
                            <span
                                class="absolute inline-block top-0 right-0 bottom-auto left-auto translate-x-2/4 -translate-y-1/2 rotate-0 skew-x-0 skew-y-0 scale-x-100 scale-y-100 rounded-full z-10">
                                <span
                                    class=" absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75 animate-ping"></span>
                                <span
                                    class="relative inline-flex rounded-full px-2 text-white bg-indigo-500 items-center m-auto text-xs">
                                    {{ Auth()->user()->unreadNotifications->count() }}
                                </span>
                            </span>
                        @else
                        @endif
                        <div class="flex items-center justify-center text-center">
                            <i class="fas fa-bell fa-xl text-white hover:text-black"></i>
                        </div>

                    </div>

                </x-slot>

                <x-slot name="content">
                    <!-- Account Management -->

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Tienes ' . Auth()->user()->unreadNotifications->count() . ' notificaciones') }}
                    </div>
                    @foreach (Auth()->user()->unreadNotifications as $notification)
                        {{-- Notificacion para Solicitud de Material --}}
                        @if ($notification->type == 'App\Notifications\CreateSolicitud')
                            <x-jet-dropdown-link
                                href="{{ route('leerNotificacion', [$notification->id, $notification->data['idSoli']]) }}">
                                <p class="text-xs "> Nueva solicitud de Materiales de <strong
                                        class="text-indigo-500">{{ $notification->data['inspector'] }}</strong></p>
                            </x-jet-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                        @endif
                        {{-- Notificacion para Solicitud Anulacion --}}
                        @if ($notification->type == 'App\Notifications\AnulacionSolicitud')
                            <x-jet-dropdown-link href="{{ route('leerAnular', [$notification->id]) }}">
                                <p class="text-xs "> Nueva solicitud de Anulación: <strong
                                        class="text-indigo-500">{{ $notification->data['idAnulacion'] }}</strong></p>
                            </x-jet-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                        @endif
                        {{--  Notificacion para Solicitud de Eliminacion --}}
                        @if ($notification->type == 'App\Notifications\SolicitudEliminacion')
                            <x-jet-dropdown-link href="{{ route('leerEliminar', [$notification->id]) }}">
                                <p class="text-xs "> Nueva solicitud de Eliminación: <strong
                                        class="text-indigo-500">{{ $notification->data['idEliminacion'] }}</strong></p>
                            </x-jet-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                        @endif
                        {{--  Notificacion para Memorando --}}
                        @if ($notification->type == 'App\Notifications\MemorandoSolicitud')
                            <x-jet-dropdown-link href="{{ route('leerMemorando', [$notification->id]) }}">
                                <p class="text-xs "> Nuevo Memorando: <strong
                                        class="text-indigo-500">{{ $notification->data['idMemorando'] }}</strong></p>
                                {{-- var_export --}}
                            </x-jet-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                        @endif
                        {{-- Notificacion para Devolucion Formatos --}}
                        @if ($notification->type == 'App\Notifications\SolicitudDevolucion')
                            <x-jet-dropdown-link href="{{ route('leerDevolucion', [$notification->id]) }}">
                                <p class="text-xs"> Devolución formatos:</p>
                                    <ol class="text-indigo-500">
                                        @foreach($notification->data['anulaciones'] as $anulacion)
                                                @php
                                                    // Asignar el nombre del material según el tipo
                                                    $tipoMaterial = '';
                                                    switch ($anulacion['tipo_material']) {
                                                        case 1:
                                                            $tipoMaterial = 'GNV';
                                                            break;
                                                        case 2:
                                                            $tipoMaterial = 'CHIP';
                                                            break;
                                                        case 3:
                                                            $tipoMaterial = 'GLP';
                                                            break;
                                                        case 4:
                                                            $tipoMaterial = 'MODI';
                                                            break;
                                                        default:
                                                            $tipoMaterial = 'Desconocido';
                                                    }
                                                @endphp
                                            <li>                                                
                                                {{ $tipoMaterial }}
                                            </li>
                                        @endforeach
                                    </ol>
                            </x-jet-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                        @endif
                    @endforeach
                    {{-- Boton para ver todas las Notificaciones --}}
                    @hasrole('Administrador del sistema|administrador')
                        <div class="mt-2 flex justify-center">
                            <a href="{{ route('Notificaciones') }}"
                                class="p-2 bg-indigo-500 rounded-xl text-white text-sm  hover:bg-indigo-700">
                                Tds. Notificaciones
                            </a>
                        </div>
                    @endhasrole
                </x-slot>
            </x-jet-dropdown>
            <x-jet-dropdown width="48">
                <x-slot name="trigger">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <button
                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}" />
                        </button>
                    @else
                        <span class="inline-flex rounded-md">
                            <button type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white  hover:text-black focus:outline-none transition">
                                <i class="fa-solid fa-user-gear fa-lg"></i>
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    @endif
                </x-slot>

                <x-slot name="content">
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Administrar Cuenta') }}
                    </div>

                    <x-jet-dropdown-link href="{{ route('profile.show') }}">
                        {{ __('Perfil') }}
                    </x-jet-dropdown-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                            {{ __('API Tokens') }}
                        </x-jet-dropdown-link>
                    @endif

                    <div class="border-t border-gray-100"></div>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Salir') }}
                        </x-jet-dropdown-link>
                    </form>
                </x-slot>
            </x-jet-dropdown>
        </div>

    </nav>
    <!-- Navbar end -->

    <!-- Sidebar start-->
    <div id="containerSidebar" class="z-40">
        <div class="navbar-menu relative z-40">
            <nav id="sidebar"
                class="fixed left-0 bottom-0 flex w-3/4 -translate-x-full flex-col bg-gray-700 pt-2  sm:max-w-xs lg:w-80">
                <!-- one category / navigation group -->
                <div class="px-4 overflow-y-auto">
                    <h3 class="mb-2 text-xs font-medium uppercase text-gray-500">
                        Menu principal
                    </h3>
                    <ul class="text-sm font-medium">
                        <li>
                            <a class="flex items-center rounded py-3 pl-3 pr-4  space-x-6 text-gray-50 hover:bg-gray-600"
                                href="{{ route('dashboard') }}">
                                <i class="fas fa-home -mt-1"></i>
                                <span class="select-none">Inicio</span>
                            </a>
                        </li>

                        {{--             OPCIONES PARA SERVICIOS                    --}}
                        @can('opciones.servicios')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm text-white ">
                                        <i class="fa-solid fa-screwdriver-wrench"></i>
                                        <span class="select-none">Servicios</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>

                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">

                                        @can('servicio')
                                            <li class="transition-colors duration-150">

                                                <x-jet-responsive-nav-link class="text-sm" href="{{ route('servicio') }}"
                                                    :active="request()->routeIs('servicio')">
                                                    Nuevo Servicio
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan
                                        @can('ServicioModi')
                                            <li class="transition-colors duration-150">
                                                <x-jet-responsive-nav-link class="text-sm" href="{{ route('ServicioModi') }}"
                                                    :active="request()->routeIs('ServicioModi')">
                                                    Nuevo Modificación
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan                                        
                                        @can('ServicioTaller')
                                            <li class="transition-colors duration-150">
                                                <x-jet-responsive-nav-link class="text-sm" href="{{ route('ServicioTaller') }}"
                                                    :active="request()->routeIs('ServicioTaller')">
                                                    Nuevo Ins.Taller
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan
                                        @can('ServicioCarta')
                                            <li class="transition-colors duration-150">
                                                <x-jet-responsive-nav-link class="text-sm" href="{{ route('ServicioCarta') }}"
                                                    :active="request()->routeIs('ServicioCarta')">
                                                    Nuevo CartaAclaratoria
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan
                                        @can('certificaciones')
                                            <li class="transition-colors duration-150">
                                                <x-jet-responsive-nav-link class="text-sm"
                                                    href="{{ route('certificaciones') }}" :active="request()->routeIs('certificaciones')">
                                                    Listado de Certificaciones
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan
                                        @can('ListadoChips')
                                            <li class="transition-colors duration-150">
                                                <x-jet-responsive-nav-link class="text-sm" href="{{ route('ListadoChips') }}"
                                                    :active="request()->routeIs('ListadoChips')">
                                                    Listado de Chips
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan

                                        @can('certificaciones.pendientes')
                                            <li class="transition-colors duration-150">
                                                <x-jet-responsive-nav-link class="text-sm"
                                                    href="{{ route('certificaciones.pendientes') }}" :active="request()->routeIs('certificaciones.pendientes')">
                                                    Certificaciones pendientes
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan
                                        @can('certificaciones.desmontes')
                                            <li class="transition-colors duration-150">
                                                <x-jet-responsive-nav-link class="text-sm"
                                                    href="{{ route('certificaciones.desmontes') }}" :active="request()->routeIs('certificaciones.desmontes')">
                                                    Listado otras Certificaciones
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan
                                        @can('Devolucion')
                                            <li class="transition-colors duration-150">
                                                <x-jet-responsive-nav-link class="text-sm"
                                                    href="{{ route('Devolucion') }}" :active="request()->routeIs('Devolucion')">
                                                    Devolucion de Formatos
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan
                                        @can('admin.certificaciones')
                                            <li class="transition-colors duration-150">
                                                <x-jet-responsive-nav-link class="bg-gray-400 text-sm"
                                                    href="{{ route('admin.certificaciones') }}" :active="request()->routeIs('admin.certificaciones')">
                                                    Admin. Servicios
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan
                                        @can('AdministracionCerTaller')
                                            <li class="transition-colors duration-150">
                                                <x-jet-responsive-nav-link class="bg-gray-400 text-sm"
                                                    href="{{ route('AdministracionCerTaller') }}" :active="request()->routeIs('AdministracionCerTaller')">
                                                    Otros. Servicios
                                                </x-jet-responsive-nav-link>
                                            </li>
                                        @endcan
                                    </ul>

                                </div>
                            </li>
                        @endcan


                        {{--             OPCIONES PARA EXPEDIENTES                  --}}
                        @can('opciones.expedientes')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full  transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-file-shield"></i>
                                        <span class="select-none">Expedientes</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">
                                        @can('expedientes')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('expedientes') }}"
                                                :active="request()->routeIs('expedientes')">
                                                {{ __('Listado Expedientes') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                        @can('revisionExpedientes')
                                            <x-jet-responsive-nav-link href="{{ route('revisionExpedientes') }}"
                                                :active="request()->routeIs('revisionExpedientes')">
                                                {{ __(' Revisión Expedientes') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('talleres.revision')
                                            <x-jet-responsive-nav-link class="text-sm"
                                                href="{{ route('talleres.revision') }}" :active="request()->routeIs('talleres.revision')">
                                                {{ __('Expedientes de taller') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                    </ul>

                                </div>
                            </li>
                        @endcan


                        {{--            OPCIONES PARA TALLERES                    --}}
                        @can('opciones.talleres')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full  transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-warehouse"></i>
                                        <span class="select-none">Talleres</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">
                                        @can('talleres')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('talleres') }}"
                                                :active="request()->routeIs('talleres')">
                                                Listado de talleres
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('PreciosInspector')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('PreciosInspector') }}"
                                                :active="request()->routeIs('PreciosInspector')">
                                                Precio de Inspectores
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('TalleresInspector')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('TalleresInspector') }}"
                                                :active="request()->routeIs('TalleresInspector')">
                                                Relacion c/n Inspectores
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                        @can('editar-taller')
                                            @if (Auth::user()->taller)
                                                <x-jet-responsive-nav-link class="text-sm"
                                                    href="{{ route('editar-taller', Auth::user()->taller) }}"
                                                    :active="request()->routeIs('editar-taller')">
                                                    Datos de taller
                                                </x-jet-responsive-nav-link>
                                            @endif
                                        @endcan

                                    </ul>

                                </div>
                            </li>
                        @endcan


                        {{--           OPCIONES PARA MATERIALES                    --}}
                        @can('opciones.materiales')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded "
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-cubes"></i>
                                        <span class="select-none">Materiales</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">
                                        @can('inventario')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('inventario') }}"
                                                :active="request()->routeIs('inventario')">
                                                {{ __('Inventario') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('inventario.revision')
                                            <x-jet-responsive-nav-link class="text-sm"
                                                href="{{ route('inventario.revision') }}" :active="request()->routeIs('inventario.revision')">
                                                {{ __('Revision de Inventarios') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('ingresos')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('ingresos') }}"
                                                :active="request()->routeIs('ingresos')">
                                                {{ __('Ingreso de Materiales') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('salidas')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('salidas') }}"
                                                :active="request()->routeIs('salidas')">
                                                {{ __('Salida de materiales') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                        @can('asignacion')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('asignacion') }}"
                                                :active="request()->routeIs('asignacion')">
                                                {{ __('Asignación de materiales') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('materiales.prestamo')
                                            <x-jet-responsive-nav-link class="text-sm"
                                                href="{{ route('materiales.prestamo') }}" :active="request()->routeIs('materiales.prestamo')">
                                                {{ __('Préstamo de materiales') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('solicitud')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('solicitud') }}"
                                                :active="request()->routeIs('solicitud')">
                                                {{ __('Solicitud de materiales') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                        @can('recepcion')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('recepcion') }}"
                                                :active="request()->routeIs('recepcion')">
                                                {{ __('Recepción de materiales') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                    </ul>

                                </div>
                            </li>
                        @endcan

                        {{--           OPCIONES PARA BOLETAS                  
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full  transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-calendar-check"></i>
                                        <span class="select-none">Boletas</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">
                                        @can('ListaBoletas')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('ListaBoletas') }}" :active="request()->routeIs('ListaBoletas')">
                                                Boletas
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                    </ul>

                                </div>
                            </li> --}}

                        {{--           OPCIONES PARA REPORTES DE CUMPLIMIENTO   --}}
                        @can('opciones.reportesGnv')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full  transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-chart-column"></i>
                                        <span class="select-none">Reportes de Cumplimiento</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">

                                        @can('reportes.reporteGeneralGnv')
                                            <x-jet-responsive-nav-link class="text-sm"
                                                href="{{ route('reportes.reporteGeneralGnv') }}" :active="request()->routeIs('reportes.reporteGeneralGnv')">
                                                Reporte general GNV
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('reportes.reporteMateriales')
                                            <x-jet-responsive-nav-link class="text-sm"
                                                href="{{ route('reportes.reporteMateriales') }}" :active="request()->routeIs('reportes.reporteMateriales')">
                                                Reporte de formatos GNV
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('reportes.reporteServiciosPorInspector')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteServiciosPorInspector') }}"
                                                :active="request()->routeIs('reportes.reporteServiciosPorInspector')">
                                                Servicios por inspector
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('reportes.reporteFotosPorInspector')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteFotosPorInspector') }}" :active="request()->routeIs('reportes.reporteFotosPorInspector')">
                                                Cumplimiento de fotos
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('reportes.reporteDocumentosTaller')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteDocumentosTaller') }}" :active="request()->routeIs('reportes.reporteDocumentosTaller')">
                                                Documentos autorizados
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('Rentabilidad')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('Rentabilidad') }}" :active="request()->routeIs('Rentabilidad')">
                                                Rentabilidad Talleres
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('ListaBoletas')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('ListaBoletas') }}" :active="request()->routeIs('ListaBoletas')">
                                                Listado de Comprobantes
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                    </ul>

                                </div>
                            </li>
                        @endcan

                        {{--           OPCIONES PARA REPORTES CERTIFICACIONES    --}}
                        @can('opciones.reportesCertificaciones')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full  transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-chart-column"></i>
                                        <span class="select-none">Reportes de Certificaciones</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">

                                        @can('reportes.reporteCalcularGasol')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteCalcularGasol') }}" :active="request()->routeIs('reportes.reporteCalcularGasol')">
                                                Motorgas Completo
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('reportes.reporteCalcularChip')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteCalcularChip') }}" :active="request()->routeIs('reportes.reporteCalcularChip')">
                                                Motorgas Taller
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('reportes.reporteTallerResumen')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteTallerResumen') }}" :active="request()->routeIs('reportes.reporteTallerResumen')">
                                                Motorgas TallerRes.
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('reportes.reporteCalcular')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteCalcular') }}" :active="request()->routeIs('reportes.reporteCalcular')">
                                                Motorgas Semanal
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                        @can('reportes.reporteMTG')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteMTG') }}" :active="request()->routeIs('reportes.reporteMTG')">
                                                Motorgas Detallado
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('reportes.reporteGasol')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteGasol') }}" :active="request()->routeIs('reportes.reporteGasol')">
                                                Gasolutión Detallado
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('reportes.reporteActualizarPrecio')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteActualizarPrecio') }}" :active="request()->routeIs('reportes.reporteActualizarPrecio')">
                                                Motorgas act. precios
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('reportes.reporteActualizarGasol')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteActualizarGasol') }}" :active="request()->routeIs('reportes.reporteActualizarGasol')">
                                                Gasolutión act. precios
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                    </ul>

                                </div>
                            </li>
                        @endcan

                        {{--           OPCIONES PARA REPORTES DE MATERIAL   --}}
                        @can('opciones.reportesMaterial')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full  transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-chart-column"></i>
                                        <span class="select-none">Reportes de Materiales</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">

                                        @can('reportes.reporteInventario')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteInventario') }}" :active="request()->routeIs('reportes.reporteInventario')">
                                                Inventario
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                        @can('reportes.reporteSalidaMateriales')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('reportes.reporteSalidaMateriales') }}" :active="request()->routeIs('reportes.reporteSalidaMateriales')">
                                                Salida de Material
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                        @can('ConsultarHoja')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('ConsultarHoja') }}"
                                                :active="request()->routeIs('ConsultarHoja')">
                                                {{ __('Consultar Hoja') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                    </ul>

                                </div>
                            </li>
                        @endcan


                        {{--           OPCIONES PARA IMPORTACION DE SERVICIOS                  --}}
                        @can('opciones.cargaDatos')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full  transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-upload"></i>
                                        <span class="select-none">Importacion de servicios</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">

                                        <x-jet-responsive-nav-link class="text-sm" href="{{ route('importar.anuales') }}"
                                            :active="request()->routeIs('importar.anuales')">
                                            Revisiones Anuales GNV
                                        </x-jet-responsive-nav-link>

                                        <x-jet-responsive-nav-link class="text-sm"
                                            href="{{ route('importar.conversiones') }}" :active="request()->routeIs('importar.conversiones')">
                                            Conversiones a GNV
                                        </x-jet-responsive-nav-link>

                                        <x-jet-responsive-nav-link class="text-sm"
                                            href="{{ route('importar.desmontes') }}" :active="request()->routeIs('importar.desmontes')">
                                            Desmontes GNV
                                        </x-jet-responsive-nav-link>

                                    </ul>

                                </div>
                            </li>
                        @endcan


                        {{--            OPCIONES PARA SOPORTE DE TABLAS                --}}
                        @can('opciones.usuarios')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full  transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-table"></i>
                                        <span class="select-none font">Mantenimiento de Tablas</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">
                                        <x-jet-responsive-nav-link class="text-sm"
                                            href="{{ route('table.tiposServicio') }}" :active="request()->routeIs('table.tiposServicio')">
                                            Tipos de servicio
                                        </x-jet-responsive-nav-link>

                                    </ul>

                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-0.5 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">
                                        <x-jet-responsive-nav-link class="text-sm"
                                            href="{{ route('table.TiposManual') }}" :active="request()->routeIs('table.TiposManual')">
                                            Tipos areas Manual
                                        </x-jet-responsive-nav-link>

                                    </ul>

                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-0.5 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">
                                        <x-jet-responsive-nav-link class="text-sm"
                                            href="{{ route('table.TiposDocumentosEmpleados') }}" :active="request()->routeIs('table.TiposDocumentosEmpleados')">
                                            Tipos doc Empleados
                                        </x-jet-responsive-nav-link>

                                    </ul>

                                </div>
                            </li>
                        @endcan

                        {{--            OPCIONES PARA NOSOTROS MOTORGAS              --}}
                        @can('opciones.nosotros')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full  transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-flag"></i>
                                        <span class="select-none font">RR.HH</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>

                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">

                                        <x-jet-responsive-nav-link class="text-sm" href="{{ route('Empleados') }}"
                                            :active="request()->routeIs('Empleados')">
                                            Contrato
                                        </x-jet-responsive-nav-link>
                                        <x-jet-responsive-nav-link class="text-sm" href="Organigrama" :active="request()->routeIs('Organigrama')">
                                            Organigrama
                                        </x-jet-responsive-nav-link>
                                        <x-jet-responsive-nav-link class="text-sm" href="{{ route('ListaMemorando') }}"
                                            :active="request()->routeIs('ListaMemorando')">
                                            Memorandums
                                        </x-jet-responsive-nav-link>
                                        <x-jet-responsive-nav-link class="text-sm" href="{{ route('ManualFunciones') }}"
                                            :active="request()->routeIs('ManualFunciones')">
                                            Manual de Funciones
                                        </x-jet-responsive-nav-link>
                                        @can('comunicado.createOrUpdateForm')
                                            <x-jet-responsive-nav-link class="text-sm truncate"
                                                href="{{ route('comunicado.createOrUpdateForm') }}" :active="request()->routeIs('comunicado.createOrUpdateForm')">
                                                Emitir Comunicados
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                    </ul>
                                </div>
                                {{--
                                @hasanyrole('administrador|supervisor|Administrador del sistema')
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-0.5 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">
                                        <x-jet-responsive-nav-link class="text-sm"
                                            href="{{ route('Memorando') }}" :active="request()->routeIs('Memorando')">
                                            Memorandum
                                        </x-jet-responsive-nav-link>

                                    </ul>
                                </div>
                                @endhasanyrole
                                --}}
                            </li>
                        @endcan

                        {{--            OPCIONES PARA USUARIOS Y ROLES                  --}}
                        @can('opciones.usuarios')
                            <li class="text-gray-50 py-3 pl-3 pr-4 hover:bg-gray-600 focus:bg-gray-600 rounded"
                                x-data="{ Open: false }">
                                <div class="inline-flex  items-center justify-between w-full  transition-colors duration-150 text-gray-500  cursor-pointer"
                                    x-on:click="Open = !Open">
                                    <span class="inline-flex items-center space-x-6  text-sm  text-white ">
                                        <i class="fa-solid fa-user-shield"></i>
                                        <span class="select-none">Usuarios y roles</span>
                                    </span>
                                    <i class="fa-solid fa-caret-down ml-1  text-white w-4 h-4" x-show="!Open"></i>

                                    <i class="fa-solid fa-caret-up ml-1  text-white w-4 h-4" x-show="Open"></i>
                                </div>
                                <div x-show.transition="Open" style="display:none;">
                                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                                        x-transition:enter-start="opacity-25 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-xl"
                                        x-transition:leave="transition-all ease-in-out duration-300"
                                        x-transition:leave-start="opacity-100 max-h-xl"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="mt-2 divide-y-2 divide-gray-600 overflow-hidden text-sm font-medium bg-gray-600 text-white shadow-inner"
                                        aria-label="submenu">
                                        @can('usuarios')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('usuarios') }}"
                                                :active="request()->routeIs('usuarios')">
                                                Usuarios
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('usuarios.roles')
                                            <x-jet-responsive-nav-link class="text-sm" href="{{ route('usuarios.roles') }}"
                                                :active="request()->routeIs('usuarios.roles')">
                                                Roles
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                        @can('usuarios.permisos')
                                            <x-jet-responsive-nav-link class="text-sm"
                                                href="{{ route('usuarios.permisos') }}" :active="request()->routeIs('usuarios.permisos')">
                                                Permisos
                                            </x-jet-responsive-nav-link>
                                        @endcan
                                    </ul>

                                </div>
                            </li>
                        @endcan

                    </ul>
                </div>

                <!-- navigation group end-->

                <!-- opciones de cuenta de usuario -->
                <div class="md:hidden block bg-gray-700 bottom-0 left-0 px-4 w-full z-10 mt-2">
                    <h3 class="my-2 text-xs font-medium uppercase text-gray-500">
                        Opciones de la cuenta
                    </h3>
                    <ul class="mb-2 text-sm font-medium ">
                        <li>
                            <a class="flex items-center rounded py-3 pl-3 pr-4  space-x-6 text-gray-50 hover:bg-gray-600 "
                                href="{{ route('profile.show') }}">
                                <i class="fa-solid fa-user-gear -mt-1"></i>
                                <span class="select-none">Configurar Perfil</span>
                            </a>
                        </li>
                        <li>


                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a class="flex items-center rounded py-3 pl-3 pr-4  space-x-6 text-gray-50 hover:bg-gray-600 "
                                    href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    <i class="fa-solid fa-arrow-right-from-bracket -mt-1"></i>
                                    <span class="select-none">Salir</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- fin -->
            </nav>
        </div>

    </div>
    <!-- Sidebar end -->

    <main>
        <!-- your content goes here -->
    </main>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", () => {
            const navbar = document.getElementById("navbar");
            const sidebar = document.getElementById("sidebar");
            const btnSidebarToggler = document.getElementById("btnSidebarToggler");
            const navClosed = document.getElementById("navClosed");
            const navOpen = document.getElementById("navOpen");

            btnSidebarToggler.addEventListener("click", (e) => {
                e.preventDefault();
                sidebar.classList.toggle("show");
                navClosed.classList.toggle("hidden");
                navOpen.classList.toggle("hidden");
            });

            sidebar.style.top = parseInt(navbar.clientHeight) - 1 + "px";
        });
    </script>
</div>
