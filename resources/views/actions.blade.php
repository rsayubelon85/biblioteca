@if (Session::get('TypeController') == 'Categoria')
    @can('rol.admin')
        <form action="{{route('categorias.destroy',$id)}}" method="POST" class="formEliminar">
            <div class="row  align-items-start">
                <div class="col">
                    <a href="{{route('categorias.edit',$id)}}" ><img class="card-img-top" title="Editar Categoria" src="{{asset('/imagen/iconos/pencil-squarenaranja.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
                </div>
                <div class="col">
                    @csrf
                    @method('DELETE')    
                    <input title="Eliminar Categoria" src="{{asset('/imagen/iconos/trashrojo.png')}}"  type="image" style="width: 30px"/>
                </div>
            </div>
        </form>        
    @endcan    
@endif
@if (Session::get('TypeController') == 'Moneda')
    @can('rol.admin')
        <form action="{{route('monedas.destroy',$id)}}" method="POST" class="formEliminar">
            <div class="row  align-items-start">
                <div class="col">
                    <a href="{{route('monedas.edit',$id)}}" ><img class="card-img-top" title="Editar Moneda" src="{{asset('/imagen/iconos/pencil-squarenaranja.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
                </div>
                <div class="col">
                    @csrf
                    @method('DELETE')    
                    <input title="Eliminar Moneda" src="{{asset('/imagen/iconos/trashrojo.png')}}"  type="image" style="width: 30px"/>
                </div>
            </div>
        </form>            
    @endcan  
@endif
@if (Session::get('TypeController') == 'Tarifa')
    <form action="{{route('tarifas.destroy',$id)}}" method="POST" class="formEliminar">
        <div class="row  align-items-start">
            @can('tarifa.edit')
                <div class="col">
                    <a href="{{route('tarifas.edit',$id)}}" ><img class="card-img-top" title="Editar Tarifa" src="{{asset('/imagen/iconos/pencil-squarenaranja.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
                </div>       
            @endcan
            @can('tarifa.delete')
                <div class="col">
                    @csrf
                    @method('DELETE')    
                    <input title="Eliminar Tarifa" src="{{asset('/imagen/iconos/trashrojo.png')}}"  type="image" style="width: 30px"/>
                </div>       
            @endcan
        </div>
    </form>  
@endif
@if (Session::get('TypeController') == 'Plan')
    <form action="{{route('plans.destroy',$id)}}" method="POST" class="formEliminar">
        <div class="row  align-items-start">
            @can('plan.edit')
                <div class="col">
                    <a href="{{route('plans.edit',$id)}}" ><img class="card-img-top" title="Editar Plan" src="{{asset('/imagen/iconos/pencil-squarenaranja.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
                </div>        
            @endcan
            @can('plan.delete')
                <div class="col">
                    @csrf
                    @method('DELETE')    
                    <input title="Eliminar Plan" src="{{asset('/imagen/iconos/trashrojo.png')}}"  type="image" style="width: 30px"/>
                </div>       
            @endcan
        </div>
    </form>  
@endif
@if (Session::get('TypeController') == 'Tarifario')
    <form action="{{route('tarifarios.destroy',$id)}}" method="POST" class="formEliminar">
        <div class="row  align-items-start">
            @can('tarifario.edit')
                <div class="col">
                    <a href="{{route('tarifarios.edit',$id)}}" ><img class="card-img-top" title="Editar Tarifario" src="{{asset('/imagen/iconos/pencil-squarenaranja.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
                </div>
            @endcan            
            @can('tarifario.delete')
                <div class="col">
                    @csrf 
                    @method('DELETE')    
                    <input title="Eliminar Tarifario" src="{{asset('/imagen/iconos/trashrojo.png')}}"  type="image" style="width: 30px"/>
                </div>                
            @endcan
        </div>
    </form>  
@endif
@if (Session::get('TypeController') == 'Libro')
    <form action="{{route('libros.destroy',$id)}}" method="POST" class="formEliminar">
        <div class="row  align-items-start">
            @can('rol.trab')
                <div class="col" style="width: 20px">
                    <a href="{{route('libros.edit',$id)}}" ><img class="card-img-top" title="Editar Libro" src="{{asset('/imagen/iconos/pencil-squarenaranja.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
                </div>
                <div class="col" style="width: 20px">
                    @csrf
                    @method('DELETE')    
                    <input title="Eliminar Libro" src="{{asset('/imagen/iconos/trashrojo.png')}}"  type="image" style="width: 30px"/>
                </div>        
            @endcan
        </div>
    </form>  
@endif
@if (Session::get('TypeController') == 'Catalogo')
    @can('rol.cli')
        @if ($statusBD == 0)
            <input type="checkbox" id="chbox" class="form-check-input" onclick="window.location='{{route('catalogo.select',$id)}}'" style="transform: scale(1.5)"/>
        @else
            <input type="checkbox" id="chbox" disabled class="form-check-input" onclick="window.location='{{route('catalogo.select',$id)}}'" style="transform: scale(1.5)"/>
        @endif      
    @endcan  
@endif
@if (Session::get('TypeController') == 'Reserva')
    @can('rol.cli')
        <div class="col" style="width: 10px">
            <a href="{{route('reserva.devolver',$id)}}" ><img class="card-img-top" title="Devolver Libro" src="{{asset('/imagen/iconos/return-book.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
        </div>                
    @endcan
@endif
@if (Session::get('TypeController') == 'OrdeneProducto')
    
    <input type="checkbox" id="chbox" class="form-check-input" onclick="window.location='{{route('ordene.select',['id_prod' => $id,'id_sol' => $id_sol])}}'" style="transform: scale(1.5)"/>
 
@endif

@if (Session::get('TypeController') == 'Usuario')
    @can('rol.admin')
        <form action="{{route('users.destroy',$id)}}" method="POST" class="formEliminar">
            <div class="row  align-items-start">
                                           
                <div class="col" style="width: 10px">
                    @csrf
                    @method('POST')
                    <a href="{{route('users.edit',$id)}}" ><img class="card-img-top" title="Editar Usuario" src="{{asset('/imagen/iconos/pencil-squarenaranja.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
                </div>      
                <div class="col" style="width: 10px">
                    @csrf
                    @method('DELETE')    
                    <input title="Eliminar Usuario" src="{{asset('/imagen/iconos/trashrojo.png')}}"  type="image" style="width: 30px"/>
                </div>
            </div>
        </form>                
    @endcan
@endif

@if (Session::get('TypeController') == 'Referencia')
    @can('rol.trab')
        <form action="{{route('referencias.destroy',$id)}}" method="POST" class="formEliminar">
            <div class="row  align-items-start">
                                           
                <div class="col" style="width: 10px">
                    @csrf
                    @method('POST')
                    <a href="{{route('referencias.edit',$id)}}" ><img class="card-img-top" title="Editar Referencia" src="{{asset('/imagen/iconos/pencil-squarenaranja.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
                </div>      
                <div class="col" style="width: 10px">
                    @csrf
                    @method('DELETE')    
                    <input title="Eliminar Referencia" src="{{asset('/imagen/iconos/trashrojo.png')}}"  type="image" style="width: 30px"/>
                </div>
            </div>
        </form>                
    @endcan
@endif
@if (Session::get('TypeController') == 'Libro_CLiente')
    @can('rol.trab')
        <div class="row  align-items-start">                             
            <div class="col" style="width: 10px">
                @csrf
                @method('POST')
                <a href="{{route('mostrar.libros',$id)}}" ><img class="card-img-top" title="Mostrar Libros" src="{{asset('/imagen/iconos/show_icon.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
            </div>      
        </div>             
    @endcan

@endif
@if (Session::get('TypeController') == 'Role')
    @can('rol.admin')
        <form action="{{route('roles.destroy',$id)}}" method="POST" class="formEliminar">
            <div class="row  align-items-start">
                <div class="col">
                    <a href="{{route('roles.edit',$id)}}" ><img class="card-img-top" title="Editar Rol" src="{{asset('/imagen/iconos/pencil-squarenaranja.png')}}" alt="Card image" style="width:30px" style="display: inline-block"></a>
                </div>
                <div class="col">
                    @csrf
                    @method('DELETE')    
                    <input title="Eliminar Rol" src="{{asset('/imagen/iconos/trashrojo.png')}}"  type="image" style="width: 30px"/>
                </div>
            </div>
        </form>       
    @endcan    
@endif
@if (Session::get('TypeController') == 'Permiso')
     @can('rol.admin')
        <input type="checkbox" class="form-check-input ck" id="chboxpermiso" name="array_perm[]" style="transform: scale(1.5)" value="{{$id}}" {{$activo}}/>         
     @endcan
@endif

<script>
$(document).ready(function () {
    $(".formEliminar").submit(function(e){
        e.preventDefault(); 
        
        Swal.fire({
            title: 'Está usted seguro?',
            text: "No podrás revertir esto!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrarlo!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.isConfirmed) {
                
                this.submit();
            }
        })
    });
})    
</script>


