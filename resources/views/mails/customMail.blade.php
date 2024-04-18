<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
@stack('styles')
<link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">

<body class="w-5/6 m-auto py-10">
    <header class="w-full flex justify-between items-center bg-gray-200 px-4 py-6 rounded-md">
        <img src="{{ asset('images/logo.png') }}" class="w-24">
        <div class="w-full">
            <p class="font-bold text-2xl w-full text-end italic">
                SISTEMA MOTORGAS
            </p>
        </div>
    </header>

    <main class="py-8 px-6">
        <h3 class="w-full py-2 font-semibold text-xl">
            AVISO DEL SISTEMA:
        </h3>
        <p>
            Estimado {{ $user->name }}, el presente correo es para informarle que su taller {{$taller->nombre}}
            tiene los siguiente documentos próximos a vencer o vencidos:
        </p>
        <br>
        <div class="block justify-center w-full">
            <div class="flex flex-col m-auto">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                      <table class="min-w-full text-center text-sm font-light border-2 rounded-lg">
                        <thead
                          class=" border-b bg-indigo-300/25  font-medium  dark:border-neutral-500 dark:bg-neutral-900">
                          <tr class="border-b divide-x divide-gray-400/25">
                            <th scope="col" class=" px-6 py-4">#</th>
                            <th scope="col" class=" px-6 py-4">Documento</th>
                            <th scope="col" class=" px-6 py-4">Fecha de Expiración</th>
                            <th scope="col" class=" px-6 py-4">Estado</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($documentos as $doc)
                                <tr class="border-b dark:border-neutral-500 divide-x divide-gray-400/25">
                                    <td class="whitespace-nowrap  px-6 py-4 font-medium">{{ $doc->id }}</td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $doc->TipoDocumento->nombreTipo }}</td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $doc->fechaExpiracion->format('d-m-Y') }}</td>

                                    @if ($doc->Dias==0)
                                    {{dd($doc->Dias)}}
                                        <td class="whitespace-nowrap  px-6 py-4"> Vence hoy </td>
                                    @else
                                        @if ($doc->Dias>0)
                                            <td class="whitespace-nowrap  px-6 py-4"> Vence en {{$doc->Tiempo}} </td>
                                        @endif
                                        @if($doc->Dias<0)
                                            <td class="whitespace-nowrap  px-6 py-4"> Venció hace {{$doc->Tiempo}} </td>
                                        @endif
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <br>
        <p>
            Es de suma importancia actualizar y/o renovar dichos documentos y adjuntarlos en el sistema, de lo contrario el
             taller podría recibir sanciones por parte de Sutran o las entidades reguladoras, si necesita ayuda o tiene consultas respecto a lo
             mencionado anteriormente comuníquese con el administrador del sistema.
        </p>
        <br>
        <p>
            Saludos cordiales.
        </p>
        <br>
        <p class="text-xs text-gray-400">
            Si ya subsano los documentos mencionados anteriormente, por favor omita este correo.
        </p>
    </main>

    <footer class="flex flex-row w-full bg-gray-200 p-2 m-auto">
        <div class="w-1/2">
            <p class="text-xs text-start">Motorgas Company S.A.C © - {{now()->format('Y')}}</p>
        </div>
        <div class="w-1/2">
            <p class="text-xs text-end text-gray-400">
                Powered by
                <a href="https://www.ecrdev.com" class="cursor-pointer hover:underline">
                    ECRDEV ®
                </a>

            </p>
        </div>
    </footer>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>
</html>
