<?php

namespace App\Http\Livewire;

use App\Models\CertificacionTaller;
use App\Models\Taller;
use App\Models\TipoMaterial;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class AdministracionCerTaller extends Component
{
    
    use WithPagination;

    public $search, $sort, $direction, $cant, $user, $fechaFin, $inspectores, $ins, $talleres, $ta, $fecIni, $fecFin, $materiales, $mate;

    protected $listeners = ['render', 'delete'];

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'certificados_taller.id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];


    public function mount()
    {
        $this->user = Auth::id();
        $this->cant = "10";
        $this->sort = 'certificados_taller.id';
        $this->direction = "desc";
        $this->fechaFin = date('d/m/Y');
        $this->inspectores = User::role(['inspector', 'supervisor'])->where('id', '!=', Auth::id())->orderBy('name')->get();
        $this->talleres = Taller::all()->sortBy('nombre');
        $this->materiales = TipoMaterial::whereIn('id', [1, 3])->get();
        $this->ins = '';
        $this->fecIni = '';
        $this->fecFin = '';
        $this->ta = '';
        $this->mate= '';
    }

    public function render()
    {
        $certificaciones = CertificacionTaller::NumFormato2($this->search)
            ->IdInspector($this->ins)
            //->IdMaterial($this->mate)
            ->IdTaller($this->ta)
            ->RangoFecha($this->fecIni, $this->fecFin)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
        return view('livewire.administracion-cer-taller', compact('certificaciones'));
    }

    public function order($sort)
    {
        if ($this->sort === $sort) {
            $this->direction = $this->direction === 'desc' ? 'asc' : 'desc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }


    public function delete(CertificacionTaller $certificacion)
    {
        $certificacion->delete();
        $this->emit('render');
    }
}
