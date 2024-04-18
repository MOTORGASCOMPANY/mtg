<div>
    <div class="container block justify-center m-auto py-12">
        <h1 class="text-2xl text-center font-bold text-indigo-500 uppercase">Mantenimiento de Logos</h1>
        <div class="rounded-xl m-4 bg-white p-8 mx-auto max-w-max shadow-lg">
            <div>
                <a href="/">
                    <img src="{{ asset('images/images/' . $currentLogo) }}" width="250" height="150" />
                </a>
            </div>
            <div class="flex items-center justify-center mt-4">
                <button class="p-3 bg-indigo-500 rounded-xl text-white text-sm hover:font-bold hover:bg-indigo-700"
                    wire:click="abrir">
                    <i class="fas fa-search"></i>
                    Actualizar
                </button>
            </div>
        </div>
    </div>

    <x-jet-dialog-modal wire:model="showModal" wire:loading.attr="disabled" wire:target="deleteFile">
        <x-slot name="title" class="font-bold">
            <h1>Editar Logo</h1>
        </x-slot>

        <x-slot name="content">
            <h1 class="pt-2  font-semibold sm:text-lg text-gray-900">
                Logo Actual:
            </h1>
            <a class="flex items-center justify-center" href="/">
                <img src="{{ asset($logoPath) }}" width="250" height="150" />
            </a>
            <h1 class="pt-2  font-semibold sm:text-lg text-gray-900">
                Imagenes:
            </h1>
            <hr />
            @if (count($availableLogos))
                <section class="my-4 pb-4 overflow-hidden border-dotted border-2 text-gray-700">
                    <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
                            @foreach ($availableLogos as $filename)
                                @if (pathinfo($filename, PATHINFO_EXTENSION) == 'png')
                                    <div class="relative group">
                                        <div class="w-full h-36 overflow-hidden">
                                            <img alt="gallery"
                                                class="object-cover object-center w-full h-full rounded-lg"
                                                src="{{ asset('images/images/' . $filename) }}">
                                        </div>
                                        <!-- Agrega el resto de tu lógica según sea necesario -->
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </section>
            @else
                <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
                    <!-- Contenido para cuando no hay archivos disponibles -->
                </section>
            @endif


        </x-slot>

        <x-slot name="footer">

            <x-jet-secondary-button wire:click="$set('showModal',false)" class="mx-2">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="actualizar">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>


</div>
