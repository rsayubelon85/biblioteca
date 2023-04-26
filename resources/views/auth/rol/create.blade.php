@extends('layouts.plantilla')

@section('contenido')
    <h2>CREAR ROL</h2>
    <form action="{{route('roles.store')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="" class="form-label">Nombre</label>
            <input id="name" name="name" type="text" class="form-control" tabindex="1" value="{{old('name')}}">
            @error('name')
                <br>
                <small>*{{$message}}</small>
                <br>
            @enderror
        </div>
        <a href="{{route('roles.index')}}" class="btn btn-secondary" tabindex="3">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    
@endsection
@section('js')
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