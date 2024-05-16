<?php

namespace App\Http\Livewire;

use App\Imports\ImportacionDesmontes;
use App\Models\ServiciosImportados;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportarDesmontes extends Component
{
    use WithFileUploads;

    public $file;
    public $data,$headers,$estadoDesmontes=false,$cuenta,$coincidencias;
    protected $listeners=["render"];

    public function render()
    {
        return view('livewire.importar-desmontes');
    }

    public function updatedFile($value){
        if(!empty($value)){
            $this->reset(["data","estadoDesmontes","cuenta","coincidencias"]);
        }
    }

    public function procesarDesmontes()
    {      
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);        
        
        $path = $this->file->getRealPath();        
        $data = Excel::toArray([], $path)[0]; 
        //dd($data);      
        if(!empty($data)){
            $this->estadoDesmontes=true;                        
            $this->headers = isset($data[0]) ?  array_column($data[0],null): [];           
            $this->data=array_slice($data,1,(count($data)-1));  
            $this->coincidencias=$this->validaCoincidencias($this->data);
            $this->cuenta=count($this->data);
        }else{
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "El archivo no es válido", "icono" => "warning"]);
        }       
       
    }

    public function cargarDesmontes(){
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);       
        $path = $this->file->getRealPath();        
        try {
            $import=Excel::import(new ImportacionDesmontes,$path);    
            $this->reset(["file","data","headers","estadoDesmontes","cuenta","coincidencias"]);
            $this->emit("minAlert", ["titulo"=>"¡EXCELENTE TRABAJO!", "mensaje" => "Los datos de su archivo fueron cargados correctamente!", "icono" => "success"]);                       
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Ocurrio un problema con los datos de su archivo: ".$e, "icono" => "warning"]);    
        }
    }

    public function validaCoincidencias($data){
        $cuenta=0;
        foreach($data as $row){
            //dd($row);
            $fecha=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]);
            $placa=$row[2];            
            $servicio=ServiciosImportados::where([['placa',$placa],['fecha',$fecha],['tipoServicio',6]])->first();            
            if($servicio!=null){
                $cuenta++;
            }          
        }        
        return $cuenta;
    }
}
