<div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1 flex justify-between">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium text-gray-900">Firma</h3>
            <p class="mt-1 text-sm text-gray-600">
                Cargue su firma para que sea agregada automáticamente en el Check List y los documentos necesarios.
            </p>
        </div>
    </div>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="firma" value="{{ __('imagen de firma') }}" />
                    <x-jet-input type="file " class="mt-1 block w-full"  accept=".jpg,.png,.jpeg,.gif,.bmp,.tif,.tiff" wire:model.defer="firma"  />
                    <x-jet-input-error for="firma" class="mt-2" />
                    <br>
                    
                </div>

                <div wire:loading wire:target="firma" class="my-4 
                px-6 py-4 col-span-6 sm:col-span-6 w-full m-auto text-center font-bold bg-indigo-200 rounded-md">
                    Espere un momento mientras se carga la imagen.
                </div>

                @if (isset($firma))
                    <div class="col-span-6 sm:col-span-6 w-full m-auto">
                        <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                            <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                                <li id="empty" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                    @if($firma->extension()=='png'|| $firma->extension()=='jpg' || $firma->extension()=='jpeg' ||$firma->extension()=='gif' || $firma->extension()=='bmp' || $firma->extension()=='tif')
                                        <img class="mx-auto w-full" src="{{ $firma->temporaryUrl() }}" alt="firma-inspector" />
                                    @endif
                                </li>
                            </ul>
                        </section>
                    </div>
                @else
                    @if (Auth::user()->rutaFirma)
                        <div class="col-span-6 sm:col-span-6 w-full m-auto">
                            <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                                <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                                    <li id="empty" class="h-full w-full text-center flex flex-col items-center justify-center items-center">                               
                                            <img class="mx-auto w-full" src="{{Storage::url(Auth::user()->rutaFirma)}}" alt="firma-inspector" />                               
                                    </li>
                                </ul>
                            </section>
                        </div>
                    @else
                        <div class="col-span-6 sm:col-span-6 m-auto w-full">
                            <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                                <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                                    <li id="empty"
                                        class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                        <img class="mx-auto w-32"
                                            src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                            alt="no data" />
                                        <span class="text-small text-gray-500">Aún no seleccionaste ningúna imagen</span>
                                    </li>
                                </ul>
                            </section>
                        </div>                        
                    @endif                    
                @endif
                        
            </div>
        </div>
        <div
            class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Guardado.') }}
            </x-jet-action-message>

            <x-jet-button wire:click="guardarFirma">
                {{ __('Guardar') }}
            </x-jet-button>
        </div>
    </div>
</div>
