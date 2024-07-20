<div class="container mx-auto py-12 mt-4">
    <div class="flex flex-row  justify-between items-center">
        <h2 class="mt-8 font-bold text-lg text-indigo-600"> Comprobantes de
            @if ($boleta->taller == null)
                {{ $boleta->certificador }}
            @elseif ($boleta->certificador == null)
                taller {{ $boleta->taller }}
            @else
            @endif
            desde {{ $boleta->fechaInicio }} hasta {{ $boleta->fechaFin }}
            con el monto  {{ 'S/' . $boleta->monto ?? null}}
        </h2>        

        <div class="flex space-x-2">
            @hasanyrole('administrador|Administrador del sistema')
                @livewire('create-boleta-archivo', ['idBoleta' => $boleta->id])
            @endhasanyrole
            <a href="{{ route('generaPdfBoleta', ['id' => $boleta->id]) }}" target="_blank"
                class="group flex py-4 px-4 text-center rounded-md bg-indigo-300 font-bold text-white cursor-pointer hover:bg-indigo-400 hover:animate-pulse">
                <i class="fa-solid fa-file-pdf"></i>
                <span
                    class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                    Pdf
                </span>
            </a>
            {{-- 
             <button data-tooltip-target="tooltip-dark" type="button" wire:click="generatePdf"
                class="group flex py-4 px-4 text-center rounded-md bg-indigo-300 font-bold text-white cursor-pointer hover:bg-indigo-400 hover:animate-pulse">
                <i class="fa-solid fa-file-pdf"></i>
                <span
                    class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                    Pdf
                </span>
             </button>
            --}}
            <div class="w-full ml-0 md:w-2/6 flex justify-start items-center">                                        
                <x-jet-label value="¿Completo?" class="py-2 ml-2 mr-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer" />
                <x-jet-input type="checkbox" wire:model="auditoria" class="w-6 h-6 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500 ml-2" />                    
                <x-jet-input-error for="auditoria" />
            </div>

            {{-- 
             <button data-tooltip-target="tooltip-dark" type="button" wire:click="regresar" wire:target="regresar"
                class="group flex py-4 px-4 text-center rounded-md bg-indigo-400 font-bold text-white cursor-pointer hover:bg-indigo-500 hover:animate-pulse">
                <i class="fa-solid fa-rotate-left"></i>
                <span
                    class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                    Regresar
                </span>
             </button>
            --}}
        </div>
    </div>
    <hr class="my-4">
    <div>
        @livewire('boletas-archivos', ['idBoleta' => $boleta->id], key($boleta->boleta_id . '-' . $boleta->id))
    </div>


</div>
