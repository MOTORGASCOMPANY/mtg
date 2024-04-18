<div>
    <div class="pt-12 border-radius-md bg-indigo-200 m-auto">

        <div class="max-w-5xl m-auto  bg-white rounded-lg shadow-md dark:bg-gray-300 p-4 mt-4">
            {{--<x-jet-label value="Fotos reglamentarias:" class="font-bold text-xl py-4" />--}}
            <x-file-pond name="archivo" id="archivo" wire:model="archivo" acceptedFileTypes="['image/*',]"
                aceptaVarios="true" wire:ignore>
            </x-file-pond>
            <x-jet-input-error for="archivo" />
        </div>

        <div class="w-full text-center items-center justify-center py-2">
            <button
                        class="p-2 w-36 bg-indigo-400 my-2 rounded-md text-white hover:bg-indigo-600 disabled:bg-gray-200 disabled:text-indigo-400"
                        id="5484" wire:loading.attr="disabled" wire:click="procesar()"
                        wire:target="archivo,procesar">
                        procesar archivo
                        <span wire:loading wire:target="procesar">
                            <i class="fas fa-spinner animate-spin text-indigo-500"> </i>
                        </span>

                    </button>
        </div>

        <div>
            @if (isset($archivos))
                {{var_export($archivos)}}
            @endif
        </div>
        <div>
            @if (isset($urls))
                @foreach ($urls as $url)
                    <img src="{{ $url }}" alt="Imagen">
                @endforeach
            @endif
        </div>

        @if (session()->has('message'))
            <div>{{ session('message') }}</div>
        @endif



    </div>
</div>
