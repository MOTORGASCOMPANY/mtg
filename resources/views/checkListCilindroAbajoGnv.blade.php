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

    <title>Check List Cilindro Abajo</title>    
</head>
<body style="display: block;">
    <header style="align-items: center;font-size:10px; font-weight: bold; position:fixed; height: 2cm; width: 100%;">                 
            <img  src="{{public_path('/images/logo.png')}}" width="120" height="50" align="left" />            
            <p style="text-align: center;  width: 500px; float: right;" align="right"> 
                REPORTE DE VERIFICACIÓN DE LA INSTALACIÓN DEL EQUIPO GNV A VEHÍCULOS CONVERTIDOS U
                ORIGINALMENTE DISEÑADOS A GAS NATURAL VEHICULAR – GNV 
                <br>
                RD N° 365 - 2021 - MTC / 17.03                
            </p>                    
    </header> 
    <br clear="left">

    <!--Datos Vehículo -->
    <section>
        <table style="border: 1px solid; border-collapse: collapse; width: 500px; float: left;">
            <tr style="">
                <td colspan="6"  style="align-self: start; border: 1px solid; border-collapse: collapse;">
                    Taller: 
                    <br>
                    {{$taller->nombre}}                   
                </td>
                <td colspan="2"  style="border: 1px solid; border-collapse: collapse;">
                    Fecha de inspeccion:
                    <br>
                    {{$fecha}}
                </td>                
            </tr>
            <tr>
                <td colspan="4" style="border: 1px solid; border-collapse: collapse;">
                    Placa de rodaje/DUA:
                    <br>
                    {{$vehiculo->placa}}
                </td>
                <td colspan="4" style="border: 1px solid; border-collapse: collapse;">
                    Inspector:
                    <br>
                    {{$inspector->name}}                   
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
                            {{$vehiculo->anioFab}}
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
                            {{$vehiculo->anioFab}}
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
                <td  style="border: 1px solid; border-collapse: collapse;">
                    Carburador
                </td>
                <td style="border: 1px solid; border-collapse: collapse;">

                </td>
                <td  style="border: 1px solid; border-collapse: collapse;">
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
        
        <img  src="{{public_path('/images/vehiculo.png')}}" width="110" height="110" style="float: right; margin-right:30px"/> 
    </section>
    <br clear="left">
    {{--
    
    <h5>Datos de equipos y Cilindros</h5>
    <br>
    --}}

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
                                {{$reductor->marca}}
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                Número de Serie:
                            </th>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                {{$reductor->numSerie}}
                            </td>
                        </tr>                        
                        <tr>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                Chip instalado:
                            </th>
                            <td style="border: 1px solid; border-collapse: collapse;">
                                {{$chip->numSerie}}
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
                                Capacidad(L)
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                Fecha de Fabricación
                            </th>
                            <th style="border: 1px solid; border-collapse: collapse;">
                                Peso(KG)
                            </th>
                        </tr>
                        
                        @foreach ($cilindros as $key=> $item)
                        <tr>
                            
                            <td  style="border: 1px solid; border-collapse: collapse;" >
                                {{$item->marca}}
                            </td>
                            <td  style="border: 1px solid; border-collapse: collapse;" >
                                {{$item->numSerie}}
                            </td>
                            <td  style="border: 1px solid; border-collapse: collapse;" >
                                {{$item->capacidad}}
                            </td>
                            <td  style="border: 1px solid; border-collapse: collapse;" >
                                {{date('d/m/Y', strtotime($item->fechaFab))}}
                            </td>
                            <td  style="border: 1px solid; border-collapse: collapse;" >
                                {{$item->peso}}
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
            <table style=" width:100%;padding: 0; box-sizing:border-box; font-size: 6px; text-align: start;">
                <tr>
                    <td>
    
                        <!--TABLA LADO IZQUIERDO-->
                        <table style="border: 1px solid; border-collapse: collapse;width: 8.7cm" align="left">
    
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
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >CERTIFICADOS DE CONFORMIDAD</strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Cilindros para almacenamiento de GNC
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Certificado del fabricante de cilindros: Análisis químico cuantitativo
                                    del material utilizado.<br>
                                    Resultado de ensayo físico sobre probetas.<br>
                                    Resultados de ensayos físicos sobre probetas Resultado ensayo aplastamiento sobre un cilindro terminado.<br>
                                    Control dimensiones: peso, volumen, diámetro, longitud, espesores.<br>
                                    Certificado de aprobación del Lote Importado Descripción técnica de fabricación Recomendaciones para el montaje y uso del cilindro, de los controles 
                                    periódicos e información derivada de la experiencia en el uso de los mismos.<br>
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse; float:center; text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Tuberías, reductor de presión, mezclador de gas, mangueras, válvulas, accesorios, instrumentos de medición y control.							
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Certificado de fabricación de equipos: Recomendaciones para el montaje de equipo Controles periódicos e informáticos derivada de la 
                                    experiencia en el uso de los mismos.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Válvulas: de cierre manual. Solanoides de retención.De llenado. De cierre automático. Selector de combustible.
                                    <br>
                                    Regulador de Presión. Mezclador /Carburador							
                                 </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Deben cumplir con los requisitos especifica- dos por las normas de fabricación nacionales al existieran o internacionales aplicables.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
                            
                            <tr>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse; text-align: center;">
                                    5.6.3.2
                                    <br>
                                    5.6.4.1
                                    <br>
                                    5.6.3.3
                                </td>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                    Cilindros, accesorios partes, piezas y demás equipos nuevos							
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    "Habilitados por PRODUCE
                                    Registrados en la base de datos del sistema de control de camara de GNV"				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
                                    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    "Instalados para la marca y modelo vehicular
                                    recomendado por el proveedor de equipos completos- PEC"				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>                          
                            </tr>
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >CONSTANCIAS</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Pre-Inspección							
                                 </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Previamente el taller debió inspeccionar el estado del vehículo, para efectos de realizar el montaje sin inconvenientes.				
                
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Garantía por el trabajo de montaje de la instalación							
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Previamente el taller debió inspeccionar el estado del vehículo, para efectos de realizar el montaje sin inconvenientes.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Manual de usuario							
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Manual de instrucción, operación y mantenimiento del vehículo convertido.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >CILINDROS</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    2.3
                                </td>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                    Generalidades							
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Fabricados, identificados y probados de acuerdo con normas nacionales, si existieran o aquellos que reconocida aceptación 
                                    internacional en lo que a GNC se refiere.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    Construidos para operar una presión normal de 200 bar.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Presión de operación							
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Deben de operar una presión normal de trabajo de 200 bar a 21+°C				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Ubicación						
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Una vez instalado, no estar modificados, ni alterados				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="11" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="11" style="border: 1px solid; border-collapse: collapse;">
                                    Instalación de cilindros						
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    No instalados en el techo ni dentro del comportamiento del motor.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                   En forma permanente y ne posición horizontal				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    No se permite el uso de cilindros intercambiables			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Anclaje acuerdo que evite su desplazamiento, resbalamiento o rotación				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    No se debe producir esfuerzos indebidos sobre el recipiente no sobre los accesorios vinculados a el				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                   "El método para montar el cilindro debe de evitar el debilitamiento significativo de la estructura del 
                                   vehículo y se debe añadir un refuerzo, si es necesario"				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Soporta una carga ocho veces el paso del recipiente lleno o en cualquier otra dirección.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    No debe soldarse ningún elemento al cilindro			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                   Debe evitar el contacto del cilindro con el vehículo o con cualquier elemento metálico				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Debe utilizarse caucho como elemento de separación entre el herraje y el cilindro		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Disponer por los menos dos cuñas o soporte de apoyo, aptas para resistir la carga estática y solicitantes dinámicas: así como dos sunchos de fijación aptos para resistir la carga dinámica.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>                       
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >DISPOSITIVOS DE SUJECIÓN DE CILINDROS</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                    Materiales			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Perfil de acero revestidos contra la corrosión.			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Cada pieza en contacto con el recipiente será electroquímicamente compatible con el cilindro.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Las  cunas,  los  suchos  y  otros  componentes metálicos, concepto de los pernos, deben ser de acero estructural de calidad comercial con una
                                    resistencia mínima a la tracción de 34 Kg/002.				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="5" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="5" style="border: 1px solid; border-collapse: collapse;">
                                    Cilindro de hasta 110 kg.		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Ancho de sunchos mínima a la tracción de 30 mm			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Espesor de sunchos mínimo 3mm			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Las variables admitidas (anchos y espesor) tendrán como producto una sección equivalente a 90mm2?			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Deben tener mínimo cuatro pernos de acero de W 7/16 pulgadas x 14 hilos por pulgada, con sus correspondientes arandelas de presión y tuerca			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Se aceptan pernos con roscas diferentes, siendo el diámetro mínimo 10mm			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
                            
                           {{--
                            <tr >
                                <td style="height: 64px; border: 1px solid white"></td>
                                <td style="height: 64px; border: 1px solid white"></td>
                                <td style="height: 64px; border: 1px solid white"></td>
                                <td style="height: 64px; border: 1px solid white"></td>
                            </tr>
                            --}}
    
                        </table>
    
                    </td>
                    <td style="width: 3px;"></td>
                    <td >
    
                        <!--TABLA LADO DERECHO-->
                        <table style="border: 1px solid; border-collapse: collapse; width: 8.7cm;" align="right">
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
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                    Cilindro de más de 110 kg.		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Ancho de sunchos mínimo 45mm				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Espesor de sunchos mínimo 5mm		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Las variables admitidos (ancho y  espesor)  tendrán como producto una sección equivalente a 225m2.  Deben
                                    de tener mínimo cuarto de pernos de acero W1. 2x12 hilos por pulgada, con sus correspondientes arandelas de presión y tuerca.Se aceptan pernos con roscas diferentes, siendo el diámetro mínimo 10mm			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                    Plantillas de Refuerzo	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Se aceptan pernos con roscas diferentes siendo el diámetro mínimo 12mm			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Diseñadas para colocarlas en el exterior de la zona donde se apoya la cuna reforzada		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Deben ser como mínimo del espesor y ancho de las cinas de formas sustancialmente cuadrada cuando tengan mas de un agujero			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                   
                                </td>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                    Materiales metálicos no resistentes a la corroción	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Tratamiento superficial: pintado, zincado, cromado, etc.			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Color de acabado: negro
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Pernos	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    De acero forjado o =50Kg/mm2			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Tuercas	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    De acero forjado o =24Kg/mm2			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                    Protección anterior del cilindro
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Planchas de elastómetro adherido en forma permanente a las cunas y sunchos de sujeción.			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Ningún punto del cilindro en contacto con partes metálicas del dispositivo de sujeción		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Planchas de elastómetro con espesor mínimo de 3mm y estan min. 5mm por ollado en el ancho de los soporte metálicos			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >MONTAJE DE CILINDROS</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="4" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="4" style="border: 1px solid; border-collapse: collapse;">
                                    Cilindros de hasta    110 Kg. de peso
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Fijados al vehículo con 2 sunchos como mínimo	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Ancho mínimo de los sunchos 30mm	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Espesor de los soportes que le confiaran una resistencia equivalente ala de una barra de acero común de 90mm2 de sección		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Diámetro de los pernos 10mm			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="4" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="4" style="border: 1px solid; border-collapse: collapse;">
                                    Cilindros de mas de 110 Kg. de peso
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Fijados al vehículo con 2 sunchos como mínimo	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Ancho mínimo de los sunchos 45mm		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Espesor de los soportes que le confiara equivalente a la de una barra de acero común de 225mm2 de  sección
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Diámetro de los pernos 12mm	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
                            
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Utilización de mas de 2 sunchos
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Área total de la sección de los mismos será por lo menos igual a la de los sunchos de los especiﬁcados anteriormente
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >CILINDROS EN COMPARTIMIENTO DE PASAJEROS</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                    Generalidades
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Dentro de un compartimiento adecuadamente diseñado
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    El extremo del cilindro que contiene la válvula y demás accesorios deberá encerrarse dentro de una ceja resistente con un venteo al exterior del vehículo		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    El disco de ruptura deberá ventear por un tubo de acero directamente al exterior del vehículo.
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="4" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="4" style="border: 1px solid; border-collapse: collapse;">
                                    Venteos
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    El disco de ruptura deberá ventear por un tubo de acero directamente al exterior del vehículo.	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Como alternativa puede ventearse el gas hacia el exterior del vehículo conforma se hace en los montajes de cilindros en comportamiento de pasajeros.		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Tubos ﬂexibles construidos con material no inﬂamable o auto extinguible.
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Expulsan el gas hacia la parte externa inferior del automotor a través de conductos encaminados y herméticos con sección o 
                                    menor a 1100mm2. No deben descargar en la zona de guardafangos.
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Cilindro instalado longitudinalmente
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Posee un medio adecuado para absorber y transmitir a la estructura del vehículo cualquier embestida.
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>      
                            
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >CILINDROS ENTRE EJES DEL VEHÍCULO</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Distancia mínima al suelo de la distancia entre ejes < 3175
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Vehículo con la máxima carga establecida, tomada desde el cilindro o desde cualquier accesorio, al que esta más bajo mínimo 175 mm
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr> 
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Distancia mínima al suelo
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Vehículo con la máxima carga establecida, tomada desde el cilindro o desde cualquier accesorio, al que esta mas bajo Mínimo 225 mm
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >CILINDROS DETRAS DEL EJE TRASERO</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Debajo de la estructura, con saliente trasera de hasta 1125 mm
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Distancia mínima al suelo =200mm
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr> 
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Debajo de la estructura, a más de 1125 mm detrás de la línea
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Mínimo 0.18 veces la distancia entre la línea central del eje posterior y la línea central del fondo recipiente
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr> 
                            <tr>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                    Dispositivos
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Tapón fusible para funda	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Cilindros en longitud menor en 1x50mm
                                    Dispositivo de seguridad ubicada en la válvula manobra con la que cada cilindro		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Cilindro en longitud mayor a 1x50mm
                                    Debe poseer un oficio calibrado ubicado en el casquete una pieza roscada con el dispositivo de seguridad combinado disco de rotura tapón fusible
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
                             
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >TUBERIAS</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                    Tuberías, manguera y accesorios de alta presión
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    No ubicadas dentro de la cabina
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Fabricados para soportar hasta cinco veces la presión de trabajo	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Tuberías líneas de baja presión				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Construidas para soportar (4) veces la presión de operación				
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
            <table style="width:100%;padding: 0; box-sizing:border-box; font-size: 6.5px; text-align: start; margin-top: 50px;">
                <tr>
                    <!--TABLA LADO IZQUIERDO-->
                    <td>
                        <table style="border: 1px solid; border-collapse: collapse;width: 8.7cm" align="left">
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
                                <td rowspan="11" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="11" style="border: 1px solid; border-collapse: collapse;">
                                    Instalación de tuberías y accesorios				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Los materiales utilizados en la fabricación deben ser resistentes a la acción química del gas y las condiciones de operaciones.			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Debe ser del tamaño adecuado para proveer el  ﬂujo de gas requerido confirme a las características del automotor en el que se implemente el sistema.		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Las tuberías y accesorios deben estar limpios y  libres de recortes, residuos de la operación de fileteado escamas y otro tipo de suciedad o defecto.
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Los bordes extremos deben estar adecuados escariados
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Los accesorios y conexiones deben estar localiza- dos en lugares accesibles para permitir la inspección y mantenimiento.
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Montalos en forma segura y soportados para compensar vibraciones por medio de abrazaderas de metal galvanizados o con otro tratamiento equivalente
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Las tuberías pueden estar amarradas por bandas de nylon y otro producto de idéntica resistencia y reacción neutra
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    La distancia entre piezas de amarre no debe ser mayor de 600mm.
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Las tuberías siguen el recorrido práctico mas corto entre cilindros y mezclador, compatible con su ﬂexibilidad.
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Protegidas contra daños y roturas debido a choques, esfuerzos excesivos o desgastes por rozamiento
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Están encamisadas en el sitio donde resulta necesario.
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                    Líneas rígidas entre cilindros y el punto de llenado
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Dispuesta de manera que permitan un ligero movimiento estructural, para absorber las vibraciones, y que ante un impacto se evite su estrangulamiento
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    No están ubicadas en canales que contengan el sistema de gases de escape	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Instaladas a una distancia mínima de 200mm de los terminales de la bateria, a menos que se prevenga el contrato eléctrico.
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Materiales
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Dispuesta de manera que permitan un ligero movimiento estructural, para absorber las vibraciones, y que ante un impacto se evite su estrangulamiento
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="9" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="9" style="border: 1px solid; border-collapse: collapse;">
                                    No está permitido				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Conexiones en lugares por accesibles			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    La ubicación de tuberías donde pueda acumularse gas		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    La unión de niveles o manguilos	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Utilizar materiales diferentes al bronce o acero
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Uniones utilizando tuberías que contengan rosca derecha e izquierda en la misma pieza
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    El curvado de tuberías donde dicha operación debilite a estos componentes
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Reparaciones de defectos en la línea que canaliza el GN: Todo elemento con fallas será reemplazado
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Cortes en la estructura, reduciendo su resistencia con el proposito de instalar tuberías o mangueras y
                                    desviándolos del objetivo para el cual fueron diseñadas
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    La línea rígida que sufra daños al doblarla en el
                                    momento del montaje no debe ser utilizada
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                           
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Mecanismo de cierre automático				
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Automáticamente evita el ﬂujo de gas el motor cesa de funcionar o no esta conectado al encendido			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Válvula de retención			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Evita retorno de gas, desde el cilindro a la conexión de llenado			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Válvula de carga			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Instalada en un lugar seguro contra impactos, en la zona del motor u otra zona considerada segura			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>                        
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Válvula Manual			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Instalada en un lugar que permita aislar del cilindro,
                                    el resto del sistema. Protegida contra golpes o choques.			
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>	
    
                            <tr>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                    Electroválvula de corte de gasolina.		
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Accionada electrónicamente
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Evita el ﬂujo de líquido al carburador haya sido conectado con el suministro de GNV
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td> 
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Debe ser instalada entre la bomba de gasolina y carburador mediante líneas rígidas ﬂexibles accesorios equivalentes aquellos que utilizan en la fabricante en la salida de bomba
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td> 
                            </tr>                       
                        </table>
                    </td>
    
                    <td style="width: 3px;"></td>
                   
                    <!--TABLA LADO DERECHO-->
                    <td >
                        <table style="border: 1px solid; border-collapse: collapse; width: 8.7cm;" align="right">
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
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >MEZCLADOR</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td  style="border: 1px solid; border-collapse: collapse;">
                                    Mezcladoras
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Fabricado con materiales adecuados conforme a las condiciones de servicio para los cuales esta diseñado.	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>
                                <td  style="border: 1px solid; border-collapse: collapse;">
                                    Vehículos carburados
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Se debe instalar entre el filtro del aire y el cuerpo del carburador
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
    
                            <tr>
                                <td  style="border: 1px solid; border-collapse: collapse;">
                                    Vehículos a los cuales se le ha retirado el sistema de combustible líquido
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Se debe empalmar con las mariposas de aclaración
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    N.A
                                </td>
                            </tr>
                           
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >MANOMETRO</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                    Instalación
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Próximo a la válvula de llenado	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Lugar visible durante la operación de reabastecimiento
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >SELECTOR DE COMBUSTIBLE / INDICADOR DE NIVEL</strong>
                                </td>
                            </tr>
                            {{-- OBSERVAR Y REVISAR EN EL PDF--}}
                            <tr>
                                <td rowspan="4" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="4" style="border: 1px solid; border-collapse: collapse;">
                                    Selector de combustible
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Próximo a la válvula de llenado	
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Operación de fácil acceso desde el asiento del conductor
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    La corriente para su accionamiento debe ser tomada de la posición de la chapa de encendido
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Entre este y la forma de alimentación eléctrica se debe intercalar un fusible para proteger todo el sistema eléctrico del equipo de conversión
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Selector de combustible
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Si está dentro de la cabina debe ser un instrumento repetidor accionado eléctricamente
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
                            {{--HASTA AQUI EVALUAR--}}
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >REGULADOR</strong>
                                </td>
                            </tr>
    
    
                            <tr>
                                <td rowspan="8" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="8" style="border: 1px solid; border-collapse: collapse;">
                                    Regulador
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Instalada en forma de segura
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    No fijado directamente al motor del vehículo
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Instalado en forma segura y en un lugar accesible
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Protegido de golpes, de excesivo calor y de equipos e instalaciones eléctricas
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
                            
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Dispone de un sistema de fijación propio de modo que su peso no sea soportado por las líneas rígidas o ﬂexibles adyacentes
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    El espesor de la platina para la fijación debe ser mínimo 3mm(1/8")
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Colocado de manera que el desplazamiento y el movimiento del vehículo no afectan el funcionamiento del mismo
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Instalado cerca al mezclador para tener las mangueras lo más corta posible
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >COMPONENTES ELECTRICOS</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="3"  style="border: 1px solid; border-collapse: collapse;">
                                    Materiales
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Debe utilizar como mínimo cable eléctrico 15 AWG
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Conexiones eléctricas y conectores, deben estar protegidos, mediante dispositivos, contra eventuales cortocircuitos y contra la corrosión
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    En todos los terminales se debe utilizar elementos para aislamiento eléctrico o conectores aislados
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td 
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td  style="border: 1px solid; border-collapse: collapse;">
                                    Uniones
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Cables recubiertos con cinta aislante o entubada a un material plástico
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td 
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td  style="border: 1px solid; border-collapse: collapse;">
                                    Distancia al múltiple de escape
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Mínimo 50mm
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
                            
                            <tr>
                                <td 
                                style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                   
                                </td>
                                <td  style="border: 1px solid; border-collapse: collapse;">
                                    
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Azul= GNCV, Rojo= ignición, Verde= gasolina Negro= puesta a tierra
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >COMPONENTES ELECTRICOS</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="3" style="border: 1px solid; border-collapse: collapse;">
                                    Variador de avance de encendido
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Debe instalarse en el vehículo que operan de manera alternativa con GNV y gasolina
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Instalado de manera segura lejos de fuentes de calor
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>                            
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Protegido contra goteo de líquidos y eventuales golpes
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >VEHICULOS CON SISTEMA DE INYECCION</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                    instalación
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Se debe emplear un sistema cerrado para el control de la mezcla
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Conectado de acuerdo con el diagrama eléctrico de cada vehículo
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                    Ref de corte de suministro de gasolina a los inyectores
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Conectado de acuerdo con el diagrama eléctrico de cada vehículo
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Debe suspender el suministro de electricidad a la bomba de gasolina
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td colspan="4" style="border: 1px solid; border-collapse: collapse;text-align:center;background-color: goldenrod;">
                                    <strong >HERMETICIDAD</strong>
                                </td>
                            </tr>
    
                            <tr>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    6.4.2.3
                                </td>
                                <td rowspan="2" style="border: 1px solid; border-collapse: collapse;">
                                    Prueba neumática
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    Realizado el montaje del equipo completo, se efectuará una veriﬁcación por prueba neumática empleando aire comprimido o un gas inerte hasta la salida del regulador, 
                                    con el ﬁn de comprobar si existen fugas a través de las conexiones en el tramo de alta presión
                                </td>
                                <td style="border: 1px solid; border-collapse: collapse;text-align: center;">
                                    C
                                </td>
                            </tr>
    
                            <tr>
                                <td style="border: 1px solid; border-collapse: collapse;">
                                    En el tramo de baja presión se realizará la veriﬁcación al doble de la presión reguladora
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
                        <img  src="{{public_path('/images/firmaIng.png')}}" width="150" height="110"/> 
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
                                    vehículo a GNV
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
                        <p>C:CUMPLE  NC: NO CUMPLE  N.A : NO APLICA</p>
                    </td> 
                </tr>
            </table>
        </section>
        <br>
        <section>
            <table style="width: 100%; border: 1px solid; border-collapse: collapse; margin: auto;">
                <tr >
                    <td style="border: 1px solid; border-collapse: collapse;width: 25%;text-align: center;">
                        {{$inspector->name}}
                    </td>
                    <td style="border: 1px solid; border-collapse: collapse;width: 25%;">
                        <img  src="{{"./".Storage::url($inspector->rutaFirma)}}" width="180" height="90"/>
                    </td>
                    <td style="border: 1px solid; border-collapse: collapse;width: 25%;text-align: center;">
                        {{$taller->representante}}
                    </td>
                    <td style="border: 1px solid; border-collapse: collapse;width: 25%;">
                        <img  src="{{"./".Storage::url($taller->rutaFirma)}}" width="180" height="90"/>
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