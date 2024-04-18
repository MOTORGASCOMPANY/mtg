<!DOCTYPE html>
<html>
<head>
    <title>Ficha Técnica</title>
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
            height: 8cm;
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
            font-size:12px;
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
            text-align: center;
        }
        h6{
            margin-bottom: -10px;
        }
        table, th, td {
        font-size: 12px;
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
    </style>
</head>
<body>
    <header>
        <article>
            <img style="float:left; padding-left: 3cm; margin-top: 20px" src="{{$taller->rutaLogo ? '.'.Storage::url($taller->rutaLogo) : ''}}" width="130" height="130"/>
            <h2 style="margin-top: 40px">{{$taller->nombre}}</h2>
            <p>{{$taller->direccion}}</p>
        </article>
    </header>
    <main>
        <h3 style="background-color:goldenrod;">
            FICHA TÉCNICA
        </h3>
        <p><strong>Nombre del taller: </strong> {{$taller->nombre}} </p>
        <p><strong>Fecha: </strong> {{$fecha}}</p>
        <p><strong>Servicio: </strong>{{'Certificado de '.$servicio->tipoServicio->descripcion.'.'}}</p>
        <p><strong>N° de Certificado: </strong>{{$hoja->numSerie}}</p>
        <!-- DATOS VEHICULO -->
        <h5 style="background-color:goldenrod;">DATOS DEL VEHICULO</h5>
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
                <td>{{(isset($carro->pesoNeto)? $carro->pesoNeto : '0.00')}}</td>
            </tr>
            <tr>
                <td style="padding: 0 5px 0 5px; text-align:center;">8</td>
                <td>N° Motor</td>
                <td>{{(isset($carro->numMotor)? $carro->numMotor : 'NE')}}</td>
                <td style="padding: 0 5px 0 5px; text-align:center;">16</td>
                <td>Peso bruto(kg)</td>
                <td>{{(isset($carro->pesoBruto)? $carro->pesoBruto : '0.00')}}</td>
            </tr>
        </table>
        <h5 style="background-color:goldenrod;">DATOS DE LOS EQUIPOS DE GNV</h5>
        <!-- DATOS DE LOS EQUIPOS -->
        <p><strong>Chip de identificacion: </strong>{{$chip->numSerie}}</p>
            <table>
                <tr>
                    <th style="text-align:center;">Componente</th>
                    <th style="text-align:center;">Marca</th>
                    <th style="text-align:center;">N°Serie</th>
                    <th style="text-align:center;">Modelo</th>
                    <th style="text-align:center;">Capacidad (LT)</th>
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
            <br>
            <br>
            <br>


            <article style="text-justify: center;"  >
                <table style=" text-align: center; width:80%; margin:auto;">
                    <tr>
                        <td style="width: 50%;">
                            <br>
                            <br>
                            <br>
                        </td>
                        <td style="width: 50%;">
                            <img  src="{{$taller->rutaFirma ? '.'.Storage::url($taller->rutaFirma) : '' }}" width="180" height="90"/>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Firma del cliente</td>
                        <td style="width: 50%;">Firma del representante del taller</td>
                    </tr>
                </table>
            </article>


        </main>
    <footer>

    </footer>
</body>
</html>
