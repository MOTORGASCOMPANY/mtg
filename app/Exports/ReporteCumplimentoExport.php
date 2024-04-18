<?php

namespace App\Exports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReporteCumplimentoExport implements FromCollection,WithHeadings,WithMapping,ShouldAutoSize
{
    use Exportable;

    public $data;
    
    public function __construct($data) {
        $this->data=$data;
    }


    public function collection()
    {
        return $this->data;
    }


    public function headings(): array
    {
        return [
            '#',
            'Inspector',
            'Conteo Gasolution',
            'Conteo Sistema',
            'Porcentaje'
        ];
    }

    public function map($data): array
    {
        //dd(gettype($data));
        return [
            $data->index,
            $data->certificador,
            $data->serviciosGasolution,
            $data->serviciosMtg,
            $data->porcentaje,
        ];
    }



}
