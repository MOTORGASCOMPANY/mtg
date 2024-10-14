<!-- resources/views/rptacomple.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte Completo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1, h2 {
            text-align: center;
            color: #4F46E5; /* Color índigo */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #C7D2FE; /* Fondo índigo claro */
        }
        .footer-table {
            width: 100%;
            border: none;
        }
        .footer-table td {
            border: none;
            padding: 8px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Reporte Completo</h1>
    <h2>Datos de la Tabla 1</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Inspector</th>
                <th>Anual GNV</th>
                <th>Conversión GNV</th>
                <th>Desmonte</th>
                <th>Duplicado</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @php
                $precios = $precios ?? [];
            @endphp
            @foreach ($data1 as $nombre => $servicio)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $nombre ?? 'N.A' }}</td>
                    <td>{{ $servicio['Revisión anual GNV'] ?? 0 }}</td>
                    <td>{{ $servicio['Conversión a GNV'] ?? 0 }}</td>
                    <td>{{ $servicio['Desmonte de Cilindro'] ?? 0 }}</td>
                    <td>{{ $servicio['Duplicado GNV'] ?? 0 }}</td>
                    <td>{{ number_format($precios[$nombre] ?? 0, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: right;">CIERRE DE EXTERNOS:</td>
                <td>{{ number_format(array_sum($precios), 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h2>Resumen de Talleres</h2>
    
    <h4>Pagos Semanales</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Talleres</th>
                <th>Encargados</th>
                <th>Tipo</th>
                <th>FAC O BOLT</th>
                <th>Observaciones</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($semanales as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data['taller'] }}</td>
                    <td>{{ $data['encargado'] ?? 'NA' }}</td>
                    <td>TALLER</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($data['total'], 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: right;">Total:</td>
                <td>S/{{ number_format(array_sum(array_column($semanales->toArray(), 'total')), 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h4>Pagos Diarios</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Talleres</th>
                <th>Encargados</th>
                <th>Tipo</th>
                <th>FAC O BOLT</th>
                <th>Observaciones</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diarios as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data['taller'] }}</td>
                    <td>{{ $data['encargado'] ?? 'NA' }}</td>
                    <td>TALLER</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($data['total'], 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: right;">Total:</td>
                <td>S/{{ number_format(array_sum(array_column($diarios->toArray(), 'total')), 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td>CIERRE TALLERES</td>
            <td>S/{{ number_format(array_sum(array_column($semanales->toArray(), 'total')) + array_sum(array_column($diarios->toArray(), 'total')), 2) }}</td>
        </tr>
        <tr>
            <td>CIERRE SEMANAL</td>
            <td>S/{{ number_format($cierreSemanal, 2) }}</td>
        </tr>
    </table>
</body>
</html>
