<?php

namespace App\Http\Livewire;

use App\Models\CartaAclaratoria;
use App\Models\CertificacionPendiente;
use App\Models\CertificacionTaller;
use App\Models\Desmontes;
use App\Models\Material;
use App\Models\Taller;
use App\Models\TipoMaterial;
use App\Models\TipoServicio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdministracionCerTaller extends Component
{

    use WithPagination;

    public $search, $sort, $direction, $cant, $inspectores, $ins, $talleres, $ta, $fecIni, $fecFin, $materiales, $mate, $tipos, $serv;
    public $modelo;

    protected $listeners = ['render', 'delete'];

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'], //certificados_taller.
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];


    public function mount()
    {
        $this->cant = "10";
        $this->sort = 'id'; //certificados_taller.
        $this->direction = "desc";
        //Inicializar
        $this->ins = '';
        $this->fecIni = '';
        $this->fecFin = '';
        $this->ta = '';
        $this->mate = '';
        $this->modelo = '';
        //Para filtros
        $this->inspectores = User::role(['inspector', 'supervisor'])->where('id', '!=', Auth::id())->orderBy('name')->get();
        $this->talleres = Taller::all()->sortBy('nombre');
        $this->materiales = TipoMaterial::whereIn('id', [1, 3])->get();
        $this->tipos = TipoServicio::all();

    }

    public function render()
    {
        $certificaciones = null;
        $pendientes = null;
        $desmontes = null;
        $carta = null;
        $chipsConsumidos = null;
        

        if ($this->modelo === 'taller') {
            $certificaciones = CertificacionTaller::NumFormato2($this->search)
                ->IdInspector($this->ins)
                //->IdMaterial($this->mate)
                ->IdTaller($this->ta)
                ->RangoFecha($this->fecIni, $this->fecFin)
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'pendientes') {
            $pendientes = CertificacionPendiente::idInspector($this->ins)
                ->IdTalleres($this->ta)
                //->idTipoServicios($this->serv)
                ->RangoFecha($this->fecIni, $this->fecFin)
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'desmontes') {
            $desmontes = Desmontes::idInspector($this->ins)
                ->idTaller($this->ta)
                //->idTipoServicios($this->serv)
                ->RangoFecha($this->fecIni, $this->fecFin)
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'carta') {
            $carta = CartaAclaratoria::idInspector($this->ins)
                //->IdMaterial($this->mate)
                ->RangoFecha($this->fecIni, $this->fecFin)
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'chipsConsumidos') {
            $chipsConsumidos = Material::query()
                ->select(
                    'material.id',
                    'material.idUsuario',
                    'material.estado',
                    'material.ubicacion',
                    'material.grupo',
                    'material.updated_at',
                    'users.name as nombreInspector',
                )
                ->join('users', 'material.idUsuario', '=', 'users.id')
                ->where([
                    ['material.estado', '=', 4], // Chips consumidos
                    ['material.idTipoMaterial', '=', 2], // Tipo de material CHIP
                    //['material.idUsuario', '=', Auth::id()], // Filtra por el usuario actualmente autenticado
                ])
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        }
        return view('livewire.administracion-cer-taller', compact('certificaciones', 'pendientes', 'desmontes', 'carta', 'chipsConsumidos'));
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
