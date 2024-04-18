<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subgrupo extends Model
{
    use HasFactory;

    protected $table="subgrupo";

    Public $fillable=[
        "id",
        "inicio",
        "fin",
        "tipo",
    ];
}
