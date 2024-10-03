<!DOCTYPE html>
<html>

<head>
    <title>CONTRATO DE TRABAJO</title>
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
            font-size: 14px;
            text-align: justify;
        }

        image {
            margin-left: 2cm;
        }

        h3 {
            margin-top: 3cm;
            font-size: 15px;
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
            /*border: 1px solid;*/
            border-collapse: collapse;
        }

        table {
            width: 100%;
            border: none;
        }

        ol {
            list-style-type: lower-latin;
            font-size: 10px;
        }

        ul {
            font-size: 10px;
        }

        /* Estilo adicional para alinear las firmas */
        .signature {
            padding-top: 95px; /* Ajusta este valor para controlar el espacio vertical */
        }
    </style>
</head>

<body>
    <header>
        <p>
            <img src="{{ public_path('/images/images/logomemo.png') }}" width="850" height="150" />

        </p>
    </header>
    <main>
        <br>
        <h3>CONTRATO DE LOCACION DE SERVICIOS</h3>
        <div>
            <p>
                Conste por el presente documento que celebramos de una parte la empresa MOTOR GAS COMPANY S. A, con RUC
                N° 20472634501 con domicilio
                fiscal en Jr. San Pedro De Carabayllo N° 180 Urbanización Santa Isabel Distrito de Carabayllo, Provincia
                y Departamento de Lima, representado
                por Don <strong>LESLY PAMELA EGOAVIL LOMOTE</strong> identificada con DNI 74760461, a quien en adelante
                se denominará EL
                CONTRATANTE <strong>{{ $nombreEmpleado }}</strong>
                y por el otro parte identificado con DNI <strong>{{ $dniEmpleado }}</strong> , domiciliada en
                {{ $domicilioEmpleado }},
                quien en adelante se le denominará EL CONTRATADO bajo los términos siguientes:
            </p>
            <p>
                PRIMERO. - EL CONTRATANTE de conformidad con el Articulo 57 de la Ley de Productividad y Competitividad
                laboral se celebra el contrato por Naturaleza Temporal con el CONTRATADO por un periodo comprendido
                entre los días <strong>{{ $fechaInicio }} al {{ $fechaExpiracion }}</strong>.
            </p>
            <p>
                SEGUNDO. - EL CONTRATADO cumplirá las funciones de <strong>{{ $cargo }}</strong> en el proceso de
                Certificaciones
                Vehiculares de Conversiones a Gas Natural Vehicular – GNV, encargadas por el ministerio de Transportes y
                Comunicaciones con puntualidad, responsabilidad y cumplimiento con el horario de trabajo y todas las
                metas establecidas por la empresa y otras funciones que le designe el contratante.
            </p>
            <p>
                TERCERO. - EL CONTRATANTE se compromete a abonar por sus <strong>HONORARIOS DE INSPECTOR</strong> al
                CONTRATADO la suma de <strong>{{ $pago }}</strong>, en forma mensual por la integridad de
                los trabajos realizados previa presentación del informe de labores.
            </p>
            <p>
                CUARTO. - EL CONTRATADO asume las siguientes obligaciones que están vinculadas a la naturaleza propia
                del servicio que presentará. <br>
                - No realizar actividad alguna que pueda perjudicar a MOTOR GAS COMPANY S.A. <br>
                - Mantener la confidencialidad de la información de MOTOR GAS COMPANY S.A. <br>
                - Por la naturaleza propia de las labores que desempeña el contratado, deberá tener disposición para
                efectuar viajes por todas las distintas ciudades del País.
            </p>
            <p>
                QUINTO. - EL CONTRATADO en caso de una renuncia voluntaria deberá avisar a la Entidad Certificadora con
                plazo mínimo de 15 días y a su vez deberá guardar confidencialidad, no brindar información de la Entidad
                Certificadora a otras personas que no pertenecen a la empresa, en caso de no cumplir la cláusula habrá
                una penalidad por parte de la Entidad Certificadora.
            </p>
            <p>
                En caso de que el taller asignado dejará de laboral con nosotros o solicita el cambio de su persona, por
                falta de taller;
                se terminará el contrato. Ambas partes se ratifican en todos los extremos y firman en aceptación del
                presente contrato el día {{ $fechaInicio }}.
            </p>
        </div>

        <table style="width: 100%;">
            <tr>
                <td style="text-align: center;">
                    <img src="{{ public_path('/images/firmLesly.jfif') }}" width="200" height="95" />
                    <h4>_________________________</h4>
                    <h4><strong>Lesly Pamela Egoavil Lomote</strong> <br> Gerente General </h4>
                </td>
                <td style="text-align: center;" class="signature">
                    <h4>_________________________</h4>
                    <h4><strong>{{ $nombreEmpleado }}</strong> <br>{{ $dniEmpleado }} </h4>
                </td>
            </tr>
        </table>

    </main>


    <footer>


    </footer>
</body>

</html>
