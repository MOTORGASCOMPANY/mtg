<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        @page {
            margin: 0.5cm 1.5cm;
            font-family: sans-serif;
            font-size: 8px;
        }
    </style>

    <title>Check List Glp Cilindro Abajo</title>
</head>

<body style="display: block;">
    <header style="align-items: center;font-size:10px; font-weight: bold; position:fixed; height: 2cm; width: 100%;">
        <img src="{{ public_path('/images/logo.png') }}" width="120" height="50" align="left" />
        <p style="text-align: center;  width: 500px; float: right;" align="right">
            REPORTE DE VERIFICACIÓN DE LA INSTALACIÓN DEL EQUIPO GLP A VEHÍCULOS CONVERTIDOS U ORIGINALMENTE DISEÑADOS A
            GAS LICUADO DE PETROLEO - GLP
            <br>
            RD N° 0268-2019 - MTC / 17.03
        </p>
    </header>
    <br clear="left">

    <!--Datos Vehículo -->
    <section>
        <table style="border: 1px solid; border-collapse: collapse; width: 500px; float: left;">
            <tr style="">
                <td colspan="6" style="align-self: start; border: 1px solid; border-collapse: collapse;">
                    Taller:
                    <br>
                    @if($tallerauto) {{ $tallerauto->nombre }} @else {{ $taller->nombre }} @endif
                </td>
                <td colspan="2" style="border: 1px solid; border-collapse: collapse;">
                    Fecha de inspeccion:
                    <br>
                    {{ $fecha }}
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border: 1px solid; border-collapse: collapse;">
                    Placa de rodaje/DUA:
                    <br>
                    {{ $vehiculo->placa }}
                </td>
                <td colspan="4" style="border: 1px solid; border-collapse: collapse;">
                    Inspector:
                    <br>
                    {{ $inspector->name }}
                </td>

            </tr>
            <tr>
                @switch($servicio->tipoServicio->id)
                    @case(1)
                        <td colspan="2" style="border: 1px solid; border-collapse: collapse;">
                            Revisión
                            inicial
                        </td>
                        <td style="border: 1px solid; border-collapse: collapse;width: 10%;text-align: center;">
                            <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                        <td colspan="2" style="border: 1px solid; border-collapse: collapse;">
                            Revisión
                            anual
                        </td>
                        <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                        </td>
                        <td colspan="2" style="border: 1px solid; border-collapse: collapse;">
                            Año del vehículo:
                            &nbsp;
                            {{ $vehiculo->anioFab }}
                        </td>
                    @break

                    @case(2)
                        <td colspan="2" style="border: 1px solid; border-collapse: collapse;">
                            Revisión
                            inicial
                        </td>
                        <td style="border: 1px solid; border-collapse: collapse;width: 10%;text-align: center;">

                        <td colspan="2" style="border: 1px solid; border-collapse: collapse;">
                            Revisión
                            anual
                        </td>
                        <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                            <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                        </td>
                        <td colspan="2" style="border: 1px solid; border-collapse: collapse;">
                            Año del vehículo:
                            &nbsp;
                            {{ $vehiculo->anioFab }}
                        </td>
                    @break

                    @default
                @endswitch

            </tr>
            <tr>
                <td colspan="4" style="border: 1px solid; border-collapse: collapse;">
                    Tipo de conversión:
                </td>
                <td colspan="4" style="border: 1px solid; border-collapse: collapse;">
                    Sistema de combustible:
                </td>
            </tr>

            <tr>
                <td style="border: 1px solid; border-collapse: collapse;">
                    dedicado a
                    <br>
                    gas
                </td>
                <td style="border: 1px solid; border-collapse: collapse;">

                </td>
                <td style="border: 1px solid; border-collapse: collapse;">
                    Bi-Combustible
                </td>
                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                    <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                </td>
                <td style="border: 1px solid; border-collapse: collapse;">
                    Carburador
                </td>
                <td style="border: 1px solid; border-collapse: collapse;">

                </td>
                <td style="border: 1px solid; border-collapse: collapse;">
                    Inyección
                </td>
                <td style="border: 1px solid; border-collapse: collapse;width: 10%;text-align: center;">
                    <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="border: 1px solid; border-collapse: collapse;">
                    (NTP 111.015-2004) / C- Conforme / NC- No conforme / N.A No aplica
                </td>
            </tr>
        </table>

        <img src="{{ public_path('/images/vehiculo.png') }}" width="110" height="110"
            style="float: right; margin-right:30px" />
    </section>
    <br clear="left">


    <!--Datos de equipos-->
    <table style="width:100%;padding: 0; box-sizing:border-box; font-size: 7px; text-align: start;">
        <tr>
            <td>
                <table style="border: 1px solid; border-collapse: collapse;margin: auto;">
                    <tr>
                        <th style="border: 1px solid; border-collapse: collapse;">
                            Marca regulador:
                        </th>
                        <td style="border: 1px solid; border-collapse: collapse;">
                            {{ $reductor->id }}
                        </td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid; border-collapse: collapse;">
                            Número de Serie:
                        </th>
                        <td style="border: 1px solid; border-collapse: collapse;">
                            {{ $reductor->numSerie }}
                        </td>
                    </tr>

                </table>
            </td>

            <td style="width: 5px">

            </td>

            <td>
                <table style="border: 1px solid; border-collapse: collapse; margin: auto;">
                    <tr>

                        <th style="border: 1px solid; border-collapse: collapse;">
                            Marca
                        </th>
                        <th style="border: 1px solid; border-collapse: collapse;">
                            Serie
                        </th>
                        <th style="border: 1px solid; border-collapse: collapse;">
                            Capacidad/Año Fab.
                        </th>
                        <th style="border: 1px solid; border-collapse: collapse;">
                            Peso(KG)
                        </th>
                    </tr>

                    @foreach ($cilindros as $key => $item)
                        <tr>

                            <td style="border: 1px solid; border-collapse: collapse;">
                                {{ $item->marca }}
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                {{ $item->numSerie }}
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                {{ $item->modelo }}
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                {{ !empty($item->peso) ? $item->peso : '30' }}
                            </td>
                        </tr>
                    @endforeach

                </table>
            </td>
        </tr>
    </table>


    <br clear="left">

    <!--PAGINA 1-->
    <section>
        <table style=" width:100%;box-sizing:border-box; font-size: 6px;">
            <tr style="vertical-align:top;">
                <td style="width: 50%;">
                <!--TABLA LADO IZQUIERDO-->
                    <table style='border: 1px solid; border-collapse: collapse;width:100%;'>

                        <tr>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ART.
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                REQUISITO
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ESPECIFICACIONES
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ESTADO
                            </th>
                        </tr>
                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>CERTIFICADOS DE CONFORMIDAD - RESOLUCIÓN DICTATORIAL N°
                                    14540-2007-MTC/15</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.6.3.3
                                <br>
                                5.6.4.2
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Analisis de Combustión
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Cumple con los limites establecidos en el Decreto Supremo 047-2001-MTC Anexo y sus
                                modificaciones
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse; float:center; text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="5" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.6.4.1
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Cilindros, accesorios, partes. Piezas y demas equipos nuevos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Certificado del fabricante de cilindros
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Valvula de llenado con valvula de retencion. Valvula de seguridad de alivio o sobre
                                presion. Valvula de maximo nivel de llenado (Multivalvulas)
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Certificado del fabricante de equipos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Regulador de presion
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Certificado del fabricante de equipos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Valvulas solenoides
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Certificado del fabricante de equipos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Llave selectora de combustible
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Certificado del fabricante de equipos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.6.3.1
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Cilindros, accesorios, partes. Piezas y demas equipos nuevos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Habilitados por PRODUCE registrqados en la base de datos del sistema de control de carga
                                de GLP.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse; text-align: center;">
                                5.6.3.2
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Cilindros, accesorios, partes. Piezas y demas equipos nuevos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Instalados para la marca y modelo vehiculo recomendado por el proveedor de equipos
                                completos PEC
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong> CONSTANCIAS - RESOLUCION DIRECTORAL N° 14540 2007-MTC/15 </strong>
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.6.5.1
                            </td>

                            {{-- REVISAR ESTE CAMPO PARA EVALUAR SI CAMBIA O ES ASÍ EN CUALQUIER CASO --}}
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Pre - inspección
                            </td>

                            <td style="border: 1px solid; border-collapse: collapse;">
                                El taller debio inspeccionar el vehiculo para determinar la conveniencia de la
                                conversión
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.6.2.3a
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Manual de usuario
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Manual de instrucción del uso. Cuidado y mantenimiento del Vehiculo convertido.
                            </td>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.6.2.3b
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                Garantía de conversion
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Expedido por el taller a nombre del Propietario del vehiculo,
                                anexa a la Garantia otorgada por el fabricante o el proveedor de los equipos completos
                                PEC
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>


                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong> CERTIFICACION ANUAL - RESOLUCION DIRECTORAL N° 14540-2007-MTC/15 </strong>
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.6.5.1
                            </td>

                            {{-- REVISAR ESTE CAMPO PARA EVALUAR SI CAMBIA O ES ASÍ EN CUALQUIER CASO --}}
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Certificacion anual
                            </td>

                            <td style="border: 1px solid; border-collapse: collapse;">

                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                a
                            </td>
                            <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                Cilindros, accesorios, partes. Piezas y demas equipos nuevos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben ser los mismo registrados en la base de datos de revision inicial
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                b
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No han sido alterados ni se encuentran deteriorados por el uso o han sido cambiados
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                c
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Estan instalados de manera segura, incluyendo las tuberias de alta y baja presion en loa
                                sitios originales.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                d
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Verificacion de Hermiticidad
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Verificar que no existen fugas en los empalmes o uniones.
                                <br>
                                Verificar que los elementos de cierre actuen hemerticamente.
                            </td>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                e
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.6.6.2
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Desmonte de cilindro en revisión anual
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Cuando se detecten signo de corrosion, abolladuras, picaduras, fisuras, daños por fuego
                                a calor.
                                Puntos de soldadura, desgaste del cuerpo del cilindro debido a la incidencia de agentes
                                externos
                                o aquellos que comprometen la seguridad del cilindro
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.6.6.3
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Prueba de emisiones de gases contaminantes
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Una vez verificado que los componentes instalados en el vehiculo se encuentran en
                                correcto estado de funcionamiento,
                                proceder a verificar que el vehiculo cumpla con los limites maximos permsibles de
                                emisiones contaminantes establecidos
                                por el Decreto Supremo N° 047 - 2001 - MTC.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>TANQUES GLP - NTP 321.117-2</strong>
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.2.1
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Presion de Operación
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben estar construidos y operar a una presión normal de 2.1 Mpa (312.5 psig)
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>TANQUES GLP - NTP 321.116</strong>
                            </td>
                        </tr>


                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                6.1.3.1
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Ubicación
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No instalado en el techo ni dentro del compartimiento del motor
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="6"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                            <td rowspan="6" style="border: 1px solid; border-collapse: collapse;">
                                Instalación Tanque Arriba
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Una vez instaladea no debe ser modificados ni alterados
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe estar ubicado de tal manera que se encuentre protegido contra daños de colision
                                y que no cause molestias al funcionamiento normal del vehiculo
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No se debe producir esfuerzos indebidos sobre el recipiente y sobre los accesorios
                                vinculados a el.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No debe soldarse ningún elemento al cilindro
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No proyectarse sobre el punto mas alto del vehículo
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No proyectarse por fuera de los costados del vehículo.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>

                        <tr>
                            <td rowspan="3"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                            <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                Instalación Tanque Abajo
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben estar instalados en el mismo nivel o mas arriba del componente estructural, mas
                                debajo de la carroceria.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Tener valvulas y conexiones protergida contra daños debidos a contactos con objetivos
                                estacionarios
                                u otros objetos sueltos en la ruta
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Ubicado por lo menos 15cm del tubo o sistema de gases de escape. Si el cumplimiento de
                                esta distancia presenta inconvenientes, se debe instalar
                                deflectores metalicos para pedir como minimo 5cm de distancia del tubo de escape.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" rowspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                ANEXO 1 de la RESOLUCION DIRECTORIAL N° 14540 - 2007 - MTC /15
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Valvula check en las entradas de gas
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Limitador de Carga al 80%
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Válvula de exceso de presión
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Válvula de exceso de flujo
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                6.1.3.1
                            </td>
                            <td rowspan="4" style="border: 1px solid; border-collapse: collapse;">
                                Tanques instalados entre ejes
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben estar instalados en el mismo nivel o mas arriba del componente estructural, mas
                                debajo de la carroceria
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben estar instalados en el mismo nivel o mas arriba del componente mas bajo del chasis
                                o del subchasis, si existe.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe ser instalado en el mismo nivel o mas arriba del punto mas bajo del motor
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben estar instalados en el mismo nivel o mas arriba del punto mas alto de la caja de
                                velocidades
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>



                    </table>
                </td>

                <td style="width: 50%;">
                 <!--TABLA LADO DERECHO-->
                    <table style="border: 1px solid; border-collapse: collapse; width:100%;">
                        <tr>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ART.
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                REQUISITO
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ESPECIFICACIONES
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ESTADO
                            </th>
                        </tr>



                        <tr>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                6.1.3.1
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Instalación
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben evitarse el contacto de cilindro con cualquier elemento metálico
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe utilizarse caucho como elemento de separación entre el herraje y el cilindro
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Ubicación
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                el tanque debe estar ubicado de tal manera que las multivalvulas se encuentren en su
                                posicion correcta,
                                de acuerdo especificacion del fabricante. El incumplimiento de este requisito conduce a
                                lecturas erroneas
                                de nivel liquido.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                La placa de identificación del tanque debe ser visible para poder consultar su
                                información
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>INSTALACIÓN DE SOPORTES DEL TANQUE - NTP 321.116</strong>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                6.1.3.1 b
                            </td>
                            <td rowspan="4" style="border: 1px solid; border-collapse: collapse;">
                                Materiales
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Los soportes deben estar diseñados para resistir como minimo cuatro veces el peso del
                                tanque completamente lleno de combustible
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No debe presentar distorsiones en ninguna dirección
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Se recomienda pernos de grado 8
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No se permite en ningun caso soldar el Elemento de fijación
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>SISTEMAS DE SUJECCION - NTP 321.116</strong>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                7.1.3.2
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Instalación
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                El tanque debe tener un sistema de fijacion compuesta de dos apoyos indepndientes del
                                tanque que pueden ser
                                del tipo flotante que van unidas a la estructra del vehiculo.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben tener dos abrazaderas con su respectivo seguro como mínimo instalados de manera
                                que eviten la vibración.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                7.1.1
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Proteccion contra la corrosión
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben proptegerse de la corrosion por medio de usos de anticorrosivos, pinturas
                                especiales y recubrimientos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>DISPOSITIVOS DE SEGURIDAD - NTP - 321.117.2</strong>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="3"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.2.5
                            </td>
                            <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                Valvula de seguridad de alivio
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                La multivalvula debe contar con una valvula de seguridad de alivio de presion o
                                subpresion con resorte interno.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Su capacidad minima de descarga debe estar de acuerdo con lo establecido en la Tabla 1,
                                y
                                su apertura debe estar regulada a una presion igual a la presion del diseño del tanque.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No se permite la instalación de Ruptura ni tapones fusibles de reemplazo o complemento
                                de válvula de seguridad.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                6.4.2.3
                            </td>
                            <td rowspan="4" style="border: 1px solid; border-collapse: collapse;">
                                Venteos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                El disco de estallido debe ventear por un tubo de acero, directamente al exterior del
                                vehiculo.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Como alternativa puede ventearse el gas hacia el exterior del vehículo conforma se hace
                                en los montajes de cilindros en comportamiento de pasajeros.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Tubos ﬂexibles construidos con material no inﬂamable o auto extinguible.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Expulsan el gas hacia la parte externa inferior del automotr a traves de conductos
                                encamisados y
                                hermeticos con seccion o menor de 1100mm2. NO deben descargar en la zona de
                                guardafangos.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>TUBERIAS - NTP - 321.155</strong>
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                11.1
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Generalidades
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Las lineas de conduccion de GLP deben soportar alta presion en la zona de liquido y baja
                                presion en la zona de gases.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">

                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                La tuberia instalado debe estar revestida con un recubrimiento de PVC
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">

                            </td>
                        </tr>


                        <tr>
                            <td rowspan="5"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                11.2.1
                            </td>
                            <td rowspan="5" style="border: 1px solid; border-collapse: collapse;">
                                Instalación de las lineas de Combustible
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                El material empleado debe ser de acero o cobre de tipo K o L de acuerdo a la NTP 342052
                                o ASTM 888
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                La presion maxima que soporta debe estar rotulada sobre la cubierta del PVC de la
                                tuberia.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                El diametro exterior del tubo no debe exceder 12mm y el espesor de la pared no debe ser
                                menor a 0.8mm.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Cuando las tuberias atraviesan orificios deben protegerse contra daños de roces, golpes
                                o vibracion.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                No esta permitido soldar de cualquier forma las tuberias del sistema de GLP, ya sea unir
                                directamente dos o mas tramos de tubos o soldar terminales de acoplamiento. Tampoco esta
                                permitido soldar las tuberias del vehiculo.
                            </td>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="6"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                11.2.2
                            </td>
                            <td rowspan="6" style="border: 1px solid; border-collapse: collapse;">
                                Tuberias lineas de baja presion (Mangueras)
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe cumplir con lo establecido en la especificacion E / ECE / TRANS / 505 anexo 8,
                                apartado 2
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe soportar presiones de trabajo de por lo menos 34.5 Kps (5psig)
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben estar contruidas de material resistente la accion GLP
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No deben tener recubrimiento de ACERO
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe estar totulados a todo lo largo de su Extensión.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                11.2.3.1
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Instalación de tuberias y accesorios
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No se deben emplear accesorios de unión de hierro fundido tales como codo, tes, cruces,,
                                uniones bridas o tapones
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Los accesorios deben de ser de acero o cobre.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                a
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">

                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Los accesorios o presiones de operación superiores a 0.9 Mps hasta 1.7 Mps, deben
                                soportar como minimo presiones de trabajo de 3 Mps.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                c
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">

                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Las uniones en los tubos de acero o cobre debe ser de empalmes bicónicos.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                11.2.3.2
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Filtro
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe estar diseñada para retener particulas mayor de 50u, debe estar en capacidad de
                                operar a una presión de 1.7Mpa
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                El filtro no debe presentar ningun tipo de deformacion visible al ser sometido a una
                                presion hidrostatica de 3.53 Mpa durante un tiempo de 3 minutos.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>



                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>VALVULAS - NTP - 321.116</strong>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                6.1.3.1.1
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Válvulas de alivio
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe estar instalada de manera que la descarga sea canalizada al exterior del vehículo a
                                tráves del contenedor de la multivalvula y los tubos de ventilación.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                La salida de las valvula de alivio debe encontrarse protegido por medio de una cubierta
                                protectora.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </section>




    <!--PAGINA 2-->
    <section>
        <table
            style="width:100%;box-sizing:border-box; font-size: 6px;margin-top: 55px;">
            <tr style="vertical-align:top;">
                <!--TABLA LADO IZQUIERDO-->
                <td style="width: 50%;">
                    <table style="border: 1px solid; border-collapse: collapse;width:100%;">
                        <tr>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ART.
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                REQUISITO
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ESPECIFICACIONES
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ESTADO
                            </th>
                        </tr>


                        <tr>
                            <td rowspan="6"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                6.1.3.2
                            </td>
                            <td rowspan="6" style="border: 1px solid; border-collapse: collapse;">
                                Válvula remota de llenado y retencion.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe estar equipados con una válvula remota de llenado desde el tanque a la parte exterior del vehículo
                                dentro de una capa empotrable.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe ser del tamaño adecuado para proveer el ﬂujo de gas requerido confirme a las
                                características del automotor en el que se implemente el sistema.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                En caso de tanques GLP instalados fuera del compartimiento de pasajeros no sera requerido el uso de la caja empotrable.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Se ubicara en sentido opuesto a la ubicación al sistema de escape tubos de escape.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                El interior de la caja empotrable debe estar conectada al exterior del vehículo mediante una manguera de ventilación.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe permitir el acople directo y hermetico de la pistola de llenado a los surtidores. No se permite el uso de adaptadores intermedios.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>



                        <tr>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                6.1.3.6
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Valvula de solenoide de corte de gasolina.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe fijarse a la carroceria del vehiculo
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Acciona electricamente.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>VALVULAS NTP - 321.115</strong>
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                8.1
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Válvula de cierre automático
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Evita el flujo de GLP al motor cuando este cesa de rotar (pueden ser de dos tipos: Micro interruptor por vacio y rele de induccion).
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                7.1.3.1.e
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Valvula de máximo nivel de llenado
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe ser equipado por un mecanismo de corte que garantice el nivel de llenado, no sobrepase el 80%.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                7.1.3.1e
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Válvula de servicio a consumo.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Es aquella que suministra GLP liquido al reductor u esta equipada con una valvula de exceso de flujo la
                                cual bloquea la salida del GLP automaticamente en caso que ocurra rotura de tuberia.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>MEZCLADOR - NTP 321.115</strong>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                10.1
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Mezclador gas / aire.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben ser los efectos corrosivos causados por los componentes del GLP
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Mezclador y sistema de inyectores.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben ser de acuerdo al tipo de motor
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Vehículos Carburados
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Se debe instalar entre el filtro de aire y el cuerpo del carburador.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                10.2.1
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Generalidades
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No deben sufrir desperfectos. No deformaciones cuando se somenten a una variacion de temperatura entre -10° C y 200° C.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                10.2.2
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Generalidades
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No deben sufrir fracturas.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                10.2.3
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No deben presentar fallas mecanicas ni desprendimientos de su parte cuando se sometan a un ensayo de vibración por un tiempo de 3 horas.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>SELECTOR DE COMBUSTIBLE / INDICADOR DE NIVEL - NTP 321.115</strong>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                8.2
                            </td>
                            <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                Selector de Combustibles
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Selecciona alternamente el combustible a usarse
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                bloquea electrónicamente las electrovalvulas para GLP en caso de una parada abrupta del motor
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                su uso obligatorio cuando se usa convertidores electro asistidos
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                    </table>
                </td>



                <!--TABLA LADO DERECHO-->
                <td style="width: 50%;">
                    <table style="border: 1px solid; border-collapse: collapse; width:100%;">
                        <tr>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ART.
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                REQUISITO
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ESPECIFICACIONES
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                ESTADO
                            </th>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>REDUCTOR - VAPORIZADOR - NTP 321.115</strong>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                9.1
                            </td>
                            <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                Generalidades
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Rotulado debe contener la presion de diseño y numero de serie
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe ser compatible para el servicio, ademas resistente a la accion de GLP, que permita obtener la
                                máxima seguridad  de operación en todo momento.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                No debe equiparse con tapones fusibles
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>REDUCTOR - VAPORIZADOR - NTP 321.115</strong>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="3"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                6.1.3.5
                            </td>
                            <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                Instalación
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Su ubicación debe ser según las especificaciones del fabricante.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Debe estar alejado a 15cm de distancia del multiple y sistema de gases de moto.
                                En caso no poder cumplir con la distancia mencionada, instalar con un deflector mecánico.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                En todos los terminales se debe utilizar elementos para aislamiento electrico y conexiones aislados.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>


                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>COMPONENTES ELECTRICOS - NTP - 321.116</strong>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="3"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                6.1.3.7
                            </td>
                            <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                Instalación
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben ser aislados adecuadamente.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Deben ser protegidos contra sobrecargas electricas, al menos mediante un fusible instalado en el circulo de alimentacion (linea positiva)
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                En todo terminales se deben utilizar elementos para aislamiento electrico a conectores aislados.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>SISTEMA DE ALIMENTACION LAMBDA GAS - NTP 321.115</strong>
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                12.1
                            </td>
                            <td  style="border: 1px solid; border-collapse: collapse;">
                                Unidad Central de Control Logico
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                El motor del vehiculo cuando aplique convertido a gas, cuenta con estos dispositivos.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                12.2
                            </td>
                            <td  style="border: 1px solid; border-collapse: collapse;">
                                Emulador
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                12.3
                            </td>
                            <td  style="border: 1px solid; border-collapse: collapse;">
                                Sensor Lambda
                            </td>
                            <td rowspan="4" style="border: 1px solid; border-collapse: collapse;">
                                El motor del vehiculo cuando aplique convertido a gas cuenta con estos dispositivos.
                            </td>
                            <td rowspan="4" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                12.4
                            </td>
                            <td  style="border: 1px solid; border-collapse: collapse;">
                                Actuador de mezcla de combustible.
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                12.5
                            </td>
                            <td  style="border: 1px solid; border-collapse: collapse;">
                                Sistema de control de ignición.
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                12.5.1
                            </td>
                            <td  style="border: 1px solid; border-collapse: collapse;">
                                Sistema electronico de reposicionamiento de avance de encendido.
                            </td>
                        </tr>



                        <tr>
                            <td colspan="4"
                                style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: cadetblue;">
                                <strong>HERMETICIDAD NTP 321.115</strong>
                            </td>
                        </tr>


                        <tr>
                            <td rowspan="2"
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                5.1
                            </td>
                            <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Prueba Neumatica
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Realizado el montaje del equipo completo, se realizara una verificación por prueba neumática empleando
                                aire comprimido o un gas inerte hasta la salida del regulador, con el fin de comprobar si existe fugas
                                a tráves de las conexiones en el tramo de alta presión.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                En el trabajo de baja presion se realizara la verificacion al doble de la presion reguladora.
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                C
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </section>

    <section>
        <table style="width: 100%">
            <tr>
                <td style="text-align: center;">
                    <img src="{{ public_path('/images/firmaIng.png') }}" width="150" height="110" />
                </td>

                <td style="text-align: center;">
                    <h4>ANALISIS DE GASES</h4>

                    <table style="border: 1px solid; border-collapse: collapse; margin: auto;">

                        <tr>
                            <th colspan="2" style="border: 1px solid; border-collapse: collapse;">
                                OC % del volumen
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                HC (ppm)
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                CO + CO2%
                            </th>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Vehículo fabricado hasta el año 1995
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Menor o igual a 3.0
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Menor o igual a 400
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Mínimo 10
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Vehículo fabricado hasta el año 1996 en adelante
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Menor o igual a 2.5
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Menor o igual a 300
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Mínimo 10
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Vehículo fabricado hasta el año 2003 en adelante
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Menor o igual a 0.5
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Menor o igual a 100
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                Mínimo 10
                            </td>
                        </tr>

                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                vehículo a GLP
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">

                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">

                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">

                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                vehículo a Gasolina
                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">

                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">

                            </td>
                            <td style="border: 1px solid; border-collapse: collapse;">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: 1px solid; border-collapse: collapse;">
                                Año de fabricación
                            </td>
                            <td colspan="2" style="border: 1px solid; border-collapse: collapse;">

                            </td>
                        </tr>

                    </table>
                    <p>C:CUMPLE NC: NO CUMPLE N.A : NO APLICA</p>
                </td>
            </tr>
        </table>
    </section>
    <br>
    <section>
        <table style="width: 100%; border: 1px solid; border-collapse: collapse; margin: auto;">
            <tr>
                <td style="border: 1px solid; border-collapse: collapse;width: 25%;text-align: center;">
                    {{ $inspector->name }}
                </td>
                <td style="border: 1px solid; border-collapse: collapse;width: 25%;">
                    <img src="{{ './' . Storage::url($inspector->rutaFirma) }}" width="180" height="90" />
                </td>
                <td style="border: 1px solid; border-collapse: collapse;width: 25%;text-align: center;">
                    @if($tallerauto) {{ $tallerauto->representante }} @else {{ $taller->representante }} @endif
                </td>
                <td style="border: 1px solid; border-collapse: collapse;width: 25%;">
                    <img src="{{ $tallerauto && $tallerauto->rutaFirma ? './' . Storage::url($tallerauto->rutaFirma) : ($taller && $taller->rutaFirma ? './' . Storage::url($taller->rutaFirma) : '') }}" width="180" height="90" />
                </td>
            </tr>

            <tr style="border: 1px solid; border-collapse: collapse; margin: auto;">
                <td style="border: 1px solid; border-collapse: collapse;">
                    Nombre inspector
                </td>
                <td style="border: 1px solid; border-collapse: collapse;">
                    Firma
                </td>
                <td style="border: 1px solid; border-collapse: collapse;">
                    Nombre del Representante del Taller
                </td>
                <td style="border: 1px solid; border-collapse: collapse;">
                    Firma
                </td>
            </tr>
        </table>
    </section>



</body>

</html>
