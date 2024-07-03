<div class="mb-4">

    <button wire:click="$set('open',true)"
        class="bg-indigo-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer">Agregar</button>


    <x-jet-dialog-modal wire:model="open">
        
        <x-slot name="title">
            <h1 class="text-xl font-bold">Crear nuevo Taller</h1>
            @if(isset($taller))
            <p>{{$taller->nombre}}</p>
            @endif
        </x-slot>
        <x-slot name="content">

            <div class="mb-4">
                <x-jet-label value="Nombre:" />
                <x-jet-input type="text" class="w-full" wire:model="nombre" />
                <x-jet-input-error for="nombre" />
            </div>

            <div class="mb-4">
                <x-jet-label value="Ruc:" />
                <x-jet-input type="text" class="w-full" wire:model="ruc"   maxlength="11"/>
                <x-jet-input-error for="ruc" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Representante del taller:" />
                <x-jet-input type="text" class="w-full" wire:model="representante" />
                <x-jet-input-error for="representante" />
            </div>            
            <div class="mb-4">
                <x-jet-label value="Direccion:" />
                <x-jet-input type="text" class="w-full" wire:model="direccion" />
                <x-jet-input-error for="direccion" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Telefono:" />
                <x-jet-input type="text" class="w-full" wire:model="telefono" />
                <x-jet-input-error for="telefono" />
            </div>            
            <div class="mb-4">
                <x-jet-label value="N° Autorizacion:" />
                <x-jet-input type="text" class="w-full" wire:model="autorizacion" />
                <x-jet-input-error for="autorizacion" />
            </div>           

            <div class="grid grid-flow-row-dense grid-cols-2">

                <div>
                    <x-jet-label value="Departamento:" />
                    <select wire:model="departamentoSel" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                        <option value="null">Seleccione</option>
                        @foreach ($departamentos as $depart)
                            <option value="{{ $depart->id }}">{{ $depart->departamento }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="departamentoSel"/>
                </div>              
                
                <div>
                    <x-jet-label value="Provincia:"/>
                    <select wire:model="provinciaSel" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                        @if ($provincias)
                            <option value="null">Seleccione</option>
                            @foreach ($provincias as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->provincia }}</option>
                            @endforeach
                        @else
                            <option value="">Seleccione Depart.</option>
                        @endif
                        
                    </select>
                    <x-jet-input-error for="provinciaSel"/>
                </div>               
            </div>

            

            <div class="mb-4">
                <x-jet-label value="Distrito:" />
                <select wire:model="distritoSel" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full pr-2 ">
                    @if ($distritos)
                        <option value="null">Seleccione</option>
                        @foreach ($distritos as $dist)
                            <option value="{{ $dist->id }}">{{ $dist->distrito }}</option>
                        @endforeach
                    @else
                        <option value="">Seleccione Prov.</option>
                    @endif                       
                </select>
                <x-jet-input-error for="distritoSel"/>
            </div>

            <div class="mb-4">
                <x-jet-label value="Logo:" />
                <x-jet-input type="file"  class="w-full" wire:model="logo"
                    accept=".jpg,.png,.jpeg,.gif,.bmp,.tif,.tiff" />
                <x-jet-input-error for="logo" />                
            </div>
            <div wire:loading wire:target="logo"
                class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                Espere un momento mientras se carga la imagen.
            </div>
            @if($logo)            
                @if($logo->extension()=='png'|| $logo->extension()=='jpeg' || $logo->extension()=='jpg' || $logo->extension()=='gif' || $logo->extension()=='gift' || $logo->extension()=='bmp'|| $logo->extension()=='tif' || $logo->extension()=='tiff')
                    <div class="w-full p-1 md:p-2 items-center justify-center" >
                        <img alt="gallery"
                            class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg"
                            src="{{ $logo->temporaryUrl() }}">                
                    </div>
                @endif
            @endif

            <div class="mb-4">
                <x-jet-label value="Firma:" />
                <x-jet-input type="file"  class="w-full" wire:model="firma"
                    accept=".jpg,.png,.jpeg,.gif,.bmp,.tif,.tiff" />
                <x-jet-input-error for="firma" />                
            </div>
            <div wire:loading wire:target="firma"
                class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                Espere un momento mientras se carga la imagen.
            </div>
            @if($firma)           
                @if($firma->extension()=='png'|| $firma->extension()=='jpg' || $firma->extension()=='jpeg' ||$firma->extension()=='gif' ||$firma->extension()=='gift' || $firma->extension()=='bmp' || $firma->extension()=='tif' || $firma->extension()=='tiff')
                    <div class="w-full p-1 md:p-2 items-center justify-center" >
                        <img alt="gallery"
                            class="mx-auto flex object-fit object-center w-36 h-36 rounded-lg"
                            src="{{ $firma->temporaryUrl() }}">                
                    </div>
                @endif
            @endif
            <h1 class="font-bold">Servicios: </h1>
            <hr class="py-2">

            <div class="mb-4">


                @foreach ($servicios as $key => $item)
                    <div class="flex flex-row justify-between bg-indigo-100 my-2 items-center rounded-lg p-2">
                        <div class="">
                            <input
                                class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white outline-transparent checked:bg-indigo-600 checked:border-indigo-600 outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                wire:model="tipos.{{ $key }}" value="{{ $item->id }}" type="checkbox">
                            <label class="form-check-label inline-block text-gray-800">
                                {{ $item->descripcion }}
                            </label>
                        </div>
                        <div class="flex flex-row items-center">
                            <x-jet-label value="precio:" />
                            <x-jet-input type="number" class="w-6px" wire:model="precios.{{ $key }}" />
                        </div>
                    </div>
                    <x-jet-input-error for="tipos.{{ $key }}" />
                    <x-jet-input-error for="precios.{{ $key }}" />
                @endforeach
                <hr>
                <x-jet-input-error for="tipos" />
                <x-jet-input-error for="precios" />

            </div>


            {{--
            <div class="flex justify-center mb-4">
                <x-jet-secondary-button class="mx-2 bg-lime-200" wire:click="agregaServicio">
                    Agregar servicio  <i class="fas fa-plus ml-1"></i>
                </x-jet-secondary-button>                
            </div> 

            @if ($serv)
                @for ($i = 0; $i < $serv; $i++)
                <div class="mb-4 p-2 bg-gray-300 rounded-sm flex flex-row items-center">
                    <select class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                        <option value="">Seleccione</option>
                        @foreach ($servicios as $item)
                        <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                        @endforeach                      
                    </select>
                    <x-jet-input-error for=""/> 

                    <x-jet-label value="precio:"/>
                    <x-jet-input type="text" class="w-full" wire:model="precio"/>
                    <x-jet-input-error for="precio" />  
                    
                    <div class="mx-2 flex flex-row">
                        <x-jet-secondary-button class="bg-lime-300">
                            <i class="fas fa-check-circle py-1"></i>
                        </x-jet-secondary-button>     
                        <x-jet-secondary-button class="bg-red-500" wire:click="borraServicio">
                            <i class="fas fa-times py-1"></i>
                        </x-jet-secondary-button> 
                    </div>
                </div>  
                @endfor
            @endif
                --}}

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="save" wire:loading.attr="disabled" wire:target="save,files,documentos">
                Guardar
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>

</div>
