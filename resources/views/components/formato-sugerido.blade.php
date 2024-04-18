<div class="max-w-5xl m-auto bg-white rounded-lg shadow-md my-4 py-4 px-8 flex flex-row justify-between items-center">
    <div class="w-4/6 items-center">
        <h1 class="font-bold"><span class="p-1 bg-green-300 rounded-lg">Formato Sugerido:</span></h1>
    </div>     
    

    <div class="w-2/6 flex justify-end">
        <x-jet-input type="text" wire:model.debounce.500ms="numSugerido"  />
        <x-jet-input-error for="numSugerido" />
    </div>
</div>
