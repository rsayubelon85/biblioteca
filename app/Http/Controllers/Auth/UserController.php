<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\UserRequest;
use App\Models\Password_historie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Reserva;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:rol.admin')->only('usuarios','index','create','store','edit','update','destroy');
        $this->middleware('can:rol.trab')->only('clientes','index_cliente');        
    }

    public function usuarios()
    {
        Session::put('TypeController', 'Usuario');

        $users = collect();        

        $usuarios = User::all();

        foreach ($usuarios as $user) {
            $us = new User();
            $us['id'] = $user->id;
            $us['name'] = $user->name;
            $us['last_name'] = $user->last_name;
            $us['id_number'] = $user->id_number;
            $us['email'] = $user->email;
            $us['rol'] = $user->roles[0]->name;
            if ($user->roles[0]->id != 1) {
                $users->push($us);
            }            
        }
        
        return datatables()->collection($users)                          
                           ->addColumn('action','actions')
                           ->toJson();
    }

    public function index()
    {     
        return view('auth.user.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('auth.user.create',compact('roles'));
    }

    public function store(UserRequest $request)
    { 
        $user = User::create([
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'id_number' => $request['id_number'],
            'password' => Hash::make($request['password']),
        ]);

        //Rol del trabajador
        $rol = Role::findById(2);
        $user->assignRole($rol);

        //return json_encode($user);
        $message = $this->Mensaje('success','Información!','El trabajador ha sido registrado correctamente.',true);
        $this->Insertar_Traza('rol.admin',json_encode($user),'null','null','null','Se creo el usuario de tipo trabajador.');
        return redirect('/users')->with($message);
    }

    public function edit(User $user)
    {
        return view('auth.user.edit',compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if($request['password'] == null){
            $request->validate([
                'name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'id_number' => 'required|numeric|min:1999999999|max:99999999999|unique:users,id_number,'.$user->id,
            ]);
        }
        else {
            $request->validate([
                'name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'id_number' => 'required|numeric|min:1999999999|max:99999999999|unique:users,id_number,'.$user->id,
                'password' => ['required',Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
                'password_confirmation' => 'required|same:password'
            ]);
        }
        $user_anterior = json_encode($user);
        $user->name = $request['name'];
        $user->last_name = $request['last_name'];
        $user->id_number = $request['id_number'];

        $new_password = $request['password'];
        if ($new_password != null) 
        {
            $users_histories = Password_historie::where('user_id',$user->id)->get();
            foreach($users_histories as $userhs)
            {
                if(Hash::check($new_password,$userhs->password)){
                    //La nueva contraseña no puede coincidir con ninguna puesta anteriormente
                    $message = $this->Mensaje('error',
                                            'Error',
                                            'La contraseña nueva no puede coincidir con ninguna puesta anteriormente, por favor ingrese otra contraseña.',
                                            false);
                    return back()->withInput()->with($message);
                }        
            }

            $user->password = Hash::make($new_password);
        }
        $user->touch();
        $user_nuevo = json_encode($user);

        $message = $this->Mensaje('success','Información!','El trabajador ha sido editado correctamente.',true);
        $this->Insertar_Traza('rol.admin','null',$user_anterior,$user_nuevo,'null','Se modificó el trabajador.');
        return redirect('/users')->with($message);
    }

    public function destroy(User $user)
    {
        $user_eliminado = json_encode($user);
        $user->removeRole($user->roles[0]);
        $user->delete();

        $message = $this->Mensaje('success','Información!','Su registro ha sido eliminado correctamente.',true);
        $this->Insertar_Traza('rol.admin','null','null','null',$user_eliminado,'Se eliminó el el trabajador.');

        return redirect('/users')->with($message);
    }

    public function edit_perfil(){

        $user = Auth()->user();
        
        return view('auth.perfil.edituser',compact('user'));
    }

    public function update_perfil(Request $request, User $user)
    {
        if($request['password'] == null){
            $request->validate([
                'name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'id_number' => 'required|numeric|min:1999999999|max:99999999999|unique:users,id_number,'.$user->id
            ]);
        }
        else {
            $request->validate([
                'name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'id_number' => 'required|numeric|min:1999999999|max:99999999999|unique:users,id_number,'.$user->id,
                'password' => ['required',Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
                'password_confirmation' => 'required|same:password'
            ]);
        }

        $user_anterior = json_encode($user);
        $user->name = $request['name'];
        $user->last_name = $request['last_name'];
        $user->id_number = $request['id_number'];        
        if ($request['password'] != null) 
        {
            $new_password = $request['password'];

            $last_password = $request['last_password'];

            if(!Hash::check($last_password,$user->password)){
                
                //La contraseña actual no coincide con la contraseña que puso el usuario
                $message = $this->Mensaje('error',
                                          'Error',
                                          'La contraseña anterior no coincide con la contraseña puesta, por favor ingrese la contraseña anterior correcta.',
                                          false);
                return back()->withInput()->with($message);
            }
            elseif ($new_password == $last_password) {
                //La contraseña actual no puede coincidir con la nueva contraseña
                $message = $this->Mensaje('error',
                                          'Error',
                                          'La contraseña nueva no puede coincidir con la contraseña anterior, por favor ingrese otra contraseña.',
                                          false);
                return back()->withInput()->with($message);
            }
            else 
            {
                $users_histories = Password_historie::where('user_id',$user->id)->get();
                foreach($users_histories as $userhs)
                {
                    if(Hash::check($new_password,$userhs->password)){
                        //La nueva contraseña no puede coincidir con ninguna puesta anteriormente
                        $message = $this->Mensaje('error',
                                                'Error',
                                                'La contraseña nueva no puede coincidir con ninguna puesta anteriormente, por favor ingrese otra contraseña.',
                                                false);
                        return back()->withInput()->with($message);
                    }        
                }
            }
            $user->password = Hash::make($new_password);

            $pass_historie = Password_historie::create([
                'user_id' => $user->id,
                'password' => $user->password,
            ]);

            $this->Insertar_Traza('rol.admin',json_encode($pass_historie),'null','null','null','Se creo un historial de contraseña.');
        }
        $user->touch();
        $user_nueva = json_encode($user);

        $message = $this->Mensaje('success','Información','El usuario fue editado correctamente.',true);
        $this->Insertar_Traza('rol.admin','null',$user_anterior,$user_nueva,'null','Se actualizó el usuario.');
        
        return redirect('/users')->with($message);
    }
 
    public function clientes()
    {
        Session::put('TypeController', 'Libro_CLiente');

        $users = collect();        

        $usuarios = User::all();

        foreach ($usuarios as $user) {
            $us = new User();
            $us['id'] = $user->id;
            $us['name'] = $user->name;
            $us['last_name'] = $user->last_name;
            $us['id_number'] = $user->id_number;
            $us['email'] = $user->email;
            $us['rol'] = $user->roles[0]->name;
            if ($user->roles[0]->id == 3) {
                $users->push($us);
            }            
        }
        
        return datatables()->collection($users)                          
                           ->addColumn('action','actions')
                           ->toJson();
    }

    public function index_cliente()
    {    
        return view('auth.user.index_cliente');
    }

    public function libros_cliente(User $user){

        $reservas_user = Reserva::where('user_id',$user->id)->get();
        $libros_user = collect();
        
        /*$fecha = $reservas_user[0]['created_at'];
        $fecha = Carbon::parse($fecha)->addDays(3)->setTime(23,59,59);//->format('Y-m-d h:i:s');
        $fecha_actual = Carbon::now();
        $horas = $fecha->diffInHours($fecha_actual);*/
        
        foreach ($reservas_user as $reserva) {
            $res['id'] = $reserva->Libro->id;
            $res['name'] = $reserva->Libro->name;
            $res['image'] = $reserva->Libro->image;
            $res['description'] = $reserva->Libro->description;
            $res['fecha_devolucion'] = Carbon::parse($reserva->created_at)->addDays(3)->setTime(23,59,59)->format('Y-m-d h:i:s');


            $libros_user->push($res);
        }

        return view('auth.user.libro_cliente',compact('libros_user'));     
    }

    public function Mostrar_Registro_Cliente(){

        return view('auth.create_client');
    }

    public function Store_Cliente(ClientRequest $request){
        $user = User::create([
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'id_number' => $request['id_number'],
            'password' => Hash::make($request['password']),
        ]);

        //Rol del cliente
        $rol = Role::findById(3);
        $user->assignRole($rol);

        //return json_encode($user);
        $message = $this->Mensaje('success','Información!','Usted ha sido registrado correctamente.',true);
        $this->Insertar_Traza('rol.admin',json_encode($user),'null','null','null','Se creo el usuario de tipo cliente.');
        return redirect('/login')->with($message);       
    }
}
