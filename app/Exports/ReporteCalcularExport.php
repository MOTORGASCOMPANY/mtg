<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ReporteCalcularExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles, WithColumnFormatting, WithStrictNullComparison
{
    use Exportable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
        //dd($this->data);
    }

    public function collection()
    {
        return $this->data;
        //return collect($this->data);
    }

    public function title(): string
    {
        return 'Reporte Calcular MTC';
    }

    public function columnFormats(): array
    {
        return [
            'A' =>  NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

    public function headings(): array
    {
        return [
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

    /*public function map($data): array
    {
        return [
            $data->taller ?? 'N.A',
            $data->nombre ?? 'N.A',
            $data->matenumSerie ?? 'N.A',
            $data->placa ?? 'EN TRAMITE',
            $data->tiposervicio ?? 'N.E',
            $data->created_at ?? 'S.F',
            $data->estado,
            $data->pagado,
            $data->precio ?? 'S.P',
        ];
    }*/

    public function map($data): array
    {
        $fecha = date('Y-m-d h:i:s', strtotime($data['fecha']));
        $precio = number_format($data['precio'], 2);
        $secondPart = '';
        // Verificar si el servicio es "Chip por deterioro"
        if ($data['servicio'] == 'Chip por deterioro') {
            // Obtener la ubicación después del primer '/' si está disponible
            $ubicacionParts = explode('/', $data['ubi_hoja']);
            $secondPart = isset($ubicacionParts[1]) ? trim($ubicacionParts[1]) : 'N.A';
        } else {
            // Si no es "Chip por deterioro", se devuelve la placa
            $secondPart = $data['placa'] ?? 'EN TRAMITE';
        }

        // Determinar el valor de 'externo' y 'anulado'
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

        // Determinar el valor de 'externo'
        $externo = isset($data['externo']) ? ($data['externo'] == 1 ? 'Externo' : null) : null;

        // Filtrar por tipo_modelo y estado
        /*if ($data['tipo_modelo'] === 'App\Models\Certificacion' && $data['estado'] === 2) {
            return [];
        }*/


        switch ($data['tipo_modelo']) {
            case 'App\Models\Certificacion':
                return [
                    $fecha ?? 'S.F',
                    $data['num_hoja'] ?? 'N.E',
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $secondPart, //$data['placa'] ?? 'EN TRAMITE'
                    $data['servicio'] ?? 'N.A',
                    '',
                    $externoyanulado ?? null,
                    $precio ?? 'S.P',
                    'certificacion',
                ];
                break;
            case 'App\Models\CertificacionPendiente':
                return [
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
                return [
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
                return [
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
    }

    /*public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I' . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('1:1')->getFont()->setBold(true);

        return [];
    }*/

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Aplicar estilos condicionales
        for ($i = 2; $i <= $lastRow; $i++) {
            $style = $sheet->getCell('J' . $i)->getValue();

            if ($style === 'certificacion') {
                $sheet->getStyle('A1:I' . $sheet->getHighestRow())
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            } elseif ($style === 'discrepancia') {
                $sheet->getStyle('A' . $i . ':I' . $i)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFC0CB'],
                    ],
                ])
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        }

        // Aplicar estilos a los encabezados
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        // Agregar la fórmula de suma en la columna I, después de la última fila de datos
        $lastDataRow = $lastRow + 1; // La fila donde se colocará la fórmula
        $sumFormula = "=SUM(I2:I{$lastRow})";

        // Iterar sobre los datos para construir la fórmula que excluya las filas anuladas
        $excludeConditions = [];
        foreach ($this->data as $index => $item) {
            if ($item['tipo_modelo'] === 'App\Models\Certificacion' && $item['estado'] == 2) {
                $rowIndex = $index + 2; // Ajustar índice debido a la fila de encabezado
                $excludeConditions[] = "I{$rowIndex}";
            }
        }

        if (!empty($excludeConditions)) {
            $excludeFormula = implode(",", $excludeConditions);
            $sumFormula = "=SUM(I2:I{$lastRow}) - SUM({$excludeFormula})";
        }

        $sheet->setCellValue("I{$lastDataRow}", $sumFormula);

        // Aplicar formato de número a la celda de la suma
        $sheet->getStyle("I{$lastDataRow}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);

        // Aplicar estilos a la fila de la suma
        $sheet->getStyle("I{$lastDataRow}")->applyFromArray([
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
