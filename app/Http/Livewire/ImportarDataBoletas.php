<?php

namespace App\Http\Livewire;

use App\Imports\ImportacionBoletas;
use App\Models\Boleta;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportarDataBoletas extends Component
{
    use WithFileUploads;

    public $file;
    public $data, $headers, $estadoBoletas = false, $cuenta, $coincidencias;
    protected $listeners = ["render"];

    public function render()
    {
        return view('livewire.importar-data-boletas');
    }

    public function updatedFile($value)
    {
        if (!empty($value)) {
            $this->reset(["data", "estadoBoletas", "cuenta", "coincidencias"]);
        }
    }

    public function procesarBoletas()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $path = $this->file->getRealPath();
        $data = Excel::toArray([], $path)[0];
        if (!empty($data)) {
            $this->estadoBoletas = true;
            $this->headers = isset($data[0]) ?  array_column($data[0],null): [];
            //$this->headers = isset($data[0]) ? array_keys($data[0]) : [];
            $this->data = array_slice($data, 1, (count($data) - 1));
            $this->coincidencias = $this->validaCoincidencias($this->data);
            $this->cuenta = count($this->data);
        } else {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "El archivo no es válido", "icono" => "warning"]);
        }
    }

    public function cargarBoletas(){
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);       
        $path = $this->file->getRealPath();        
        try {
            $import=Excel::import(new ImportacionBoletas,$path);    
            $this->reset(["file","data","headers","estadoBoletas","cuenta","coincidencias"]);
            $this->emit("minAlert", ["titulo"=>"¡EXCELENTE TRABAJO!", "mensaje" => "Los datos de su archivo fueron cargados correctamente!", "icono" => "success"]);                       
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Ocurrio un problema con los datos de su archivo: ".$e, "icono" => "warning"]);    
        }
    }

    /*public function cargarBoletas()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $path = $this->file->getRealPath();
        try {
            foreach ($this->data as $row) {
                $taller = $row[0];
                $certificador = $row[1];
                $fechaInicio = Date::excelToDateTimeObject($row[2]);
                $fechaFin = Date::excelToDateTimeObject($row[3]);

                $boleta = Boleta::where([['taller', $taller], ['certificador', $certificador], ['fechainicio', $fechaInicio], ['fechafin', $fechaFin]])->first();

                if ($boleta) {
                    // Actualizar el registro existente
                    $boleta->update([
                        "anual" => $row[4],
                        "duplicado" => $row[5],
                        "inicial" => $row[6],
                        "desmonte" => $row[7],
                        "monto" => $row[8],
                        "observacion" => null,
                    ]);
                } else {
                    // Crear un nuevo registro
                    Boleta::create([
                        "taller" => $taller,
                        "certificador" => $certificador,
                        "fechaInicio" => $fechaInicio,
                        "fechaFin" => $fechaFin,
                        "anual" => $row[4],
                        "duplicado" => $row[5],
                        "inicial" => $row[6],
                        "desmonte" => $row[7],
                        "monto" => $row[8],
                        "observacion" => null,
                    ]);
                }
            }

            $this->reset(["file", "data", "headers", "estadoBoletas", "cuenta", "coincidencias"]);
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Los datos de su archivo fueron cargados correctamente!", "icono" => "success"]);
        } catch (\Exception $e) {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Ocurrió un problema con los datos de su archivo: " . $e->getMessage(), "icono" => "warning"]);
        }
    }*/

    public function validaCoincidencias($data)
    {
        $cuenta = 0;
        foreach ($data as $row) {
            $taller = $row[1];
            $certificador = $row[2];
            //$fechaInicio=$row[2]; 
            //$fechaFin=$row[3]; 
            $fechaInicio = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]);
            $fechaFin = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]);
            $servicio = Boleta::where([['taller', $taller], ['certificador', $certificador], ['fechainicio', $fechaInicio], ['fechafin', $fechaFin]])->first();
            if ($servicio != null) {
                $cuenta++;
            }
        }
        return $cuenta;
    }
}
