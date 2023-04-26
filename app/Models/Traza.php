<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Spatie\Permission\Models\Permission;

class Traza extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','permiso_id','objeto_creado','objeto_antes_modificar','objeto_modificado','objeto_eliminado','descripcion'];

    //Relacion uno a muchos una sola es asignada a un solo usuario
    public function User(){
        return $this->belongsTo('\App\Models\User');
    }

    //Relacion uno a muchos una sola es asignada a un solo usuario
    public function Permiso(){
        return $this->belongsTo('\Spatie\Permission\Models\Permission');
    }
}
