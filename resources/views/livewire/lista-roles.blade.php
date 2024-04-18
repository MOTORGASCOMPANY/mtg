<div class="mt-4">
    <x-jet-label for="rol" value="{{ __('Rol') }}" />
    <select  id="rol" name="rol" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full " wire:model="rol">
        <option value="">Seleccione</option>
        @foreach ($roles as $item)
        <option value="{{ $item->name }}">{{ $item->name }}</option>
        @endforeach              
    </select>
    <x-jet-input-error for="rol"/>
    @if($rol=="Administrador taller")
        <x-jet-label for="taller" value="{{ __('Taller') }}" />
        <select  id="taller" name="taller" class="bg-gray-50 mx-2 border-indigo-500 rounded-md outline-none ml-1 block w-full">
            <option value="">Seleccione</option>
            @foreach ($talleres as $item)
            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
            @endforeach              
        </select>
        <x-jet-input-error for="taller"/>
    @endif
</div>
