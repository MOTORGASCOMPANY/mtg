<!DOCTYPE html>
<html>
<head>
    <title>DUPLICADO DE CONVERSIÓN DEL VEHÍCULO A GNV</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: sans-serif;
        }

        body {
            margin:1cm 2cm 2cm;
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

        p{
            font-size:10px;
        }

        image{
            margin-left: 2cm;
        }
        h3{
            margin-top: 3cm;
            color: black;
            text-align: center;
        }
        h4{
            font-size: 14px;
            text-align: center;
        }
        h5{
            text-align: right;
        }
        h6{
            margin-bottom: -10px;
        }
        table, th, td {
        font-size: 10px;
        border: 1px solid;
        border-collapse: collapse;
        }
        table{
            width: 100%;
        }
        ol{
            list-style-type: lower-latin;
            font-size: 10px;
        }
        ul{
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
        <h3>CERTIFICADO DE CONFORMIDAD DE CONVERSIÓN A GNV</h3>
        <h5>{{ "Certificado N° ".$hoja->numSerie." - ". $fechaCert->format('Y')}}</h5>
        <h4> {{"LA ENTIDAD CERTIFICADORA ".$empresa." CERTIFICA:"}}</h4>
        <p>Haber efectuado la evaluación de las condiciones de seguridad respecto de la conversión del sistema de combustión a
            Gas Natural Vehicular – GNV efectuada  por  el taller de  Conversión  Autorizado: {{$taller}}</p>
        <!-- DATOS VEHICULO -->
        <table>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">1</td>
                <td>Placa de rodaje</td>
                <td>{{$carro->placa}}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">9</td>
                <td>Cilindros / Cilindrada</td>
                <td>{{ (isset($carro->cilindros)? $carro->cilindros : 'NE').' / '. (isset($carro->cilindrada)? $carro->cilindrada : 'NE')}}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">2</td>
                <td>Categoria</td>
                <td>{{$carro->categoria}}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">10</td>
                <td>Combustible</td>
                <td>{{$carro->combustible}}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">3</td>
                <td>Marca</td>
                <td>{{(isset($carro->marca)? $carro->marca : 'NE')}}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">11</td>
                <td>N° Ejes / N° Ruedas</td>
                <td>{{(isset($carro->ejes)? $carro->ejes : 'NE').' / '.(isset($carro->ruedas)? $carro->ruedas : 'NE')}}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">4</td>
                <td>Modelo</td>
                <td>{{(isset($carro->modelo)? $carro->modelo : 'NE')}}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">12</td>
                <td>N° Asientos / N° Pasajeros</td>
                <td>{{(isset($carro->asientos)? $carro->asientos : 'NE').' / '.(isset($carro->pasajeros)? $carro->pasajeros : 'NE')}}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">5</td>
                <td>Versión</td>
                <td>{{$carro->version}}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">13</td>
                <td>Largo / Ancho / Alto(m)</td>
                <td>{{(isset($carro->largo)?  bcdiv($carro->largo, '1', 2) : 'NE').' / '.(isset($carro->ancho)? bcdiv($carro->ancho, '1', 2) : 'NE').' / '.(isset($carro->altura)? bcdiv($carro->altura, '1', 2) : 'NE')}}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">6</td>
                <td>Año fabricación</td>
                <td>{{(isset($carro->anioFab)? $carro->anioFab : 'NE')}}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">14</td>
                <td>Color(es)</td>
                <td>{{$carro->color}}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">7</td>
                <td>VIN / N° Serie</td>
                <td>{{(isset($carro->numSerie)? $carro->numSerie : 'NE')}}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">15</td>
                <td>Peso neto(kg)</td>
                <td>{{(isset($carro->pesoNeto)? $carro->pesoNeto+0 : '0')}}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">8</td>
                <td>N° Motor</td>
                <td>{{(isset($carro->numMotor)? $carro->numMotor : 'NE')}}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">16</td>
                <td>Peso bruto(kg)</td>
                <td>{{(isset($carro->pesoBruto)? $carro->pesoBruto+0 : '0')}}</td>
            </tr>
        </table>
        <p>Habiéndose instalado al mismo los siguientes componentes:</p>
        <!-- DATOS DE LOS EQUIPOS -->
        <p>Chip de identificacion: {{$chip->numSerie}}</p>
            <table>
                <tr>
                    <td style="text-align:center;">Componente</td>
                    <td style="text-align:center;">Marca</td>
                    <td style="text-align:center;">N°Serie</td>
                    <td style="text-align:center;">Modelo</td>
                    <td style="text-align:center;">Capacidad</td>
                </tr>
                @foreach ($equipos as $key=>$item)
                    @switch($item->idTipoEquipo)
                        @case(2)
                            <tr>
                                <td style="text-align:center;">{{$item->tipo->nombre}}</td>
                                <td style="text-align:center;">{{$item->marca}}</td>
                                <td style="text-align:center;">{{$item->numSerie}}</td>
                                <td style="text-align:center;">{{$item->modelo}}</td>
                                <td style="text-align:center;">N/A</td>
                            </tr>
                        @break
                        @case(3)
                            <tr>
                                <td style="text-align:center;">{{$item->tipo->nombre}}</td>
                                <td style="text-align:center;">{{$item->marca}}</td>
                                <td style="text-align:center;">{{$item->numSerie}}</td>
                                <td style="text-align:center;">N/A</td>
                                <td style="text-align:center;">{{$item->capacidad}}</td>
                            </tr>
                        @break
                        @default
                    @endswitch
                @endforeach
            </table>
        <p>
            Como consecuencia de la conversion del sistema de combustion a Gas Natural Vehicular - GNV, las caracteristicas originales del vehiculo
            se han modificado de la siguiente manera:
        </p>
            <table>
                <tr>
                    <td style="text-align:center;">17</td>
                    <td style="text-align:center;">Combustible</td>
                    <td style="text-align:center;">BI COMBUSTIBLE GNV</td>
                </tr>
                <tr>
                    <td style="text-align:center;">18</td>
                    <td style="text-align:center;">Peso neto(kg)</td>
                    <td style="text-align:center;">{{$carro->pesoNeto+$pesos+0}}</td>
                </tr>
            </table>
        <p>Consiste por el presente documento que el sistema de combustible  a Gas Natural Vehicular GNV, del vehículo antes referido, no afectaran negativamente la seguridad
             del mismo(**), el tránsito terrestre, el medio ambiente o incumplen con las condiciones técnicas establecidas en la normativa vigente en la materia(***),según el
              expediente técnico   N° {{$hoja->numSerie .'-'.$fechaCert->format('Y')}},  habilitándose al mismo para cargar  Gas  Natural  vehicular-GNV,  hasta  el: {{$fechaAntiguo->format("d/m/").($fechaAntiguo->format("Y")+1)}}
        </p>
        <h6>OBSERVACIONES</h6>
            <ul>
                <li>(*) Los datos de los numerales 1 al 18, provienen de la tarjeta de propiedad del vehículo y/o han sido suministrados por el cliente, por tal motivo deberán
                    ser verificados por el cliente antes de iniciar cualquier trámite con este certificado.
                </li>
                <li>
                    (**) y (***) Las condiciones técnicas y de seguridad verificadas en el vehículo, corresponden a las expuestas en la Resolución Directoral 3990 -2005-MTC/f5.
                </li>
                <li> Este documento no es válido en caso de presentar cualquier tipo de alteración o enmendadura.</li>
                <li>Este documento es válido únicamente en original, con firma y sello del representante y del ingeniero supervisor</li>
                <li>Las abreviaturas: S/V significa “Sin Versión”, NE significa “No Especificado en los documentos presentes” </li>
                <li>Este certificado es <strong>DUPLICADO</strong> a pedido del cliente porque se le perdió y es <strong>COPIA FIEL DEL ORIGINAL</strong>. </li>
                <li>De acuerdo a la normatividad vigente, el resultado de la prueba de emisiones contaminantes del vehiculó es aprobatorio.</li>
            </ul>
        <p>Se expide el presente en la ciudad de Lima, a los {{$fecha}}</p>
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
