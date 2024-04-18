<div>

    <div class="container block justify-center m-auto py-12">
        <h1 class="text-2xl bold text-center text-indigo-500 font-semibold ">
            CARGA DE SERVICIOS DE REVISION ANUALES DE GNV
        </h1>
        <div class="max-w-8xl border shadow-md rounded-md bg-indigo-100 flex flex-col justify-center pt-12 mx-auto">
            <div class="flex flex-row space-x-2 items-center m-auto">
                <x-jet-label value="Servicios de revisión anual:" />
                <input
                    class="relative m-0 block w-full min-w-0 flex-auto rounded border  shadow-sm bg-indigo-300  bg-clip-padding px-3 py-2 text-base font-normal text-white transition duration-300 ease-in-out file:-mx-3 file:-my-2 file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-indigo-500 file:px-3 file:py-2 file:text-white file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-indigo-700 focus:border-primary focus:text-white focus:shadow-te-primary focus:outline-none "
                    type="file" wire:model="file" accept=".xlsx," />

                @if (!$estadoAnuales)
                    <button
                        class="p-2 w-36 bg-indigo-400 my-2 rounded-md text-white hover:bg-indigo-600 disabled:bg-gray-200 disabled:text-indigo-400"
                        id="5484" wire:loading.attr="disabled" wire:click="procesarAnuales"
                        wire:target="file,procesarAnuales">
                        procesar archivo
                        <span wire:loading wire:target="procesarAnuales">
                            <i class="fas fa-spinner animate-spin text-indigo-500"> </i>
                        </span>

                    </button>
                @else
                    <button
                        class="p-2 w-36 bg-green-500 my-2 rounded-md text-white hover:bg-green-700 disabled:bg-gray-200 disabled:text-indigo-400"
                        id="123" wire:loading.attr="disabled" wire:click="cargarAnuales"
                        wire:target="file,cargarAnuales">
                        cargar datos
                        <span wire:loading wire:target="cargarAnuales">
                            <i class="fas fa-spinner animate-spin text-indigo-500"> </i>
                        </span>
                    </button>
                @endif

            </div>
            @error('file')
                <span class="error text-red-600">{{ $message }}</span>
            @enderror

            <br>
            @if (!empty($cuenta))
                <p class="text-center font-bold text-slate-700">
                    Se encontró: {{ $cuenta }} registros
                </p>
            @endif
            @if (!empty($coincidencias))
                @if ($coincidencias > 0 && $coincidencias < 2)
                    <p class="text-center text-sm font-bold text-red-500">
                        Del cual: {{ $coincidencias }} Conincidencia con registros anteriores
                    </p>
                @else
                    <p class="text-center text-xs text-red-500">
                        De los cuales: {{ $coincidencias }} coinciden con registros anteriores
                    </p>
                @endif
            @endif


            {{--
            @if (isset($data))
            <div class="w-full bg-white border rounded-md py-4">
                @foreach ($data as $key => $item)        
                    
                    @foreach ($item as $id => $row)
                    <span class="text-indigo-500 font-bold">{{$key }}</span><p>{{var_export($row)}}</p><br>
                        <p>{{$id.'---'.$row[2].' - '.$row[4].' - '.$row[7]}}</p>
                    @endforeach
                @endforeach
            </div>           
            @endif
            --}}


        </div>
    </div>

    @if (isset($data))
        <div class="max-h-96 overflow-y-auto overflow-x-auto max-w-7xl mx-auto ">
            <table class="">
                <thead class="bg-slate-700">
                    <tr>
                        <th class="font-bold text-indigo-300">#</th>
                        @foreach ($headers as $header)
                            <th class="font-bold text-indigo-300">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($data as $ids => $row)
                        <tr class="hover:bg-gray-200 divide-x">
                            <td class="text-center text-orange-400 font-bold">{{ $ids + 1 }}</td>
                            @foreach ($row as $key => $value)
                                <td class="text-center">{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif


</div>
