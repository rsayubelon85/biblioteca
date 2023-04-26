<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:rol.admin')->only('roles','index','create','store','edit','update','destroy');
    }

    public function roles()
    {
        Session::put('TypeController', 'Role');

        return datatables()->eloquent(Role::query())
                           ->addColumn('action','actions')
                           ->toJson();
    }

    public function index()
    {       
        return view('auth.rol.index');
    }

    public function create()
    {
        return view('auth.rol.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)|unique:roles,name'   
        ]);
        $rol = Role::create(['name'=> $request['name']]);

        $message = $this->Mensaje('success','Información!','El rol fue registrado correctamente.',true);
        $this->Insertar_Traza('rol.admin',json_encode($rol),'null','null','null','Se creo el rol.');

        return redirect('/roles')->with($message);
    }

    public function edit(Role $role)
    {
        return view('auth.rol.edit',compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
        ]);

        if(Role::where('name',$request['name'])->get()->count() > 0 && $request['name'] != $role->name){

            $message = $this->Mensaje('error','Error','Ya el rol se encuentra registrado.',false);
            return back()->withInput()->with($message);//Ir a la ruta anterior.
        }

        $role_anterior = json_encode($role);
        $role->name = $request['name'];
        $role->touch();
        $role_nueva = json_encode($role);

        $message = $this->Mensaje('success','Información!','El rol fue editado correctamente.',true);
        $this->Insertar_Traza('rol.admin','null',$role_anterior,$role_nueva,'null','Se modificó el rol');

        return redirect('/roles')->with($message);
    }

    public function destroy(Role $role)
    {
        if($role->users()->count() > 0){
            $message = $this->Mensaje('error','Error','El rol no se puede eliminar porque está asignado a un usuario.',false);            
        }
        elseif ($role->permissions()->count() > 0) {
            $message = $this->Mensaje('error','Error','El rol no se puede eliminar porque tiene asignado permisos.',false);
        }
        else{
            $role_eliminado = json_encode($role);            
            $role->delete();
            $message = $this->Mensaje('success','Información!','Su registro ha sido eliminado correctamente.',true);
            $this->Insertar_Traza('rol.admin','null','null','null',$role_eliminado,'Se eliminó el rol.');
        }
        return redirect('/roles')->with($message);
        
        //Hay que tener en cuenta si el rol esta asignado a un ususario

    }
}
