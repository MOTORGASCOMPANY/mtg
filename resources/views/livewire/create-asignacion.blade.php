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

            {{-- 
            <div class="mb-4 -mr-2">
                <x-jet-label value="Cantidad:" />
                <x-jet-input type="number" class="w-full" wire:model="cantidad"/>
                <x-jet-input-error for="cantidad" />
            </div> 
             --}}



            @switch($tipoM)
                @case(1)
                    {{--
                    <div>
                        <x-jet-label value="Grupo:" for="guia" />
                        <select wire:model="guia" class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full " wire:loading.attr="disabled" wire:target="tipoM">
                            <option value="">Seleccione</option>   
                            @if ($guias->count() > 1)            
                                    @foreach ($guias as $key => $item)
                                        <option wire:ignore value="{{ $item->grupo }}">{{$item->grupo." - ( stock: ".$item->stock.' )'}}</option>                                  
                                    @endforeach
                            @endif                       
                        </select>                      
                        <x-jet-input-error for="guia" />
                    </div>  
                --}}



                    <div>
                        <x-jet-label value="Grupo:" wire:loading.attr="disabled" wire:target="tipoM" />
                        <select wire:model="guia" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                            <option value="null">Seleccione</option>
                            @if (count($guias))
                                @foreach ($guias as $item)
                                    <option value="{{ $item['guia'] }}">
                                        {{ $item['guia'] . ' | ' . $item['minimo'] . ' - ' . $item['maximo'] . ' | -  ( ' . $item['stock'] . ' )' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <x-jet-input-error for="guia" />
                    </div>
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
                    <div class="mb-4">
                        <x-jet-label value="Motivo:" />
                        <select wire:model="motivo" class="bg-gray-50 border-indigo-500 rounded-md outline-none  block w-full ">
                            <option value="0">Seleccione</option>
                            <option value="Solicitud de material">Solicitud de material</option>
                            <option value="Cambio">Cambio</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <x-jet-input-error for="motivo" />
                    </div>
                @break

                @case(2)
                    <div>
                        <x-jet-label value="Cantidad:" />
                        <x-jet-input type="number" class="w-full" wire:model="cantidad" />
                        <x-jet-input-error for="cantidad" />
                    </div>
                    <div class="mb-4">
                        <x-jet-label value="Motivo:" />
                        <select wire:model="motivo" class="bg-gray-50 border-indigo-500 rounded-md outline-none  block w-full ">
                            <option value="0">Seleccione</option>
                            <option value="Solicitud de material">Solicitud de material</option>
                            <option value="Cambio">Cambio</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <x-jet-input-error for="motivo" />
                    </div>
                @break

                @case(3)
                    <div>
                        <x-jet-label value="Grupo:" wire:loading.attr="disabled" wire:target="tipoM" />
                        <select wire:model="guia" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                            <option value="null">Seleccione</option>
                            @if (count($guias))
                                @foreach ($guias as $item)
                                    <option value="{{ $item['guia'] }}">
                                        {{ $item['guia'] . ' | ' . $item['minimo'] . ' - ' . $item['maximo'] . ' | -  ( ' . $item['stock'] . ' )' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <x-jet-input-error for="guia" />
                    </div>
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
                    <div class="mb-4">
                        <x-jet-label value="Motivo:" />
                        <select wire:model="motivo" class="bg-gray-50 border-indigo-500 rounded-md outline-none  block w-full ">
                            <option value="0">Seleccione</option>
                            <option value="Solicitud de material">Solicitud de material</option>
                            <option value="Cambio">Cambio</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <x-jet-input-error for="motivo" />
                    </div>
                @break

                @case(4)
                    <div>
                        <x-jet-label value="Grupo:" wire:loading.attr="disabled" wire:target="tipoM" />
                        <select wire:model="guia" class="bg-gray-50 border-indigo-500 rounded-md outline-none w-full">
                            <option value="null">Seleccione</option>
                            @if (count($guias))
                                @foreach ($guias as $item)
                                    <option value="{{ $item['guia'] }}">
                                        {{ $item['guia'] . ' | ' . $item['minimo'] . ' - ' . $item['maximo'] . ' | -  ( ' . $item['stock'] . ' )' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <x-jet-input-error for="guia" />
                    </div>
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
                    <div class="mb-4">
                        <x-jet-label value="Motivo:" />
                        <select wire:model="motivo"
                            class="bg-gray-50 border-indigo-500 rounded-md outline-none  block w-full ">
                            <option value="0">Seleccione</option>
                            <option value="Solicitud de material">Solicitud de material</option>
                            <option value="Cambio">Cambio</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <x-jet-input-error for="motivo" />
                    </div>
                @break

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
