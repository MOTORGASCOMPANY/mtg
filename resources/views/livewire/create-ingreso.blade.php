<div>
<div>
    <button  wire:click="$set('open',true)" class="bg-indigo-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer">Agregar</button>
</div>
<x-jet-dialog-modal wire:model="open">
    <x-slot name="title">
        <h1 class="text-xl font-bold">Nuevo Ingreso</h1>                                  
    </x-slot>        
    <x-slot name="content">     
                            
        <div class="mb-4">
            <x-jet-label value="N° de guia:"/>
            <x-jet-input type="text" class="w-full" wire:model="numguia" />
            <x-jet-input-error for="numguia"/>
        </div>   
        <div class="mb-4">
            <x-jet-label value="Motivo:"/>
            <x-jet-input type="text" class="w-full" wire:model="motivo" />
            <x-jet-input-error for="motivo"/>
        </div> 
        
        <div class="mb-4 p-6 bg-gray-200 rounded-lg">    
            <div>
                <x-jet-label value="Tipo de Articulo:" for="tipoMat"/>
                <select class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full -ml-1" wire:model="tipoMat">
                    <option value="">Seleccione</option>
                    @foreach ($tiposMaterial as $t)
                        <option value="{{ $t->id }}">{{ $t->descripcion }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="tipoMat" />
            </div>

            @switch($mostrar)
                @case(1)
                    <div>
                        <x-jet-label value="Cantidad:" />
                        <x-jet-input type="number" class="w-full" wire:model="cantidad" />
                        <x-jet-input-error for="cantidad" />
                    </div>
                    <div>
                        <x-jet-label value="Año de Actividad:" />
                        <x-jet-input type="number" class="w-full" wire:model="anioActivo" />
                        <x-jet-input-error for="anioActivo" />
                    </div>
                    <div>
                        <x-jet-label value="N° de inicio" />
                        <x-jet-input type="number" class="w-full" wire:model="numInicio" />
                        <x-jet-input-error for="numInicio" />
                    </div>
                    <div>
                        <x-jet-label value="N° de Final" />
                        <x-jet-input type="number" class="w-full" wire:model="numFinal" enable />
                        <x-jet-input-error for="numFinal" />
                    </div>
                    @break
                @case(2)
                    <div>
                        <x-jet-label value="Cantidad:" />
                        <x-jet-input type="number" class="w-full" wire:model="cantidad" />
                        <x-jet-input-error for="cantidad" />
                    </div>
                    @break
                @default
                    <h1>Selecciona un tipo de articulo</h1>
            @endswitch                 
        </div>
            
           
            
       
        <div wire:loading  wire:target="save" class="bg-indigo-400 p-4 text-center w-full rounded-lg border border-indigo-500 shadow-lg">
            <p><i class="fas fa-fan animate-spin text-white"></i></p>            
            <p> Creando materiales por favor espere...</p>                   
        </div>
        
        @if ($temp)
            @if ($temp->count() >= 1)
                <div class="p-4 bg-red-400 items-center text-align-center rounded-lg shadow-xl border border-red-500">
                    <p>⚠ <strong class="text-yellow-200">Error.</strong></p>
                    <p >Se encontrarón {{ $temp->count()}} formatos existentes en el rango de series que ingresaste, por favor ingresa un rango de series válido.</p>            
                </div>
            @endif            
        @endif
        
    </x-slot>
    
    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
            Cancelar
        </x-jet-secondary-button>
        <x-jet-button wire:click="save" wire:loading.attr="disabled" wire:target="save,validaSeries">
            Guardar
        </x-jet-button>            
    </x-slot>

</x-jet-dialog-modal>

</div>
