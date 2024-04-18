<?php

namespace App\Http\Livewire;

use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Documento;
use App\Models\Provincia;
use App\Models\Taller;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditarTaller extends Component
{

    use WithFileUploads;

    public $idTaller,$taller,$openEdit;
    
    public $departamentosTaller,$provinciasTaller,$distritosTaller,$logoTaller,$firmaTaller;

    public $logoNuevo=null;
    public $firmaNuevo=null;

    public $nuevoPdf,$documento;

    public $departamentoSel=Null;
    public $provinciaSel=Null;
    public $distritoSel=Null;

    protected $rules=[
        'taller.nombre'=>'required|min:5',
        'taller.direccion'=>'required|min:5',
        'taller.ruc'=>'required|digits:11',
        'taller.representante'=>'required|min:5',
        'taller.idDistrito'=>'required',        
        'logoNuevo'=>'nullable|mimes:jpg,bmp,png,jpeg,tif,tiff',
        'firmaNuevo'=>'nullable|mimes:jpg,bmp,png,jpeg,tif,tiff',      
        "doc.tipoDocumento"=>"required|numeric|min:1",        
        "doc.fechaInicio"=>"required|date",
        "doc.fechaExpiracion"=>"required|date",  
        "doc.nombreEmpleado"=>"required|string" 
      ];
    
    protected $listeners=["refrescaTaller"];
    

    public function mount(){
        $this->taller=Taller::find($this->idTaller);
        $this->departamentosTaller=Departamento::all();
        if($this->taller->idDistrito!=null) {
            $dist=Distrito::find($this->taller->idDistrito);
            $prov=Provincia::find($dist->idProv);
            $depa=Departamento::find($prov->idDepa);        
            
            $this->departamentoSel=$depa->id;
            $this->updatedDepartamentoSel($depa->id);
            $this->provinciaSel=$prov->id;
            $this->updatedProvinciaSel($prov->id);
        }
    } 

    public function render()
    {        
        return view('livewire.editar-taller');
    }

    public function abrirModal(Documento $doc){
        $this->documento=$doc;
        $this->openEdit=true;
    }

    public function updatedDepartamentoSel($depa){        
        $this->provinciasTaller=Provincia::where("idDepa",$depa)->get();  
        $this->provinciaSel=null;  
         
    }

    public function updatedProvinciaSel($prov){        
        $this->distritosTaller=Distrito::where("idProv",$prov)->get();               
        $this->distritoSel=null;          
    }
    
    public function refrescaTaller(){
        $this->taller->refresh();
    }

    public function actualizar(){
        
        $this->validate([
        'taller.nombre'=>'required|min:5',
        'taller.direccion'=>'required|min:5',
        'taller.ruc'=>'required|digits:11',
        'taller.representante'=>'required|min:5',
        'taller.idDistrito'=>'required',        
        'logoNuevo'=>'nullable|mimes:jpg,bmp,png,jpeg,tif,tiff',
        'firmaNuevo'=>'nullable|mimes:jpg,bmp,png,jpeg,tif,tiff',
        ]);
        if($this->logoNuevo){             
            $rutaLogo=$this->logoNuevo->storeAs('public/Logos','logo-'.$this->taller->ruc.'.'.$this->logoNuevo->extension());  
            $this->taller->rutaLogo=$rutaLogo;
        }
        if($this->firmaNuevo){            
            $rutaFirma=$this->firmaNuevo->storeAs('public/Firmas','firma-'.$this->taller->ruc.'.'.$this->firmaNuevo->extension()); 
            $this->taller->rutaFirma=$rutaFirma;
        }      
            
        
            if($this->taller->isDirty()){                
                $this->taller->save();
                $this->emit("CustomAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "Se actualizó el taller ".$this->taller->nombre, "icono" => "success"]);
            
            }
        
        
       
       
        //return redirect()->route('talleres');

    }

    public function cancelar(){
        
       
        
        switch (Auth::user()->roles->first()->id) {
            //case 5= administrador
            case 5:
                return redirect()->route('talleres');
                break;
            case 8:
                return redirect()->route('dashboard');
            default:
                # code...
                break;
        }
    }
}
