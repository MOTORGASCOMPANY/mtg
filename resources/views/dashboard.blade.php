<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome />           
            </div>
        </div>
    </div>

    {{-- COMUNICADO CON CONTROLLER --}}
    @if (isset($comunicado) && $comunicado->activo)
        <div id="comunicadoModal" class="mt-16 fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- FONDO OSCURO MODAL -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <div
                    class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <button class="absolute top-0 right-0 mt-4 mr-4 focus:outline-none" onclick="closeModal()">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <a class="py-2 h-1/2">
                        <img src="{{ asset('images/images/logomemo.png') }}" />
                    </a>
                    <div class="bg-white px-6 pt-5 pb-6 sm:p-6 sm:pb-4 relative">
                        <div class="text-center">
                            <h3 class="text-lg font-medium text-gray-900">{{ $comunicado->titulo }}</h3>
                            <p class="mt-2 text-sm text-gray-500 mb-4" style="text-align: justify;">
                                {!! nl2br(e($comunicado->contenido)) !!}
                            </p>
                            @if ($comunicado->imagen)
                                <img src="{{ asset($comunicado->imagen) }}" alt="Imagen del comunicado"
                                    class="mt-4 mx-auto">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function openModal() {
            document.body.classList.add('overflow-hidden');
            document.getElementById('comunicadoModal').classList.remove('hidden');
        }

        function closeModal() {
            document.body.classList.remove('overflow-hidden');
            document.getElementById('comunicadoModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
