<div class="mb-4">
    <select wire:model="servicio" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full ">
        <option value="">Seleccione</option>
        @foreach ($servicios as $item)
        <option value="{{ $item->id }}">{{ $item->precio }}</option>
        @endforeach                   
    </select>
    <x-jet-input-error for="servicio"/>
</div>
