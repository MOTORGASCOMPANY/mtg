<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertifiacionExpediente extends Model
{
    use HasFactory;

    protected $table="certificacion_expediente";

    public $fillable=["idCertificacion","idExpediente"];
}
