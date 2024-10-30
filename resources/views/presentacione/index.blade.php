@extends('template')

@section('title','presentaciones')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('css/datatables.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
@endpush

@section('content')
    
    @if(session('success'))
    <script>

        let message = "{{ session('success') }}";
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
            icon: "success",
            title: message
        });
    </script>
    @endif

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Presentaciones</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel')}}">Inicio</a></li>
            <li class="breadcrumb-item active">Presentaciones</li>
        </ol>

        <div class="mb-4">
            <a href="{{route ('presentaciones.create')}}">
                <button type="button" class="btn btn-primary">Añadir nueva presentacion</button>
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Presentaciones
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>                    
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($presentaciones as $presentacione)
                            <tr>
                                <td>
                                    {{$presentacione->caracteristica->nombre}}
                                </td>
                                <td>
                                    {{$presentacione->caracteristica->descripcion}}
                                </td>
                                <td>
                                    @if ($presentacione->caracteristica->estado == 1)
                                        <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                                    @else
                                        <span class="fw-bolder p-1 rounded bg-danger text-white">Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class ="btn-group" role="group" aria-label="Basic mixed styles example">
                                        
                                    <form action="{{route('presentaciones.edit',['presentacione'=>$presentacione])}}" method="get">
                                            <button type="submit" class="btn btn-warning">Editar</button>
                                        </form>
                                        
                                        @if ($presentacione->caracteristica->estado == 1)
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$presentacione->id}}">Eliminar</button>                                    
                                        @else
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal-{{$presentacione->id}}">Restaurar</button>
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal-{{$presentacione->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{$presentacione->caracteristica->estado == 1 ? '¿Estas seguro de elminiar esta presentación?' : '¿Estas seguro de restaurar esta presentació?'}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <form action="{{route('presentaciones.destroy',['presentacione'=>$presentacione->id]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Confirmar</button>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>         
@endpush