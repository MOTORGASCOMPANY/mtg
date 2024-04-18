<div>
    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <div class="mt-8 text-2xl">
            Hola, {{ Auth::user()->name }} 👋.
            <span> </span>
        </div>
    </div>
    <div class="divide-y-2 divide-indigo-400">
        
        @hasanyrole("administrador|Administrador del Sistema")
        <div x-data="{ open: true }"
            class=" bg-white flex flex-col items-center justify-center relative overflow-hidden w-full border ">
            <div @click="open = ! open" class="bg-indigo-100 p-6 w-full flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i class="fas fa-tools pl-5 text-indigo-600"></i>
                    <p class="ml-4 text-lg text-indigo-600 leading-7 font-semibold" >
                        Servicios:
                    </p>
                </div>
                <i class="fas fa-chevron-down fa-lg text-indigo-600"></i>
            </div>
            <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-0" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-10"
                x-transition:leave-end="opacity-0 translate-y-0" class="w-full bg-white">
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
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-10"
                x-transition:leave-end="opacity-0 translate-y-0" class="w-full bg-white">
               
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
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-10"
                x-transition:leave-end="opacity-0 translate-y-0" class="w-full bg-white">
               
               @livewire('resumen-documentos')                

            </div>
        </div>
        @endhasanyrole
  
    </div>
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
