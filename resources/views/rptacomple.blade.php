<!DOCTYPE html>
<html>

<head>
    <title>Vacacion Asignada</title>
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
            font-size: 18px;
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
            padding-top: 80px;
            /* Ajusta este valor para controlar el espacio vertical */
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
        <h3>CONSTANCIA</h3>
        <div>
            <p>Lima {{ $fechaBase }}</p>
            <p>DE: MOTOR GAS COMPANY</p>
            <p><strong>ENTIDAD CERTIFICADORA</strong></p>
            <p>PARA: {{ $inspector }}</p>
            <p><strong>{{ $cargo }}</strong></p>
        </div>
        <div>
            <p><strong>ASUNTO: Vacaciones del Inspector</strong></p>
        </div>
        <div>
            <p>
                De mi consideracion.
            </p>
            <p>
                Señor {{ $inspector }}, por medio del presente me dirijo a usted para hacer de su conocimiento
                que esta haciendo uso de sus vacaciones que empiezan el dia {{ $empieza }} y terminan el dia
                {{ $termina }}.
            </p>
            <p>
                Sin otra particular
            </p>
            <p>
                Atentamente.
            </p>
        </div>

        <br>
        <br>
        <br>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center;">
                    <img src="{{ public_path('/images/firmLesly.jfif') }}" width="200" height="95" />
                    <h4>_________________________</h4>
                    <h4><strong>Lesly Pamela Egoavil Lomote</strong> <br> Gerente General </h4>
                </td>
                <td style="text-align: center;" class="signature">
                    <h4>_________________________</h4>
                    <h4><strong></strong>{{ $inspector }} <br></h4>
                </td>
            </tr>
        </table>

    </main>


    <footer>


    </footer>
</body>

</html>
