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
        <h5>Lima, {{$fecha}}</h5>
        <br>
        <p>Señor(a):</p>        
        <p>{{$idInspector}}</p>
        <br>
        <p>Asunto: Entrega de Materiales</p>   
        <p>Presente.-</p>     
        <p>De mi especial consideración.</p>
        <p>Por medio del presente me dirigo a usted, para saludarlo y hacerle llegar los siguientes materiales por parte de la empresa <strong>{{$empresa}}</strong></p>
       <p>{{$idAnulacion}}</p>
       <p>{{$idServicio}}</p>
        
        <p>Sin otro particular me despido;</p>

        <p>Atentamente.</p>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center;">
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                    <h4>_________________________</h4>
                    <h4><strong>Inspector</strong></ul>
                    <h4 style="text-align: left; margin-left: 50px;">Recibí Conforme</h4>
                    <h4 style="text-align: left; margin-left: 50px;">Dni :</h4>
                </td>
                
                <td style="text-align: center;">
                    <p style="text-align: center;">
                        <img src="{{ public_path('/images/firmLesly.jfif') }}" width="250" height="112" />
                    </p>
                </td>
                
            </tr>
        </table>

    </main>
    
    <footer>
        <p>www.motorgasperu.com</p>
    </footer>    
</body>
</html>