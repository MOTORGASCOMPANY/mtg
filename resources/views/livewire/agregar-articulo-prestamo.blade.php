<div>
    <div class="pt-7">
        <a wire:click="$set('open',true)"
            class="ml-6 bg-amber-500 px-6 py-3  mt-4 rounded-md text-white font-semibold tracking-wide hover:cursor-pointer">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold">Agregar Articulo</h1>
        </x-slot>
        <x-slot name="content">
            <div>
                <x-jet-label value="articulo:" />
                <select wire:model="tipoM" class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full">
                    <option value="">Seleccione</option>
                    @foreach ($tiposMateriales as $tipo)
                        <option value="{{ $tipo->id }}">
                            {{ $tipo->descripcion . ' - ( ' . $stocks[$tipo->descripcion] . ' )' }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="tipoM" />
            </div>            

            @switch($tipoM)
                @case(1)
                    <div>
                        <x-jet-label value="Cantidad:" />
                        <x-jet-input type="number" class="w-full" wire:model="cantidad" />
                        <x-jet-input-error for="cantidad" />
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

                @case(3)
                    <div>
                        <x-jet-label value="Cantidad:" />
                        <x-jet-input type="number" class="w-full" wire:model="cantidad" />
                        <x-jet-input-error for="cantidad" />
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
                @case(4)
                    <div>
                        <x-jet-label value="Cantidad:" />
                        <x-jet-input type="number" class="w-full" wire:model="cantidad" />
                        <x-jet-input-error for="cantidad" />
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

                @default
                    <div class="p-4 bg-indigo-300 rounded-md my-4">
                        <h1 class="text-center font-bold text-red-600">Selecciona un tipo de articulo</h1>
                    </div>
            @endswitch            
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="addArticulo" wire:loading.attr="disabled" wire:target="agregar">
                Agregar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
