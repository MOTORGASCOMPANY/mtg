<div class="bg-gray-200  px-8 py-4 rounded-xl w-full">
    <div class=" items-center md:block sm:block">
         <!-- TITULO DE LA TABLA -->
        <div class="p-2 w-64 my-4 md:w-full">                  
            {{$titulo}}    
        </div>
        <div class="w-full items-center md:flex  md:justify-between">
            <div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
                <span>Mostrar</span>
                <select wire:model="cant" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block ">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>registros</span>
            </div>
            <div class="flex bg-gray-50 items-center lg:w-3/6 p-2 rounded-md mb-4 ">                
                <i class="fas fa-search h-5 w-5 text-indigo-600" ></i>
                <input class="bg-gray-50 outline-none block rounded-md border-indigo-500 w-full" type="text" wire:model.debounce.300ms="search"
                    placeholder="buscar..." >
            </div>
            
            <!-- BOTON PRINCIPAL -->          
           <div class="flex mb-4">                
                {{$btnAgregar}}
            </div>
           

        </div>
    </div>
    {{$contenido}}
    
</div>