<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoManual extends Model
{
    use HasFactory;

    protected $table="tipomanual";

    public $fillable = [
        'nombreTipo',
    ];

    public function documentosManuales()
    {
        return $this->hasMany(DocumentoManual::class, 'tipomanual_id');
    }

}
