<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\ErrorHandler\Collecting;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function permisos(Request $request)
    { 
        $rol_id = $request['role'];
        $search = $request['$search'];
        $role = Role::findById($rol_id);
        
        Session::put('TypeController', 'Permiso');  
        $permisos = Permission::where('id','<>',1)->get();
        
        foreach ($permisos as $permiso) {
            if ($role->permissions->count() == 0) {
                $permiso['activo'] = '';
            }
            else{
                $esta = false;
                if ($role->hasPermissionTo($permiso)) {
                    $esta = true;
                }
                $permiso['activo'] = $esta ? 'checked' : '';
            }            
        }

        return datatables()->collection($permisos)
                           ->addColumn('action','actions')
                           ->toJson();
    }

    public function index(Request $request){

        Session::put('TypeController', 'Permiso');
        
        $roles = Role::all();
       
        return view('auth.assign_perm_rol',compact('roles'));
    }

    public function Permisos_Json(Role $rol){
        $rol_permisos = array();

        foreach($rol->permissions as $permiso){
            array_push($rol_permisos,$permiso->name);
        }                
        return json_encode($rol_permisos);
    }

    public function asignacion_permiso(Request $request)
    {
        $rol = Role::findById($request['roles'][0]);
        $message = '';
        if($request['array_perm'] != null){

            $permisos_int = $request['array_perm'];
            $permisos_anteriores = $this->Permisos_Json($rol);
            if ($rol->id === 1) {//Rol del administrador del sistema y lleva el permiso rol.admin (administrar el sistema)
                
                $permisos_entrada = Permission::wherein('id',$permisos_int)->orwhere('id',1)->get();                
                $rol->syncPermissions($permisos_entrada);

            } else {
                
                $permisos_entrada = Permission::wherein('id',$permisos_int)->get();
                $rol->syncPermissions($permisos_entrada);
            }
            $permisos_nuevos = $this->Permisos_Json($rol);
            $message = $this->Mensaje('success','Información!','Los permisos han sido asignados correctamente.',true);
            if($permisos_anteriores < $permisos_nuevos)
                $this->Insertar_Traza('rol.admin','null',$permisos_anteriores,$permisos_nuevos,'null','Se asignaron los permisos al rol.');
            else
            $this->Insertar_Traza('rol.admin','null',$permisos_anteriores,$permisos_nuevos,'null','Se quitaron los permisos al rol.');
        }
        else{
            $permisos_anteriores = $this->Permisos_Json($rol);
            foreach ($rol->permissions as $perm) {
                if($perm->id != 1)
                    $rol->revokePermissionTo($perm);
            }
            $permisos_nuevos = $this->Permisos_Json($rol);

            $message = $this->Mensaje('success','Información!','Se les quitaron los permisos al rol correctamente.',true);
            $this->Insertar_Traza('rol.admin','null',$permisos_anteriores,$permisos_nuevos,'null','Se quitaron los permisos al rol.');
        }
        
        return redirect('/permisos')->with($message);

    }
}
