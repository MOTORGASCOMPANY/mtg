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

class ReporteTallerRsmnExport implements FromView, ShouldAutoSize, WithStyles 
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function view(): View
    {
        return view('reporteTaller', ['data' => new HtmlString($this->data)]);
    }

    public function styles(Worksheet $sheet)
    {
        // Bordes a todas las celdas de la primera tabla (de A2 a G4)
        $sheet->getStyle('A3:G20')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Bordes a todas las celdas de la segunda tabla (de A7 a G9)
        $sheet->getStyle('A23:G32')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Bordes a todas las celdas de la tercera tabla (de A7 a G9)
        $sheet->getStyle('F34:G34')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Encabezado de la primera tabla (negrita en A2:G2)
        //$sheet->getStyle('A2:G2')->getFont()->setBold(true);

        // Encabezado de la segunda tabla (negrita en A7:G7)
        //$sheet->getStyle('A22:G22')->getFont()->setBold(true);

        // Formato de dos decimales para la columna G (totales)
        $sheet->getStyle('G:G')->getNumberFormat()->setFormatCode('#,##0.00');

        return [
            // Puedes agregar más estilos personalizados aquí
        ];
    } 
}
