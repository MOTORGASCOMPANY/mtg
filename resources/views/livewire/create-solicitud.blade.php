<div>
    <div class="container block justify-center m-auto py-12">
        <h1 class="text-2xl font-bold text-center text-indigo-600 ">Nueva Solicitud de Materiales</h1>
        <div class="block flex-row w-full justify-center gap-2 mt-4 md:flex md:flex-row">
            <div class="md:w-1/2 w-full">
                <div class="flex p-8 items-center justify-center">
                    <div class="w-full  max-w-lg px-4 py-3 bg-white rounded-md shadow-md dark:bg-gray-800">
                        <div class="flex items-center justify-center">
                            <span class="text-xl font-semi-bold text-gray-800 dark:text-gray-400"><i
                                    class="fas fa-clipboard-list" style="color:#15aa44;"></i>&nbsp; Tu stock:</span>
                        </div>

                        <div class="mt-4">
                            <div class="mx-auto w-full flex flex-row justify-between items-center">
                                <p class="mt-2 text-md text-gray-600 dark:text-gray-300">Formatos GLP:</p> <span
                                    class=" mr-2 bg-indigo-200 px-1 rounded-full">{{$stockGLP}}</span>
                            </div>
                            <hr>
                            <div class="mx-auto w-full flex flex-row justify-between items-center">
                                <p class="mt-2 text-md text-gray-600 dark:text-gray-300">Formatos GNV:</p> <span
                                    class=" mr-2 bg-amber-200 px-1  text-black rounded-full">{{$stockGNV}}</span>
                            </div>
                            <hr>
                            <div class="mx-auto w-full flex flex-row justify-between items-center">
                                <p class="mt-2 text-md text-gray-600 dark:text-gray-300">Chips:</p> <span
                                    class=" mr-2 bg-indigo-200 px-1 rounded-full">{{$stockCHIP}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:w-1/2 w-full">
                <div class="block p-8 items-center justify-center">
                    <div class="w-full  max-w-lg px-4 py-3">
                        <div class="flex items-center justify-center">
                            <a  wire:click="$set('open',true)" class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-amber-400 hover:bg-amber-500 hover:cursor-pointer focus:outline-none rounded-full">
                                <p class="text-sm font-medium leading-none text-white"><i class="fas fa-plus"></i>&nbsp;Agregar Articulos</p>
                            </a>
                        </div>                        
                    </div>
                    @if ($articulos)
                        @foreach ($articulos as $key=>$item)
                            <div class="flex flex-row w-full justify-between max-w-lg px-4 py-3 bg-white mb-4 rounded-md shadow-md dark:bg-gray-800">
                                <div class="flex items-center justify-evenly">
                                    <span class="bg-lime-300 rounded-full px-2 mr-6">{{$item["nombre"]}}</span> <p>{{$item["cantidad"]}} <strong>UND.</strong></p>                           
                                </div>     
                                <div class="flex items-center justify-end">
                                    <button class="bg-sky-300 p-2 rounded-full shadow-lg border border-sky-400 hover:bg-sky-500" wire:click="eliminaArticulo({{$key}})"><i class="fas fa-times" style="color: darkgreen"></i></button>
                                </div>                   
                            </div>                        
                        @endforeach
                        <x-jet-input-error for="tipoM" />
                        <div class="w-full  max-w-lg px-4 py-3">
                            <div class="flex items-center justify-center">
                                <a  wire:click="guardaSolicitud" class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded-lg">
                                    <p class="text-sm font-medium leading-none text-white"><i class="fas fa-plus"></i>&nbsp;Registrar Solicitud</p>
                                </a>
                            </div>                        
                        </div>
                    @endif                      
                   
                </div>
            </div>
        </div>
    </div>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            <h1 class="text-xl font-bold">Agregar nuevo articulo a solicitud</h1>                                  
        </x-slot>        
        <x-slot name="content">     
                                
            <div class="mb-4  -mr-2">
                <x-jet-label value="articulo:" />
                <select wire:model="tipoM"
                    class="bg-gray-50  border-indigo-500 rounded-md outline-none -ml-1 block w-full ">
                    <option value="">Seleccione</option>
                    @if($tiposMateriales)
                        @foreach ($tiposMateriales as $tipo)
                            @if ($tipo['estado'] == 1)
                                <option value="{{ $tipo['id'] }}">{{ $tipo['nombre'] }}</option>
                            @else
                                <option value="{{ $tipo['id'] }}" disabled>{{ $tipo['nombre'] }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
                <x-jet-input-error for="tipoM" />
            </div> 
            <div class="mb-4">
                <x-jet-label value="Cantidad:"/>
                <x-jet-input type="number" class="w-full" wire:model="cantidad"/>
                <x-jet-input-error for="cantidad"/>
            </div>           
        </x-slot>
        
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="agregarArticulo" wire:loading.attr="disabled" wire:target="agregarArticulo">
                Agregar 
            </x-jet-button>            
        </x-slot>

    </x-jet-dialog-modal>
</div>
