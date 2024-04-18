<div class="flex box-border">  
  <div class="container mx-auto py-12">
    <x-table-talleres>
            @if (count($talleres))            
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full leading-normal rounded-md">
                                <thead class="bg-slate-600 border-b font-bold text-white">
                                    <tr>
                                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                            wire:click="order('id')">
                                            Id
                                            @if ($sort == 'id')
                                              @if ($direction == 'asc')
                                                  <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                              @else
                                                  <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                              @endif
                                            @else
                                                <i class="fas fa-sort float-right mt-0.5"></i>
                                            @endif
                                        </th>
                                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                            wire:click="order('nombre')">
                                            Nombre    
                                            @if ($sort == 'nombre')
                                              @if ($direction == 'asc')
                                              <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                              @else
                                                  <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                              @endif
                                            @else
                                                <i class="fas fa-sort float-right mt-0.5"></i>
                                            @endif
                                        </th>
                                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                            wire:click="order('direccion')">
                                            Dirección
                                            @if ($sort == 'direccion')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort float-right mt-0.5"></i>
                                            @endif
                                        </th>
                                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                            wire:click="order('ruc')">
                                            Ruc
                                            @if ($sort == 'ruc')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort float-right mt-0.5"></i>
                                            @endif
                                        </th>    
                                        <th scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                            wire:click="order('idDistrito')">
                                            Distrito
                                            @if ($sort == 'idDistrito')
                                                @if ($direction == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-sort float-right mt-0.5"></i>
                                            @endif
                                        </th>                                         
                                        <th
                                        scope="col" class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-300"> 
                                    @foreach ($talleres as $item)
                                        <tr tabindex="0" class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-200">
                                            <td class="pl-5">
                                                <div class="flex items-center">
                                                    <p class="bg-indigo-200 rounded-sm w-5 h-5 flex flex-shrink-0 justify-center items-center relative text-indigo-900">
                                                        {{ strtoupper($item->id) }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="pl-2">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-medium leading-none text-gray-600 mr-2">
                                                        {{ $item->nombre }}
                                                    </p>
                                                </div>
                                            </td>                                            
                                            <td class="pl-2">
                                                <p class="text-sm leading-none text-gray-600 ml-2">{{ $item->direccion }}</p>
                                            </td>
                                            <td class="pl-2">
                                                <div class="flex items-center">
                                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                                        {{ $item->ruc }}
                                                    </p>
                                                </div>
                                            </td>     
                                            <td class="pl-2">
                                                <div class="flex items-center">
                                                    <p class="text-sm leading-none text-gray-600 ml-2">
                                                        @if(isset($item->Distrito->distrito))
                                                            {{ $item->Distrito->distrito }}
                                                        @else
                                                            SIN DATOS
                                                        @endif
                                                    </p>
                                                </div>
                                            </td>
                                           
                                                                                      

                                            <td class="pl-2">
                                                {{-- @livewire('edit-usuario', ['usuario' => $usuario], key($usuario->id)) --}}
                                                <div class="flex justify-end space-x-2">
                                                    <a 
                                                    wire:click="edit({{ $item }})"
                                                   {{--href="{{ route('editar-taller',$item->id)}}"--}}
                                                    class="group flex py-4 px-4 text-center rounded-md bg-lime-300 font-bold text-white cursor-pointer hover:bg-lime-400 hover:animate-pulse" >
                                                        <i class="fas fa-edit"></i>
                                                        <span class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto">
                                                            Editar
                                                        </span>
                                                    </a>
                                                    @if($this->obtieneServiciosDisponibles($item)->count()>0)
                                                    <button data-tooltip-target="tooltip-dark" type="button" class="group flex py-4 px-4 text-center rounded-md bg-orange-300 font-bold text-white cursor-pointer hover:bg-orange-400 hover:animate-pulse" wire:click="agregarServicios({{ $item }})">
                                                        <i class="fas fa-plus-circle"></i>                                                          
                                                        <span class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto">
                                                            Agregar servicios
                                                        </span>
                                                    </button>                                                  
                                                    @endif   

                                                    {{--@livewire('create-documento-taller', ['idTaller' => $item->id], key($item->id))    --}}
                                                        
                                                    <a wire:click="redirectEditarTaller({{ $item->id }})" class="group flex py-4 px-4 text-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400  hover:animate-pulse">                                                        
                                                        <i class="fas fa-folder-plus"></i>
                                                        <span class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                                                           Datos/Doc
                                                        </span>
                                                    </a>  
                                                         
                                                    <a class="group flex py-4 px-4 text-center rounded-md bg-indigo-300 font-bold text-white cursor-pointer hover:bg-indigo-400  hover:animate-pulse">
                                                        <i class="fas fa-trash"></i>
                                                        <span class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto">
                                                           Eliminar
                                                        </span>
                                                    </a>        
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>            
            @if ($talleres->hasPages())
                <div>
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <div class="px-5 py-5 bg-white border-t">
                                {{ $talleres->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>                        
            @endif
            
        @else
            <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                No se encontro ningun registro.
            </div>
        @endif   
    </x-table-talleres>        
   </div> 

{{-- MODAL PARA EDITAR TALLER --}}
   <x-jet-dialog-modal wire:model="editando" wire:loading.attr="disabled" >
    <x-slot name="title" class="font-bold">
      <h1 class="text-xl font-bold">Editar Taller</h1> 
    </x-slot>

    <x-slot name="content">     
        <div class="mb-4">
            <x-jet-label value="Nombre:" />
            <x-jet-input wire:model="taller.nombre" type="text" class="w-full" />
            <x-jet-input-error for="taller.nombre" />            
        </div>
        <div class="mb-4">
            <x-jet-label value="RUC:" />
            <x-jet-input wire:model="taller.ruc" type="text" class="w-full" maxlength="11"/>
            <x-jet-input-error for="taller.ruc" />
        </div> 
        <div class="mb-4">
            <x-jet-label value="Representante del taller:" />
            <x-jet-input wire:model="taller.representante" type="text" class="w-full" />
            <x-jet-input-error for="taller.representante" />
          </div>     
        <div class="mb-4">
          <x-jet-label value="Direccion:" />
          <x-jet-input wire:model="taller.direccion" type="text" class="w-full" />
          <x-jet-input-error for="taller.direccion" />
        </div>  
        

    <div class="grid grid-flow-row-dense grid-cols-2">

        <div>
            <x-jet-label value="Departamento:" />
            <select wire:model="departamentoSel" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                <option value="null">Seleccione</option>
                @foreach ($departamentosTaller as $depart)
                    <option value="{{ $depart->id }}">{{ $depart->departamento }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="departamentoSel"/>
        </div>              
        
        <div>
            <x-jet-label value="Provincia:"/>
            <select wire:model="provinciaSel" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                @if ($provinciasTaller)
                    <option value="null">Seleccione</option>
                    @foreach ($provinciasTaller as $prov)
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
        <select wire:model="taller.idDistrito" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full pr-2 ">
            @if ($distritosTaller)
                <option value="null">Seleccione</option>
                @foreach ($distritosTaller as $dist)
                    <option value="{{ $dist->id }}">{{ $dist->distrito }}</option>
                @endforeach
            @else
                <option value="">Seleccione Prov.</option>
            @endif                       
        </select>
        <x-jet-input-error for="taller.idDistrito"/>
    </div>

    <div class="mb-4">
        <x-jet-label value="Logo:" />
        <x-jet-input type="file"  class="w-full" wire:model="logoNuevo"
            accept=".jpg,.png,.jpeg,.gif,.bmp,.tif,.tiff" />
        <x-jet-input-error for="logoNuevo" />                
    </div>
    <div wire:loading wire:target="logoNuevo"
        class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
        Espere un momento mientras se carga la imagen.
    </div>
    @if($logoNuevo)   
        @if( $logoNuevo->extension()=='png'|| $logoNuevo->extension()=='jpeg' || $logoNuevo->extension()=='jpg' || $logoNuevo->extension()=='gif' || $logoNuevo->extension()=='gift' || $logoNuevo->extension()=='bmp'|| $logoNuevo->extension()=='tif' || $logoNuevo->extension()=='tiff')
            <div class="w-full p-1 md:p-2 items-center justify-center" id="{{$index}}-ind">
                <img alt="gallery"
                    class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg"
                    src="{{ $logoNuevo->temporaryUrl() }}">                
            </div>
        {{--
        @else
            <div>
                <p class="text-center text-red-500"> ⚠ Formato inválido cargue un archivo de tipo imagen.</p> 
            </div>
        --}}
        @endif          
    @else
        @if($logoTaller)
            <div class="w-full p-1 md:p-2 items-center justify-center" id="{{$index}}-src">
                <img alt="gallery" class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg" src="{{Storage::url($logoTaller)}}">                
            </div>            
        @else
            <div class="w-full m-auto">
                <p class="text-center text-red-500"> ⚠ No se a cargado ningún logo.</p>               
            </div>
        @endif                    
    @endif

    <div class="mb-4">
        <x-jet-label value="Firma:" />
        <x-jet-input type="file"  class="w-full" wire:model="firmaNuevo"
            accept=".jpg,.png,.jpeg,.gif,.bmp,.tif,.tiff" />
        <x-jet-input-error for="firmaNuevo" />                
    </div>
    <div wire:loading wire:target="firmaNuevo"
        class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
        Espere un momento mientras se carga la imagen.
    </div>     

    @if($firmaNuevo)   
        @if( $firmaNuevo->extension()=='png' || $firmaNuevo->extension()=='jpg' || $firmaNuevo->extension()=='jpeg' || $firmaNuevo->extension()=='gif' || $firmaNuevo->extension()=='gift' || $firmaNuevo->extension()=='bmp'|| $firmaNuevo->extension()=='tif' || $firmaNuevo->extension()=='tiff')
            <div class="w-full p-1 md:p-2 items-center justify-center" id="{{$index}}-in">
                <img alt="gallery"
                    class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg"
                    src="{{ $firmaNuevo->temporaryUrl() }}">                
            </div>
        {{--
        @else
            <div>
                <p class="text-center text-red-500"> ⚠ Formato inválido cargue un archivo de tipo imagen.</p> 
            </div>
        --}}
        @endif          
    @else
        @if($firmaTaller)
            <div class="w-full p-1 md:p-2 items-center justify-center" id="{{$index}}-src-2">
                <img alt="gallery" class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg" src="{{Storage::url($firmaTaller)}}">                
            </div>            
        @else      
            <div class="w-full m-auto">
                <p class="text-center text-red-500"> ⚠ No se a cargado ningúna firma</p>               
            </div>
        @endif                    
    @endif

    @if($taller) 
      @if(count($taller->servicios))
      <h1 class="font-bold text-lg"> Servicios</h1>
      <hr class="my-4">
      <div class="mb-4" wire:loading.attr="disabled" wire:target="actualizar">
        @foreach ($taller->servicios as $key=>$serv)
        <div class="flex flex-row justify-between bg-indigo-100 my-2 items-center rounded-lg p-2">
            <div class="">
                <input wire:model="taller.servicios.{{$key}}.estado" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white outline-transparent checked:bg-indigo-600 checked:border-indigo-600 outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox">
                <label class="form-check-label inline-block text-gray-800">
                    {{ $serv->tiposervicio->descripcion }}
                </label>                        
            </div>
            <div class="flex flex-row items-center">
                <x-jet-label value="precio:"/>
                <x-jet-input type="number" class="w-6px" wire:model="taller.servicios.{{$key}}.precio" />                                        
            </div>  
        </div>
        <x-jet-input-error for="taller.servicios.{{$key}}.estado" />
        <x-jet-input-error for="taller.servicios.{{$key}}.precio" />
        @endforeach
      </div>
      @else
      <hr>
        <div class="w-full items-center mt-2 justify-center text-center py-2 ">
          <h1 class="text-xs text-gray-500 ">El taller no cuenta con servicios registrados</h1>
        </div>
      @endif 
    @endif   
    <div>
        @if(isset($taller->Documentos))
        <h1 class="font-bold text-lg"> Documentos</h1>
           <hr class="my-4">
           @if($taller->Documentos->count() > 0)
           
           <div class="space-y-4">

           
           @foreach($taller->Documentos as $doc)
           {{--
            <div class="block p-6 bg-green-100 text-center shadow-lg rounded-md">
                  <div class="flex justify-between items-center">
                        <h1>{{$doc->TipoDocumento->nombreTipo}}</h1>
                        <button>
                            <i class="fas fa-chevron-down fa-lg text-green-600"></i>
                        </button>
                        
                  </div>
            </div>
            --}}
            <div x-data="{ open: false }"
                class=" bg-green-200 flex flex-col items-center justify-center relative overflow-hidden w-full border shadow-md rounded-md hover:cursor-pointer ">
                <div @click="open = ! open" class="bg-green-100 p-4 w-full flex justify-between items-center">
                    <div class="flex items-center gap-2 ">                        
                        <p class="ml-4 text-lg text-green-600 leading-7 font-semibold" >
                            {{$doc->TipoDocumento->nombreTipo}}
                        </p>
                    </div>
                    <i class="fas fa-chevron-down fa-lg text-green-600"></i>
                </div>
                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-0" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-10"
                    x-transition:leave-end="opacity-0 translate-y-0" class="w-full bg-white">
                    <div class="flex flex-row w-full divide-x divide-gray-400/20">
                        <div class="px-8 py-4 bg-green-100/30 w-2/3 ">
                            @if($doc->tipoDocumento==9)
                            <p class="text-gray-500 text-xs"> 
                                <i class="fas fa-user"></i>
                                Empleado: 
                                <span class="font-bold"> {{$doc->nombreEmpleado}} </span> 
                            </p>
                            @endif
                            <p class="text-gray-500 text-xs"> 
                                <i class="fas fa-calendar-check"></i>
                                fecha de inicio: 
                                <span class="font-bold"> {{date('d-m-Y',strtotime($doc->fechaInicio))}} </span> 
                            </p>
                            <p class="text-gray-500 text-xs">
                                <i class="fas fa-calendar-times"></i>
                                fecha de expiración: 
                                <span class="font-bold"> 
                                    {{date('d-m-Y',strtotime($doc->fechaExpiracion))}} 
                                </span> 
                            </p>
                        </div>

                        
                        <div class="bg-green-100/30 w-1/3 flex justify-center space-x-2 items-center px-3">
                            <a href="{{Storage::url($doc->ruta)}}" rel="nonopener nonreferer" target="__blank"
                                 class="group flex py-2 px-2 text-center items-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
                                <i class="fas fa-eye"></i>
                                <span class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                    ver
                                </span>
                            </a>

                            <a href="{{route('download_doctaller',$doc->id)}}" class="group flex py-2 px-2 text-center items-center rounded-md bg-indigo-300 font-bold text-white cursor-pointer hover:bg-indigo-400 hover:animate-pulse">
                                <i class="fas fa-download"></i>
                                <span class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                    Descargar
                                </span>
                            </a>
                            {{-- 
                            <button class="group flex py-2 px-2 text-center items-center rounded-md bg-amber-300 font-bold text-white cursor-pointer hover:bg-amber-400 hover:animate-pulse">
                                <i class="fas fa-pen"></i>
                                <span class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                    Editar
                                </span>
                            </button>

                            <button class="group flex py-2 px-2 text-center items-center rounded-md bg-red-500 font-bold text-white cursor-pointer hover:bg-red-700 hover:animate-pulse">
                                <i class="fas fa-times-circle"></i>
                                <span class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute  translate-y-full opacity-0 m-4 mx-auto z-50">
                                    Eliminar
                                </span>
                            </button>
                            --}}
                        </div>
                    
                    
                    </div>                   
                </div>
            </div>
           @endforeach
            </div>
           @else
            
            <div class="w-full items-center mt-2 justify-center text-center py-2 ">
                <h1 class="text-xs text-gray-500 ">Aun no se ha cargado ningún documento del taller</h1>
            </div>
           @endif      
        @endif
    </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('editando',false)" class="mx-2">
            Cancelar
        </x-jet-secondary-button>
        <x-jet-button wire:click="actualizar" wire:loading.attr="disabled" wire:target="update">
            Actualizar
        </x-jet-button>      

    </x-slot>  
    
   </x-jet-dialog-modal>


{{-- MODAL PARA AGREGAR SERVICIOS --}}
   <x-jet-dialog-modal wire:model="agregando" wire:loading.attr="disabled" >
    <x-slot name="title" class="font-bold">
      <h1 class="text-xl font-bold">Agregar Servicios</h1> 
    </x-slot>

    <x-slot name="content">     
        @if ($serviciosNuevos)
            @foreach ($serviciosNuevos as $key=>$serv)
           {{--
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
                    <x-jet-input type="text" class="w-6px" wire:model="precios.{{ $key }}" />
                </div>
            </div>
            --}}
            <div class="flex flex-row justify-between bg-indigo-100 my-2 items-center rounded-lg p-2">
                <div class="">
                    <input wire:model="serviciosNuevos.{{$key}}.estado" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white outline-transparent checked:bg-indigo-600 checked:border-indigo-600 outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox">
                    <label class="form-check-label inline-block text-gray-800">
                        {{$serviciosDisponibles[$key]->descripcion}}
                    </label>                        
                </div>
                <div class="flex flex-row items-center">
                    <x-jet-label value="precio:"/>
                    <x-jet-input type="number" class="w-6px" wire:model="serviciosNuevos.{{$key}}.precio" />                                            
                </div> 
                                                  
            </div>
            <div class="flex flex-row">
                <x-jet-input-error for="serviciosNuevos.{{$key}}.estado" />
                <x-jet-input-error for="serviciosNuevos.{{$key}}.precio" /> 
            </div>  
            <x-jet-input-error for="serviciosNuevos.{{ $key }}" />            
            @endforeach
        @endif
             
       
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('agregando',false)" class="mx-2">
            Cancelar
        </x-jet-secondary-button>
        <x-jet-button  wire:loading.attr="disabled" wire:target="guardarServicios" wire:click="guardarServicios">
            Agregar
        </x-jet-button>      

    </x-slot>  
    
   </x-jet-dialog-modal>
   
</div>
