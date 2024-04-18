<div class="flex  w-full pt-12 justify-center">
    <section class="bg-white dark:bg-gray-900 mt-2 border rounded-md shadow-lg">
        <div class="container px-6 py-10 mx-auto">
            <h1 class="text-3xl font-bold text-center text-gray-800  lg:text-4xl dark:text-white">
                Inventario de 
                <span class="text-indigo-500">Materiales</span>
            </h1>
    
            <div class="grid grid-cols-1 gap-8 mt-8 xl:mt-12 xl:gap-16 md:grid-cols-2 xl:grid-cols-3">

                {{--              GNVS                  --}}
                <div class="w-full border border-indigo-400 max-w-sm px-4 py-3 bg-white rounded-md shadow-md dark:bg-gray-800 dark:shadow-indigo-400">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-800 dark:text-gray-400 font-bold"><i class="fas fa-file"></i>&nbsp; FORMATOS GNV</span> 
                        <span class="px-3 py-1 text-sm text-green-800 uppercase bg-green-200 rounded-full dark:bg-blue-300 dark:text-blue-900"><i class="fa-solid fa-clipboard-check"></i></span>
                    </div>                
                    <div class="mt-4">                        
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 text-md font-semibold text-gray-600 dark:text-gray-300">
                                En stock:
                            </p>
                            @if ($todos->where("idTipoMaterial",1)->where("estado",3)->count()>0) 
                                <span class=" mr-2 bg-green-200 px-1 rounded-full text-green-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",1)->where("estado",3)->count()}}                                                                        
                                </span>
                            @else
                                <span class=" mr-2 bg-green-200 p-1 rounded-full text-green-800 font-bold">
                                    {{$todos->where("idTipoMaterial",1)->where("estado",3)->count()}} 
                                </span> 
                            @endif                                                         
                        </div>   
                        <hr class="border-indigo-400"> 
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 text-md font-semibold text-gray-600 dark:text-gray-300">
                                Consumido:
                            </p>                                 
                            @if ($todos->where("idTipoMaterial",1)->where("estado",4)->count()>0) 
                                <span class=" mr-2 bg-orange-200 px-1 rounded-full text-orange-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",1)->where("estado",4)->count()}}                                                                        
                                </span>
                            @else
                                <span class=" mr-2 bg-orange-200 px-1 rounded-full text-orange-800 font-bold">
                                    {{$todos->where("idTipoMaterial",1)->where("estado",4)->count()}}     
                                </span> 
                            @endif                       
                        </div>  
                        <hr class="border-indigo-400"> 
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Anulado:
                            </p>                              
                            @if ($todos->where("idTipoMaterial",1)->where("estado",5)->count()>0) 
                                <span class=" mr-2 bg-red-200 px-1 rounded-full text-red-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",1)->where("estado",5)->count()}}                                                                        
                                </span>
                            @else
                                <span class=" mr-2 bg-red-200 px-1 rounded-full text-red-800 font-bold">
                                    {{$todos->where("idTipoMaterial",1)->where("estado",5)->count()}}     
                                </span> 
                            @endif                         
                        </div> 
                        <hr class="border-indigo-400"> 
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 text-md font-semibold text-gray-600 dark:text-gray-300">Pendiente de Cambio:</p> <span class=" mr-2 bg-gray-200 p-3 rounded-full"></span>                            
                        </div> 
                    </div>               
                </div>
                
                {{--              GLPS                  --}}
                <div class="border border-indigo-400 w-full max-w-sm px-4 py-3 bg-white rounded-md shadow-md dark:bg-gray-800 dark:shadow-indigo-400">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-800 dark:text-gray-400 font-bold"> <i class="fas fa-file"></i> &nbsp;FORMATOS GLP</span>
                        <span class="px-3 py-1 text-sm text-green-800 uppercase bg-green-200 rounded-full dark:bg-blue-300 dark:text-blue-900"><i class="fa-solid fa-clipboard-check"></i></span>
                    </div>
                    <div class="mt-4">     
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                En stock:
                            </p>
                            @if ($todos->where("idTipoMaterial",3)->where("estado",3)->count()>0) 
                                <span class=" mr-2 bg-green-200 px-1 rounded-full text-green-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",3)->where("estado",3)->count()}}                                                                        
                                </span>
                            @else
                            <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{$todos->where("idTipoMaterial",3)->where("estado",3)->count()}} 
                                </span> 
                            @endif                                                         
                        </div>  
                        <hr class="border-indigo-400"> 
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 text-md font-semibold text-gray-600 dark:text-gray-300">
                                Consumido:
                            </p>                                 
                            @if ($todos->where("idTipoMaterial",3)->where("estado",4)->count()>0) 
                                <span class=" mr-2 bg-orange-200 px-1 rounded-full text-orange-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",3)->where("estado",4)->count()}}                                                                        
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{$todos->where("idTipoMaterial",3)->where("estado",4)->count()}}     
                                </span> 
                            @endif                       
                        </div>  
                        <hr class="border-indigo-400"> 
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Anulado:
                            </p>                              
                            @if ($todos->where("idTipoMaterial",3)->where("estado",5)->count()>0) 
                                <span class=" mr-2 bg-red-200 px-1 rounded-full text-red-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",3)->where("estado",5)->count()}}                                                                        
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{$todos->where("idTipoMaterial",3)->where("estado",5)->count()}}     
                                </span> 
                            @endif                         
                        </div>  
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Pendiente de Cambio:
                            </p> 
                            <span class=" mr-2 bg-gray-200 p-3 rounded-full"></span>                            
                        </div>                               
                    </div>
                </div>  
                
                {{--              CHIPS                 --}}
                <div class="border border-indigo-400 w-full max-w-sm px-4 py-3 bg-white rounded-md shadow-md dark:bg-gray-800 dark:shadow-indigo-400">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-800 dark:text-gray-400 font-bold"> <i class="fas fa-microchip"></i> CHIPS</span>
                        <span class="px-3 py-1 text-sm text-green-800 uppercase bg-green-200 rounded-full dark:bg-blue-300 dark:text-blue-900"><i class="fa-solid fa-clipboard-check"></i></span>
                    </div>

                    <div class="mt-4">     
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                En stock:
                            </p>
                            @if ($todos->where("idTipoMaterial",2)->where("estado",3)->count()>0) 
                                <span class=" mr-2 bg-green-200 px-1 rounded-full text-green-800 font-bold">                                   
                                    {{$todos->where("idTipoMaterial",2)->where("estado",3)->count()}}                                                                        
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{$todos->where("idTipoMaterial",2)->where("estado",3)->count()}}
                                </span> 
                            @endif                                                        
                        </div>  
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Consumido:
                            </p>                                 
                            @if ($todos->where("idTipoMaterial",2)->where("estado",4)->count()>0) 
                                <span class=" mr-2 bg-orange-200 px-1 rounded-full text-orange-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",2)->where("estado",4)->count()}}                                                                        
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{$todos->where("idTipoMaterial",2)->where("estado",4)->count()}}     
                                </span> 
                            @endif                       
                        </div>   
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                otro:
                            </p>                              
                            @if ($todos->where("idTipoMaterial",2)->where("estado",5)->count()>0) 
                                <span class=" mr-2 bg-red-200 px-1 rounded-full text-red-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",2)->where("estado",5)->count()}}                                                                        
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{$todos->where("idTipoMaterial",2)->where("estado",5)->count()}}     
                                </span> 
                            @endif                         
                        </div>  
                    </div>
                </div>

                {{--              MODIFICACION           --}}
                <div class="border border-indigo-400 w-full max-w-sm px-4 py-3 bg-white rounded-md shadow-md dark:bg-gray-800 dark:shadow-indigo-400">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-800 dark:text-gray-400 font-bold"> <i class="fas fa-file"></i> &nbsp;MODIFICACIÓN</span>
                        <span class="px-3 py-1 text-sm text-green-800 uppercase bg-green-200 rounded-full dark:bg-blue-300 dark:text-blue-900"><i class="fa-solid fa-clipboard-check"></i></span>
                    </div>
                    <div class="mt-4">     
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                En stock:
                            </p>
                            @if ($todos->where("idTipoMaterial",4)->where("estado",3)->count()>0) 
                                <span class=" mr-2 bg-green-200 px-1 rounded-full text-green-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",4)->where("estado",3)->count()}}                                                                        
                                </span>
                            @else
                            <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{$todos->where("idTipoMaterial",4)->where("estado",3)->count()}} 
                                </span> 
                            @endif                                                         
                        </div>  
                        <hr class="border-indigo-400"> 
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 text-md font-semibold text-gray-600 dark:text-gray-300">
                                Consumido:
                            </p>                                 
                            @if ($todos->where("idTipoMaterial",4)->where("estado",4)->count()>0) 
                                <span class=" mr-2 bg-orange-200 px-1 rounded-full text-orange-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",4)->where("estado",4)->count()}}                                                                        
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{$todos->where("idTipoMaterial",4)->where("estado",4)->count()}}     
                                </span> 
                            @endif                       
                        </div>  
                        <hr class="border-indigo-400"> 
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Anulado:
                            </p>                              
                            @if ($todos->where("idTipoMaterial",4)->where("estado",5)->count()>0) 
                                <span class=" mr-2 bg-red-200 px-1 rounded-full text-red-800 font-bold">                                   
                                        {{$todos->where("idTipoMaterial",3)->where("estado",5)->count()}}                                                                        
                                </span>
                            @else
                                <span class=" mr-2 bg-gray-200 px-1 rounded-full text-gray-800 font-bold">
                                    {{$todos->where("idTipoMaterial",4)->where("estado",5)->count()}}     
                                </span> 
                            @endif                         
                        </div>  
                        <hr class="border-indigo-400">
                        <div class="mx-auto w-full flex flex-row justify-between items-center">
                            <p class="mt-2 font-semibold text-md text-gray-600 dark:text-gray-300">
                                Pendiente de Cambio:
                            </p> 
                            <span class=" mr-2 bg-gray-200 p-3 rounded-full"></span>                            
                        </div>                               
                    </div>
                </div> 


            </div>
        </div>
    </section>

    
</div>
