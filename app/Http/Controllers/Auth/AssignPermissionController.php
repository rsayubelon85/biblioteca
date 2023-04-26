<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function permisos()
    {
        Session::put('TypeController', 'Permiso');

        $permisos_rol = collect();
        
        $roles = Role::all();//pluck('name','name') selecciona un atributo en especifico de la bd
        $rolP = $roles[0];
        //return $rolP->permisos==null?'null':'123';

        $permisos = Permission::all();
        //return $permisos;

        foreach ($permisos as $permiso) {
            $perm = new Permission();
            $perm['id'] = $permiso->id;
            $perm['name'] = $permiso->name;
            if ($rolP->permisos == null) {
                $perm['activo'] = 0;
            }
            else{
                $esta = false;
                foreach ($rolP->permisos as $pm) {
                    if ($pm == $permiso) {
                        $esta = true;
                        break;
                    }
                }
                $perm['activo'] = $esta ? 1 : 0;
            }            
            $permisos_rol->push($perm);
        }
                
        return datatables()->collection($permisos_rol)                          
                           ->addColumn('action','actions')
                           ->toJson();
    }

    public function index(){

        $roles = Role::all();
        
        return view('auth.assign_perm_rol',compact('roles'));
    }
}
