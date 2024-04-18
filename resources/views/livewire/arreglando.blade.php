<div>
   

    <div class="w-4/6 mx-auto my-8">
        <ol>
            @foreach ($certificaciones as $item)
                <li>{{$item->id .' - '.$item->Vehiculo->placa.' - '.$item->created_at.'________'}}<span class="text-red-500">{{$item->updated_at}}</span></li>
            @endforeach
        </ol>
        <button wire:click="cambiar" class="p-2 rounded-md border border-slate-500 text-white bg-slate-400 hover:bg-slate-600">
            Cambiar
        </button>
    </div>
   
</div>
