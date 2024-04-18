<div class="bg-gray-200  px-8 py-4 rounded-xl w-full">
    <div class=" items-center md:block sm:block">
        <div class="p-2 w-64 my-4 md:w-full">
            <h2 class="text-indigo-600 font-bold text-3xl">
                <i class="fas fa-user fa-xl"></i>
                 &nbsp;Usuarios
            
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
                {{--
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
                --}}
                <i class="fas fa-search h-5 w-5 text-indigo-600" ></i>

                <input class="bg-gray-50 outline-none block rounded-md border-indigo-500 w-full" type="text" wire:model="search"
                    placeholder="buscar...">
            </div>
            
            <!-- boton agregar -->            
           
            <div class="mb-4">
                <button  class="bg-indigo-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer"> 
                     Nuevo Usuario &nbsp;<i class="fas fa-plus"></i>
                </button>

            </div>
           

        </div>
    </div>
    {{$slot}}
    
</div>