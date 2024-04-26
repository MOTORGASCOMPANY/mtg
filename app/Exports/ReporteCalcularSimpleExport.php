<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReporteCalcularSimpleExport implements FromView
{
    public function view(): View
    {
        return view('reporteCalcular');
    }
}
