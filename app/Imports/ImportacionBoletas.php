<?php

namespace App\Imports;

use App\Models\Boleta;
use App\Models\Taller;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportacionBoletas implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $fechaInicio = Date::excelToDateTimeObject($row['fechainicio']);
        $fechaFin = Date::excelToDateTimeObject($row['fechafin']);

         // Buscar el ID del taller ignorando mayúsculas, minúsculas y espacios en blanco
         $tallerId = Taller::whereRaw('LOWER(REPLACE(nombre, " ", "")) = ?', [strtolower(str_replace(' ', '', $row['taller']))])->value('id');

         // Buscar el ID del certificador ignorando mayúsculas, minúsculas y espacios en blanco
         $certificadorId = User::whereRaw('LOWER(REPLACE(name, " ", "")) = ?', [strtolower(str_replace(' ', '', $row['certificador']))])->value('id');

        // Verificar si la boleta ya existe
        $boleta = Boleta::where([
            ['taller', $tallerId], //$row['taller']]
            ['certificador', $certificadorId], //$row['certificador']]
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
            "taller" => $tallerId, //$row['taller']
            "certificador" => $certificadorId, //$row['certificador']
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
