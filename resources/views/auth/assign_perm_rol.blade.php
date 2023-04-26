@extends('layouts.plantilla')

@section('contenido')
    <form action="{{route('asigna.perm')}}" method="POST">
        @csrf        
        
        <label for="rol" class="col-md-1 col-form-label text-md-end">{{ __('Seleccionar Rol') }}</label>
        <select name="roles[]" id="select-roles" class="form-control selectpicker" data-style="btn-primary" title="Seleccionar Rol">
            @foreach ($roles as $rol)
                <option value="{{$rol->id}}">{{$rol->name}}</option>
            @endforeach
        </select><br>
        <button type="submit" class="btn btn-primary">Asignar</button>
        
        <div class="card">
            <div class="card-body">
                <table class="table table-primary table-striped mt-4" id="permisos">
                    <thead>
                        <tr>
                            <th><input name="Todos" type="checkbox" value="1" class="check_todos form-check-input" style="transform: scale(1.5)"/>    Todos</th>
                            <th scope="col">Nombre</th>                        
                        </tr>            
                    </thead>
                </table>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('js/dataTables.responsive.min.js')}} "></script>
    <script src="{{asset('js/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{asset('js/configuracion.js')}}"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            $(".check_todos").click(function(event){
                if($(this).is(":checked")){
                    $(".ck:checkbox:not(:checked)").attr("checked","checked");
                }
                else{
                    $(".ck:checkbox:checked").removeAttr("checked","checked");
                }
            });
            
        });

        $(function(){
            var table = $('#permisos').DataTable({
                processing: true,
                serverSide: false,
                language: {
                    lengthMenu:   'Mostrando <select class="custom-select custom-select-sm form-control form-control-sm"> '+
                                    '<option value="10">10</option>'+
                                    '<option value="25">25</option>'+
                                    '<option value="50">50</option>'+
                                    '<option value="100">100</option>'+
                                    '<option value="-1">Todos</option>'+
                                    '</select> registros por página',
                    zeroRecords: "Registros no encontrados - disculpe",
                    emptyTable: "No hay datos",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    infoEmpty: "No hay coincidencias",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    search:"Buscar",
                    loadingRecords:"Cargando...",
                    processing:"Procesando...",
                    paginate:{
                        first: "Primero",
                        last: "Último",
                        next:"Siguiente",
                        previous:"Anterior"
                    }
                },
                ajax: {
                url: "{{ route('permisos.show') }}",
                data: function (d) {
                        d.role = $('#select-roles').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'nombre_real', name: 'nombre_real'},
                ]
            });

            $('#select-roles').change(function(){
                table.ajax.reload();
            });
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