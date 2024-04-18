<div class="bg-gray-200  px-8 py-4 rounded-xl w-full">
    <div class=" items-center md:block sm:block">
        <div class="p-2 w-64 my-4 md:w-full">
            <h2 class="text-indigo-600 font-bold text-3xl">
                <i class="fas fa-user fa-xl"></i>
                 &nbsp;Precios por Inspector
            
            </h2>            
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
                <span>Entradas</span>
            </div>
            <div class="flex bg-gray-50 items-center lg:w-3/6 p-2 rounded-md mb-4">
                <i class="fas fa-search h-5 w-5 text-indigo-600" ></i>

                <input class="bg-gray-50 outline-none block rounded-md border-indigo-500 w-full" type="text" wire:model="search"
                    placeholder="buscar...">
            </div>
            
            <!-- boton agregar -->            
           
            <div class="mb-4">
                <button  class="bg-indigo-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer"> 
                     Nuevo  &nbsp;<i class="fas fa-plus"></i>
                </button>

            </div>
           

        </div>
    </div>
    {{$slot}}
    
</div>