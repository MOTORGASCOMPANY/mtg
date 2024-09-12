<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobantes</title>
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

        a {
            text-align: center;
            font-style: italic;
            font-size: smaller;
        }

        h5 {
            position: absolute;
            bottom: 250px;
            right: 0.5px;
            transform: rotate(-90deg);
            transform-origin: right bottom;
        }
    </style>
</head>

<body>
    @if ($documentos->isNotEmpty())
        <p>
            {{ $documentos->first()->boleta->identificador . ') ' }}
            @if ($documentos->first()->boleta->taller == null)
                {{ $documentos->first()->boleta->Certificador->name }}
            @else
                taller {{ $documentos->first()->boleta->Taller->nombre }}
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

    <a>
        {!! nl2br(e($boleta->observacion)) !!}
    </a>

    <h5>
        {{ $boleta->identificador . ') ' }}
        @if ($boleta->taller == null)
            {{ 'Inspector ' . $boleta->Certificador->name }}
        @else
            {{ 'Taller ' . $boleta->Taller->nombre }}
        @endif
    </h5>
</body>


</html>
