<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Traza;

class TrazaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function trazas()
    {
        $trazas = collect();        

        $lista_trazas = Traza::all();
                
        foreach ($lista_trazas as $traza) {
            $tr = new Traza();
            $tr['nombre_usuario'] = $traza->User->name;
            $tr['nombre_permiso'] = $traza->Permiso->nombre_real;
            $tr['descripcion'] = $traza->descripcion;
            $tr['fecha'] = date('d-m-y H:i:s A',strtotime($traza->updated_at));
            $tr['obj_creado'] = $traza->objeto_creado;
            $tr['obj_antes_modificar'] = $traza->objeto_antes_modificar;
            $tr['obj_modificado'] = $traza->objeto_modificado;
            $tr['obj_eliminado'] = $traza->objeto_eliminado;            

            $trazas->push($tr);
        }        
        return datatables()->collection($trazas)                          
                           ->toJson();
    }

    public function index()
    {      
        return view('auth.traza.index');
    }


}
