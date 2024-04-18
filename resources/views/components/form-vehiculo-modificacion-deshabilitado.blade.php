<div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300" id="datosVehiculo">
    <div class="flex items-center justify-between bg-green-400 py-4 px-6 rounded-t-lg">
        <span class="text-lg font-semibold text-white dark:text-gray-400">Datos del vehículo</span>
        <i class="fas fa-check-circle fa-lg"></i>
    </div>
    <div class="mt-2 mb-6 px-8 py-2">
        <div class="grid grid-cols-2 gap-4 py-6">
            <div>
                <x-jet-label value="Razón Social / Persona Natural:" />
                <x-jet-input type="text" class="w-full" wire:model="vehiculo.propietario" disabled/>
                <x-jet-input-error for="vehiculo.propietario" />
            </div>
            <div>
                <x-jet-label value="Dirección: "/>
                <x-jet-input type="text" class="w-full" wire:model="direccion" disabled/>
                <x-jet-input-error for="modificacion.direccion" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-3">

            <div>
                <x-jet-label value="Placa:" />
                <x-jet-input type="text" class="w-full" wire:model="vehiculo.placa" maxlength="7" disabled/>
                <x-jet-input-error for="placa" />
            </div>
            <div>
                <x-jet-label value="Categoria:" />
                <select wire:model="vehiculo.categoria"
                    class="bg-gray-50 border-indigo-500 rounded-md outline-none block w-full" disabled>
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
                <x-jet-input type="text" class="w-full" wire:model="vehiculo.marca" disabled/>
                <x-jet-input-error for="marca" />
            </div>

            <div>
                <x-jet-label value="Modelo:" />
                <x-jet-input type="text" class="w-full" wire:model="vehiculo.modelo" disabled/>
                <x-jet-input-error for="modelo" />
            </div>
            <div>
                <x-jet-label value="Version:" />
                <x-jet-input type="text" class="w-full" wire:model="vehiculo.version" disabled/>
                <x-jet-input-error for="version" />
            </div>
            <div>
                <x-jet-label value="año de fabricación:" />
                <x-jet-input type="text" class="w-full" wire:model="vehiculo.anioFab" type="number" disabled/>
                <x-jet-input-error for="anioFab" />
            </div>

            <div>
                <x-jet-label value="N° Serie / Chasis:" />
                <x-jet-input type="text" class="w-full" wire:model="vehiculo.numSerie" disabled/>
                <x-jet-input-error for="numSerie" />
            </div>
            <div>
                <x-jet-label value="VIN:" />
                <x-jet-input type="text" class="w-full" wire:model="chasis" disabled/>
                <x-jet-input-error for="modificacion.chasis" />
            </div>            
            <div class="flex flex-row justify-center">
                <div class="w-1/2">
                    <x-jet-label value="Cilindros:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.cilindros" type="number" disabled/>
                    <x-jet-input-error for="cilindros" />
                </div>
                <div class="w-1/2">
                    <x-jet-label value="Cilindrada:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.cilindrada" type="number" disabled/>
                    <x-jet-input-error for="cilindrada" />
                </div>
            </div>
            <div>
                <x-jet-label value="N° Serie Motor:" />
                <x-jet-input type="text" class="w-full" wire:model="vehiculo.numMotor" disabled/>
                <x-jet-input-error for="numMotor" />
            </div>
            <div>
                <x-jet-label value="Carrocería:" />
                <x-jet-input type="text" class="w-full" wire:model="carroceria" disabled/>
                <x-jet-input-error for="modificacion.carroceria" />
            </div>
            
            <div>
                <x-jet-label value="Combustible:" />
                <x-jet-input type="text" class="w-full" wire:model="vehiculo.combustible" disabled/>
                <x-jet-input-error for="combustible" />
            </div>
            <div class="flex flex-row">
                <div class="w-1/2">
                    <x-jet-label value="Ejes:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.ejes" type="number" disabled/>
                    <x-jet-input-error for="ejes" />
                </div>
                <div class="w-1/2">
                    <x-jet-label value="Ruedas:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.ruedas" type="number" disabled/>
                    <x-jet-input-error for="ruedas" />
                </div>
            </div>
            <div class="flex flex-row">
                <div class="w-1/2">
                    <x-jet-label value="Asientos:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.asientos" type="number" disabled/>
                    <x-jet-input-error for="asientos" />
                </div>
                <div class="w-1/2">
                    <x-jet-label value="Pasajeros:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.pasajeros" type="number" disabled/>
                    <x-jet-input-error for="pasajeros" />
                </div>
            </div>
            <div class="flex flex-row w-full justify-center m-auto">
                <div class="w-1/3">
                    <x-jet-label value="Largo:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.largo" type="number" disabled/>
                    <x-jet-input-error for="largo" />
                </div>
                <div class="w-1/3">
                    <x-jet-label value="Ancho:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.ancho" type="number" disabled/>
                    <x-jet-input-error for="ancho" />
                </div>
                <div class="w-1/3">
                    <x-jet-label value="Altura:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.altura" type="number" disabled/>
                    <x-jet-input-error for="altura" />
                </div>
            </div>
            <div>
                <x-jet-label value="Color:" />
                <x-jet-input type="text" class="w-full" wire:model="vehiculo.color" disabled/>
                <x-jet-input-error for="color" />
            </div>
            <div class="flex flex-row w-full justify-center m-auto">
                <div class="w-1/3">
                    <x-jet-label value="Peso Neto:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.pesoNeto" type="number" disabled/>
                    <x-jet-input-error for="pesoNeto" />
                </div>
                <div class="w-1/3">
                    <x-jet-label value="Peso Bruto:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.pesoBruto" type="number" disabled/>
                    <x-jet-input-error for="pesoBruto" />
                </div>
                <div class="w-1/3">
                    <x-jet-label value="Carga Util:" />
                    <x-jet-input type="text" class="w-5/6" wire:model="vehiculo.cargaUtil" type="number" disabled/>
                    <x-jet-input-error for="cargaUtil" />
                </div>
            </div>
            <div>
                <x-jet-label value="Potencia (HP @ RPM):" />
                <x-jet-input type="text" class="w-full" wire:model="potencia"  disabled/>
                <x-jet-input-error for="modificacion.potencia" />
            </div>            

        </div>
        <div class="grid grid-cols-2 gap-4 py-6">
            <div>
                <x-jet-label value="Fórmula rodante (FR):" />
                <x-jet-input type="text" class="w-full" wire:model="rodante" disabled/>
                <x-jet-input-error for="modificacion.rodante" />
            </div>
            <div>
                <x-jet-label value="Transporte de:" />
                <x-jet-input type="text" class="w-full" wire:model="carga" disabled/>
                <x-jet-input-error for="modificacion.carga" />
            </div>
        </div>
        <div class="col-span-2">
            <x-jet-label value="Datos a modificar:" />
            <x-textarea class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="rectificacion" maxlength="245" disabled/>
            <x-jet-input-error for="modificacion.rectificacion" />
        </div>

        <div class="mt-4  mb-2 flex flex-row justify-center items-center">
            <a wire:click="$set('estado','editando')"
                class="hover:cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 sm:mt-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-400 hover:bg-indigo-500 focus:outline-none rounded">
                <p class="text-sm font-medium leading-none text-white">Editar vehículo</p>
            </a>
        </div>
    </div>

</div>
