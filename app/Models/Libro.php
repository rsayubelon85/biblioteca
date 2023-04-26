<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;
    protected $fillable = ['name','image','description','status'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    //Relacion uno a muchos un libro puede estar en varias reservas
    public function Reserva(){
        return $this->hasOne('\App\Models\Reserva');
    }
}
