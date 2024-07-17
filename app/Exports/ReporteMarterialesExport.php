<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class ReporteMarterialesExport implements FromView, ShouldAutoSize, WithStyles
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function view(): View
    {
        return view('reporteMateriales', ['data' => new HtmlString($this->data)]);
    }

    public function styles(Worksheet $sheet)
    {
        // bordes a todas las celdas
        $sheet->getStyle('A1:F' . $sheet->getHighestRow())
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
