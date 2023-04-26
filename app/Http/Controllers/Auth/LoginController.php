<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to  provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request){
 
        $credenciales = $request->getCredentials();
        
        $remember = request()->filled('remember');

        if(!Auth::validate($credenciales)){

            $message = $this->Mensaje('error','Error!','Credenciales incorrectas.',false);
            return redirect()->to('/login')->with($message);
        }

        $user = Auth::getProvider()->retrieveByCredentials($credenciales);

        Auth::login($user,$remember);

        return $this->autenticated($request,$user);
    }

    public function autenticated(LoginRequest $request,$user){
        
        $rol = $user->roles[0];

        if ($rol->id == 1) {
            return redirect('/users');
        } elseif($rol->id == 2){

            $reservas = Reserva::all();
            foreach($reservas as $reserva){
                $fecha_anterior = Carbon::parse($reserva->created_at)->addDays(2)->setTime(23,59,59);
                $fecha_actual = Carbon::now();
                if (Carbon::now() >= $fecha_anterior) {
                    $message = $this->Mensaje('info','Información!','Existe alguna reserva de alguno de los clientes que ya se encuentra pasada la fecha de devolución, por favor revise',false);
                    return redirect('/libros')->with($message);
                }
            }
            return redirect('/libros');
        }
        else{
            $reservas = Reserva::where('user_id',$user->id)->get();
            foreach($reservas as $reserva){
                $fecha_anterior = Carbon::parse($reserva->created_at)->addDays(2)->setTime(23,59,59);
                if (Carbon::now() >= $fecha_anterior) {
                    $message = $this->Mensaje('info','Información!','Existe algún libro de los que reselvó que se encuentra pasado en fecha de devolución, por favor revise',false);
                    return redirect('/catalogo')->with($message);
                }
            }
             
            return redirect('/catalogo');
        }
        
        
    }

}