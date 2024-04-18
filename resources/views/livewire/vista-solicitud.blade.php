<div>
    @if ($solicitud)
        <div class="block items-center mt-8">
            <h1 class="text-xl text-center w-full font-bold"> SOLICITUD </h1>
            <div class="flex justify-center">
                <div class="bg-white rounded-xl p-8 w-4/6 shadow-lg">
                    <p>Fecha: <span class="px-2 bg-amber-200 rounded-xl">{{ $solicitud->created_at }}</span></p>
                    <p>Solicitado por: <strong class="px-2 bg-sky-200 rounded-xl">{{ $inspector }}</strong></p>
                    <div class="bg-slate-300 my-4 rounded-lg">
                        @foreach (json_decode($solicitud->data) as $item)
                            <div class="mx-auto max-w-lg flex flex-row justify-between items-center pb-2">
                                <p class="mt-2 text-md text-gray-600 dark:text-gray-300">{{ $item->nombre }}</p> 
                                <span class=" mr-2 bg-red-400 px-1 rounded-full">{{ $item->cantidad }}</span>                                    
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    @else
        <div class="block items-center mt-8">

            <div class="flex justify-center">
                <div class="bg-white rounded-xl p-8 w-5/6 shadow-lg">
                    <p class="text-center">No se encontro la solicitud que buscabas...</p>
                </div>
            </div>
            <div class="flex justify-center">
                <a href="{{ route('solicitud') }}" class="p-4 bg-sky-400 hover:cursor-pointer hover:bg-sky-600">
                    Volver</a>
            </div>

        </div>

    @endif
</div>
