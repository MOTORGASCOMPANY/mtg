<div class="mt-12 pt-8 w-full items-center">
    <h1 class="w-full m-auto text-center font-bold text-2xl">Listado de recepciones pendientes</h1>
    @if (count($recepciones))
        <div class="block m-auto pt-12 items-center justify-center w-96">
         @foreach ($recepciones as $recepcion)
            <div class="mb-4 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-indigo-200 dark:bg-gray-800 dark:border-gray-700">   
                <div class="flex flex-row justify-between">
                    <i class="fas fa-box"></i>       <span class="text-sm font-bold text-green-700">{{$recepcion->created_at}}</span>   
                </div>                  
                <a href="#">
                   <span>Codigo:</span> <h5 class="mb-2 text-sm font-semibold tracking-tight text-red-700 dark:text-white">{{$recepcion->numero}}</h5>
                </a>
                <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Motivo de envio: <strong> {{$recepcion->motivo}} </strong></p>
                <a wire:click="recepcionar({{$recepcion}})"class="mr-0 cursor-pointer focus:ring-2 text-white focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-4 py-2 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                    Recepcionar               
                </a>
            </div>        
        @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center mt-56">
            <div>
                <i class="fas fa-exclamation-circle fa-5x mb-4" style="color:#6258C8"></i>               
            </div>
            <div>
                <p class="font-bold text-md text-white p-8 bg-amber-400 rounded-xl">No tienes ninguna recepción de materiales pendiente</p>
            </div>          
        </div>
    @endif
    
    <x-jet-dialog-modal wire:model="open" wire:loading.attr="disabled" >
        <x-slot name="title" class="font-bold">
            <h1 class="font-bold text-xl">Recepción:</h1>
        </x-slot>    
        <x-slot name="content">    
            <div class="mt-4">
                @if($recepcion)
                <p>codigo: <strong class="text-red-900">{{$recepcion->numero}}</strong></p>
                <p>creado por: <span class="p-1 bg-red-400 rounded-lg">{{$recepcion->usuarioCreador->name}}</span></p>
                <p>fecha de creación: <span class="p-1 bg-lime-400 rounded-lg">{{$recepcion->created_at}}</span></p>
                <p>Motivo de envio: {{$recepcion->motivo}}</p>
                <br>
                <h1 class="font-bold underline">Detalles de envio:</h1>  
                @endif             
                @if($materiales)
                        <div class="flex flex-row justify-between m-auto w-96">
                            <p class="font-bold text-red-900">Material</p> 
                            <p class="font-bold text-red-900">cantidad</p> 
                            <p class="font-bold text-red-900">desde</p>
                            <p class="font-bold text-red-900">hasta</p>
                        </div>
                        <hr class="mb-2 w-96 m-auto">               
                    @foreach ($materiales as $material)
                        <div class="flex flex-row justify-between m-auto w-96">
                            <p>{{$material["tipo"]}}</p> 
                            <p>{{$material["cantidad"]}}</p> 
                            <p>{{ $material["numSerieMin"] }}</p>
                            <p>{{ $material["numSerieMax"] }}</p>
                            {{--
                            ." (".($material["tipo"] = 1  ?  :).")"    
                            --}}
                        </div>
                        <hr class="mb-2 w-96 m-auto">                        
                    @endforeach             
                @endif   
                 
            </div>
            <div class="mt-4">
                <label for="acepto" class="flex items-center">
                    <x-jet-checkbox id="acepto" wire:model="acepto" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Acepto y estoy de acuerdo con la recepción de los materiales asignados en este cargo.') }}</span>                    
                </label>
                <x-jet-input-error for="acepto" />
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="terminar" wire:loading.attr="disabled" wire:target="terminar" >
                Recepcionar
            </x-jet-button>   
        </x-slot>    
    </x-jet-dialog-modal>


</div>
