<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expediente extends Model
{
    

    use HasFactory;
    protected $fillable=
    [
    'id',
    'placa',
    'certificado',
    'fecha',
    'estado',
    'idTaller',
    'idObservacion',
    'usuario_idusuario',
    'servicio_idservicio'
    ];

   

    protected $appends=
    [
        "nombre_taller",   
        "nombre_inspector"
        
    ];

    //DEFINIENDO RELACIONES
    public function Taller() {
        return $this->belongsTo(Taller::class, 'idTaller')->withDefault([
            'nombre' => 'Sin Nombre'
        ]);     
    }

    public function Inspector(){
        return $this->belongsTo(User::class,'usuario_idusuario')->withDefault([
            'name' => 'Sin Nombre'
        ]);           
    }

    public function Servicio(){
        return $this->belongsTo(Servicio::class,'servicio_idservicio');       
    }   

    public function Archivos(): HasMany
    {
        return $this->hasMany(Imagen::class,'Expediente_idExpediente');
    }





    //AGREGANDO ATRIBUTOS
    public function getNombreTallerAttribute(){
        return $this->Taller->nombre;
    }  
   
    public function getNombreInspectorAttribute(){
        return $this->Inspector->name;
    }   
   
    public function getNombreServicioAttribute(){
        return $this->Servicio->tipoServicio->descripcion;
    }   

    public function getFotosAttribute(){
        return $this->Archivos()->whereIn('extension',[ 'jpg','jpeg','gif','gift','bimp','tif','tiff'])->get();
    }

    public function getDocumentosAttribute(){
        return $this->Archivos()->whereIn('extension',[ 'pdf','docx','xlsx','xlx','txt'])->get();
    }

    //SCOPES PARA FILTROS
    public function scopePlacaOcertificado(Builder $query, string $search): void
    {   
        if($search){
            $query->where('placa','like','%'.$search.'%')->orWhere('certificado','like','%'.$search.'%');
        }       
    }

    public function scopeidInspector(Builder $query, string $search): void
    {   
        if($search){
            $query->where('usuario_idusuario',$search);
        }       
    }


    public function scopeidTaller(Builder $query, string $search): void
    {   
        if($search){
            $query->where('idTaller', $search);
        }       
    } 

    public function scopeEstado(Builder $query, string $search): void
    {   
        if($search){
            $query->where('estado', $search);
        }       
    }    

   
    public function scopeRangoFecha(Builder $query, string $desde, string $hasta): void
    {   
        if($desde && $hasta){
            $query->whereBetween('created_at', [$desde,$hasta]);
        }       
    }

    public function scopeTipoServicio($query,$search): void{
        if($search){           
            $query->whereHas('Servicio', function (Builder $query) use ($search) {
                $query->where('tipoServicio_idtipoServicio',$search);
            });               
        }       
    }

    public function certificacion(){
        return $this->belongsToMany(Certificacion::class,'certificacion_expediente','idExpediente','idCertificacion');
    }
    
    
    

}
