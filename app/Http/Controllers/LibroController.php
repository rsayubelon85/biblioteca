<?php

namespace App\Http\Controllers;

use App\Enums\LibroStatus;
use App\Http\Requests\RulesLibros;
use App\Models\Libro;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\User;

class LibroController extends Controller
{
    public function __construct()
    {

    }
    
    public function libros()
    {
        Session::put('TypeController', 'Libro');

        $libros = Libro::all();
        

        $libros_arr = collect();
        foreach ($libros as $libro) {
            $lb['id'] = $libro->id;
            $lb['name'] = $libro->name;
            $lb['image'] = $libro->image;
            $lb['description'] = $libro->description;

            $enumInstance = LibroStatus::coerce($libro->status);
            $lb['status'] = $enumInstance->key;
            if ($libro->status == 0) {
                $lb['nombre_cliente'] = '';
            }
            else{
                $reserva = Reserva::where('libro_id',1)->first();
                $lb['nombre_cliente'] = $reserva->User->name.' '.$reserva->User->last_name; 
            }
            

            $libros_arr->push($lb);
        }
        
        return datatables()->collection($libros_arr)
                           ->addColumn('action','actions')
                           ->toJson();
    }

    public function index()
    {
        $hay_perm = false;
        $user = Auth()->user();
        $rol = $user->roles[0];        
        $permisos = Permission::where('name','rol.trab')->get();
        foreach ($permisos as $permiso) {
            if($rol->hasPermissionTo($permiso)){
                $hay_perm = true;
                break;
            }
        }
        return view('libro.index',compact('hay_perm'));
    }

    public function create()
    {
        return view('libro.create');
    }

    public function store(RulesLibros $request)
    {         
        //Procesamiento de la imagen
        if($imagen = $request->file('imagen')){
            
            $ruta_guardar_imagen = 'imagen/libros/'.'/'.$request->nombre.'/';
            
            if (! File::exists(public_path($ruta_guardar_imagen))) {
                File::makeDirectory(public_path($ruta_guardar_imagen), $mode = 0777, true, true);
            }
            
            $nuevo_nombre_imagen = date('YmdHis').".".$imagen->extension();
            
            $ruta_new_imagen = public_path($ruta_guardar_imagen).$nuevo_nombre_imagen;

            Image::make($imagen)->resize(150,150)->save($ruta_new_imagen,72);

            $imagenlibro = $ruta_guardar_imagen.$nuevo_nombre_imagen;
            
        }
        else{
            $imagenlibro = null;
        }
        
        $libro = Libro::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagenlibro,
            'status' => 0
        ]);

        $message = $this->Mensaje('success','Información!','El libro fue registrado correctamente.',true);
        $this->Insertar_Traza('rol.trab',json_encode($libro),'null','null','null','Se creo el libro.');
        return redirect('libros')->with($message);
    }

    public function edit($id)
    {
        $libro = Libro::find($id);

        return view('libro.edit',compact('libro'));
    }

    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'name' => 'required|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)|unique:libros,name,'.$libro->id,
            'image' => 'image|mimes:jpg,jpeg,png,svg|max:1024'
        ]);

        $libro_anterior = json_encode($libro);
        //Procesamiento de la imagen
        if($imagen = $request->file('imagen')){
            
            $ruta_guardar_imagen = 'imagen/libros/'.$request->nombre.'/';
            
            if (! File::exists(public_path($ruta_guardar_imagen))) {
                File::makeDirectory(public_path($ruta_guardar_imagen), $mode = 0777, true, true);
            }
            
            $nuevo_nombre_imagen = date('YmdHis').".".$imagen->extension();
            
            $ruta_new_imagen = public_path($ruta_guardar_imagen).$nuevo_nombre_imagen;

            Image::make($imagen)->resize(150,150)->save($ruta_new_imagen,72);

            $imagenlibro = $ruta_guardar_imagen.$nuevo_nombre_imagen;

            if (@getimagesize(public_path($libro->image))) {//ELIMINAR ARCHIVO IMAGEN
                unlink(public_path($libro->image));
            } 
            
        }
        else{
            $imagenlibro = $libro->image;
        }

        //Procesamiento de la imagen     
        $libro->name = $request->name;
        $libro->description = $request->description;
        $libro->image = $imagenlibro;
        $libro->touch();

        $libro_nuevo= json_encode($libro);

        $message = $this->Mensaje('success','Información!','El libro fue editado correctamente.',true);
        $this->Insertar_Traza('rol.trab','null',$libro_anterior,$libro_nuevo,'null','Se editó el libro.');
        return redirect('/libros')->with($message);
    }

    public function destroy($id)
    {        
        $libro = Libro::find($id);

        if(Reserva::where('libro_id',$libro->id)->get()->count() > 0){
            $message = $this->Mensaje('error','Error','No puede eliminar el libro porque está asignado a un cliente.',false);
            return redirect('/libros')->with($message);
        }
        $libro_eliminado = json_encode($libro);
        
        if (@getimagesize(public_path($libro->image))) {//ELIMINAR ARCHIVO IMAGEN
            unlink(public_path($libro->image));
        } 
    
        $libro->delete();

        $message = $this->Mensaje('success','Información!','Su registro ha sido eliminado correctamente.',true);
        $this->Insertar_Traza('rol.trab','null','null','null',$libro_eliminado,'Se eliminó el libro.');
        return redirect('/libros')->with($message);
    }
}
