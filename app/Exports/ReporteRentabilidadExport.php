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

class ReporteRentabilidadExport implements FromView, ShouldAutoSize, WithStyles
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
        //dd($this->data);
    }
    public function view(): View
    {
        return view('rentabilidadTaller', ['data' => new HtmlString($this->data)]);
    }

    public function styles(Worksheet $sheet)
    {
        // Define the end rows for each table
        $endRows = [
            'A2:C3',  // Adjust this range based on the actual number of rows for the first table
            'A6:C7', // Adjust this range based on the actual number of rows for the second table
            'A10:I11', // Adjust this range based on the actual number of rows for the third table
            'A14:E16', // Adjust this range based on the actual number of rows for the fourth table
            'A19:E27'  // Adjust this range based on the actual number of rows for the fifth table
        ];

        foreach ($endRows as $range) {
            $sheet->getStyle($range)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        }

        // Encabezados en negrita para cada tabla
        $sheet->getStyle('A2:C2')->getFont()->setBold(true);
        $sheet->getStyle('A6:C6')->getFont()->setBold(true);
        $sheet->getStyle('A10:I10')->getFont()->setBold(true);
        $sheet->getStyle('A14:E14')->getFont()->setBold(true);
        $sheet->getStyle('A16:E16')->getFont()->setBold(true)->getColor()->setRGB('FF0000');
        $sheet->getStyle('A19:E19')->getFont()->setBold(true);

        // Establecer el ancho de la columna A
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('A')->setAutoSize(false);

        return [];
    }
}
