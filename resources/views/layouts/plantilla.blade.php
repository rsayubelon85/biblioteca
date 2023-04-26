<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"> 
    <link rel="stylesheet" href="{{asset('css/cloudflare.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.bootstrap5.min.css')}}">

    <style>
      .file {
      visibility: hidden;
      position: absolute;
      }
      .table{
        width: 100%;
        text-align: left;
        background-color: aliceblue;
        border-collapse: collapse;
      }
      .table th{
        background-color: #c3e7fb;
        color: black;
      }
      .table td{
        background-color: rgb(248, 250, 252);
        color: black;
      }   
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg text-center" style="background-color: #e3f2fd;">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="{{asset('/imagen/icono.png')}}" style="width: 40px"/>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            @auth
              @can('rol.cli')
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{route('catalogo.index')}}" id="nav_reserva">Catálogo</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{route('reserva.index')}}" id="nav_reserva">Reservas</a>
                </li>   
              @endcan
              @can('rol.trab')
                <li class="nav-item">
                  <a class="nav-link" href="{{route('libros.index')}}" id="nav_libro">Libros</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('users.index_cliente')}}" id="nav_cliente">Clientes</a>
                </li>   
              @endcan                                                    
              @can('rol.admin')
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="nav_gusuarios">
                    Gestión de Seguridad
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('roles.index')}}"  id="nav_roles">Roles</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{route('users.index')}}">Usuarios</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{route('permiso.index')}}">Asignar Permisos a Rol</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{route('traza.index')}}">Trazas</a></li>
                  </ul>
                </li>                 
              @endcan            

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{auth()->user()->name ?? ''}}
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{route('perfil.edit','')}}">Editar</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="{{route('logout')}}">Desconectarse</a></li>
                </ul>
              </li>
            @endauth             
        </div>
      </div>
    </nav>    
    <div class="container">
        @yield('contenido')
    </div> 
    <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>       
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('js/dataTables.responsive.min.js')}} "></script>
    <script src="{{asset('js/responsive.bootstrap5.min.js')}}"></script>

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script><!--https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"-->
    <script src="{{asset('js/sweetalert2_11.js')}}"></script>

    <div class="container">
        @yield('js')
    </div>
  </body>
</html>