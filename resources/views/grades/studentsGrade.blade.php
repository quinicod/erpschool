@extends('layouts.app')
@section('content')
    <div class="row page-header">
        <div class="col-md-10">
            <h1>{{ $grade->name }}</h1>
        </div>
        <div class="col-md-2">
            <a href="" class="btn botones" data-toggle="modal" data-target="#exampleModal"> Añadir Estudiante</a>
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
            <div class="col-md-10 offset-1 ">
                <table class="table table-striped table-hover" id="myTable">
                    <thead class="thead-default">
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Años</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grade->students as $s)
                            <tr class="trhover">
                                <td>{{ $s->name }}</td>
                                <td>{{ $s->lastname }}</td>
                                <td>{{ $s->age }}</td>
                                <td><a class="btn btnBorrar btn-sm" href="{{ route('borrarAlumnoCurso', ['id_c' => $grade->id, 'id_a' => $s->id]) }}" onclick="return confirm('¿Quieres borrar ha este alumno de {{ $grade->name }}?')"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row marginTitulo"><a class="btn btn-outline-secondary" href="../grades">Volver</a></div>

{{-- modal Añadir estudiante --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Añadir Estudiante</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form method="POST" action="{{route('addStudent', ['id_g' => $grade->id])}}">
                            @csrf
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">Alumnos</label>
                                <select multiple class="form-control" id="exampleFormControlSelect2" name="students[]">
                                    <option>Seleccione uno o mas Estudiantes...</option>
                                    @foreach($students as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                                <p>Pulse Ctrl para seleccionar varios.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Añadir</button>
                            </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>

    
@endsection