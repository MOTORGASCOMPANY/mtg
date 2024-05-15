<?php

namespace App\Imports;

use App\Models\ServiciosImportados;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ImportacionDesmontes implements ToModel, WithHeadingRow, WithUpserts
{
    public function uniqueBy()
    {
        return 'placa_serie';
    }

    public function model(array $row)
    {             
        //dd($row);        
        return new ServiciosImportados([
            "idImportado" => $row['id'],
            "placa" => $row['placavehiculo'],
            "serie"=>$row['seriecilindro'],
            "certificador" => $row['certificador'],
            "taller" => $row['nombretaller'],
            "fecha" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fechadesmonte']),
            "precio"=>null,
            "tipoServicio"=>6,
            "estado"=>1,
            "pagado"=>false,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
