<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    @if ($documentos->isNotEmpty())
        <p>
            Comprobantes del taller
            {{ optional($documentos->first()->boleta->taller)->nombre ?? '' }}
            desde
            {{ $documentos->first()->boleta->fechaInicio ?? '' }}
            hasta
            {{ $documentos->first()->boleta->fechaFin ?? '' }}
        </p>
        @foreach ($documentos as $doc)
            <div class="image-container">
                <img src="{{ public_path('storage/docsBoletas/' . basename($doc->ruta)) }}">
            </div>
        @endforeach
    @else
        <p>No hay comprobantes disponibles.</p>
    @endif
</body>

</html>
