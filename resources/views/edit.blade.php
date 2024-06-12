<!-- Vista de Edición (resources/views/edit.blade.php) -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl mb-4">Editar Comunicado</h2>

                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('comunicado.update') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
                        <input type="text" name="titulo" id="titulo" value="{{ $comunicado['titulo'] ?? old('titulo') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('titulo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="contenido" class="block text-gray-700 text-sm font-bold mb-2">Contenido:</label>
                        <textarea name="contenido" id="contenido" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $comunicado['contenido'] ?? old('contenido') }}</textarea>
                        @error('contenido')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
