@extends('layouts.plantilla')
@section('contenido')    
    <input type="text" id="tipo_config" value="traza_index" hidden="hidden">      
    <div class="card">
        <div class="card-body">
            <table class="table table-primary table-striped mt-4" id="trazas">
                <thead>
                    <tr>
                        <th scope="col">Usuario</th>
                        <th scope="col">Permiso</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Objeto Creado</th>
                        <th scope="col">Objeto Antes de Modificar</th>
                        <th scope="col">Objeto Modificado</th>
                        <th scope="col">Objeto Eliminado</th>                                                                                                
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
            var datatable = $('#trazas').DataTable({
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
                "ajax": "{{ url('trazas/tra') }}",
                "columns": [
                    {data: 'nombre_usuario'},
                    {data: 'nombre_permiso'},
                    {data: 'descripcion'},
                    {data: 'fecha'},
                    {data: 'obj_creado'},
                    {data: 'obj_antes_modificar'},
                    {data: 'obj_modificado'},
                    {data: 'obj_eliminado'},                    
                ]
            });
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