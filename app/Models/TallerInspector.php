<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TallerInspector extends Model
{
    use HasFactory;

    protected $table = 'taller_inspector';
    protected $fillable=
    [
     'id', 
     'taller_id'  ,
     'inspector_id' ,
    ];

    public function taller()
    {
        return $this->belongsTo(Taller::class, 'taller_id');
    }
    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}
