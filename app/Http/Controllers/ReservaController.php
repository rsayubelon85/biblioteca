<?php

namespace App\Http\Controllers;

use App\Enums\LibroStatus;
use App\Models\Reserva;
use App\Models\Solicitude;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Tarifa;
use App\Models\Producto;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DatosSolicitudMaillable;
use Illuminate\Support\Carbon;

class ReservaController extends Controller
{
 
    public function reservas_user(){

        Session::put('TypeController', 'Reserva');
        $user = auth()->user();
        $reservas_user = Reserva::where('user_id',$user->id)->get();
        $array_reservas = collect();
        
        foreach ($reservas_user as $reserva) {
            $res['id'] = $reserva->Libro->id;
            $res['name'] = $reserva->Libro->name;
            $res['image'] = $reserva->Libro->image;
            $res['description'] = $reserva->Libro->description;
            $res['fecha_devolucion'] = Carbon::parse($reserva->created_at)->addDays(2)->setTime(23,59,59)->format('Y-m-d h:i:s');//->format('Y-m-d h:i:s');


            $array_reservas->push($res);
        }

        return datatables()->collection($array_reservas)
                           ->addColumn('action','actions')
                           ->toJson();
        

    }

    public function index(){  

        return view('reserva.index');
    }

    public function devolver_libro(Libro $libro){
                
        $reserva = $libro->Reserva;
        $reserva_eliminada = json_encode($reserva);
        $reserva->delete();
        $this->Insertar_Traza('rol.cli','null','null','null',$reserva_eliminada,'La reserva ha sido eliminada.');

        $libro_anterior = json_encode($libro);
        $libro->status = 0;
        $libro_nuevo = json_encode($libro);        
        $libro->touch();
        $this->Insertar_Traza('rol.cli','null',$libro_anterior,$libro_nuevo,'null','Se cambia el estado del libro a Sin Reservar.');

        $message = $this->Mensaje('info','Información!','Se ha eliminado la reserva del libro devolviéndose al catátolo de libros',true);

        return back()->withInput()->with($message);
    }

    

}


