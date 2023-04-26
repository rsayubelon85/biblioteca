<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Producto;
use App\Models\Ordene;
use App\Models\Solicitude;
use App\Mail\DatosSolicitudMaillable;
use App\Models\Moneda;
use App\Models\Tarifa;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Enums\LibroStatus;
use App\Models\Libro;
use App\Models\Referencia;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Reference\Reference;

class CatalogoController extends Controller
{
    
    public function libros_catalogo()
    {
        Session::put('TypeController', 'Catalogo');      

        $libros = Libro::all();

        $libros_arr = collect();
        foreach ($libros as $libro) {
            $lb['id'] = $libro->id;
            $lb['name'] = $libro->name;
            $lb['image'] = $libro->image;
            $lb['description'] = $libro->description;
            $enumstatus = LibroStatus::coerce($libro->status);
            $lb['statusBD'] = $libro->status;
            $lb['status'] = $enumstatus->key;        

            $libros_arr->push($lb);
        }

        return  datatables()->collection($libros_arr)
                            ->addColumn('action','actions')
                            ->toJson();
                            
    }
    
    public function index(){  
        
        return view('index');
    }


//-----Reservar libro
    public function add_solicitud_orden(Request $request, $id){
              
        $libro = Libro::find($id);
        $user = Auth()->user();
        
        $reserva = Reserva::create([
            'libro_id' => $libro->id,
            'user_id' => $user->id
        ]);
        $this->Insertar_Traza('rol.cli',json_encode($reserva),'null','null','null','Se ha creado una reserva.');

        $libro_anterior = json_encode($libro);
        $libro->status = 1;
        $libro->touch();
        $libro_nuevo = json_encode($libro);
        
        $this->Insertar_Traza('rol.cli','null',$libro_anterior,$libro_nuevo,'null','Se ha reservado el libro.');
        
        $message = $this->Mensaje('info','Información!','Se ha reservado el libro correctamente',true);

        return redirect('/catalogo')->with($message);
    }

}
