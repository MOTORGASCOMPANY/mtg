<!DOCTYPE html>
<html>

<head>
    <title>CERTIFICADO DE CONFORMIDAD DE MODIFICACIÓN</title>
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

        .nota-container h6 {
            margin-top: 5px;
            /* Ajusta el margen superior de la segunda línea según sea necesario */
        }
    </style>
</head>

<body>
    <header>

    </header>
    <main>
        <h3>CERTIFICADO DE CONFORMIDAD DE MODIFICACIÓN</h3>
        <h5>{{ 'Certificado N° ' . $hoja->numSerie . ' - ' . $fechaCert->format('Y') }}</h5>
        <h4> {{ 'LA ENTIDAD CERTIFICADORA ' . $empresa . ' CERTIFICA:' }}</h4>
        <p>Haber efectuado la evaluación técnica al vehículo de las siguientes características registrales:</p>
        <table>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">1</td>
                <td>
                    Razón Social / <br>
                    Persona Natural:
                </td>
                <td colspan="4">
                    {{ $carro->propietario }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">2</td>
                <td>
                    Dirección:
                </td>
                <td colspan="4">
                    {{$modificacion->direccion ?? null}}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">3</td>
                <td>Placa / Dua</td>
                <td>{{ $carro->placa }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">15</td>
                <td>Potencia (HP @ RPM)</td>
                <td>{{ $modificacion->potencia ?? null}}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">4</td>
                <td>Categoria / Clase</td>
                <td>{{ $carro->categoria }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">16</td>
                <td>N° Asientos / N° Pasajeros</td>
                <td>{{ (isset($carro->asientos) ? $carro->asientos : 'NE') . ' / ' . (isset($carro->pasajeros) ? $carro->pasajeros : 'NE') }}
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">5</td>
                <td>Modelo</td>
                <td>{{ isset($carro->modelo) ? $carro->modelo : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">17</td>
                <td>N° Cilindros / Cilindrada (cm<sup>3</sup>)</td>
                <td>{{ (isset($carro->cilindros) ? $carro->cilindros : 'NE') . ' / ' . (isset($carro->cilindrada) ? $carro->cilindrada : 'NE') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">6</td>
                <td>Versión</td>
                <td>{{ $carro->version }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">18</td>
                <td>Largo (m.)</td>
                <td>{{isset($carro->largo) ? $carro->largo : 'NE'}}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">7</td>
                <td>Marca</td>
                <td>{{ isset($carro->marca) ? $carro->marca : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">19</td>
                <td>Ancho (m.)</td>
                <td>{{isset($carro->ancho) ? $carro->ancho : 'NE' }}
                </td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">8</td>
                <td>Serie</td>
                <td>{{ isset($carro->numSerie) ? $carro->numSerie : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">20</td>
                <td>Alto (m.)</td>
                <td>{{isset($carro->altura) ? $carro->altura : 'NE'}}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">9</td>
                <td>Chasis</td>                
                <td>{{ isset($carro->numSerie) ? $carro->numSerie : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">21</td>
                <td>Peso neto(kg.)</td>
                <td>{{ isset($carro->pesoNeto) ? $carro->pesoNeto + 0 : 'NE' }}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">10</td>
                <td>VIN</td>
                <td>{{ $modificacion->chasis ?? null }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">22</td>
                <td>Peso bruto vehicular(kg.)</td>
                <td>{{ isset($carro->pesoBruto) ? $carro->pesoBruto + 0 : 'NE' }}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">11</td>
                <td>N° de Motor</td>
                <td>{{ isset($carro->numMotor) ? $carro->numMotor : 'NE' }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">23</td>
                <td>Carga útil(kg.)</td>
                <td>{{ isset($carro->cargaUtil) ? $carro->cargaUtil + 0 : 'NE' }}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">12</td>
                <td>Color</td>
                <td>{{ $carro->color }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">24</td>
                <td>Año de fabricación</td>
                <td>{{ isset($carro->anioFab) ? $carro->anioFab : 'NE' }}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">13</td>
                <td>Carrocería</td>
                <td>{{ $modificacion->carroceria ?? null}}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">25</td>
                <td>Fórmula Rodante (FR)</td>
                <td>{{ $modificacion->rodante ?? null}}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">14</td>
                <td>Combustible</td>
                <td>{{ $carro->combustible }}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">26</td>
                <td>N° Ejes / N° Ruedas</td>
                <td>{{ (isset($carro->ejes) ? $carro->ejes : 'NE') . ' / ' . (isset($carro->ruedas) ? $carro->ruedas : 'NE') }}
                </td>
            </tr>
        </table>
        <p>Al que se le ha efectuado las siguientes modificaciones:</p>

        <h6>
            <span>{!! nl2br(e($modificacion->rectificacion ?? null)) !!}</span>
        </h6>
        {{--
        <h6>
            <span>{!! nl2br(e($modificacion->nota ?? null)) !!}</span>
        </h6>
        --}}

        <h6>(ADECUACION A RD 4848-2006 Y RD10476-2008 MTC/15)</h6>

        <h6>NOTA: El vehiculo no ha sufrido modificación alguna que altera o modifique su estructura o carroceria,
            se respeta los parámetros del fabricante y se cumplen con la normatividad vigente.
        </h6><br>

        <p>Conste por el presente documento que las modificaciones efectuadas al vehículo no afectan negativamente la
            seguridad del mismo, el tránsito terrestre,
            el medio ambiente o incumplen con las condiciones técnicas establecidas en la normativa vigente en la
            materia, que está amparado en el
            expediente N°{{ $hoja->numSerie . ' - ' . $fechaCert->format('Y') }}
        </p>

        <p>
            El vehículo materia de evaluación fue originalmente diseñado y construido para destinarlo al transporte de
            <strong>{{ $modificacion->carga ?? null}}</strong>
        </p>

        <p>Se expide el presente en la ciudad de Lima, a los {{ $fecha }}</p>
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
