<?php

namespace App\Exports;

// Importación necesaria para la clase Worksheet
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class ReporteCalcularExport2 implements FromView, ShouldAutoSize, WithStyles
{
    public $datae;

    public function __construct($datae)
    {
        $this->datae = $datae;
    }

    public function view(): View
    {
        return view('reporteCalcular', ['data' => new HtmlString($this->datae)]);
    }

    /*public function view(): View
    {
        // Suponiendo que exportData es un array con las claves 'data1' y 'data2'
        $data1 = $this->exportData['data1'];
        $data2 = $this->exportData['data2'];

        return view('reporteCalcular', [
            'data1' => new HtmlString($data1),
            'data2' => new HtmlString($data2)
        ]);
    }*/


    /*public function styles(Worksheet $sheet)
    {
        // bordes a todas las celdas
        $sheet->getStyle('A1:G' . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // encabezados sea negrita
        $sheet->getStyle('1:1')->getFont()->setBold(true);

        return [
            // 
        ];
    }*/

    public function styles(Worksheet $sheet)
    {
        // Estilo para el título en la primera fila (opcional)
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A1:G1'); // Fusionar celdas de la primera fila para el título
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center'); // Centrar el texto en la celda

        // Mantener la segunda fila vacía sin bordes ni estilo
        // Si quieres puedes omitir la segunda fila en los estilos

        // Aplicar bordes y negrita desde la tercera fila en adelante
        $highestRow = $sheet->getHighestRow(); // Obtener la última fila con datos

        // Aplicar bordes a todas las celdas desde la tercera fila
        $sheet->getStyle('A3:G' . $highestRow)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Hacer negrita la tercera fila (encabezados)
        $sheet->getStyle('A3:G3')->getFont()->setBold(true);

        // Recorre cada fila donde tienes datos para asegurar que los valores sean numéricos
        for ($row = 4; $row < $highestRow; $row++) {
            // Verifica si el valor en la columna G es un número
            $currentValue = $sheet->getCell('G' . $row)->getValue();

            // Si no es un número, intenta convertirlo
            if (!is_numeric($currentValue)) {
                // Remover comas o espacios innecesarios y convertir a número
                $numericValue = floatval(str_replace(',', '', $currentValue));
                $sheet->setCellValueExplicit('G' . $row, $numericValue, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            }
        }

        // Aplicar fórmula en la columna G para sumar los valores (desde la fila 4 hasta la penúltima fila)
        $sumRow = $highestRow; // La última fila es donde está el total

        // Formula en la celda de Total (fila $sumRow, columna G)
        $sheet->setCellValue('G' . $sumRow, '=SUM(G4:G' . ($sumRow - 1) . ')');

        // Aplicar formato numérico a la columna G (Monto)
        $sheet->getStyle('G4:G' . $sumRow)
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); // Formato para números con comas

        return [];
    }
}
