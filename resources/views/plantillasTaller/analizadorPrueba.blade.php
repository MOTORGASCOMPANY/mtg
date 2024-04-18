<!DOCTYPE html>
<html>
<head>    
    <title>Voucher Analizador de Gases</title>
    <style>        
        @page {
            margin: 0cm 0cm;
           
        }
        body {           
            margin:2px 2px 2px;
            display: block;
            text-align: center;
            font-family: 'Courier New', Courier, monospace;
            min-height: 100vh;
        } 
        
        p{
            font-size: 10px;
        }    
    </style>
</head>
<body>
<p>
------------------------------------
Hermann Analizador gases HGA 400
<br/>
   Version-Software: 21/01/07
<br/>
fecha: {{$fecha->format('d.m.Y')}} Hora:  {{$fecha->format('h:i')}}
------------------------------------
PIERBURG INSTRUMENTS HGA 400 4GR
HOMOLOG.Nro-G002-2002-DGMA-MTC
RD No.721-2014-MTC/16 Serie:1138

    {{$taller->nombre}}

    {{$taller->direccion}}/Telefono: 981473070

------------------------------------

Vehiculo: __________________________

Placa:______________________________
------------------------------------
</p>

    <table style=" font-size: 11px; width: 94%; margin: auto;">
        <tr>
            <td>CO</td>
            <td style="text-align:right;">[% vol]:</td>
            <td style="text-align:right;">0.36</td>
        </tr>
        <tr>
            <td>HC hexano</td>
            <td style="text-align:right;">[ppm vol]:</td>
            <td style="text-align:right;">43</td>
        </tr>
        <tr>
            <td>CO2</td>
            <td style="text-align:right;">[%vol]:</td>
            <td style="text-align:right;">12.09</td>
        </tr>
        <tr>
            <td>O2</td>
            <td style="text-align:right;">[%vol]:</td>
            <td style="text-align:right;">0.06</td>
        </tr>
        <tr>
            <td>Lambda</td>
            <td style="text-align:right;">[-]:</td>
            <td style="text-align:right;">1.191</td>
        </tr>
        <tr>
            <td>CO+CO2</td>
            <td style="text-align:right;">[%vol]:</td>
            <td style="text-align:right;">12.45</td>
        </tr>
        <tr>
            <td>Rpm</td>
            <td style="text-align:right;">[1/min]:</td>
            <td style="text-align:right;">2539</td>
        </tr>
        <tr>
            <td>Temp. motor.</td>
            <td style="text-align:right;">[°C]:</td>
            <td style="text-align:right;">78</td>
        </tr>
        
    </table>
<p>
------------------------------------

Aprobado:
<span style="font-family: DejaVu Sans, sans-serif; font-size: 18px">▢</span> 
<br> 

                             ┌─┐
Desaprobado:                 └─┘
--------------------------------
 


--------------------------------
Hermann Analizador gases HGA 400
   Version-Software: 21/01/07
fecha: 03.03.2021  Hora:  10: 34
--------------------------------
PIERBURG INSTRUMENTS HGA 400 4GR
HOMOLOG.Nro-G002-2002-DGMA-MTC
RD No.721-2014-MTC/16 Serie:1138
    J.R. AUTOMOTRICES S.A.C.
Av Universitaria norte No.9460 
COMAS/Telefono: 981473070

--------------------------------
Vehiculo: ______________________
Placa:    ______________________
--------------------------------
CO               [% vol]:  0.32
HC hexano      [ppm vol]:    55
CO2              [% vol]: 12.11
O2               [% vol]:  1
Lambda               [-]: 1.169
CO+CO2            [%vol]: 12.43
Rpm              [1/min]:   831
Temp. motor.        [°C]:    80
--------------------------------
                             ┌─┐
Aprobado:                    └─┘
                             ┌─┐
Desaprobado:                 └─┘
--------------------------------





--------------------------------
Hermann Analizador gases HGA 400
   Version-Software: 21/01/07
fecha: 03.03.2021  Hora:  10: 36
--------------------------------
PIERBURG INSTRUMENTS HGA 400 4GR
HOMOLOG.Nro-G002-2002-DGMA-MTC
RD No.721-2014-MTC/16 Serie:1138
    J.R. AUTOMOTRICES S.A.C.
Av Universitaria norte No.9460 
COMAS/Telefono: 981473070

--------------------------------
Vehiculo: ______________________
Placa:    ______________________
--------------------------------
CO               [% vol]:  0.29
HC propano     [ppm vol]:    72
CO2              [% vol]: 12.08
O2               [% vol]:  2.3
Lambda           [% vol]: 1.138
CO+CO2               [-]: 12.37
Rpm              [1/min]:  2522
Temp. motor.        [°C]:    77
--------------------------------
                             ┌─┐
Aprobado:                    └─┘
                             ┌─┐
Desaprobado:                 └─┘
--------------------------------



--------------------------------
Hermann Analizador gases HGA 400
   Version-Software: 21/01/07
fecha: 03.03.2021  Hora:  10: 37
--------------------------------
PIERBURG INSTRUMENTS HGA 400 4GR
HOMOLOG.Nro-G002-2002-DGMA-MTC
RD No.721-2014-MTC/16 Serie:1138
    J.R. AUTOMOTRICES S.A.C.
Av Universitaria norte No.9460 
COMAS/Telefono: 981473070

--------------------------------
Vehiculo: ______________________
Placa:    ______________________
--------------------------------
CO               [% vol]:  0.3
HC propano     [ppm vol]:    73
CO2              [% vol]: 12.07
O2               [% vol]:  2.6
Lambda               [-]: 1.113
CO+CO2            [%vol]: 12.37
Rpm              [1/min]:   779
Temp. motor.        [°C]:    79
--------------------------------
                             ┌─┐
Aprobado:                    └─┘
                             ┌─┐
Desaprobado:                 └─┘
--------------------------------
    </p>
       
</body>
</html>