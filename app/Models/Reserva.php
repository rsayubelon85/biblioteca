<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $fillable = ['libro_id','user_id','created_at'];

    protected $hidden = [
        'updated_at',
    ];
    
    //Relacion uno a muchos una reserva tiene solo un usuario
    public function User(){
        return $this->belongsTo('\App\Models\User');
    }

    //Relacion uno a muchos una reserva tiene solo un libro
    public function Libro(){
        return $this->belongsTo('\App\Models\Libro');
    }
}
