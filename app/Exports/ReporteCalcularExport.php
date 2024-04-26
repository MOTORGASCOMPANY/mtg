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
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER_00,
            'G' =>  NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function headings(): array
    {
        return [
            'Placa',
            'Taller',
            'Inspector',
            'Servicio',
            'Hoja',
            'Precio',
            'Fecha',
            'Estado',
            'Pagado',
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


        switch ($data['tipo_modelo']) {
            case 'App\Models\Certificacion':
                return [
                    $secondPart, //$data['placa'] ?? 'EN TRAMITE'
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $data['servicio'] ?? 'N.A',
                    $data['num_hoja'] ?? 'N.E',
                    $precio ?? 'S.P',
                    $fecha ?? 'S.F',
                    $data['estado'] ?? 'S.E',
                    $data['pagado'],
                    'certificacion',
                ];
                break;
            case 'App\Models\CertificacionPendiente':
                return [
                    $data['placa'] ?? 'EN TRAMITE',
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $data['servicio'] ?? 'N.A',
                    $data['num_hoja'] ?? 'N.E',
                    $precio ?? 'S.P',
                    $fecha ?? 'S.F',
                    $data['estado'] ?? 'S.E',
                    $data['pagado'],
                    'certificacion pendiente',
                ];
                break;
            case 'App\Models\ServiciosImportados':
                return [
                    $data['placa'] ?? 'EN TRAMITE',
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $data['servicio'] ?? 'N.A',
                    $data['num_hoja'] ?? 'N.E',
                    $precio ?? 'S.P',
                    $fecha ?? 'S.F',
                    $data['estado'] ?? 'S.E',
                    $data['pagado'],
                    'discrepancia'
                ];
                break;

            default:
                return [
                    $data['placa'] ?? 'EN TRAMITE',
                    $data['taller'] ?? 'N.A',
                    $data['inspector'] ?? 'N.A',
                    $data['servicio'] ?? 'N.A',
                    $data['num_hoja'] ?? 'N.E',
                    $precio ?? 'S.P',
                    $fecha ?? 'S.F',
                    $data['estado'] ?? 'S.E',
                    $data['pagado'],
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
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        return [];
    }
}
