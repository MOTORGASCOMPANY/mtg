<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReporteCalcularExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles, WithColumnFormatting, WithStrictNullComparison
{
    use Exportable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Reporte Calcular MTC';
    }

    public function columnFormats(): array
    {
        return [
            'B' =>  NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER_00,
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'FECHA',
            'N° CERTIFICADO',
            'TALLER',
            'INSPECTOR',
            'PLACA',
            'SERVICIO',
            'FAC O BOLT',
            'OBSERVACIONES',
            'MONTO',
        ];
    }

    public function map($data): array
    {
        static $rowNumber = 1;  // Static variable to keep track of row numbers

        $fecha = date('Y-m-d h:i:s', strtotime($data['fecha']));
        $precio = number_format($data['precio'], 2);
        $secondPart = '';

        if ($data['servicio'] == 'Chip por deterioro') {
            $ubicacionParts = explode('/', $data['ubi_hoja']);
            $secondPart = isset($ubicacionParts[1]) ? trim($ubicacionParts[1]) : 'N.A';
        } else {
            $secondPart = $data['placa'] ?? 'EN TRAMITE';
        }

        $externoyanulado = null;
        if (isset($data['externo']) && $data['externo'] == 1) {
            $externoyanulado = 'Externo';
        }
        if ($data['estado'] == 2) {
            if ($externoyanulado !== null) {
                $externoyanulado .= ', Anulado';
            } else {
                $externoyanulado = 'Anulado';
            }
        }

        $externo = isset($data['externo']) ? ($data['externo'] == 1 ? 'Externo' : null) : null;

        // Definir el valor en la columna "Observaciones" para diferenciar si solo está en Certificacion
        $observacion = isset($data['solo_en_certificacion']) && $data['solo_en_certificacion'] ? 'null' : '';
        // Concatenar externoyanulado y observacion
        $observacionFinal = trim($externoyanulado . ($externoyanulado && $observacion ? ', ' : '') . $observacion);
        $observacionFinal = $observacionFinal !== '' ? $observacionFinal : null; // Si está vacío, poner null

        $mappedData = [];

        switch ($data['tipo_modelo']) {
            case 'App\Models\Certificacion':
                $mappedData = [
                    $rowNumber++,  // Increment the row number for each row
                    $fecha ?? 'S.F',
                    $data['num_hoja'] ?? 'N.E',
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $secondPart,
                    $data['servicio'] ?? 'N.A',
                    '',
                    $observacionFinal ?? null,
                    $precio ?? 'S.P',
                    'certificacion',
                ];
                break;
            case 'App\Models\CertificacionPendiente':
                $mappedData = [
                    $rowNumber++,  // Increment the row number for each row
                    $fecha ?? 'S.F',
                    $data['num_hoja'] ?? 'N.E',
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $data['placa'] ?? 'EN TRAMITE',
                    $data['servicio'] ?? 'N.A',
                    '',
                    $externo ?? null,
                    $precio ?? 'S.P',
                    'certificacion pendiente',
                ];
                break;
            case 'App\Models\ServiciosImportados':
                $mappedData = [
                    $rowNumber++,  // Increment the row number for each row
                    $fecha ?? 'S.F',
                    $data['num_hoja'] ?? 'N.E',
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $data['placa'] ?? 'EN TRAMITE',
                    $data['servicio'] ?? 'N.A',
                    '',
                    '',
                    $precio ?? 'S.P',
                    'discrepancia'
                ];
                break;
            default:
                $mappedData = [
                    $rowNumber++,  // Increment the row number for each row
                    $fecha ?? 'S.F',
                    $data['num_hoja'] ?? 'N.E',
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $data['placa'] ?? 'EN TRAMITE',
                    $data['servicio'] ?? 'N.A',
                    '',
                    '',
                    $precio ?? 'S.P',
                    'certificacion',
                ];
                break;
        }

        return $mappedData;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Aplicar estilos condicionales
        for ($i = 2; $i <= $lastRow; $i++) {
            $style = $sheet->getCell('K' . $i)->getValue();

            if ($style === 'certificacion') {
                $sheet->getStyle('A1:J' . $sheet->getHighestRow())
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            } elseif ($style === 'discrepancia') {
                $sheet->getStyle('A' . $i . ':J' . $i)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFC0CB'],
                    ],
                ])
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }

            // Colorear de amarillo las filas de certificaciones anuladas
            $dataRow = $this->data[$i - 2]; // Ajustar índice por la fila de encabezado
            if ($dataRow['tipo_modelo'] === 'App\Models\Certificacion' && $dataRow['estado'] == 2) {
                $sheet->getStyle('A' . $i . ':J' . $i)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFFF00'],
                    ],
                ]);
            }
        }

        // Aplicar estilos a los encabezados
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        // Agregar la fórmula de suma en la columna J, después de la última fila de datos
        $lastDataRow = $lastRow + 1;
        $sumFormula = "=SUM(J2:J{$lastRow})";

        $excludeConditions = [];
        foreach ($this->data as $index => $item) {
            if ($item['tipo_modelo'] === 'App\Models\Certificacion' && $item['estado'] == 2) {
                $rowIndex = $index + 2;
                $excludeConditions[] = "J{$rowIndex}";
            }
        }

        if (!empty($excludeConditions)) {
            $excludeFormula = implode(",", $excludeConditions);
            $sumFormula = "=SUM(J2:J{$lastRow}) - SUM({$excludeFormula})";
        }

        $sheet->setCellValue("J{$lastDataRow}", $sumFormula);

        $sheet->getStyle("J{$lastDataRow}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);

        $sheet->getStyle("J{$lastDataRow}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        return [];
    }
}
