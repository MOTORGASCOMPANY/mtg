<!DOCTYPE html>
<html>
<head>    
    <title>Cargo</title>
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
            height: 2cm;            
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
            left: 0;
        }
        image{
            margin-left: 2cm;
        }
        h5{
            margin-top: 150px;
            color: black; 
        }   
    </style>
</head>
<body>
    <header>
        <p>          
            <img  src="{{public_path('/images/mtg.png')}}" width="90" height="90"/>
            
        </p>       
        <h1>{{$empresa}}</h1>
    </header>  
   
    <main>        
        <h5>Lima, {{$date}}</h5>
        <br>
        <p>Señor(a):</p>        
        <p>{{$inspector}}</p>
        <br>
        <p>Asunto: Entrega de Materiales</p>   
        <p>Presente.-</p>     
        <p>De mi especial consideración.</p>
        <p>Por medio del presente me dirigo a usted, para saludarlo y hacerle llegar los siguientes materiales por parte de la empresa <strong>{{$empresa}}</strong></p>
        <!--p>Le enviamos el siguiente material de trabajo por parte de la empresa <strong>{{$empresa}}</strong> </p-->
        <ol>        
            @foreach ($materiales as $key=>$material)                
                @if ($material["tipo"]=="FORMATO GNV" || $material["tipo"]=="FORMATO GLP" || $material["tipo"]=="MODIFICACION")
                    <li>{{$material["tipo"]}} - {{$material["cantidad"]." Unds"}} - 
                    (
                        @if(count($material["series"]))
                            @if(count($material["series"])>1)
                                @foreach ($material["series"] as $key=>$serie)
                                    {{$serie["inicio"]." - ".$serie["final"]."/"}}
                                @endforeach
                                
                            @else
                                {{$material["series"][0]["inicio"]}} - {{$material["series"][0]["final"]}}
                            @endif
                        
                        @else
                            SIN DATOS DE SERIES
                        @endif
                    ) - por motivo de <strong>{{$material["motivo"]}}</strong>
                    </li>
                @else
                    <li>{{$material["tipo"]}} - {{$material["cantidad"]}}</li>
                @endif               
            @endforeach  
            @foreach ($cambios as $key=>$cambio)
            <li>
                @if ($cambio["tipo"]=="FORMATO GNV" || $cambio["tipo"]=="FORMATO GLP" || $material["tipo"]=="MODIFICACION")                    
                    {{$cambio["tipo"]}} - {{$cambio["cantidad"]." Unds"}} - 
                    (
                        @if(count($cambio["series"]))
                            @if(count($cambio["series"])>1)
                                @foreach ($cambio["series"] as $key=>$serie)
                                    {{$serie["inicio"]." - ".$serie["final"]." / "}}
                                @endforeach                            
                            @else
                                {{$cambio["series"][0]["inicio"]}} - {{$cambio["series"][0]["final"]}}
                            @endif                        
                        @else
                            SIN DATOS DE SERIES 
                        @endif
                    ) - por motivo de <strong>{{$cambio["motivo"]}}</strong>                     
                @else
                    <li>{{$cambio["tipo"]}} - {{$cambio["cantidad"]}}</li>
                @endif 
            </li>
            
            {{--
            @if ($material["tipo"]=="FORMATO GNV" || $material["tipo"]=="FORMATO GLP")
                <li>{{$material->detalle->motivo}}</li>
            @else
                <li>{{$material["tipo"]}} - {{$material["cantidad"]}}</li>
            @endif
            --}}
            @endforeach 

            @foreach ($prestamos as $key=>$material)                
                @if ($material["tipo"]=="FORMATO GNV" || $material["tipo"]=="FORMATO GLP" || $material["tipo"]=="MODIFICACION")
                    <li>{{$material["tipo"]}} - {{$material["cantidad"]." Unds"}} - 
                    (
                        @if(count($material["series"]))
                            @if(count($material["series"])>1)
                                @foreach ($material["series"] as $key=>$serie)
                                    {{$serie["inicio"]." - ".$serie["final"]."/"}}
                                @endforeach
                                
                            @else
                                {{$material["series"][0]["inicio"]}} - {{$material["series"][0]["final"]}}
                            @endif
                        
                        @else
                            SIN DATOS DE SERIES
                        @endif
                    ) - por motivo de <strong>{{$material["motivo"]}}</strong>
                    </li>
                @else
                    <li>{{$material["tipo"]}} - {{$material["cantidad"]." Unds"}}</li>
                @endif               
            @endforeach  

           
                                         
        </ol>
        
        <p>Sin otro particular me despido;</p>

        <p>Atentamente.</p>
        <!--br>
        <br>
        <br>
        <p>_________________________</p>
      
        <p>Nombre:</p>
        <p>DNI:</p-->
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center;">
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                    <h4>_________________________</h4>
                    <h4><strong>{{$inspector}}</strong></ul>
                    <h4 style="text-align: left; margin-left: 50px;">Recibí Conforme</h4>
                    <h4 style="text-align: left; margin-left: 50px;">Dni :</h4>
                </td>
                <td style="text-align: center;">
                    <p style="text-align: center;">
                        <img src="{{ public_path('/images/firmaAdm.jpg') }}" height="73" />
                    </p>
                    <h4>_________________________</h4>
                    <h4><strong>Gerente General</strong></ul>
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                </td>
                
                <!--td style="text-align: center;">
                    <p style="text-align: center;">
                        <img src="{{ public_path('/images/firmLesly.jfif') }}" width="250" height="112" />
                    </p>
                </td-->
                
            </tr>
        </table>

    </main>
    
    <footer>
        <p>www.motorgasperu.com</p>
    </footer>    
</body>
</html>