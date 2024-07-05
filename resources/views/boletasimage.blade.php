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
            margin: 0; /* Ajusta el margen para hacer más espacio */
        }

        .image-container {
            text-align: center;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-grid {
            display: grid;
            /*grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));*/
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
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
            Comprobantes del
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
        <div class="content">
            <div class="image-grid">
                @foreach ($documentos as $doc)
                    <div class="image-container">
                        <img src="{{ public_path('storage/docsBoletas/' . basename($doc->ruta)) }}">
                        {{-- @if ($doc->nombre === 'comprobante') height="500" @endif> --}}
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p>No hay comprobantes disponibles.</p>
    @endif
</body>

</html>
