@extends('layouts.plantilla')

@section('contenido')
    <div class="py12">
        <div class="max-w-71 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-x1 sm:rounded-lg">
                <h2>EDITAR LIBRO</h2>
                <form action="{{route('libros.update',$libro)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="form-label">Nombre</label>
                        <input id="name" name="name" type="text" class="form-control" tabindex="1" value="{{old('name',$libro->name)}}">
                        @error('name')
                            <br>
                            <small>*{{$message}}</small>
                            <br>
                        @enderror           
                        <br>
                        <label class="form-label">Descripción</label>
                        <textarea id="description" name="description" rows="5" type="text" class="form-control" tabindex="1" >{{old('description',$libro->description)}}</textarea>
                        @error('description')
                            <br>
                            <small>*{{$message}}</small>
                            <br>
                        @enderror
                        <input type="text" name="imagen_update" value="{{$libro->image}}" hidden>
                        <div class="form-group">
                            <input type="file" name="imagen" class="imagen" hidden>
                            <div class="input-group my-3">
                                <input type="text" class="form-control" disabled placeholder="Cargar imagen" id="imagen" value="{{old('imagen',$libro->image)}}">
                                <div class="input-group-append">
                                    <button type="button" class="browse btn btn-primary">Browse...</button>
                                </div>
                            </div>
                            @error('image')
                                <small>*{{$message}}</small>
                                <br>
                            @enderror
                        </div>
                        <div class="form-group">
                            <img src="{{asset($libro->image)}}" id="preview" class="img-thumbnail">
                        </div>
                        <br>
                    </div>
                    
                    <a href="{{route('libros.index')}}" class="btn btn-secondary" tabindex="3">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>            
            </div>
        </div>
    </div>
    
@endsection
@section('js')
    <script>
        $(document).on("click", ".browse", function() {
            var file = $(this).parent().parent().parent().find(".imagen");
            file.trigger("click");
            });
        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $("#imagen").val(fileName);
            
            var reader = new FileReader();
            reader.onload = function(e) {
                // get loaded data and render thumbnail.
                document.getElementById("preview").src = e.target.result;
            };
            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
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