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
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ReporteDetalladoGasolExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles, WithColumnFormatting, WithStrictNullComparison
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
        static $rowNumber = 1;
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
        
        switch ($data['tipo_modelo']) {
            case 'App\Models\Certificacion':
                return [
                    $rowNumber++,
                    $fecha ?? 'S.F',
                    $data['num_hoja'] ?? 'N.E',
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $secondPart, //$data['placa'] ?? 'EN TRAMITE'
                    $data['servicio'] ?? 'N.A',
                    '',
                    '',
                    $precio ?? 'S.P',
                    //'certificacion',
                ];
                break;
            case 'App\Models\CertificacionPendiente':
                return [
                    $rowNumber++,
                    $fecha ?? 'S.F',
                    $data['num_hoja'] ?? 'N.E',
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $data['placa'] ?? 'EN TRAMITE',
                    $data['servicio'] ?? 'N.A',
                    //$data['estado'] ?? 'S.E',
                    //$data['pagado'],
                    '',
                    '',
                    $precio ?? 'S.P',
                    //'certificacion pendiente',
                ];
                break;
            case 'App\Models\ServiciosImportados':
                return [
                    $rowNumber++,
                    $fecha ?? 'S.F',
                    $data['num_hoja'] ?? null,
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $data['placa'] ?? 'EN TRAMITE',
                    $data['servicio'] ?? 'N.A',
                    '',
                    '',
                    $precio ?? 'S.P',
                    //'gasolution'
                ];
                break;

            default:
                return [
                    $rowNumber++,
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
        $lastRow = $sheet->getHighestRow();

        // Aplicar estilos condicionales
        for ($i = 2; $i <= $lastRow; $i++) {
            $style = $sheet->getCell('J' . $i)->getValue();

            if ($style === 'certificacion') {
                $sheet->getStyle('A1:I' . $sheet->getHighestRow())
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            } elseif ($style === 'gasolution') {
                $sheet->getStyle('A' . $i . ':I' . $i)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFFFFF'],
                    ],
                ])
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        }

        // Aplicar estilos a los encabezados
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ])
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);;

        return [];
    }*/
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow(); // Obtiene la última fila con datos
        $columnJ = 'J';


        // Añadir la suma de la columna I al final
        $sumCell = $columnJ . ($highestRow + 1);
        $sheet->setCellValue($sumCell, "=SUM(J2:J$highestRow)");

        // Aplicar formato de número con dos decimales a la celda de la suma
        $sheet->getStyle($sumCell)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);

        // bordes a todas las celdas
        $sheet->getStyle('A1:J' . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // encabezados sea negrita
        $sheet->getStyle('1:1')->getFont()->setBold(true);

        return [
            // 
        ];
    }
}
