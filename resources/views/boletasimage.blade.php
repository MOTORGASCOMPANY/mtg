<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 10px;
        }

        .image-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .image-container img {
            max-width: 100%;
            /*height: auto;*/
        }

        p {
            margin: 0;
            padding: 10px;
        }
    </style>
</head>

<body>
    @if ($documentos->isNotEmpty())
        <p style="text-align: center;">
            Comprobantes del taller
            {{ optional($documentos->first()->boleta->taller)->nombre ?? '' }}
            desde
            {{ $documentos->first()->boleta->fechaInicio ?? '' }}
            hasta
            {{ $documentos->first()->boleta->fechaFin ?? '' }}
        </p>
        <br>
        <br>
        @foreach ($documentos as $doc)
            <div class="image-container">
                <img src="{{ public_path('storage/docsBoletas/' . basename($doc->ruta)) }}"
                    @if ($doc->nombre === 'comprobante') height="500" @endif>
            </div>
        @endforeach
    @else
        <p>No hay comprobantes disponibles.</p>
    @endif
</body>

</html>
