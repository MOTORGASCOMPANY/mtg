<?php

namespace App\Imports;

use App\Models\Boleta;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportacionBoletas implements ToModel, WithHeadingRow   //, WithUpserts
{
    /*public function uniqueBy()
    {
        return 'placa_serie';
    }*/

    public function model(array $row)
    {
        //dd($row);        
        return new Boleta([
            "taller" => $row['taller'],
            "certificador" => $row['certificador'],
            "fechaInicio" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fechainicio']),
            "fechaFin" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fechafin']),
            "anual" => $row['anual'],
            "duplicado" => $row['duplicado'],
            "inicial" => $row['inicial'],
            "desmonte" => $row['desmonte'],
            "monto" => $row['monto'],
            "observacion" => null,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
