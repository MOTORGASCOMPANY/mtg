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

class ReporteCalcularSimpleExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles, WithColumnFormatting, WithStrictNullComparison
{
    use Exportable;

    public $iteration;
    private $data;


    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function title(): string
    {
        return 'Reporte Calcular MTC';
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function headings(): array
    {
        return [
            'N°',
            'Inspector',
            'Anual Gnv',
            'Conversion Gnv',
            'Desmonte',
            'Duplicado',
            'Total',
        ];
    }

    public function map($data): array
    {
        return [
            'N°' => $this->getIterationNumber(), 
            'Inspector' => $data['Inspector'] ?? 'N.E',
            'Anual Gnv' => $data['Anual Gnv'] ?? 'S.P',
            'Conversion Gnv' => $data['Conversion Gnv'] ?? 'S.P',
            'Desmonte' => $data['Desmonte'] ?? 'S.P',
            'Duplicado' => $data['Duplicado'] ?? 'S.P',
            'Total' => $data['Total'] ?? 'S.P',
        ];
    }
    protected function getIterationNumber()
{
    return ++$this->iteration;
}

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G' . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('1:1')->getFont()->setBold(true);

        return [];
    }

    /*public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Encontrar el número de filas en el conjunto de datos
                $rowCount = count($this->data) + 2; // +2 para incluir la fila de encabezado y empezar desde 1

                // Agregar una fila vacía después de cada grupo de datos del inspector
                $inspectorActual = null;

                for ($i = 2; $i <= $rowCount; $i++) {
                    $inspectorSiguiente = $event->sheet->getCell('B' . $i)->getValue();

                    if ($inspectorActual !== null && $inspectorActual !== $inspectorSiguiente) {
                        $event->sheet->insertNewRowBefore($i, 1);
                        $rowCount++; // Incrementar el número total de filas
                        $i++; // Saltar la fila que acabamos de agregar
                    }

                    $inspectorActual = $inspectorSiguiente;
                }
            },
        ];
    }*/
}
