<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
//use Maatwebsite\Excel\Concerns\WithEvents;
//use Maatwebsite\Excel\Events\AfterSheet;

class ReporteTallerRsmnExport implements FromView, ShouldAutoSize, WithStyles //, WithEvents
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
        $sheet->getStyle('A2:G19')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Bordes a todas las celdas de la segunda tabla (de A7 a G9)
        $sheet->getStyle('A22:G31')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Encabezado de la primera tabla (negrita en A2:G2)
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // Encabezado de la segunda tabla (negrita en A7:G7)
        $sheet->getStyle('A21:G21')->getFont()->setBold(true);

        return [
            // Puedes agregar más estilos personalizados aquí
        ];
    }

    /*public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Fórmula para el total de la primera tabla en G4 (sumar los valores de la columna G)
                $sheet->setCellValue('G19', '=SUM(G3)'); // Ajusta G3 al rango de valores en tu tabla

                // Fórmula para el total de la segunda tabla en G9 (sumar los valores de la columna G)
                $sheet->setCellValue('G31', '=SUM(G23)'); // Ajusta G8 al rango de valores en tu tabla
            },
        ];
    }*/

}
