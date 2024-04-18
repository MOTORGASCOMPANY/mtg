<div>
    @if ($memorando)
        <div class="block items-center mt-8">
            <h1 class="mt-16 text-2xl text-center font-bold text-indigo-500 uppercase"> MEMORANDO </h1>
            <div class="flex justify-center">
                <div class="bg-white rounded-xl p-8 w-4/6 shadow-lg">
                    <p>Remitente: <strong class="px-2 bg-sky-200 rounded-xl">{{ $memorando->remitente }}</strong></p>
                    <p>Destinatario: <span class="px-2 bg-amber-200 rounded-xl">{{ $user }}</span></p>
                    <!--<p>Motivo: <strong class="px-2 bg-sky-200 rounded-xl">{{ $memorando->motivo }}</strong></p>-->
                    <p>Fecha: <span class="px-2 bg-amber-200 rounded-xl">{{ $memorando->fecha }}</span></p>
                    <a href="{{ $pdf }}" target="_blank" class="block mt-4 text-indigo-500 hover:underline">Ver Memorando</a>
                    <!--<embed src="{{ asset($memorando->rutaVistaMemorando) }}" type="application/pdf" width="100%" height="600px" />-->
                </div>
            </div>

        </div>

    @endif
</div>
