<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function usuarios()
    {
        Session::put('TypeController', 'Usuario');
        
        return datatables()->eloquent(User::query())                           
                           ->addColumn('action','actions')
                           ->toJson();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function create()
    {
        return view('auth.register');
    }

    public function index()
    {
        return view('auth.index');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function store(RegisterRequest $request)
    {
        //$request->setA
        //return $request->validated(); 
        //return $request->validated();    
        $user = User::create($request->validated()); 

        $message = array(
            'eliminar' => 'ok',
            'type'     => 'info',
            'title'    => 'Añadir usuario',
            'message'  => 'El usuario ha sido añadido exitosamente.'
        );
        return redirect('/usuarios')->with($message);
        
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);*/
    }

    public function update(Request $request,$id)
    {
        return User::find($id);
    }

    public function destroy($id)
    {
        return User::find($id);
    }
}
