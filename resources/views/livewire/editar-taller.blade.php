<div class="lg:w-5/6 pt-4 w-full m-auto">
    <div class="mt-12 w-full">
        <h1 class="text-2xl font-bold my-6 text-indigo-500 text-center"><i class="fas fa-pen pr-2"></i>  DATOS DEL TALLER </h1>  
    </div>  
    <div class="bg-indigo-300 bg-opacity-25 md:p-4 m-4 grid grid-cols-1 md:grid-cols-2 space-x-4  rounded-md shadow-md border ">        
        <div class="px-4 pt-4">
            <div class="mb-4">
                <x-jet-label value="Nombre:" />
                <x-jet-input wire:model="taller.nombre" type="text" class="w-full" />
                <x-jet-input-error for="taller.nombre" />
            </div>
            <div class="mb-4">
                <x-jet-label value="RUC:" />
                <x-jet-input wire:model="taller.ruc" type="text" class="w-full" maxlength="11" />
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

            <div class="grid grid-flow-row-dense grid-cols-2 space-x-2">
                <div>
                    <x-jet-label value="Departamento:" />
                    <select wire:model="departamentoSel"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                        <option value="null">Seleccione</option>
                        @foreach ($departamentosTaller as $depart)
                            <option value="{{ $depart->id }}">{{ $depart->departamento }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="departamentoSel" />
                </div>
                <div>
                    <x-jet-label value="Provincia:" />
                    <select wire:model="provinciaSel"
                        class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                        @if ($provinciasTaller)
                            <option value="null">Seleccione</option>
                            @foreach ($provinciasTaller as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->provincia }}</option>
                            @endforeach
                        @else
                            <option value="">Seleccione Depart.</option>
                        @endif

                    </select>
                    <x-jet-input-error for="provinciaSel" />
                </div>
            </div>
            <div class="mb-4">
                <x-jet-label value="Distrito:" />
                <select wire:model="taller.idDistrito"
                    class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full pr-2 ">
                    @if ($distritosTaller)
                        <option value="null">Seleccione</option>
                        @foreach ($distritosTaller as $dist)
                            <option value="{{ $dist->id }}">{{ $dist->distrito }}</option>
                        @endforeach
                    @else
                        <option value="">Seleccione Prov.</option>
                    @endif
                </select>
                <x-jet-input-error for="taller.idDistrito" />
            </div>

        </div>

        <div class="px-4 pt-4">            
            <div class="mb-4 w-full">
                <x-jet-label value="Logo:" />               
                <input class="relative m-0 block w-full min-w-0 flex-auto rounded border  shadow-sm bg-indigo-300  bg-clip-padding px-3 py-2 text-base font-normal text-white transition duration-300 ease-in-out file:-mx-3 file:-my-2 file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-indigo-500 file:px-3 file:py-2 file:text-white file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-indigo-700 focus:border-primary focus:text-white focus:shadow-te-primary focus:outline-none "
                    type="file" wire:model="logoNuevo"
                    accept=".jpg,.png,.jpeg,.gif,.bmp,.tif,.tiff"
                     />
                <x-jet-input-error for="logoNuevo" />
            </div>
            <div wire:loading wire:target="logoNuevo"
                class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                Espere un momento mientras se carga la imagen.
            </div>
            @if ($logoNuevo)
                @if (
                    $logoNuevo->extension() == 'png' ||
                        $logoNuevo->extension() == 'jpeg' ||
                        $logoNuevo->extension() == 'jpg' ||
                        $logoNuevo->extension() == 'gif' ||
                        $logoNuevo->extension() == 'gift' ||
                        $logoNuevo->extension() == 'bmp' ||
                        $logoNuevo->extension() == 'tif' ||
                        $logoNuevo->extension() == 'tiff')
                    <div class="w-full p-1 md:p-2 items-center justify-center" id="{{ rand() }}-ind">
                        <img alt="gallery" class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg"
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
                @if ($taller->rutaLogo != null)
                    <div class="w-full p-1 md:p-2 items-center justify-center" id="{{ rand() }}-src">
                        <img alt="gallery" class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg"
                            src="{{ Storage::url($taller->rutaLogo) }}">
                    </div>
                @else
                    <div class="w-full m-auto">
                        <p class="text-center text-red-500"> ⚠ No se a cargado ningún logo.</p>
                    </div>
                @endif
            @endif

            <div class="mb-4">
                <x-jet-label value="Firma:" />
                <input class="relative m-0 block w-full min-w-0 flex-auto rounded border  shadow-sm bg-indigo-300  bg-clip-padding px-3 py-2 text-base font-normal text-white transition duration-300 ease-in-out file:-mx-3 file:-my-2 file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-indigo-500 file:px-3 file:py-2 file:text-white file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-indigo-700 focus:border-primary focus:text-white focus:shadow-te-primary focus:outline-none "
                    type="file" wire:model="firmaNuevo"
                    accept=".jpg,.png,.jpeg,.gif,.bmp,.tif,.tiff"
                     />                
                <x-jet-input-error for="firmaNuevo" />
            </div>
            <div wire:loading wire:target="firmaNuevo"
                class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                Espere un momento mientras se carga la imagen.
            </div>

            @if ($firmaNuevo)
                @if (
                    $firmaNuevo->extension() == 'png' ||
                        $firmaNuevo->extension() == 'jpg' ||
                        $firmaNuevo->extension() == 'jpeg' ||
                        $firmaNuevo->extension() == 'gif' ||
                        $firmaNuevo->extension() == 'gift' ||
                        $firmaNuevo->extension() == 'bmp' ||
                        $firmaNuevo->extension() == 'tif' ||
                        $firmaNuevo->extension() == 'tiff')
                    <div class="w-full p-1 md:p-2 items-center justify-center" id="{{ rand() }}-in">
                        <img alt="gallery" class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg"
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
                @if ($taller->rutaFirma != null)
                    <div class="w-full p-1 md:p-2 items-center justify-center" id="{{ rand() }}-src-2">
                        <img alt="gallery" class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg"
                            src="{{ Storage::url($taller->rutaFirma) }}">
                    </div>
                @else
                    <div class="w-full m-auto">
                        <p class="text-center text-red-500"> ⚠ No se a cargado ningúna firma</p>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <div class="w-full px-4 py-8 flex justify-center space-x-4 ">
        @hasanyrole('administrador')
        <x-jet-secondary-button wire:click="cancelar" class="mx-2">
            Regresar
        </x-jet-secondary-button>     
        @endhasanyrole   
        <x-jet-button wire:click="actualizar" wire:loading.attr="disabled" wire:target="update">
            Actualizar
        </x-jet-button>
        
    </div>

    <div class="px-4 w-full mt-8 md:mt-6 pb-6">
        <div class="flex flex-row  justify-between items-center">
            <h1 class="font-bold text-lg text-green-600"> DOCUMENTOS DE TALLER</h1>
            @livewire('create-documento-taller', ['idTaller' => $taller->id])
        </div>
        <hr class="my-4">
        @if (isset($taller->Documentos))
            <div>
                @livewire('documentos-taller', ['idTaller' => $taller->id], key($taller->nombre.'-'.$taller->id))
            </div>
        @endif
    </div>

    
</div>
