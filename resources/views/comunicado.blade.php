<x-app-layout>
    <div class="py-12 mt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl bold text-center text-indigo-500 font-semibold">
                    GESTIONAR COMUNICADO
                </h1>

                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ $comunicado ? route('comunicado.update', $comunicado->id) : route('comunicado.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($comunicado)
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <x-jet-label value="Título:" for="titulo" />
                        <x-jet-input type="text" name="titulo" id="titulo" value="{{ $comunicado->titulo ?? old('titulo') }}" class=" w-full" />
                        @error('titulo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-jet-label value="Contenido:" for="contenido" />
                        <textarea name="contenido" id="contenido" rows="5" class="shadow appearance-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" style="height: 300px;">{{ $comunicado->contenido ?? old('contenido') }}</textarea>
                        @error('contenido')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center">
                            <x-jet-label value="Seleccionar Imagen:" for="imagen" class="mr-2" />
                            <button type="button" id="selectImageBtn" class="group flex py-2 px-2 text-center items-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
                                <i class="fa fa-image"></i>
                                <span class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                    Imagen
                                </span>
                            </button>
                        </div>

                        <div id="imageAlbum" class="flex flex-wrap mt-4 hidden">
                            <label class="mr-4 mb-4 cursor-pointer">
                                <input type="radio" name="imagen" value="" {{ !isset($comunicado->imagen) ? 'checked' : '' }} class="hidden">
                                <span class="w-24 h-24 flex items-center justify-center border-2 border-gray-300 rounded text-gray-500 hover:border-indigo-500">
                                    Ninguna
                                </span>
                            </label>
                            @foreach (File::files(public_path('images/images')) as $file)
                                @if (in_array(strtolower($file->getExtension()), ['png', 'jpg', 'jpeg']))
                                    <label class="mr-4 mb-4 cursor-pointer">
                                        <input type="radio" name="imagen" value="{{ 'images/images/' . basename($file) }}" {{ isset($comunicado->imagen) && $comunicado->imagen == 'images/images/' . basename($file) ? 'checked' : '' }} class="hidden">
                                        <img src="{{ asset('images/images/' . basename($file)) }}" alt="{{ basename($file) }}" class="w-24 h-24 object-cover border-2 border-gray-300 rounded hover:border-indigo-500 {{ isset($comunicado->imagen) && $comunicado->imagen == 'images/images/' . basename($file) ? 'border-indigo-500' : '' }}">
                                    </label>
                                @endif
                            @endforeach
                        </div>
                        @error('imagen')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-center">
                        <x-jet-button loading:attribute="disabled" type="submit" class="bg-indigo-300 hover:bg-indigo-400 border-indigo-400 mx-2">
                            {{ $comunicado ? 'Actualizar' : 'Crear' }}
                        </x-jet-button>

                        @if ($comunicado)
                            <x-jet-secondary-button id="deactivateBtn" class="text-indigo-500 border-indigo-400">
                                Inhabilitar
                            </x-jet-secondary-button>
                        @endif
                    </div>
                </form>

                <form action="{{ route('comunicado.uploadImage') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <x-jet-label value="Subir Imagen:" />
                        <div class="flex items-center">
                            <input type="file" name="new_image" accept="image/*" class="shadow appearance-none rounded mr-2" required>
                            <button type="submit" class="group flex py-2 px-2 text-center items-center rounded-md bg-blue-300 font-bold text-white cursor-pointer hover:bg-blue-400 hover:animate-pulse">
                                <i class="fa-solid fa-file-circle-plus"></i>
                                <span class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-50">
                                    Agregar
                                </span>
                            </button>
                        </div>
                    </div>
                    @error('new_image')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('selectImageBtn').addEventListener('click', function() {
            var album = document.getElementById('imageAlbum');
            if (album.classList.contains('hidden')) {
                album.classList.remove('hidden');
            } else {
                album.classList.add('hidden');
            }
        });

        document.getElementById('deactivateBtn')?.addEventListener('click', function() {
            @if ($comunicado)
                fetch('{{ route('comunicado.deactivate', $comunicado->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
            @endif
        });
    </script>
</x-app-layout>
