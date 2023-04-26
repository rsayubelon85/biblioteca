@extends('layouts.plantilla')

@section('contenido')
    @can('rol.trab')
        <a href="{{route('libros.create')}}" ><img class="card-img-top" title="Crear Libro" src="{{asset('/imagen/iconos/plus-square.png')}}" alt="Card image" style="width:40px"></a>    
    @endcan
    <input type="text" id="perm" value="{{$hay_perm}}" hidden="hidden">
    <div class="card">
        <div class="card-body">
            <table class="table table-primary table-striped mt-4" id="libros">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Estado</th>                        
                        <th scope="col" style="width: 100px">Acciones</th>                                               
                        <th scope="col">Descripción</th>
                        <th scope="col">Nombre del CLiente</th>
                    </tr>            
                </thead>
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
        $(document).ready(function () {
            var perm = $('#perm').val();
            var datatable = $('#libros').DataTable({
                "responsive": true,
                "autoWidth": false,
                "serverSide": true,
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
                "ajax": "{{ url('libros/libro') }}",
                "columns": [
                    {data: 'name'},
                    {
                        data:"image",
                        render:function(data,type,row) {
                            return '<center><img src="'+data+'"width="120" height="120"></center>'                            
                        }
                    },
                    {data: 'status'},                    
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'description'},
                    {data: 'nombre_cliente'},
                ]
            });
            if(perm){
                datatable.column(5).visible(true);
            }
            else{
                datatable.column(5).visible(false);
            }            
        })
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