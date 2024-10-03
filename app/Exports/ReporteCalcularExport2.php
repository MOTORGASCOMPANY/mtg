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
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    /*public function view(): View
    {
        //dd($this->data);
        return view('reporteCalcular', ['data' => $this->data]);
    }*/
    public function view(): View
    {
        return view('reporteCalcular', ['data' => new HtmlString($this->data)]);
    }

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

        // Aplicar fórmula en la columna G para sumar los valores (desde la fila 4 hasta la penúltima fila)
        // Suponemos que la columna G es la del "Monto"
        $sumRow = $highestRow; // La última fila es donde está el total

        // Formula en la celda de Total (fila $sumRow, columna G)
        $sheet->setCellValue('G' . $sumRow, '=SUM(G4:G' . ($sumRow - 1) . ')');

        return [];

        return [];
    }
}
