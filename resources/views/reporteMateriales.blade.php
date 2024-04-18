<div class="overflow-x-auto sm:-mx-6 lg:-mx-8 mx-12 w-full">
    <div class="inline-block min-w-full py-2 sm:px-6 ">
        <div class="overflow-hidden">
            <table class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                <thead class="border-b font-medium dark:border-neutral-500">
                    <tr class="bg-indigo-200">
                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                            Inspector
                        </th>
                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                            Numero de formato
                        </th>
                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                            Guia
                        </th>
                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                            Ubicacion
                        </th>
                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                            Estado
                        </th>
                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                            otro dato
                        </th>       
                        {{--                      
                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                            Realizado con sistema
                        </th>
                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                            Precio
                        </th>
                        --}}   

                    </tr>
                </thead>                       
                <tbody>
                    @foreach ($materiales as $item)
                        <tr class="border-b dark:border-neutral-500">
                            <td
                                class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">
                                {{ $item->Inspector->name?? "Sin datos de usuario" }}
                            </td>
                            <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                {{ $item->numSerie.' - '.$item->añoActivo }}
                            </td>
                            <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                {{ $item->grupo }}
                            </td>
                            <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                {{ $item->ubicacion }}
                            </td>

                            <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                @switch($item->estado)
                                    @case(1)
                                        En Almacen Motorgas
                                        @break
                                    @case(2)
                                        En proceso de envio
                                        @break
                                    @case(3)
                                        En poder del inspector
                                        @break
                                    @case(4)
                                        Consumido
                                        @break
                                    @default                                                
                                @endswitch
                            </td>
                            <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                otro dato
                            </td>                                   
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>