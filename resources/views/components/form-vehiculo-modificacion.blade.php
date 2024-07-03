<div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300" id="datosVehiculo">
    <div class="flex items-center justify-between bg-gray-400 py-4 px-6 rounded-t-lg">
        <span class="text-lg font-semibold text-white dark:text-gray-400">Datos del vehículo</span>
        <a class="px-3 py-1 text-sm font-bold text-gray-100 transition-colors duration-300 transform bg-gray-600 rounded cursor-pointer hover:bg-gray-500"
            tabindex="0" role="button">Nuevo</a>
    </div>
    <div class="mt-2 mb-6 px-8 py-2">
        <!--
        <div class="mb-2">
            <x-jet-label value="Propietario:" />
            <x-jet-input type="text" class="w-full" wire:model="propietario" maxlength="245" />
            <x-jet-input-error for="propietario" />
        </div>
        -->
        <div class="grid grid-cols-2 gap-4 py-6">
            <div>
                <x-jet-label value="Razón Social / Persona Natural:" />
                <x-jet-input type="text" class="w-full" wire:model="propietario" />
                <x-jet-input-error for="propietario" />
            </div>
            <div>
                <x-jet-label value="Dirección: "/>
                <select wire:model="direccion"
                    class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full ">
                    <option value="">Seleccione</option>
                    <option value="LIMA">LIMA</option>
                </select>
                <x-jet-input-error for="direccion" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-3">

            <div>
                <x-jet-label value="Placa:" />
                <x-jet-input list="vehiculos" type="text" class="w-full" wire:model="placa"
                    wire:keydown.enter="buscarVehiculo" maxlength="7" />
                <x-jet-input-error for="placa" />
            </div>
            <div>
                <x-jet-label value="Categoria:" />
                <select wire:model="categoria"
                    class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full ">
                    <option value="">Seleccione</option>
                    <option value="NE">NE</option>
                    <option value="M1">M1</option>
                    <option value="M2">M2</option>
                    <option value="M3">M3</option>
                    <option value="N1">N1</option>
                    <option value="N2">N2</option>
                    <option value="N3">N3</option>
                    <option value="L1">L1</option>
                    <option value="L2">L2</option>
                    <option value="L3">L3</option>
                    <option value="L5">L5</option>
                    <option value="O1">O1</option>
                    <option value="O2">O2</option>
                    <option value="O3">O3</option>
                    <option value="O4">O4</option>
                    <option value="M1-C3">M1-C3</option>
                    <option value="M2-C1">M2-C1</option>
                    <option value="M2-C2">M2-C2</option>
                    <option value="M2-C3">M2-C3</option>
                    <option value="M3-C1">M3-C1</option>
                    <option value="M3-C2">M3-C2</option>
                    <option value="M3-C3">M3-C3</option>
                </select>
                <x-jet-input-error for="categoria" />
            </div>

            <div>
                <x-jet-label value="Marca:" />
                <x-jet-input type="text" class="w-full" wire:model="marca" />
                <x-jet-input-error for="marca" />
            </div>

            <div>
                <x-jet-label value="Modelo:" />
                <x-jet-input type="text" class="w-full" wire:model="modelo" />
                <x-jet-input-error for="modelo" />
            </div>
            <div>
                <x-jet-label value="Version:" />
                <x-jet-input type="text" class="w-full" wire:model="version" />
                <x-jet-input-error for="version" />
            </div>
            <div>
                <x-jet-label value="año de fabricación:" />
                <x-jet-input type="text" class="w-full" wire:model="anioFab" type="number" inputmode="numeric" />
                <x-jet-input-error for="anioFab" />
            </div>

            <div>
                <x-jet-label value="N° Serie / Chasis:" />
                <x-jet-input type="text" class="w-full" wire:model="numSerie" />
                <x-jet-input-error for="numSerie" />
            </div>
            <div>
                <x-jet-label value="VIN:" />
                <x-jet-input type="text" class="w-full" wire:model="chasis" />
                <x-jet-input-error for="chasis" />
            </div>            
            <div class="flex flex-row justify-center">
                <div class="w-1/2">
                    <x-jet-label value="Cilindros:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="cilindros" type="number"
                        inputmode="numeric" />
                    <x-jet-input-error for="cilindros" />
                </div>
                <div class="w-1/2">
                    <x-jet-label value="Cilindrada:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="cilindrada"  /> {{-- type="number" inputmode="numeric" --}}
                    <x-jet-input-error for="cilindrada" />
                </div>
            </div>
            <div>
                <x-jet-label value="N° Serie Motor:" />
                <x-jet-input type="text" class="w-full" wire:model="numMotor" />
                <x-jet-input-error for="numMotor" />
            </div>
            <div>
                <x-jet-label value="Carrocería:" />
                <x-jet-input type="text" class="w-full" wire:model="carroceria" />
                <x-jet-input-error for="carroceria" />
            </div>
            
            <div>
                <x-jet-label value="Combustible:" />
                <x-jet-input type="text" class="w-full" wire:model="combustible" list="items" />
                <datalist id="items">
                    <option value="GASOLINA">GASOLINA</option>
                    <option value="BI-COMBUSTIBLE GNV">BI-COMBUSTIBLE GNV</option>
                    <option value="BI-COMBUSTIBLE GLP">BI-COMBUSTIBLE GLP</option>
                    <option value="GNV">GNV</option>
                    <option value="GLP">GLP</option>
                </datalist>

                <x-jet-input-error for="combustible" />
            </div>
            <div class="flex flex-row">
                <div class="w-1/2">
                    <x-jet-label value="Ejes:" />
                    <x-jet-input class="w-5/6" wire:model="ejes" type="number" inputmode="numeric" />
                    <x-jet-input-error for="ejes" />
                </div>
                <div class="w-1/2">
                    <x-jet-label value="Ruedas:" />
                    <x-jet-input class="w-5/6" wire:model="ruedas" type="number" inputmode="numeric" />
                    <x-jet-input-error for="ruedas" />
                </div>
            </div>
            <div class="flex flex-row">
                <div class="w-1/2">
                    <x-jet-label value="Asientos:" />
                    <x-jet-input class="w-5/6" wire:model="asientos" type="number" inputmode="numeric" />
                    <x-jet-input-error for="asientos" />
                </div>
                <div class="w-1/2">
                    <x-jet-label value="Pasajeros:" />
                    <x-jet-input class="w-5/6" wire:model="pasajeros" type="number" inputmode="numeric" />
                    <x-jet-input-error for="pasajeros" />
                </div>
            </div>
            <div class="flex flex-row w-full justify-center m-auto">
                <div class="w-1/3">
                    <x-jet-label value="Largo:" />
                    <x-jet-input class="w-5/6" wire:model="largo" type="number" inputmode="numeric" />
                    <x-jet-input-error for="largo" />
                </div>
                <div class="w-1/3">
                    <x-jet-label value="Ancho:" />
                    <x-jet-input class="w-5/6" wire:model="ancho" type="number" inputmode="numeric" />
                    <x-jet-input-error for="ancho" />
                </div>
                <div class="w-1/3">
                    <x-jet-label value="Altura:" />
                    <x-jet-input class="w-5/6" wire:model="altura" type="number" inputmode="numeric" />
                    <x-jet-input-error for="altura" />
                </div>
            </div>
            <div>
                <x-jet-label value="Color:" />
                <x-jet-input type="text" class="w-full" wire:model="color" />
                <x-jet-input-error for="color" />
            </div>
            <div class="flex flex-row w-full justify-center m-auto">
                <div class="w-1/3">
                    <x-jet-label value="Peso Neto:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="pesoNeto" type="number"
                        inputmode="numeric" />
                    <x-jet-input-error for="pesoNeto" />
                </div>
                <div class="w-1/3">
                    <x-jet-label value="Peso Bruto:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="pesoBruto" type="number"
                        inputmode="numeric" />
                    <x-jet-input-error for="pesoBruto" />
                </div>
                <div class="w-1/3">
                    <x-jet-label value="Carga Util:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="cargaUtil" type="number"
                        inputmode="numeric" />
                    <x-jet-input-error for="cargaUtil" />
                </div>
            </div>
            <div>
                <x-jet-label value="Potencia (HP @ RPM):" />
                <x-jet-input type="text" class="w-full" wire:model="potencia" />
                <x-jet-input-error for="potencia" />
            </div>            

        </div>
        <div class="grid grid-cols-2 gap-4 py-6">
            <div >
                <x-jet-label value="Fórmula rodante (FR):" />
                <x-jet-input type="text" class="w-full" wire:model="rodante" />
                <x-jet-input-error for="rodante" />
            </div>
            <div >
                <x-jet-label value="Transporte de:" />
                <x-jet-input type="text" class="w-full" wire:model="carga"  />
                <x-jet-input-error for="carga" />
            </div>
        </div>
        <div class="col-span-2">
            <x-jet-label value="Datos a modificar:" />
            <x-textarea class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="rectificacion" style="height: 200px;" />
            <x-jet-input-error for="rectificacion" />
        </div>

        <div class="mt-4  mb-2 flex flex-row justify-center items-center">
            <button wire:click="guardaVehiculo" wire:loading.attr="disabled" wire:target="guardaVehiculo"
                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-amber-400 hover:bg-amber-500 focus:outline-none rounded">
                <p class="text-sm font-medium leading-none text-white">
                    <span wire:loading wire:target="guardaVehiculo">
                        <i class="fas fa-spinner animate-spin"></i>
                        &nbsp;
                    </span>
                    Guardar vehículo
                </p>
            </button>
        </div>
    </div>

</div>
