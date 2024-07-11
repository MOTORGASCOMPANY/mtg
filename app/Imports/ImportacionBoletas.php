<?php

namespace App\Imports;

use App\Models\Boleta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportacionBoletas implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $fechaInicio = Date::excelToDateTimeObject($row['fechainicio']);
        $fechaFin = Date::excelToDateTimeObject($row['fechafin']);

        // Verificar si la boleta ya existe
        $boleta = Boleta::where([
            ['taller', $row['taller']],
            ['certificador', $row['certificador']],
            ['fechaInicio', $fechaInicio],
            ['fechaFin', $fechaFin]
        ])->first();

        if ($boleta) {
            // Actualizar el registro existente
            $boleta->update([
                "identificador" => $row['identificador'],
                "anual" => $row['anual'],
                "duplicado" => $row['duplicado'],
                "inicial" => $row['inicial'],
                "desmonte" => $row['desmonte'],
                "monto" => $row['monto'],
                "observacion" => null,
                
            ]);
            return null; // No crear un nuevo registro
        }

        // Crear un nuevo registro si no existe
        return new Boleta([
            "identificador" => $row['identificador'],
            "taller" => $row['taller'],
            "certificador" => $row['certificador'],
            "fechaInicio" => $fechaInicio,
            "fechaFin" => $fechaFin,
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
