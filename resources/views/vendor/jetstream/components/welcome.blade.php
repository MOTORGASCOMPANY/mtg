<div>
    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <div class="mt-8 text-2xl">
            Hola, {{ Auth::user()->name }} 👋
            <span> </span>

            @if (Auth()->user()->unreadNotifications->count() > 0)
                <div class="block py-4 text-base text-gray-500">
                    {{ __('Tienes ' . Auth()->user()->unreadNotifications->count() . ' notificaciones sin abrir 🔔') }}
                </div>
            @endif
        </div>
    </div>

    <div class="divide-y-2 divide-indigo-400">

        @hasanyrole('administrador|Administrador del sistema')
            <div x-data="{ open: true }"
                class=" bg-white flex flex-col items-center justify-center relative overflow-hidden w-full border ">
                <div @click="open = ! open" class="bg-indigo-100 p-6 w-full flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-tools pl-5 text-indigo-600"></i>
                        <p class="ml-4 text-lg text-indigo-600 leading-7 font-semibold">
                            Servicios:
                        </p>
                    </div>
                    <i class="fas fa-chevron-down fa-lg text-indigo-600"></i>
                </div>
                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-0" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-10" x-transition:leave-end="opacity-0 translate-y-0"
                    class="w-full bg-white">
                    @livewire('resumen-servicios')
                </div>
            </div>
        @endhasanyrole

        @hasanyrole('Administrador taller|inspector|Administrador del Sistema')
            <div x-data="{ open: true }"
                class=" bg-white flex flex-col items-center justify-center relative overflow-hidden w-full">
                <div @click="open = ! open" class="bg-indigo-100 p-6 w-full flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-file-archive pl-5 text-indigo-600"></i>
                        <p class="ml-4 text-lg text-indigo-600 leading-7 font-semibold">
                            Expedientes:
                        </p>
                    </div>
                    <i class="fas fa-chevron-down fa-lg text-indigo-600"></i>
                </div>
                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-0" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-10" x-transition:leave-end="opacity-0 translate-y-0"
                    class="w-full bg-white">

                    @livewire('resumen-expedientes')

                </div>
            </div>

            {{--
            <div x-data="{ open: true }"
            class=" bg-white flex flex-col items-center justify-center relative overflow-hidden w-full">
            <div @click="open = ! open" class="bg-indigo-100 p-6 w-full flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i class="fas fa-book pl-5 text-indigo-600"></i>
                    <p class="ml-4 text-lg text-indigo-600 leading-7 font-semibold">
                        Manual de Funciones:
                    </p>
                </div>
                <i class="fas fa-chevron-down fa-lg text-indigo-600"></i>
            </div>
            <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-0" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-10"
                x-transition:leave-end="opacity-0 translate-y-0" class="w-full bg-white">
               
                
            </div>
            </div>
            <div x-data="{ open: true }"
            class=" bg-white flex flex-col items-center justify-center relative overflow-hidden w-full">
            <div @click="open = ! open" class="bg-indigo-100 p-6 w-full flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i class="fas fa-sitemap pl-5 text-indigo-600"></i>
                    <p class="ml-4 text-lg text-indigo-600 leading-7 font-semibold">
                        Organigrama:
                    </p>
                </div>
                <i class="fas fa-chevron-down fa-lg text-indigo-600"></i>
            </div>
            <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-0" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-10"
                x-transition:leave-end="opacity-0 translate-y-0" class="w-full bg-white">
               
                
            </div>
            </div>
            --}}
        @endhasanyrole

        @hasanyrole('Administrador taller')
            <div x-data="{ open: true }"
                class=" bg-white flex flex-col items-center justify-center relative overflow-hidden w-full">
                <div @click="open = ! open" class="bg-indigo-100 p-6 w-full flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-file-archive pl-5 text-indigo-600"></i>
                        <p class="ml-4 text-lg text-indigo-600 leading-7 font-semibold">
                            Documentos de Taller:
                        </p>
                    </div>
                    <i class="fas fa-chevron-down fa-lg text-indigo-600"></i>
                </div>
                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-0" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-10" x-transition:leave-end="opacity-0 translate-y-0"
                    class="w-full bg-white">

                    @livewire('resumen-documentos')

                </div>
            </div>
        @endhasanyrole

    </div>

    {{-- COMUNICADO --}}
    @hasanyrole('Administrador taller|inspector|supervisor|administrador')
        <div class="mt-16 fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- FONDO OSCURO MODAL -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <div
                    class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <button class="absolute top-0 right-0 mt-4 mr-4 focus:outline-none" onclick="closeModal()">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                    <a class="py-2 h-1/2">
                        <img src="{{ asset('images/images/logomemo.png') }}" />
                    </a>

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 relative">
                        <h3 class="text-lg font-medium text-center text-gray-600 mb-4" id="modal-title">Comunicado</h3>
                        <p class="text-sm text-gray-500 mb-4" style="text-align: justify;">
                            Para su conocimiento, al momento de ingresar un nuevo servicio y digitar la placa NO DEBE TENER ESPACIOS, NI GUIONES .                        
                        </p>
                        <p>Forma Incorrepta:
                            <img class="pl-16" src="images/images/incorrepto.PNG">
                        </p>
                        <p class="mt-4">Forma Correpta:
                            <img class="pl-16" src="images/images/correcto.PNG">
                        </p>

                        <p class="mt-8 text-sm text-gray-500 mb-4" style="text-align: justify;">
                            Por otro lado cuando el nuevo servicio es "Chip por deterioro" la forma correcta de colocar los propietarios es con (-) y la placa sin espacios todo junto.                           
                        </p>
                        <p>Forma Incorrepta:
                            <img src="images/images/incorrepto2.PNG">
                        </p>
                        <p class="mt-4">Forma Correpta:
                            <img src="images/images/correcto2.PNG">
                        </p>
                            
                        
                        
                    </div>
                </div>
            </div>
        </div>
    @endhasanyrole
    

    {{--
                           <p class="text-sm text-gray-500 mb-4" style="text-align: justify;">
                            Queremos expresarte nuestro más sincero agradecimiento por tu dedicación y compromiso en cada
                            tarea que realizas como parte de nuestro equipo de trabajo. Tu labor es fundamental para
                            garantizar la calidad y seguridad en cada certificación que entregamos a nuestros clientes.
                           </p>
                           <p class="text-sm text-gray-500 mb-4" style="text-align: justify;">
                            Esperamos seguir contando con tu invaluable colaboración en este viaje de crecimiento y
                            superación. Juntos, seguiremos alcanzando nuevas metas y brindando el mejor servicio a nuestros
                            clientes.
                           </p>
                           <p class="text-sm text-gray-500 text-center mb-4">
                            ¡¡¡ Gracias por confiar en nosotros y por ser parte de nuestra familia !!!
                            Con aprecio y gratitud,
                           </p>
    --}}



    <script>
        function openModal() {
            document.body.classList.add('overflow-hidden');
            document.querySelector('[aria-labelledby="modal-title"]').classList.remove('hidden');
        }

        function closeModal() {
            document.body.classList.remove('overflow-hidden');
            document.querySelector('[aria-labelledby="modal-title"]').classList.add('hidden');
        }
    </script>

</div>


{{--  
    @can('expedientes')
    @livewire('resumen-expedientes')
    @endcan
    @can('talleres.revision')
    @livewire('resumen-expedientes')
    @endcan
 
    <hr>
    @livewire('resumen-servicios')
    
   
    
--}}
