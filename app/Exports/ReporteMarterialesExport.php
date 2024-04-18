<?php

namespace App\Exports;

//use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Material;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReporteMarterialesExport implements FromView
{
    public function view(): View
    {
        return view('reporteMateriales', [
            'materiales' => Material::where([["idTipoMaterial",1]])->get()
        ]);
    }
}
