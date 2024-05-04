<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TallerSheet implements FromView
{
    protected $taller;
    protected $certificaciones;

    public function __construct($taller, $certificaciones)
    {
        //dd($taller, $certificaciones);
        $this->taller = $taller;
        $this->certificaciones = $certificaciones;
        
    }

    public function view(): View
    {
        return view('reporteTaller', [
            'taller' => $this->taller,
            'certificaciones' => $this->certificaciones,
        ]);
    }
}
