<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoTaller extends Model
{
    use HasFactory;

    protected $table="documentostaller";

    public $fillable=[
        "idDocumento",
        "idTaller",
        "estado",
        "combustible",
    ];
}
