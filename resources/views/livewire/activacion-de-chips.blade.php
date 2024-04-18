<div>
    @livewire('form-vehiculo', ['tipoServicio' => $tipoServicio,"nombreDelInvocador"=>"activacion-de-chips"])

    <div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300 p-4 mt-4">
        <x-jet-label value="Fotos reglamentarias:" class="font-bold text-xl py-4" />
        <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" acceptedFileTypes="['image/*',]"
            aceptaVarios="true">
        </x-file-pond>
        <x-jet-input-error for="imagenes" />
    </div>

    <div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4">
        <div class="my-2 flex flex-row justify-evenly items-center">
            @if($estado!="realizado")
            {{--
            <button wire:click="guardar" wire:loading.attr="disabled" wire.target="guardar"
                class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                <p class="text-sm font-medium leading-none text-white">
                    <span wire:loading wire:target="guardar">
                        <i class="fas fa-spinner animate-spin"></i>
                        &nbsp;
                    </span>
                    &nbsp;Finalizar
                </p>
            </button>
            --}}
                <div class="w-full md:w-2/6 flex justify-center items-center">
                    <x-jet-input type="checkbox" wire:model="serviexterno"
                        class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded outline-none hover:cursor-pointer focus:ring-indigo-600  focus:ring-1 dark:bg-gray-600 dark:border-gray-500" />
                    <x-jet-label value="Externo"
                        class="py-2 ml-2 text-sm font-medium text-gray-900 select-none hover:cursor-pointer " />
                    <x-jet-input-error for="serviexterno" />
                </div>
                <div>
                    <button wire:click="guardar" wire:loading.attr="disabled" wire.target="guardar"
                        class="hover:cursor-pointer border border-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                        <p class="text-sm font-medium leading-none text-white">
                            <span wire:loading wire:target="guardar">
                                <i class="fas fa-spinner animate-spin"></i>
                                &nbsp;
                            </span>
                            &nbsp;Finalizar
                        </p>
                    </button>
                </div>
            @else
            <a href="{{ route('servicio') }}"
                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-red-400 hover:bg-red-500 focus:outline-none rounded">
                <p class="text-sm font-medium leading-none text-white">
                    <i class="fas fa-archive"></i>&nbsp;Nuevo Servicio
                </p>
            </a>
            @endif
        </div>
    </div>

</div>
