@extends('layouts.plantilla')

@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('EDITAR TRABAJADOR') }}</div>

                <div class="card-body">
                    <form action={{route('users.update',$user)}} method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}">
                                @error('name')
                                    <small>*{{$message}}</small>
                                    <br>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Apellidos') }}</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name',$user->last_name) }}">
                                @error('last_name')
                                    <small>*{{$message}}</small>
                                    <br>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="id_number" class="col-md-4 col-form-label text-md-end">{{ __('Carnet') }}</label>
                            <div class="col-md-6">
                                <input id="id_number" type="text" class="form-control" name="id_number" value="{{ old('id_number',$user->id_number) }}" autocomplete="id_number">
                                @error('id_number')
                                    <small>*{{$message}}</small>
                                    <br>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">                            
                            <div class="col-md-10">
                                <label for="password" class="col-md-12 col-form-label text-md-end">{{ __('Si no desea cambiar la contraseña deje los campos en blanco') }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">                            
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Nueva Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" autocomplete="new-password">
                                @error('password')
                                    <small>*{{$message}}</small>
                                    <br>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar Nueva Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                @error('password_confirmation')
                                    <small>*{{$message}}</small>
                                    <br>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{route('users.index')}}" class="btn btn-secondary" tabindex="3">Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
