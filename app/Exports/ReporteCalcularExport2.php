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

    public function styles(Worksheet $sheet)
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
    }
}
