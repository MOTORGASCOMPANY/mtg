<div class="mb-4">

    <button wire:click="$set('open',true)"
        class="bg-indigo-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer">Agregar</button>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            Crear nuevo Expediente
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label value="Taller:" for="taller" />
                <select wire:model="tallerSeleccionado"
                    class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                    <option value="0">Seleccione</option>
                    @foreach ($talleres as $taller)
                        <option value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="tallerSeleccionado" />
            </div>
            @if ($servicios != null)
                <div class="mb-4">
                    <x-jet-label value="Servicio:" for="servicio" />
                    <select wire:model="servicio"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                        <option value="">Seleccione</option>
                        @foreach ($servicios as $serv)
                            <option value="{{ $serv['id'] }}">{{ $serv['descripcion'] }}</option>
                        @endforeach
                    </select>
                    @if ($servicio)
                    @endif
                    <x-jet-input-error for="servicio" />
                </div>
            @else
                <div class="mb-4">
                    <x-jet-label value="Servicio:" for="servicio" />
                    <select wire:model="servicio"
                        class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
                        <option value="">Seleccione un taller</option>
                    </select>
                    <x-jet-input-error for="servicio" />
                </div>
            @endif
            <div class="mb-4">
                <x-jet-label value="Placa:" />
                <x-jet-input type="text" class="w-full" wire:model="placa" maxlength="7" />
                <x-jet-input-error for="placa" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Certificado:" />
                <x-jet-input type="text" class="w-full" wire:model="certificado" maxlength="7" />
                <x-jet-input-error for="certificado" />
            </div>
            <div class="mb-4">
                <x-jet-label value="fotos:" />
                <x-jet-input type="file" id="{{ $identificador }}-111" class="w-full" wire:model="files"
                    accept=".jpg,.png,.jpeg,.gif,.bmp,.tif,.tiff" multiple />
                <x-jet-input-error for="files" />
                <x-jet-input-error for="files.*" />
            </div>
            <div wire:loading wire:target="files"
                class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                Espere un momento mientras se carga la imagen.
            </div>

            <h1 class="pt-1  font-semibold sm:text-lg text-gray-900">
                Galeria de fotos:
            </h1>

            @if ($files)
                <section class="mt-4 overflow-hidden border-dotted border-2 text-gray-700 "
                    id="{{ 'section-' . $identificador }}">
                    <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @foreach ($files as $key => $fil)
                                <div class="flex flex-wrap w-1/3 ">
                                    <div class="w-full p-1 md:p-2 items-center justify-center">
                                        <img alt="gallery"
                                            class="mx-auto flex object-cover object-center w-36 h-36 rounded-lg"
                                            src="{{ $fil->temporaryUrl() }}">
                                        <a class="flex" wire:click="deleteFileUpload({{ $key }})"><i
                                                class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @else
                <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                    <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                        <li id="empty"
                            class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32"
                                src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                alt="no data" />
                            <span class="text-small text-gray-500">Aún no seleccionaste ningúna fotografia</span>
                        </li>
                    </ul>
                </section>
            @endif
            <hr class="my-4" />



            <div class="mb-4">
                <x-jet-label value="Archivos:" />
                <x-jet-input type="file" id="{{ $identificador }}-xd" class="w-full" wire:model="documentos"
                    accept=".pdf,.xls,.docx,.xlsx,.doc" multiple />
                <x-jet-input-error for="documentos" />
                <x-jet-input-error for="documentos.*" />
            </div>
            {{--
            <div class="block">
            @error('documentos') 
                <span class="mt-0 text-sm text-red-500">{{ $message }}</span> 
            @enderror
            @error('documentos.*') 
                <span class="mt-0 text-sm text-red-500">{{ $message }}</span> 
            @enderror
            
            </div>
            --}}
            <div wire:loading wire:target="documentos"
                class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                Espere un momento mientras se cargan los documentos.
            </div>

            <h1 class="font-semibold sm:text-lg text-gray-900">
                Galeria de documentos:
            </h1>

            @if ($documentos)
                <section class="mt-4 overflow-hidden border-dotted border-2 text-gray-700 "
                    id="{{ 'section-' . $identificador }}">
                    <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @foreach ($documentos as $key => $fil)
                                @switch($fil->extension())
                                    @case('pdf')
                                        <div class="flex flex-wrap w-1/5 ">
                                            <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                                <img alt="gallery"
                                                    class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg"
                                                    src="/images/pdf.png">
                                                <p class="truncate text-sm"> {{ $fil->getClientOriginalName() }}</p>
                                                <a class="flex" wire:click="deleteDocumentUpload({{ $key }})"><i
                                                        class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                            </div>
                                        </div>
                                    @break

                                    @case('xls')
                                        <div class="flex flex-wrap w-1/5 ">
                                            <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                                <img alt="gallery"
                                                    class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg"
                                                    src="/images/xls.png">
                                                <p class="truncate text-sm"> {{ $fil->getClientOriginalName() }}</p>
                                                <a class="flex" wire:click="deleteDocumentUpload({{ $key }})"><i
                                                        class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                            </div>
                                        </div>
                                    @break

                                    @case('xlsx')
                                        <div class="flex flex-wrap w-1/5 ">
                                            <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                                <img alt="gallery"
                                                    class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg"
                                                    src="/images/xlsx.png">
                                                <p class="truncate text-sm"> {{ $fil->getClientOriginalName() }}</p>
                                                <a class="flex" wire:click="deleteDocumentUpload({{ $key }})"><i
                                                        class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                            </div>
                                        </div>
                                    @break

                                    @case('docx')
                                        <div class="flex flex-wrap w-1/5 ">
                                            <div class="w-full p-1 md:p-2 items-center justify-center text-center">
                                                <img alt="gallery"
                                                    class="mx-auto flex object-cover object-center w-15 h-15 rounded-lg"
                                                    src="/images/docx.png">
                                                <p class="truncate text-sm"> {{ $fil->getClientOriginalName() }}</p>
                                                <a class="flex" wire:click="deleteDocumentUpload({{ $key }})"><i
                                                        class="fas fa-trash mt-1 mx-auto hover:text-indigo-400"></i></a>
                                            </div>
                                        </div>
                                    @break

                                    @default
                                @endswitch
                            @endforeach
                        </div>
                    </div>
                </section>
            @else
                <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                    <ul id="gallery-documents" class="flex flex-1 flex-wrap -m-1">
                        <li id="empty"
                            class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32"
                                src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                alt="no data" />
                            <span class="text-small text-gray-500">Aún no seleccionaste ningún archivo</span>
                        </li>
                    </ul>
                </section>
            @endif


            {{--
            <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center">
                  <p class="mb-3 font-semibold text-gray-900 flex flex-wrap justify-center">
                    <span>Arrastre y suelte</span>&nbsp;<span>Sus archivos o</span>
                  </p>
                  <xjet-input id="{{$identificador}}" type="file"  class="hidden"  wire:model="files"/>
                  <button id="button" wire:model="files" class="mt-2 rounded-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none">
                    Carguelos desde aqui
                  </button>
                </header>
    
                
    
                
            </section>
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
