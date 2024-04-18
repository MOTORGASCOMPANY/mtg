<?php

namespace App\Http\Livewire\Reportes;

use App\Models\ServiciosImportados;
use Livewire\Component;
use Livewire\WithPagination;

class AdministracionDeServiciosImportados extends Component
{
    use WithPagination;

    public $sort,$direction,$cant,$search,$servicio,$permisos,$fechaInicio,$fechaFin;
    public $selectedPermisos=[];
    public $editando=false;

    protected $rules=[
        "servicio.precio"=>"required|numeric",
        //"selectedPermisos"=>"array|min:1",
    ];

    protected $listeners=["render"];

    public function mount(){
        $this->direction='desc';
        $this->sort='id';       
        $this->cant=10;   
        $this->fechaInicio='';
       $this->fechaFin='';    
    }
    
    public function render()
    {
        $servicios_importados=ServiciosImportados::where([['placa','like','%'.$this->search.'%']])
        ->rangoFecha($this->fechaInicio,$this->fechaFin)
        ->orderBy($this->sort,$this->direction)
        ->paginate($this->cant);
        return view('livewire.reportes.administracion-de-servicios-importados',compact("servicios_importados"));
    }


    public function order($sort)
    {
        if($this->sort=$sort){
            if($this->direction=='desc'){
                $this->direction='asc';
            }else{
                $this->direction='desc';
            }
        }else{
            $this->sort=$sort;
            $this->direction='asc';
        }        
    }

    public function editar(ServiciosImportados $si){
        $this->servicio=$si;
        $this->editando=true;
    }

    public function actualizar(){
        $this->validate();
        $this->servicio->save();
        $this->reset(["editando"]);
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Se actualizó correctamente el servicio", "icono" => "success"]); 
    }
}
