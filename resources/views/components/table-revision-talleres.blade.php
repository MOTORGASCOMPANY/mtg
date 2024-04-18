<div class="sm:px-6 w-full">
    <!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->
    <div class="px-4 md:px-10 py-4 md:py-7">
        <div class="flex items-center justify-between">
            <p class=" text-base sm:text-lg md:text-xl lg:text-3xl font-bold leading-normal text-gray-800">
                EXPEDIENTES
            </p>
            <div class="py-3 px-4 flex items-center text-sm font-medium leading-none text-gray-600 bg-gray-200 hover:bg-gray-300 cursor-pointer rounded-md">
                <p>Motrar:</p>
                <select wire:model="cant" aria-label="select" class="focus:text-indigo-600 focus:outline-none bg-transparent ml-1" >
                    <option class="text-sm text-indigo-800" value="10">10</option>
                    <option class="text-sm text-indigo-800" value="20">20</option>
                    <option class="text-sm text-indigo-800" value="50">50</option>
                    <option class="text-sm text-indigo-800" value="100">100</option>
                </select>
            </div>
        </div>
    </div>
    <div class="bg-white py-4 md:py-7 px-4 md:px-8 xl:px-10 rounded-t-md">
        <div class="sm:flex items-center justify-between space-x-2">
            <div class="flex bg-gray-300 items-center p-2 rounded-md">
                <span>Estado: </span>
                <select wire:model="es" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 w-full items-center md:flex  md:justify-center">
                    <option value="">SELECCIONE</option>
                    <option value="1">Por revisar</option>
                    <option value="2">Observado</option>
                    <option value="3">Aprobado</option>
                    <option value="4">Desaprobado</option>
                </select>                
            </div>

            {{$tipos}}

            <div class="flex bg-gray-300 items-center p-2 rounded-md">
                <span>Desde: </span>
                <x-date-picker wire:model="fecIni" placeholder="Fecha de inicio" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate"/>             
            </div>

            <div class="flex bg-gray-300 items-center p-2  rounded-md ">
                <span>Hasta: </span>
                <x-date-picker wire:model="fecFin" placeholder="Fecha de Fin" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full truncate"/>             
            </div>  
            <div class="flex bg-gray-300 items-center rounded-md p-2 lg:w-2/6 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
                <input class="bg-gray-50 outline-none block rounded-md border-indigo-500 w-full" type="text" wire:model="search"
                    placeholder="buscar...">
            </div>          
        </div>
        <div class="mt-7 overflow-x-auto">
            {{$slot}}
        </div>
    </div>
</div>
