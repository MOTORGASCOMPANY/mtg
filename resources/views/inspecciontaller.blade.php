<!DOCTYPE html>
<html>

<head>
    <title>CERTIFICADO DE INSPECCIÓN DE TALLER</title>
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

        .qr-code {
            width: 25%;
            /* Ajusta el ancho según tus necesidades */
            margin-left: auto;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>

    </header>
    <main>
        <h3>CERTIFICADO DE INSPECCIÓN DE TALLER</h3>
        <h5 style=" text-align:left;">TIPO DE CERTIFICADO:

            @if ($certi->inicial === 1)
                INICIAL
            @elseif ($certi->inicial === 0)
                ANUAL
            @else
            @endif
        </h5>
        <h5>{{ 'CERTIFICADO N° SD-05-' . $certi->material->numSerie . '-' . $certi->created_at->format('Y') }}</h5>
        <h4> MOTOR GAS COMPANY S.A</h4>
        <h5 style="text-align:left;">CERTIFICA:</h5>
        <p>Haber efectuado la inspeccion
            @if ($certi->inicial === 0)
                anual
            @else
            @endif
            al siguiente taller:
        </p>
        <table>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center; width: 5%;">1</td>
                <td style="padding: 0 5px 0 5px; width: 20%;">
                    <strong>Nombre del Taller</strong>
                </td>
                <td style="padding: 0 5px 0 5px; width: 75%;">
                    {{ $certi->taller->nombre ?? null }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center; width: 5%;">2</td>
                <td style="padding: 0 5px 0 5px; width: 20%;">
                    <strong>Dirección</strong>
                </td>
                <td style="padding: 0 5px 0 5px; width: 75%;">
                    {{ $certi->taller->direccion ?? null }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center; width: 5%;">3</td>
                <td style="padding: 0 5px 0 5px; width: 20%;">
                    <strong>Teléfono</strong>
                </td>
                <td style="padding: 0 5px 0 5px; width: 75%;">
                    {{ $certi->taller->telefono ?? null }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center; width: 5%;">4</td>
                <td style="padding: 0 5px 0 5px; width: 20%;">
                    <strong>Ciudad</strong>
                </td>
                <td style="padding: 0 5px 0 5px; width: 75%;">
                    {{ $certi->taller->Distrito->distrito ?? null }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center; width: 5%;">5</td>
                <td style="padding: 0 5px 0 5px; width: 20%;">
                    <strong>Representante Legal</strong>
                </td>
                <td style="padding: 0 5px 0 5px; width: 75%;">
                    {{ $certi->taller->representante ?? null }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center; width: 5%;">6</td>
                <td style="padding: 0 5px 0 5px; width: 20%;">
                    <strong>Nro. de Autorización</strong>
                </td>
                <td style="padding: 0 5px 0 5px; width: 75%;">                   

                    @if ($certi->inicial === 1)
                        NE
                    @else
                        {{ $certi->taller->autorizacion ?? null }}
                    @endif
                </td>
            </tr>
        </table>

        <p style="text-align: justify;">Habiéndose verificado que su infraestructura inmobiliaria, equipamiento y
            personal técnico cumplen con los
            requisitos establecidos en las normas legales y técnicas peruanas vigentes en la materia, calificando dicho
            taller para realizar la conversión y/o reparación del sistema de combustión de los vehiculos a
            <strong>
                @if ($certi->material->idTipoMaterial === 3)
                    Gas Licuado de Petroleo - GLP
                @elseif ($certi->material->idTipoMaterial === 1)
                    Gas Natural Vehicular - GNV
                @else
                @endif
            </strong>, tal como se evidencian en los documentos que se anexan a la
            presente.
        </p>
        <p>Fecha de la próxima inspección anual: {{ $certi->created_at->addYear()->format('d-m-Y') }}</p>
        <p>OBSERVACIONES:</p>
        <ul>
            <li>Requisitos verificados: Directiva N°001-2005-MTC/15, Numerales 6.1.2, 6.1.3, 6.1.4 con sus
                modificaciones en la Resolución Directoral
                @if ($certi->material->idTipoMaterial === 3)
                    N°0464-2023-MTC/17.03
                @elseif ($certi->material->idTipoMaterial === 1)
                    N°365-2021-MTC/17.03
                @else
                @endif
                Y NTP/17.03 Y NTP 111.018.2004, capitulo 5
            </li>
            <li>Documentos anexos a la presente son: check list de chequeo y evidencias de conformidad, total de
                anexos (60) hojas.</li>
            <li>N.E No Especifica.</li>
        </ul>
        <p>Se expide el presente certificado en la ciudad de <strong>Lima</strong>, el {{ $fecha }}.</p>

        <!-- Agrega esto donde quieras mostrar el código QR -->
        @if (!empty($qrCode))
            <div class="qr-code">
                <img src="data:image/png;base64, {!! base64_encode($qrCode) !!}" alt="Código QR">
            </div>
        @endif


    </main>

    <footer>

    </footer>
</body>

</html>
