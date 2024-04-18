<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-md" id="navigate">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 w-full">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                
                <div class="hidden  sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Inicio') }}
                    </x-jet-nav-link>
                </div>

                @hasanyrole('inspector|administrador|supervisor|digitador')
                    <div class="hidden pt-4 sm:-my-px sm:ml-2 sm:flex">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">                            
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-indigo-500 hover:font-bold focus:outline-none transition">
                                            Servicios
                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>                            
                            </x-slot>

                            <x-slot name="content">                         
                                @can('servicio')
                                    <x-jet-dropdown-link href="{{ route('servicio') }}" :active="request()->routeIs('servicio')">
                                        {{ __('Nuevo Servicio') }}
                                    </x-jet-dropdown-link>
                                @endcan
                                @can('ServicioModi')
                                    <x-jet-dropdown-link href="{{ route('ServicioModi') }}" :active="request()->routeIs('ServicioModi')">
                                        {{ __('Servicio Modificación') }}
                                    </x-jet-dropdown-link>
                                @endcan
                                                                                                                
                                @can('certificaciones')
                                    <div class="border-t border-gray-100"></div>
                                    <x-jet-dropdown-link href="{{ route('certificaciones') }}" :active="request()->routeIs('certificaciones')">
                                        {{ __('Listado Servicios') }}
                                    </x-jet-dropdown-link>                                 
                                @endcan
                                
                                @can('ListadoChips')
                                    <x-jet-dropdown-link href="{{ route('ListadoChips') }}" :active="request()->routeIs('ListadoChips')">
                                        {{ __('Listado Chips') }}
                                    </x-jet-dropdown-link>
                                @endcan

                                @can('admin.certificaciones')
                                    <div class="border-t border-gray-100"></div>
                                    <x-jet-dropdown-link href="{{ route('admin.certificaciones') }}" :active="request()->routeIs('admin.certificaciones')">
                                        {{ __('Admin. Certificaciones') }}
                                    </x-jet-dropdown-link>                                 
                                @endcan
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endhasanyrole
                
                @hasrole('administrador|Administrador taller') 
                    <div class="hidden pt-4  sm:-my-px sm:ml-2 sm:flex">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">                            
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-indigo-500 hover:font-bold focus:outline-none transition">
                                            Talleres
                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>                            
                            </x-slot>

                            <x-slot name="content">                         
                                @can('talleres')
                                    <x-jet-dropdown-link href="{{ route('talleres') }}" :active="request()->routeIs('talleres')">
                                        {{ __('Listado talleres') }}
                                    </x-jet-dropdown-link>
                                @endcan     
                                <div class="border-t border-gray-100"></div>
                                @can('talleres.revision')
                                <x-jet-dropdown-link href="{{ route('talleres.revision') }}" :active="request()->routeIs('talleres.revision')">
                                    {{ __('Expedientes de taller') }}
                                </x-jet-dropdown-link>
                                @endcan
                                @can('editar-taller')
                                <x-jet-dropdown-link href="{{ route('editar-taller', Auth::user()->taller ) }}" :active="request()->routeIs('editar-taller')">
                                    {{ __('Datos del taller') }}
                                </x-jet-dropdown-link>
                                @endcan
                            </x-slot>                          
                        </x-jet-dropdown>
                    </div>
                @endhasrole
               
                @hasanyrole('inspector|administrador|supervisor')
                <div class="hidden pt-4 sm:-my-px sm:ml-2 sm:flex">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">                            
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-indigo-500 hover:font-bold focus:outline-none transition">
                                        Expedientes
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>                            
                        </x-slot>

                        <x-slot name="content">                         
                            @can('expedientes')
                            <x-jet-dropdown-link href="{{ route('expedientes') }}" :active="request()->routeIs('expedientes')">
                                {{ __('Crear Expediente') }}
                            </x-jet-dropdown-link>
                            @endcan   
                                                                               
                            @can('revisionExpedientes')
                            <div class="border-t border-gray-100"></div>
                            <x-jet-dropdown-link href="{{ route('revisionExpedientes') }}" :active="request()->routeIs('revisionExpedientes')">
                                {{ __('Revisar Expedientes') }}
                            </x-jet-dropdown-link>  
                            @endcan                          
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endhasanyrole
                

                @hasanyrole('inspector|administrador|supervisor')
                <div class="hidden pt-4 sm:-my-px sm:ml-2 sm:flex">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">                            
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-indigo-500 hover:font-bold focus:outline-none transition">
                                        Materiales
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            
                        </x-slot>
                        <x-slot name="content">     
                            @can('inventario')
                            <x-jet-dropdown-link href="{{ route('inventario') }}">
                                {{ __('Inventario') }}
                            </x-jet-dropdown-link> 
                            <div class="border-t border-gray-100"></div> 
                            @endcan
                                              
                            @can('ingresos')
                                <x-jet-dropdown-link href="{{ route('ingresos') }}">
                                    {{ __('Ingreso de Materiales') }}
                                </x-jet-dropdown-link>
                                <div class="border-t border-gray-100"></div>                                
                            @endcan

                            @can('salidas')
                                <x-jet-dropdown-link href="{{ route('salidas') }}">
                                    {{ __('Salida de materiales') }}
                                </x-jet-dropdown-link>                          
                                <div class="border-t border-gray-100"></div>
                            @endcan                            

                            @can('asignacion')
                                <x-jet-dropdown-link href="{{ route('asignacion') }}">
                                    {{ __('Asignación de materiales') }}
                                </x-jet-dropdown-link>                             
                                <div class="border-t border-gray-100"></div>
                            @endcan
                            
                            @can('solicitud')
                            <x-jet-dropdown-link href="{{ route('solicitud') }}">
                                {{ __('Solicitud de materiales') }}
                            </x-jet-dropdown-link>                             
                            <div class="border-t border-gray-100"></div>
                            @endcan
                            
                            @can('recepcion')
                            <x-jet-dropdown-link href="{{ route('recepcion') }}">
                                {{ __('Recepción de materiales') }}
                            </x-jet-dropdown-link> 
                            @endcan
                            
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endhasanyrole

                    
            </div>
            

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                        {{ Auth::user()->currentTeam->name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-jet-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                
                <!-- NOTIFICACIONESSS -->

                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            
                            <div class="m-4 inline-flex relative w-fit">
                                @if (Auth()->user()->unreadNotifications->count())                                    
                                    <span class="absolute inline-block top-0 right-0 bottom-auto left-auto translate-x-2/4 -translate-y-1/2 rotate-0 skew-x-0 skew-y-0 scale-x-100 scale-y-100 rounded-full z-10">
                                        <span class=" absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75 animate-ping"></span>
                                        <span class="relative inline-flex rounded-full px-2 text-white bg-indigo-500 items-center m-auto text-xs">
                                            {{Auth()->user()->unreadNotifications->count()}}
                                        </span>
                                    </span>
                                @else
                                    
                                @endif                                
                                <div class="flex items-center justify-center text-center">
                                  <i class="fas fa-bell fa-lg"></i>
                                </div>
                              </div>                           
                              
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Tienes '.Auth()->user()->unreadNotifications->count().' notificaciones') }}
                            </div>
                            @foreach (Auth()->user()->unreadNotifications as $notification)
                                @if ($notification->type=="App\Notifications\CreateSolicitud")
                                <x-jet-dropdown-link href="{{ route('leerNotificacion',[$notification->id,$notification->data['idSoli']])}}" >
                                    <p class="text-xs "> Nueva solicitud de Materiales de <strong class="text-indigo-500">{{ $notification->data["inspector"] }}</strong></p> 
                                </x-jet-dropdown-link>
                                <div class="border-t border-gray-100"></div>
                                @endif
                               
                            @endforeach                         
                            

                            <!-- Authentication -->
                            
                        </x-slot>
                    </x-jet-dropdown>
                </div>



                <!-- Settings Dropdown -->
                <div class="relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Cerrar') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Inicio') }}
            </x-jet-responsive-nav-link>
        </div>       
        
        @hasanyrole('inspector|supervisor|administrador') 
        <div x-data="{ open: false }" class="border-t border-indigo-200 ">
            <div  @click="open = ! open" class="p-4 bg-gray-100 flex w-full hover:bg-gray-200">
              <div class="flex gap-2 w-full justify-between items-center">                  
                  <h4 class="font-medium  text-indigo-700">Servicios</h4>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                  </svg>
              </div>             
            </div>
            <div x-show="open" @click.outside="open = false"  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 translate-y-0"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 translate-y-10"
                  x-transition:leave-end="opacity-0 translate-y-0" class="w-full">

            {{--OPCIONES--}}
                  @can('servicio')
                    <div class="space-y-1 border-b border-t">
                        <x-jet-responsive-nav-link href="{{ route('servicio') }}" :active="request()->routeIs('servicio')">
                            Nuevo Servicio
                        </x-jet-responsive-nav-link>
                    </div>
                  @endcan
                  
                  @can('certificaciones')
                    <div class="space-y-1">
                        <x-jet-responsive-nav-link href="{{ route('certificaciones') }}" :active="request()->routeIs('certificaciones')">
                            Listado de Servicios
                        </x-jet-responsive-nav-link>
                    </div>
                  @endcan

                  @can('admin.certificaciones')
                    <div class="space-y-1">
                        <x-jet-responsive-nav-link href="{{ route('admin.certificaciones') }}" :active="request()->routeIs('admin.certificaciones')">
                            Admin. Servicios
                        </x-jet-responsive-nav-link>
                    </div>
                  @endcan
            {{--FIN OPCIONES--}}

            </div>
        </div>
        @endhasanyrole

        

        @hasrole('administrador|Administrador taller') 
        <div x-data="{ open: false }" class="border-t border-indigo-200 ">
            <div  @click="open = ! open" class="p-4 bg-gray-100 flex w-full hover:bg-gray-200">
              <div class="flex gap-2 w-full justify-between items-center">                  
                  <h4 class="font-medium  text-indigo-700">Talleres</h4>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                  </svg>
              </div>             
            </div>
            <div x-show="open" @click.outside="open = false"  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 translate-y-0"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 translate-y-10"
                  x-transition:leave-end="opacity-0 translate-y-0" class="w-full">

            {{--OPCIONES--}}
                  @can('talleres')
                    <div class="space-y-1 border-b border-t">
                        <x-jet-responsive-nav-link href="{{ route('talleres') }}" :active="request()->routeIs('talleres')">
                           Listado de talleres
                        </x-jet-responsive-nav-link>
                    </div>
                  @endcan
                  @can('editar-taller')
                    <div class="space-y-1 border-b border-t">
                        <x-jet-responsive-nav-link href="{{ route('editar-taller', Auth::user()->taller ) }}" :active="request()->routeIs('edtiar-taller')">
                           Datos de taller
                        </x-jet-responsive-nav-link>
                    </div>
                  @endcan                 
            {{--FIN OPCIONES--}}

            </div>
        </div>
        @endhasrole


        <div x-data="{ open: false }" class="border-t border-indigo-200">
            <div  @click="open = ! open" class="p-4 bg-gray-100 flex w-full hover:bg-gray-200 ">
              <div class="flex gap-2 w-full justify-between items-center">                  
                  <h4 class="font-medium  text-indigo-700">Expedientes</h4>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                  </svg>
              </div>             
            </div>
            <div x-show="open" @click.outside="open = false"  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 translate-y-0"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 translate-y-10"
                  x-transition:leave-end="opacity-0 translate-y-0" class="w-full">

            {{--OPCIONES--}}
                  @can('expedientes')
                  <div class="space-y-1 border-t border-b">
                      <x-jet-responsive-nav-link href="{{ route('expedientes') }}" :active="request()->routeIs('expedientes')">
                        Listado Expedientes
                      </x-jet-responsive-nav-link>
                  </div>
                  @endcan
                  
                  @can('revisionExpedientes')
                  <div class="space-y-1">
                      <x-jet-responsive-nav-link href="{{ route('revisionExpedientes') }}" :active="request()->routeIs('revisionExpedientes')">
                          Revisión Expedientes
                      </x-jet-responsive-nav-link>
                  </div>
                  @endcan
            {{--FIN OPCIONES--}}
            </div>
        </div>
        

        <div x-data="{ open: false }" class="border-t border-indigo-200">
            <div  @click="open = ! open" class="p-4 bg-gray-100 flex w-full hover:bg-gray-200">
              <div class="flex gap-2 w-full justify-between items-center">                  
                  <h4 class="font-medium  text-indigo-700">
                    Materiales
                  </h4>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                  </svg>
              </div>             
            </div>
            <div x-show="open" @click.outside="open = false"  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 translate-y-0"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 translate-y-10"
                  x-transition:leave-end="opacity-0 translate-y-0" class="w-full">

            {{--OPCIONES--}}                            
                  @can('inventario')
                    <div class="space-y-1 border-t border-b">
                        <x-jet-responsive-nav-link href="{{ route('inventario') }}" :active="request()->routeIs('inventario')">
                            {{ __('Inventario') }}
                        </x-jet-responsive-nav-link>
                    </div>                  
                  @endcan
                                    
                  @can('ingresos')
                    <div class="border-b space-y-1">
                        <x-jet-responsive-nav-link href="{{ route('ingresos') }}" :active="request()->routeIs('ingresos')">
                            {{ __('Ingreso de Materiales') }}
                        </x-jet-responsive-nav-link>
                    </div>                                                  
                  @endcan
                  

                  @can('salidas')
                    <div class="border-b space-y-1">
                        <x-jet-responsive-nav-link href="{{ route('salidas') }}" :active="request()->routeIs('salidas')">
                            {{ __('Salida de materiales') }}
                        </x-jet-responsive-nav-link>
                    </div> 
                  @endcan
                  

                  @can('asignacion')
                    <div class="border-b space-y-1">
                        <x-jet-responsive-nav-link href="{{ route('asignacion') }}" :active="request()->routeIs('asignacion')">
                            {{ __('Asignación de materiales') }}
                        </x-jet-responsive-nav-link>
                    </div>                         
                  @endcan
                  
                  @can('solicitud')
                    <div class="border-b space-y-1">
                        <x-jet-responsive-nav-link href="{{ route('solicitud') }}" :active="request()->routeIs('solicitud')">
                            {{ __('Solicitud de materiales') }}
                        </x-jet-responsive-nav-link>
                    </div> 
                  @endcan
                  
                  @can('recepcion')
                    <div class="space-y-1">
                        <x-jet-responsive-nav-link href="{{ route('recepcion') }}" :active="request()->routeIs('recepcion')">
                            {{ __('Recepción de materiales') }}
                        </x-jet-responsive-nav-link>
                    </div>                   
                  @endcan
            {{--FIN OPCIONES--}}

            </div>
        </div>
        

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-indigo-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
