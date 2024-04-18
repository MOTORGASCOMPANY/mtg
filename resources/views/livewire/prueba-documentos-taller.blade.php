<div class="mt-12 pt-12">
    @if (isset($docs))
        @foreach ($docs as $doc )
            <p>
                {{$doc->id.' - '.$doc->TipoDocumento->nombreTipo.' - '.$doc->fechaExpiracion->format('Y-m-d')}}
                @if ($doc->Dias==0)
                    <span class="p-1 rounded-md bg-red-300"> Vence hoy.</span>
                @else
                    @if ($doc->Dias>0)
                        <span class="p-1 rounded-md bg-orange-300"> Vence en {{$doc->Tiempo}} </span>
                    @endif
                    @if($doc->Dias<0)
                        <span class="p-1 rounded-md bg-red-300"> Venció hace {{$doc->Tiempo}} </span>
                    @endif
                @endif
                {{$doc->estadoDocumento==1 ? '✔' : '❌'}}
            </p>
            <br>
        @endforeach
        <div class="my-4 mx-auto p-4 w-1/6 flex flex-row justify-center">
            <p class="bg-red-500 text-white p-2 rounded-md">{{count($docs) }}</p>
        </div>

        <div class=" mx-auto  p-8 bg-gray-300 flex flex-row justify-center">
            <button class="bg-green-500 rounded-md border-none p-2" wire:click="cambiar({{$docs}})">
                Cambiar estados
            </button>
        </div>
    @else
        <div class=" mx-auto p-8 bg-gray-300 flex flex-row justify-center">
            <p class="text-center text-xs "> <i class="fa-solid fa-circle-exclamation "></i> No se encontraron documentos pendientes de cambio de estado</p>
        </div>
    @endif
</div>
