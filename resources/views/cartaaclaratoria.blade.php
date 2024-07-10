<!DOCTYPE html>
<html>

<head>
    <title>CARTA ACLARATORIA</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: sans-serif;
        }

        body {
            margin: 1cm 2cm 2cm;
            display: block;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3.5cm;
            color: black;
            font-weight: bold;
            text-align: center;
        }



        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            color: black;
            text-align: center;
            line-height: 35px;

        }

        p {
            font-size: 12px;
        }

        image {
            margin-left: 2cm;
        }

        h3 {
            margin-top: 3cm;
            color: black;
            text-align: center;
        }

        h4 {
            font-size: 14px;
            text-align: center;
        }

        h5 {
            text-align: right;
        }

        h6 {
            margin-bottom: -10px;
        }

        table,
        th,
        td {
            font-size: 10px;
            border: 1px solid;
            border-collapse: collapse;
        }

        table {
            width: 100%;
        }

        ol {
            list-style-type: lower-latin;
            font-size: 10px;
        }

        ul {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <header>

    </header>
    <main>
        <p>Lima, {{ $fecha }}</p>
        <p>Señores:</p>
        <p style="font-weight: bold; text-decoration: underline;">SUNARP</p>
        <p>
            Referencia: <span style="margin-left: 30px;">CARTA ACLARATORIA</span> <br>
            Título N°: <span style="margin-left: 42px;">{{ $certi->titulo }}</span> <br>
            Partida N°: <span style="margin-left: 34px;">{{ $certi->partida }}</span> <br>
            Placa: <span style="margin-left: 60px;">{{ $certi->placa }}</span>
        </p>
        <p>Presente.-</p>
        <p style="text-align: justify;">
            De mi especial consideración; <br>
            <strong>Yo ROLANDO ALBERJO CAJO RAVELLO,</strong> con <strong>DNI N°</strong> 21538229 en calidad de Gerente
            General de la
            empresa <strong>MOTOR GAS COMPANY</strong> con <strong>RUC N°</strong> 20472634501 con dirección en Jr. San
            Pedro de Carabayllo
            N° 180 Urb. Santa Isabel Distrito de Carabayllo, Provincia y Departamento de Lima, tengo el gusto de
            dirigirme a su distinguida
            persona para manifestarle lo siguiente:
        </p>
        <p style="text-align: justify;">
            Que mi representada es una Entidad Certificadora de
            @if ($certi->tipo == 'FORMATO GNV')
                Conversiones de Gas Natural Vehicular, autorizada Resolución Directoral <strong>N°
                    0321-2023-MTC/17.03</strong>, en este sentido les hacemos llegar la <strong>CARTA
                    ACLARATORIA</strong>, del Título N°
                {{ $certi->titulo . ', Partida N° ' . $certi->partida . ' y PLACA: ' . $certi->placa }}.
            @elseif ($certi->tipo == 'FORMATO GLP')
                Conversiones de Gas Licuado de Petróleo, autorizada Resolución Directoral <strong>N°
                    0464-2023-MTC/17.03</strong>, en este sentido les hacemos llegar la <strong>CARTA
                    ACLARATORIA</strong>, del Título N°
                {{ $certi->titulo . ', Partida N° ' . $certi->partida . ' y PLACA: ' . $certi->placa }}.
            @elseif ($certi->tipo == 'MODIFICACION')
                conformidad de modificación, montaje y fabricación autorizada con Resolución Directoral N°
                2651-2024.MTC/15, en este sentido les hacemos llegar la <strong>CARTA ACLARATORIA</strong>,
                del Título N° {{ $certi->titulo . ', Partida N° ' . $certi->partida . ' - ' . $certi->placa }}.
            @else
            @endif
        </p>

        <p>
            @if ($certi->tipo == 'FORMATO GNV')
                En cierto que, en el certificado de Conformidad de conversión a GNV, hubo un error de digitación.
            @elseif ($certi->tipo == 'FORMATO GLP')
                En cierto que, en el certificado de Conformidad de conversión a GLP, hubo un error de digitación.
            @elseif ($certi->tipo == 'MODIFICACION')
                En el certificado de Conformidad de Modificación, hubo un error tipográfico.
            @else
            @endif
        </p>

        <p>DICE:</p>
        @if ($certi->tipo == 'FORMATO GNV' || $certi->tipo == 'FORMATO GLP')
            @if (is_array($diceData) && count($diceData) > 0)
                <table style="width: 70%;">
                    @foreach ($diceData as $data)
                        <tr>
                            <td style="padding: 0 5px 0 5px; text-align:center; width: 5%;">{{ $data['numero'] }}</td>
                            <td style="padding: 0 5px 0 5px; width: 20%;">{{ $data['titulo'] }}</td>
                            <td style="padding: 0 5px 0 5px; width: 75%;">{{ $data['descripcion'] }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p>No hay datos disponibles para 'DICE'.</p>
            @endif
        @elseif ($certi->tipo == 'MODIFICACION')
            @if (is_array($diceData) && count($diceData) > 0)
                @foreach ($diceData as $data)
                    <p>{{ $data }}</p>
                @endforeach
            @else
                <p>No hay datos disponibles para 'DICE'.</p>
            @endif
        @endif

        <p>DEBE DECIR:</p>
        @if ($certi->tipo == 'FORMATO GNV' || $certi->tipo == 'FORMATO GLP')
            @if (is_array($debeDecirData) && count($debeDecirData) > 0)
                <table style="width: 70%;">
                    @foreach ($debeDecirData as $data)
                        <tr>
                            <td style="padding: 0 5px 0 5px; text-align:center; width: 5%;">{{ $data['numero'] }}</td>
                            <td style="padding: 0 5px 0 5px; width: 20%;">{{ $data['titulo'] }}</td>
                            <td style="padding: 0 5px 0 5px; width: 75%;">{{ $data['descripcion'] }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p>No hay datos disponibles para 'DEBE DECIR'.</p>
            @endif
        @elseif ($certi->tipo == 'MODIFICACION')
            @if (is_array($debeDecirData) && count($debeDecirData) > 0)
                @foreach ($debeDecirData as $data)
                    <p>{{ $data }}</p>
                @endforeach
            @else
                <p>No hay datos disponibles para 'DEBE DECIR'.</p>
            @endif
        @endif

        <p>Les expresamos las disculpas del caso y le pedimos que realicen la corrección.</p>
        <p>Sin otro particular, me despido.</p>
        <p>Atentamente;</p>


    </main>

    <footer>

    </footer>
</body>

</html>
