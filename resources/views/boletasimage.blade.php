<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .content {
            padding: 10px;
            margin: 0;
        }

        p {
            margin: 0;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    @if ($documentos->isNotEmpty())
        <p>
            {{$documentos->first()->boleta->identificador . ") " }}
            @if ($documentos->first()->boleta->taller == null)
                {{ $documentos->first()->boleta->certificador }}
            @elseif ($documentos->first()->boleta->certificador == null)
                taller {{ $documentos->first()->boleta->taller }}
            @else
            @endif
            desde
            {{ $documentos->first()->boleta->fechaInicio ?? '' }}
            hasta
            {{ $documentos->first()->boleta->fechaFin ?? '' }}
        </p>
        <br>
        <br>
        <br>
        @foreach ($documentos as $doc)
            <img src="{{ public_path('storage/docsBoletas/' . basename($doc->ruta)) }}"
                style="width: 250px; height: {{ $doc->nombre === 'estado de cuenta' ? '50px' : '300px' }};">
        @endforeach
    @else
        <p>No hay comprobantes disponibles.</p>
    @endif
</body>

</html>
