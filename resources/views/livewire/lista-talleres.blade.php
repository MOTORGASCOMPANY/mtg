<div class="flex bg-gray-50 items-center p-2 rounded-md mb-4">
    <span>Taller: </span>
    <select wire:click="$emitTo('revision-expedientes','tallerSel({{ $seleccion }})');" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block">
        <option value="">Seleccione</option>
        @foreach ($talleres as $item)
        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
        @endforeach 
    </select>   
    {{$seleccion}}   
</div> 