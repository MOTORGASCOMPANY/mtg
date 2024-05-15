<?php

namespace App\Http\Livewire;

use App\Imports\ImportacionDeConversiones;
use App\Imports\ServicesImport;
use App\Models\ServiciosImportados;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportarConversiones extends Component
{
    use WithFileUploads;

    public $file;
    public $data,$headers,$estadoConversiones=false,$cuenta,$coincidencias;
    protected $listeners=["render"];

    public function render()
    {
        return view('livewire.importar-conversiones');
    }

    public function updatedFile($value){
        if(!empty($value)){
            $this->reset(["data","estadoConversiones","cuenta","coincidencias"]);
        }
    }

    //importa reporte anuales
    public function procesarConversiones()
    {      
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);        
        
        $path = $this->file->getRealPath();        
        $data = Excel::toArray([], $path)[0];
        //dd($data);
        
        if(!empty($data)&& ($data[2][7]=="CONVERSIONES DIARIAS CERTIFICADORA")){
            $this->estadoConversiones=true;            
            $this->headers = isset($data[6]) ?  array_column($data[6],null): [];
            $this->data=array_slice($data,7,(count($data)-6));  
            $this->coincidencias=$this->validaCoincidencias($this->data);
            $this->cuenta=count($this->data);
        }else{
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "El archivo no es válido", "icono" => "warning"]);
        }
        
       
    }

    public function cargarConversiones(){
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);       
        $path = $this->file->getRealPath();        
        try {
            $import=Excel::import(new ImportacionDeConversiones,$path);    
            $this->reset(["file","data","headers","estadoConversiones","cuenta","coincidencias"]);
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Los datos de su archivo fueron cargados correctamente!", "icono" => "success"]);                       
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Ocurrio un problema con los datos de su archivo: ".$e, "icono" => "warning"]);    
        }
    }

    public function validaCoincidencias($data){
        $cuenta=0;
        foreach($data as $row){
            $fecha=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]);
            $placa=$row[2];            
            $servicio=ServiciosImportados::where([['placa',$placa],['fecha',$fecha],['tipoServicio',1]])->first();            
            if($servicio!=null){
                $cuenta++;
            }          
        }        
        return $cuenta;
    }
}
