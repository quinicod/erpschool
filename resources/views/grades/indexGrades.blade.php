@extends('layouts.app')

@section('content')
    <div class="row page-header">
        <div class="col-md-10">
            <h1>Cursos</h1>
        </div>
        <div class="col-md-2">
            <a href="" class="btn botones" data-toggle="modal" data-target="#exampleModal"> Nuevo Curso</a>
        </div>
    </div>
    <div class="row">
            @if (session('modificado'))
                <div class="alert alert-success" >
                    {{ session('modificado') }}
                </div>
              @endif
              @if (session('eliminado'))
                <div class="alert alert-danger" >
                    {{ session('eliminado') }}
                </div>
              @endif
        </div>
    <div class="row">
        <div class="col-md-10 offset-1 marginTitulo">
            <table class="table table-striped table-hover" id="myTable">
                <thead class="thead-default">
                    <tr>
                        <th>Nombre</th>
                        <th>Nivel</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $g)
                        <tr class="trhover">
                            <td>{{ $g->name }}</td>
                            <td>{{ $g->level }}</td>
                            <td>{{ $g->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{route('grades.show', ['id' => $g->id])}}" class="btn btnAdd btn-sm" style="float: left;"><i class="fas fa-user-graduate"></i></a>
                                <form action="{{route('grades.edit', ['id' => $g->id])}}" method="get" style="float: left;">
                                    @csrf
                                    <button type="submit" class="btn btnEdit btn-sm"><i class="fas fa-edit"></i></button>
                                </form>
                                <form action="{{route('grades.destroy', ['id' => $g->id])}}" method="post" style="float: left;">
                                   {{method_field('DELETE')}}
                                    @csrf
                                    <button type="submit" class="btn btnBorrar btn-sm" onclick="return confirm('¿Quieres borrar este alumno?')"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

{{-- modal Crear--}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Nuevo Curso</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="{{route('grades.store')}}">
                    @csrf
            <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>
    
                                <div class="col-md-6">
                                    <input id="name" style="text-transform: capitalize;" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
    
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="level" class="col-md-4 col-form-label text-md-right">Grado</label>
    
                                <div class="col-md-6">
                                    <select class="form-control" name="level" required>
                                        <option>Seleccione el grado...</option>
                                        <option>Medio</option>
                                        <option>Superior</option>
                                    </select>
    
                                    @if ($errors->has('level'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('level') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
          </div>
        </div>
      </div>

      {{-- modal Editar--}}

      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edición de Curso</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post" action="{{route('grades.update', ['id' => $grade->id])}}">
                {{method_field('PATCH')}}
                    @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">Nombre</label>

                    <div class="">
                        <input id="name" style="text-transform: capitalize;" type="text"  class="form-control" name="name" value="{{ $grade->name}}" maxlength="50" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="level" class="control-label">Nivel</label>

                    <div class="">
                        <input id="level" type="text"  class="form-control" name="level" value="{{ $grade->level}}" maxlength="100" required autofocus>
                    </div>
                </div>
            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
          </div>
        </div>
      </div>
      
      
@endsection
@section('script')
    <script>
        $(document).ready(function() {
        var n = {{$errors->count()}}
        if(n > 0){
            $('#exampleModal').modal('show')
        }
      });
    </script>
    <script>
        $(document).ready(function() {
        var a = {{$abrir}}
        if(a){
            $('#editModal').modal('show')
        }
      });
    </script>
@endsection