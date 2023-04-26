@extends('layouts.plantilla')

@section('contenido')    
    <div class="card">
        <div class="card-body">
            <table class="table table-primary table-striped mt-4" id="libros_usuarios">
                <thead>
                    <tr>
                        <th scope="col">Nombre del Libro</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Fecha Tope de Devolución</th>
                    </tr>            
                </thead>
                <tbody>
                    @foreach ($libros_user as $libro_u)
                    <tr>
                        <td>{{$libro_u['name']}}</td>
                        <td><img src="{{asset($libro_u['image'])}}"/></td>
                        <td>{{$libro_u['description']}}</td>
                        <td>{{$libro_u['fecha_devolucion']}}</td> 
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('js/dataTables.responsive.min.js')}} "></script>
    <script src="{{asset('js/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{asset('js/configuracion.js')}}"></script>
    <script type="application/javascript">
            $('#libros_usuarios').DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "lengthMenu":   'Mostrando <select class="custom-select custom-select-sm form-control form-control-sm"> '+
                                    '<option value="10">10</option>'+
                                    '<option value="25">25</option>'+
                                    '<option value="50">50</option>'+
                                    '<option value="100">100</option>'+
                                    '<option value="-1">Todos</option>'+
                                    '</select> registros por página',
                    "zeroRecords": "Registros no encontrados - disculpe",
                    "emptyTable": "No hay datos",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay coincidencias",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search":"Buscar",
                    "loadingRecords":"Cargando...",
                    "processing":"Procesando...",
                    "paginate":{
                        "first": "Primero",
                        "last": "Último",                        
                        "next":"Siguiente",
                        "previous":"Anterior"
                    },
                },
            });
    </script>
    @if(session('hay_mensaje'))
        <script>            
            var icon = "{{ Session::get('icon') }}";
            var title = "{{ Session::get('title') }}";
            var text = "{{ Session::get('text') }}";
            var timer = "{{ Session::get('timer') }}";
            var position = "{{ Session::get('position') }}";
            var showConfirmButton = "{{ Session::get('showConfirmButton') }}";
            Swal.fire({
                'title':title,
                'text':text,
                'icon':icon,
                'timer':timer,
                'position':position,
                'showConfirmButton':showConfirmButton
            })
        </script>
    @endif
@endsection