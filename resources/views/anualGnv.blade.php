<!DOCTYPE html>
<html>

<head>
    <title>CERTIFICADO DE INSPECCIÓN ANUAL DEL VEHÍCULO A GNV</title>
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
            font-size: 10px;
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
        <h3>CERTIFICADO DE INSPECCIÓN ANUAL DEL VEHÍCULO A GNV</h3>
        <h5>{{ 'Certificado N° ' . $hoja->numSerie . ' - ' . $fechaCert->format('Y') }}</h5>{{--estaba asi y jalaba el año actual date('Y') se cambio para 2024 $fechaCert->format('Y')--}}
        <h4> {{ 'LA ENTIDAD CERTIFICADORA ' . $empresa . ' CERTIFICA:' }}</h4>
        <p>Haber efectuado la evaluación de las condiciones de seguridad del sistema de combustión a Gas Natural
            Vehicular – GNV del siguiente vehículo (*):</p>
        <table>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">1</td>
                <td>Placa de rodaje</td>
                <td>{{ $carro->placa }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">9</td>
                <td>Cilindros / Cilindrada</td>
                <td>{{ (isset($carro->cilindros) ? $carro->cilindros : 'NE') . ' / ' . (isset($carro->cilindrada) ? $carro->cilindrada : 'NE') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">2</td>
                <td>Categoria</td>
                <td>{{ $carro->categoria }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">10</td>
                <td>Combustible</td>
                <td>{{ $carro->combustible }}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">3</td>
                <td>Marca</td>
                <td>{{ isset($carro->marca) ? $carro->marca : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">11</td>
                <td>N° Ejes / N° Ruedas</td>
                <td>{{ (isset($carro->ejes) ? $carro->ejes : 'NE') . ' / ' . (isset($carro->ruedas) ? $carro->ruedas : 'NE') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">4</td>
                <td>Modelo</td>
                <td>{{ isset($carro->modelo) ? $carro->modelo : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">12</td>
                <td>N° Asientos / N° Pasajeros</td>
                <td>{{ (isset($carro->asientos) ? $carro->asientos : 'NE') . ' / ' . (isset($carro->pasajeros) ? $carro->pasajeros : 'NE') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">5</td>
                <td>Versión</td>
                <td>{{ $carro->version }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">13</td>
                <td>Largo / Ancho / Alto(m)</td>
                <td>{{ (isset($carro->largo) ? $largo : 'NE') . ' / ' . (isset($carro->ancho) ? rtrim($carro->ancho, '0') : 'NE') . ' / ' . (isset($carro->altura) ? rtrim($carro->altura, '0') : 'NE') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">6</td>
                <td>Año fabricación</td>
                <td>{{ isset($carro->anioFab) ? $carro->anioFab : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">14</td>
                <td>Color(es)</td>
                <td>{{ $carro->color }}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">7</td>
                <td>VIN / N° Serie</td>
                <td>{{ isset($carro->numSerie) ? $carro->numSerie : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">15</td>
                <td>Peso neto(kg)</td>
                <td>{{ isset($carro->pesoNeto) ? $carro->pesoNeto+0 : '0' }}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">8</td>
                <td>N° Motor</td>
                <td>{{ isset($carro->numMotor) ? $carro->numMotor : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">16</td>
                <td>Peso bruto(kg)</td>
                <td>{{ isset($carro->pesoBruto) ? $carro->pesoBruto+0 : '0' }}</td>
            </tr>
        </table>
        <p>Habiendose verificado que:</p>
        <ol>
            <li>El equipo completo instalado en el vehículo está compuesto con los elementos, partes o piezas
                registradas en la base de datos del Sistema de Control de Carga de GNV.</li>
            <li>El cilindro y el kit de montaje no han sido alterados ni se encuentren deteriorados por el uso, ni han
                sido cambiados.</li>
            <li>Cada uno de los componentes están instalados de manera segura, incluyendo las tuberías de alta y baja
                presión, y que dichos componentes estén ubicados en los sitios originales.</li>
            <li>No existen fugas en los empalmes o uniones.</li>
            <li>Los elementos de cierre actúan herméticamente.</li>
            <li>El sistema de combustión a GNV responde a las características originales recomendadas por el fabricante
                del vehículo o el Proveedor de Equipos Completos-PEC.</li>
            <li>Los controles ubicados en el tablero del vehículo respondan a las exigencias para los cuales fueron
                montados.</li>
            <li>Las exigencias sobre ventilación en las distintas zonas de instalación no han sido alteradas, y demás
                exigencias establecidas por la normativa vigente en la materia.</li>
        </ol>
        <p>Consiste por el presente documento que el sistema de combustible a Gas Natural Vehicular GNV, del vehículo
            antes referido, no afectaran negativamente la seguridad
            del mismo(**), el tránsito terrestre, el medio ambiente o incumplen con las condiciones técnicas
            establecidas en la normativa vigente en la materia(***),según el
            expediente técnico N° {{ $hoja->numSerie . ' - ' . $fechaCert->format('Y') }} , habilitándose al mismo para cargar Gas Natural
            vehicular-GNV, hasta el: {{ $fechaCert->format('d/m/') . ($fechaCert->format('Y') + 1) }}
        </p>
        <h6>OBSERVACIONES</h6>
        <ul>
            <li>(*) Los datos de los numerales 1 al 16, provienen de la tarjeta de propiedad del vehículo y/o han sido
                suministrados por el cliente, por tal motivo deberán ser verificados por el cliente antes de iniciar
                cualquier trámite con este certificado.</li>
            <li>(**) y (***) Las condiciones técnicas y de seguridad verificadas en el vehículo, corresponden a las
                expuestas en la Resolución Directoral 365-2021-MTC/17.03</li>
            <li>Este documento no es válido en caso de presentar cualquier tipo de alteración o enmendadura.</li>
            <li>Este documento es válido únicamente en original, con firma y sello del representante y del ingeniero
                supervisor.</li>
            <li>Las abreviaturas: S/V significa “Sin Versión”, NE significa “No Especificado en los documentos
                presentes”</li>
            <li>De acuerdo a la normatividad vigente, el resultado de la prueba de emisiones contaminantes del vehiculó
                es aprobatorio.</li>
        </ul>

        <p>Inspeccion realizada en el taller: {{ $taller->nombre }} </p>
        <p>Se expide el presente en la ciudad de Lima, a los {{ $fecha }}</p>
        <!-- Agrega esto donde quieras mostrar el código QR -->
        @if(!empty($qrCode))
        <div class="qr-code">
            <img src="data:image/png;base64, {!! base64_encode($qrCode) !!}" alt="Código QR">
        </div>
        @endif


    </main>

    <footer>

    </footer>
</body>

</html>
