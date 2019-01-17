@extends('layouts.app')

@section('content')
    <div class="row page-header">
        <div class="col-md-10">
            <h1>Estudiantes</h1>
        </div>
        <div class="col-md-2">
            <a href="" class="btn botones" data-toggle="modal" data-target="#exampleModal"> Nuevo Estudiante</a>
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
                        <th>Apellidos</th>
                        <th>Años</th>
                        <th>Cursos</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $s)
                        <tr class="trhover">
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->lastname }}</td>
                            <td>{{ $s->age }}</td>
                                <td>
                                    @foreach($s->cursos as $c)
                                        <a href="{{route('grades.show', ['id' => $c->id])}}" class="btn btn-outline-primary btn-sm cursos">{{ $c->name }}</a>
                                    @endforeach
                                </td>
                            <td>{{ $s->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <form action="{{route('students.edit', ['id' => $s->id])}}" method="get" style="float: left;">
                                    @csrf
                                    <button type="submit" class="btn btnEdit btn-sm"><i class="fas fa-edit"></i></button>
                                </form>
                                <form action="{{route('students.destroy', ['id' => $s->id])}}" method="post" style="float: left;">
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
              <h5 class="modal-title" id="exampleModalLabel">Nuevo Estudiante</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="{{route('students.store')}}">
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
                                <label for="lastname" class="col-md-4 col-form-label text-md-right">Apellidos</label>
    
                                <div class="col-md-6">
                                    <input id="lastname" style="text-transform: capitalize;" type="lastname" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('lastname') }}" required>
    
                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="age" class="col-md-4 col-form-label text-md-right">Años</label>
    
                                <div class="col-md-6">
                                    <input id="age" type="age" class="form-control{{ $errors->has('age') ? ' is-invalid' : '' }}" name="age" required>
    
                                    @if ($errors->has('age'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('age') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                <label for="exampleFormControlSelect1">Example select</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                  <option>4</option>
                                  <option>5</option>
                                </select>
                              </div> --}}
                            
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
              <h5 class="modal-title" id="exampleModalLabel">Edición Alumno</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post" action="{{route('students.update', ['id' => $student->id])}}">
                {{method_field('PATCH')}}
                    @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">Nombre</label>

                    <div class="">
                        <input id="name" style="text-transform: capitalize;" type="text"  class="form-control" name="name" value="{{ $student->name}}" maxlength="50" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lastname" class="control-label">Apellidos</label>

                    <div class="">
                        <input id="lastname" style="text-transform: capitalize;" type="text"  class="form-control" name="lastname" value="{{ $student->lastname}}" maxlength="100" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="age" class="control-label">Años</label>

                    <div class="">
                        <input id="age" type="text"  class="form-control" name="age" value="{{ $student->age}}" maxlength="2" minlength="1" required autofocus>
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