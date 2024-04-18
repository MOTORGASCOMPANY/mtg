<!DOCTYPE html>
<html>
<head>    
    <title>EVALUACIÓN DE PRE-CONVERSIÓN</title>
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
            height: 6cm;            
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
            text-align: center;      
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
            font-size: 8px;
        }
        ul{
            font-size: 8px;
        }
    </style>
</head>
<body>
    <header>
        <article>           
            <img style="float:left; padding-left: 3cm; margin-top: 20px" src="{{'.'.Storage::url($taller->rutaLogo)}}" width="90" height="90"/>
            <h2 style="margin-top: 40px">{{$taller->nombre}}</h2>
            <p>{{$taller->direccion}}</p>            
        </article>        
    </header>  
    <main>        
        <h3 >           
            EVALUACIÓN DE PRE CONVERSIÓN
        </h3>       
        
        <table> 
            <tr>               
                <td colspan="2" style="text-align: center; font-weight: bold;">DATOS DEL PROPIETARIO </td>
                <td colspan="2" style="text-align: center; font-weight: bold;">DATOS DEL VEHÍCULO </td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td></td>
                <td>placa</td>
                <td>{{(isset($carro->placa)? $carro->placa : 'NE')}}</td>
            </tr>
            <tr>
                <td>DNI / RUC</td>
                <td></td>
                <td>Marca</td>
                <td>{{(isset($carro->marca)? $carro->marca : 'NE')}}</td>
            </tr>
            <tr>
                <td>Dirección</td>
                <td></td>
                <td>Modelo</td>
                <td>{{(isset($carro->modelo)? $carro->modelo : 'NE')}}</td>
            </tr>
            <tr>
                <td>Telefono</td>
                <td></td>
                <td>Año de Fab.</td>
                <td>{{(isset($carro->anioFab)? $carro->anioFab : 'NE')}}</td>
            </tr>
            <tr>
                <td>Fecha</td>
                <td></td>
                <td>Cilindrada</td>
                <td>{{(isset($carro->cilindrada)? $carro->cilindrada : 'NE')}}</td>
            </tr>
            <tr>
                <td>Servicio</td>
                <td>CONVERSION A GAS NATURAL VEHICULAR</td>
                <td>Kilometraje</td>
                <td></td>
            </tr> 
            <tr>
               <td colspan="4" style="text-align: center; font-weight: bold;">REVISIONES</td>
            </tr>   
            <tr>         
                <td> 
                    <p> 
                        <strong style="text-decoration: underline;">1. BATERÍA ARRANQUE</strong>                          
                        <br>                 
                        Voltaje batería 
                        <br>
                        Voltaje de arranque
                        <br>
                        Prueba de arranque
                    </p>
                </td>
                <td style="text-align: center;">
                    <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                </td>
                <td>
                    <p>
                        <strong style="text-decoration: underline;">5. SISTEMA DE ESCAPE</strong>                        
                        <br>
                        Verificación general estado y 
                        <br>
                        funcionamiento
                    </p>
                    
                </td>
                <td style="text-align: center; ">
                    <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                </td>
            </tr>    
            
            <tr>         
                <td>                    
                    <p> 
                        <strong style="text-decoration: underline;">2. BOBINA/CABLEADO/BUJIAS</strong>                        
                        <br>                 
                        Entrada a la bobina de arranque
                        <br>
                        Entrada a la bobina de funcionamiento
                        <br>
                        Salida de la bobina polaridad de la bobina
                        <br>
                        Condición de cables y bujías.
                    </p>
                </td>
                <td style="text-align: center;">
                    <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                </td>
                <td>                   
                    <p>
                        <strong style="text-decoration: underline;">6. SISTEMA DE ENFRIAMIENTO</strong>                        
                        <br>
                        Verificación general estado y 
                        <br>
                        funcionamiento
                    </p>                                        
                </td>
                <td style="text-align: center; ">
                    <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                </td>
            </tr> 

            <tr>         
                <td>
                    <p> 
                        <strong style="text-decoration: underline;">3.SISTEMA CARBURACIÓN- INYECCIÓN</strong>                        
                        <br>                 
                        Verificación filtro de aire
                        <br>
                        Verificación filtro de combustible
                        <br>
                        Operación del carburador
                        <br>
                        Operación del sistema de inyección
                    </p>
                </td>
                <td style="text-align: center;">
                    <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                </td>
                <td>
                    <p>
                        <strong style="text-decoration: underline;">7. DISTRIBUIDOR</strong>
                        
                        <br>
                        Condición de motor
                        <br>
                        Condición de la tapa
                        <br>
                        Operación avance por vacío
                        <br>
                        Operación avance centrifugado
                    </p>
                    
                </td>
                <td style="text-align: center; ">
                    <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                </td>
            </tr> 

            <tr>         
                <td>
                    <p> 
                        <strong style="text-decoration: underline;"> 4. SISTEMA DE ADMISIÓN</strong>
                                              
                        <br>                 
                        Verificación entrada de aire                        
                    </p>
                </td>
                <td style="text-align: center;">
                    <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                </td>
                <td>
                    <p>
                        <strong style="text-decoration: underline;">8. CARROCERÍA Y CHASIS</strong>                        
                        <br>
                        Verificación estado general                        
                    </p>                    
                </td>
                <td style="text-align: center; ">
                    <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                </td>
            </tr> 
            <tr>
                <td colspan="4" style="text-align: center;">
                    <p>
                        <strong style="text-decoration: underline;">9. VERIFICACIÓN DE BALANCE Y COMPRESIÓN DE CILINDROS</strong>                        
                        <br>                                              
                    </p> 
                    @if($cilindros->count()>8)
                    
                        <article style="float:left; width:45%; margin-left: 4%;">
                            <table >
                                <thead>
                                    <td> N° Cilindro</td>
                                    <td> Compresión obtenida (PSI)</td>
                                </thead>
                                @for($i=0;$i<=7;$i++)
                                    <tr>
                                        <td>{{$cilindros[$i]["numeracion"]}}</td>
                                        <td style="text-align: right;">{{$cilindros[$i]["presion"]}}</td>
                                    </tr>
                                @endfor
                            </table>
                        </article>
                        <article style="float:right;width:45%; margin-right: 
                        4%;">
                            <table >
                                <thead>
                                    <td> N° Cilindro</td>
                                    <td> Compresión obtenida (PSI)</td>
                                </thead>
                                @for($i=8;$i<$cilindros->count();$i++)
                                    <tr>
                                        <td>{{$cilindros[$i]["numeracion"]}}</td>
                                        <td style="text-align: right;">{{$cilindros[$i]["presion"]}}</td>
                                    </tr>
                                @endfor
                            </table>
                        </article>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>                                       
                    @else                        
                        <table style="width: 40%; margin: 5px auto">
                            <thead>
                                <td> N° Cilindro</td>
                                <td> Compresión obtenida (PSI)</td>
                            </thead>
                            @if($cilindros->count()>0)
                                @foreach($cilindros as $cilindro)
                                    <tr>
                                        <td>{{$cilindro["numeracion"]}}</td>
                                        <td style="text-align: right;">{{$cilindro["presion"]}}</td>
                                    </tr>
                                @endforeach
                            @else
                                    <tr>
                                        <td colspan="2">
                                            NO SE ENCONTRARON DATOS EN LA TARJETA DEL VEHÍCULO
                                        </td>
                                    </tr>
                            @endif
                        </table>                       
                    @endif                   
                                      
                    <p style="font-size: 10px;">Para la prueba de compresión la diferencia máxima la especificación del fabricante es del 20% y entre cilindros del 10%</p>
                </td>
            </tr>
            <tr style="text-align: center;">
                <td colspan="4">
                    RESULTADO DE LAS REVISIONES
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <strong>OBSERVACIONES</strong>(separaciones o refuerzos):
                    <br>
                    <br>
                    <br>                                      
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Responsable:                                   
                </td>
                <td colspan="2">
                    Fecha:                                   
                </td>
            </tr>
            
        </table>        
                       
           <img  src="{{public_path('/images/vehiculo1.png')}}" width="200" height="150" style="float:left; margin-top: 5px;"/>
            <p>
                <strong style="text-decoration: underline;">NOTA: </strong>
                 EFECTUADA LA REVISIÓN QUEDA A CRITERIO DEL INSTALADOR Y EL USUARIO LA INSTALACIÓN DEL EQUIPO DE CONVERSIÓN
            </p>
            <article style="text-justify: center;"  >
                <table style=" text-align: center; width:68%;  float:right;">
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
                    <tr >
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