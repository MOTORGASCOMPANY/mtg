<!DOCTYPE html>
<html>

<head>
    <title>MEMORANDO</title>
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
            font-size: 12px;
            text-align: justify;
        }

        image {
            margin-left: 2cm;
        }

        h3 {
            margin-top: 3cm;
            font-size: 25px;
            color: black;
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
        <br>
        <br>
        <h3>MEMORANDUM</h3>
        <br>
        <div>
            <p>Lima {{ $fecha }}</p>
            <p>DE: {{ $remitente }}</p>
            <p><strong>{{ $cargoremi }}</strong></p>
            <p>PARA: {{ $idUser }}</p>
            <p><strong>{{ $cargo }}</strong></p>
        </div>
        <div>
            <p>De mi consideración.</p>
            <p>Señor {{ $idUser }}, por medio del presente me dirijo a usted para hacer de su conocimiento que es
                el {!! nl2br(e($motivo ?? null)) !!}
            </p>
            <p>Sin otra particular</p>
            <p>Atentamente.</p>
        </div>
        <br>
        <br>
        <br>
        <br>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center;">
                    <p style="text-align: center;">
                        @if ($remitente == 'LOPEZ HENRIQUEZ SPASOJE BRATZO')
                            <img src="{{ public_path('/images/firmaIng.png') }}" width="250" height="100" />
                        @elseif ($remitente == 'LESLY PAMELA EGOAVIL LOMOTE')
                            <img src="{{ public_path('/images/firmaJR.png') }}" width="250" height="100" />
                        @else
                        @endif
                    </p>
                    <h4>-------------------------------------------------------</h4>
                    <h4><strong>{{ $remitente }}</strong></h4>
                    <h4><strong>Área: {{ $cargoremi }}</strong></h4>
                </td>
                <td style="text-align: center;">
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                    <h4></h4>
                    <h4>-------------------------------------------------------</h4>
                    <h4><strong>INSPECTOR</strong></ul>
                        <h4></h4>
                        <h4></h4>
                </td>
            </tr>
        </table>

    </main>


    <footer>


    </footer>
</body>

</html>
