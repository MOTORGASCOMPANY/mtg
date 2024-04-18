<div>
    <div class="pt-12 border-radius-md bg-indigo-200 m-auto">

        <div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300 p-4 mt-4">
            {{--<x-jet-label value="Fotos reglamentarias:" class="font-bold text-xl py-4" />--}}
            <x-file-pond name="imagenes" id="imagenes" wire:model="imagenes" acceptedFileTypes="['image/*',]"
                aceptaVarios="true" wire:ignore>
            </x-file-pond>
            <x-jet-input-error for="imagenes" />
        </div>

        <div class="w-full text-center items-center justify-center py-2">
            <button class="border-none rounded-xl bg-green-300 text-center mx-auto p-3" wire:click='muestraData()'>
                Procesar
            </button>
        </div>

    </div>
</div>
