<!DOCTYPE html>
<html>

<head>
    <title>DUPLICADO DE INSPECCIÓN ANUAL DEL VEHÍCULO A GLP</title>
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

            color: black;
            text-align: center;
            font-size: 17px;
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
            font-size: 7px;
        }

        ul {
            font-size: 10px;
        }

        .qr-code {
            width: 10%;
            /* Ajusta el ancho según tus necesidades */
            float: right;
            /* Hace que el contenedor flote a la derecha */
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <header>

    </header>
    <main>
        <p style=" margin-top: 2.7cm;text-align: center;">
            Entidad Certificadora de Conversiones a GLP
            autorizada por el MTC mediante R.D. N° 0464-2023-MTC/17.03
        </p>
        <h3>CERTIFICADO DE INSPECCIÓN DE VEHÍCULO A GLP</h3>
        <h5>{{ 'Certificado N° ' . $hoja->numSerie . ' - ' . $fechaCert->format('Y') }}</h5>
        <h4> {{ 'LA ENTIDAD CERTIFICADORA ' . $empresa . ' CERTIFICA:' }}</h4>
        <p>
            Haber efectuado la evaluación de las condiciones de seguridad del sistema de combustión a
            Gas Licuado de Petróleo - GLP del siguiente vehículo:
        </p>
        <table>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">1</td>
                <td>
                    Propietario:
                </td>
                <td colspan="4">
                    {{ $carro->propietario }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">2</td>
                <td>Placa de rodaje</td>
                <td>{{ $carro->placa }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">10</td>
                <td>Cilindros / Cilindrada</td>
                <td>{{ (isset($carro->cilindros) ? $carro->cilindros : 'NE') . ' / ' . (isset($carro->cilindrada) ? $carro->cilindrada : 'NE') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">3</td>
                <td>Categoria</td>
                <td>{{ $carro->categoria }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">11</td>
                <td>Combustible</td>
                <td>{{ $carro->combustible }}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">4</td>
                <td>Marca</td>
                <td>{{ isset($carro->marca) ? $carro->marca : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">12</td>
                <td>N° Ejes / N° Ruedas</td>
                <td>{{ (isset($carro->ejes) ? $carro->ejes : 'NE') . ' / ' . (isset($carro->ruedas) ? $carro->ruedas : 'NE') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">5</td>
                <td>Modelo</td>
                <td>{{ isset($carro->modelo) ? $carro->modelo : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">13</td>
                <td>N° Asientos / N° Pasajeros</td>
                <td>{{ (isset($carro->asientos) ? $carro->asientos : 'NE') . ' / ' . (isset($carro->pasajeros) ? $carro->pasajeros : 'NE') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">6</td>
                <td>Versión</td>
                <td>{{ $carro->version }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">14</td>
                <td>Largo / Ancho / Alto(m)</td>
                <td>{{ (isset($carro->largo) ? $largo : 'NE') . ' / ' . (isset($carro->ancho) ? rtrim($carro->ancho, '0') : 'NE') . ' / ' . (isset($carro->altura) ? rtrim($carro->altura, '0') : 'NE') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">7</td>
                <td>Año fabricación</td>
                <td>{{ isset($carro->anioFab) ? $carro->anioFab : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">15</td>
                <td>Peso neto(kg)</td>
                <td>{{ isset($carro->pesoNeto) ? $carro->pesoNeto : '0' }}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">8</td>
                <td>VIN / N° Serie</td>
                <td>{{ isset($carro->numSerie) ? $carro->numSerie : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">16</td>
                <td>Peso bruto(kg)</td>
                <td>{{ isset($carro->pesoBruto) ? $carro->pesoBruto : '0' }}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">9</td>
                <td>N° Motor</td>
                <td>{{ isset($carro->numMotor) ? $carro->numMotor : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">17</td>
                <td>Carga útil(kg)</td>
                <td>{{ isset($cargaUtil) ? $cargaUtil : 'NE' }}</td>
            </tr>
        </table>
        <p>Que cuenta con los siguientes componentes que permiten la combustión a GLP:</p>
        <table>
            <tr>
                <td style="text-align:center; font-weight: bold; ">Componente</td>
                <td style="text-align:center; font-weight: bold;">Marca</td>
                <td style="text-align:center; font-weight: bold;">Modelo</td>
                <td style="text-align:center; font-weight: bold;">N°Serie</td>
            </tr>
            @foreach ($equipos as $key => $item)
                @switch($item->idTipoEquipo)
                    @case(4)
                        <tr>
                            <td style="text-align:center;">{{ $item->tipo->nombre }}</td>
                            <td style="text-align:center;">{{ $item->marca }}</td>
                            <td style="text-align:center;">{{ $item->modelo }}</td>
                            <td style="text-align:center;">{{ $item->numSerie }}</td>
                        </tr>
                    @break

                    @case(5)
                        <tr>
                            <td style="text-align:center;">{{ $item->tipo->nombre }}</td>
                            <td style="text-align:center;">{{ $item->marca }}</td>
                            <td style="text-align:center;">{{ $item->modelo }}</td>
                            <td style="text-align:center;">{{ $item->numSerie }}</td>
                        </tr>
                    @break

                    @default
                @endswitch
            @endforeach
        </table>
        <p>
            (*): En caso del cilindro de almacenamiento de GLP, indicar su capacidad en litros y año de fabricación a
            GLP.
        </p>
        <p>Habiéndose verificado que:</p>
        <ol type="1">
            <li>El sistema de combustión a GLP (cilindro y kit de conversión) responde a las características originales
                recomendadas por el fabricante del vehículo y/o el Proveedor de Equipos Completos de Conversión a GLP
                (PEC-GLP), cumple con la Norma Técnica Peruana NTP 321.115:2003 y su montaje cumple las exigencias sobre
                la ventilación en las distintas zonas de instalación.</li>
            <li>El vaporizador/regulador cuenta con un sistema de corte de gas automático, en el caso que el motor deje
                de funcionar.</li>
            <li>El tanque de almacenamiento de GLP ha sido fabricado bajo normas ASME Sección VIII y cumple las normas
                dictadas para recipientes a presión, asimismo, cuenta con una válvula check en la entrada de gas, un
                limitador automático de carga al 80%, una válvula de exceso de presión y una válvula de exceso de flujo
            </li>
            <li>Los accesorios e insumos (mangueras, tuberías y válvulas) utilizados en la instalación han sido
                certificados para el uso de GLP y están instalados de manera segura.</li>
            <li>Los equipos y accesorios utilizados en la modificación para uso de GLP cumplen con la Norma Técnica
                Peruana NTP 321.115:2003.</li>
            <li>No existan fugas en los empalmes o uniones y los elementos de cierre actúan herméticamente.</li>
            <li>Los controles ubicados en el tablero del vehículo responden a las exigencias para los cuales fueron
                montados.</li>
        </ol>
        <p>
            Conste por el presente documento que el sistema de combustión a
            Gas Licuado de Petróleo - GLP, del vehículo antes referido, no afectaran negativamente
            la seguridad del mismo, el tránsito terrestre, el medio ambiente o incumplen con las
            condiciones técnicas establecidas en la normativa vigente en la materia, según consta
            en el expediente técnico N° {{ $hoja->numSerie . ' - ' . $fechaCert->format('Y') }}
        </p>
        <!-- Agrega esto donde quieras mostrar el código QR -->
        @if (!empty($qrCode))
            <div class="qr-code">
                <img src="data:image/png;base64, {!! base64_encode($qrCode) !!}" alt="Código QR">
            </div>
        @endif
        <p>
            Habilitandose al mismo para cargar Gas Licuado de Petróleo-GLP hasta el día:
            {{ $fechaAntiguo->format('d/m/') . ($fechaAntiguo->format('Y') + 1) }}
        </p>
        <p>
            El presente Certificado es emitido a solicitud del Taller de Conversión a GLP autorizado:
            <strong>
                @if ($tallerauto)
                    {{ $tallerauto->nombre }}
                @else
                    {{ $taller->nombre }}
                @endif
            </strong>
        </p>
        <p>
            Ubicado : @if ($tallerauto)
                {{ $tallerauto->direccion }}
            @else
                {{ $taller->direccion }}
            @endif
        </p>
        <h6>OBSERVACIONES</h6>
        <ul type="1">
            <li>
                <strong>
                    Cumpliendo con el D.S. 047-2001-MTC,modificatorias 009-2012 MINAM,
                    D.S. Nro. 010-2017 - MINAM, indicamos que el resultado de la prueba de emisiones
                    contaminantes del vehiculó es aprobatorio.
                </strong>
            </li>
            <li>
                Este certificado es <strong>DUPLICADO</strong> a pedido del cliente porque se le perdió y es <strong>COPIA FIEL DEL ORIGINAL.</strong>
            </li>
        </ul>

        <p>Se expide el presente en la ciudad de Lima, a los {{ $fecha }}</p>


    </main>

    <footer>

    </footer>
</body>

</html>
