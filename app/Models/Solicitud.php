<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Solicitud extends Model
{
    use HasFactory;

    protected $table="solicitud";

    public $fillable=["id","idInspector","data","estado"];

    public function Inspector(){
        return $this->belongsTo(User::class,'idInspector');
    }
}
