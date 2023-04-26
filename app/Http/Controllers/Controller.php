<?php

namespace App\Http\Controllers;

use App\Models\Solicitude;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Tarifa;
use App\Models\Moneda;
use App\Models\Tarifario;
use Spatie\Permission\Models\Permission;
use App\Models\Traza;
use App\Models\User;
 
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function Mensaje($tipo,$title,$mensaje,$tiene_tiempo){

        if($tiene_tiempo){
            return array(
                'hay_mensaje' => true,
                'icon' => $tipo,//success,question,error,warning,info
                'title' => $title,
                'text' => $mensaje,
                'showConfirmButton' => false,
                'position' => 'top-end',                
                'timer' => 1500
            );
        }
        else{
            return array(
                'hay_mensaje' => true,
                'icon' => $tipo,
                'title' => $title,
                'text' => $mensaje,
                'showConfirmButton' => true,
                'position' => '',                
                'timer' => ''
            );
        }       
    }

    public function Insertar_Traza(string $nombre_permiso,string $obj_creado,string $obj_antes_modificar,string $obj_modificado,string $obj_eliminado,string $descripcion)
    {
        $user_actual = Auth()->user();
        if($user_actual == null)
            $user_actual = User::find(1);
        $traza = new Traza();
        $traza->user_id = $user_actual->id;
        $permiso = Permission::where('name',$nombre_permiso)->first();
        $traza->permiso_id = $permiso->id;

        $obj_creado != 'null' ? $traza->objeto_creado = $obj_creado : $traza->objeto_creado = null;
        $obj_antes_modificar != 'null' ? $traza->objeto_antes_modificar = $obj_antes_modificar : $traza->objeto_antes_modificar = null;
        $obj_modificado != 'null' ? $traza->objeto_modificado = $obj_modificado : $traza->objeto_modificado = null;
        $obj_eliminado != 'null' ? $traza->objeto_eliminado = $obj_eliminado : $traza->objeto_eliminado = null;

        $traza->descripcion = $descripcion;

        $traza->save();
    }
}
