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

        h5 {
            position: absolute;
            bottom: 200px;
            right: 0.5px;
            transform: rotate(-90deg);
            transform-origin: right bottom;
            margin: 1.5px;
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
        <br>
        @foreach ($documentos as $doc)
            <img src="{{ public_path('storage/docsBoletas/' . basename($doc->ruta)) }}"
                style="width: 260px; height: {{ $doc->nombre === 'estado de cuenta' ? '100px' : '400px' }};">
        @endforeach
    @else
        <p>No hay comprobantes disponibles.</p>
    @endif

    <h5>
        @if ($documentos->isNotEmpty())
            {{$documentos->first()->boleta->identificador . ") " }}
                @if ($documentos->first()->boleta->taller == null)
                    {{"Inspector " . $documentos->first()->boleta->certificador }}
                @elseif ($documentos->first()->boleta->certificador == null)
                    {{"Taller " . $documentos->first()->boleta->taller }}
                @else
                @endif
        @endif
    </h5>
</body>


</html>
