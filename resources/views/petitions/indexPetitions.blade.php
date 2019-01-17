@extends('layouts.app')

@section('content')
    <div class="row page-header">
        <div class="col-md-10">
            <h1>Solicitudes</h1>
        </div>
        <div class="col-md-2">
            <a href="" class="btn botones" data-toggle="modal" data-target="#exampleModal"> Nueva Solicitud</a>
        </div>
    </div><br><br>
    <div class="row">
            <form action="{{ route('filtroPetitions') }}" method="post" class="form-inline">
                @csrf
                    
                @if(isset($desde))
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="" class="">Desde</label>
                        <input class="form-control" type="date" name="desde" value="{{ $hasta }}">
                    </div>
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="">Hasta</label>
                        <input class="form-control" type="date" name="hasta" value="{{ $desde }}">
                    </div>
                @else
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="" class="">Desde</label>
                        <input class="form-control" type="date" name="desde" value="{{ \Carbon\Carbon::now()->subYear()->format('Y-m-d')}}">
                    </div>
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="" class="">Hasta</label>
                        <input class="form-control" type="date" name="hasta" value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d')}}">
                    </div>
                    @endif
      
                      <div class="form-group mx-sm-5 mb-2">
                          <label for="">Grado</label>
                          <select class="form-control" id="" name="grade">
                                @if(isset($grade))
                                <option value="" >...</option>
                                    @foreach($grades as $g)
                                        @if($grade == $g->id)
                                            <option value="{{ $g->id }}" selected>{{ $g->name }}</option>
                                        @else
                                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="" selected>...</option>
                                    @foreach($grades as $g)
                                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                                    @endforeach
                                @endif
                          </select>
                      </div>
                      <div class="form-group mx-sm-5 mb-2">
                                <label for="">Tipo</label>
                                <select class="form-control" id="" name="type">
                                @if(isset($type))
                                    <option value="" >...</option>
                                    @if($type == 'Contrato')
                                        <option selected>Contrato</option>
                                    @else 
                                        <option>Contrato</option>
                                    @endif
                                    @if($type == 'Formación Dual')
                                        <option selected>Formación Dual</option>
                                    @else 
                                        <option>Formación Dual</option>
                                    @endif
                                    @if($type == 'Prácticas de FTC')
                                        <option selected>Prácticas de FTC</option>
                                    @else 
                                        <option>Prácticas de FTC</option>
                                    @endif
                                @else
                                    <option value="" selected>...</option>
                                    <option>Contrato</option>
                                    <option>Formación Dual</option>
                                    <option>Prácticas de FTC</option>
                                @endif
                                </select>
                          </div>
      
                    <button class="btn btn btn-outline-secondary btn-sm" type="submit">Aplicar</button>
                  </form>
    </div> <br> <br>
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
        <div class="col-md-10 offset-1">
            <table class="table table-striped table-hover" id="myTable">
                <thead class="thead-default">
                    <tr>
                        <th>Empresa</th>
                        <th>Curso</th>
                        <th>Tipo</th>
                        <th>Nº Estudiantes</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($petitions as $p)
                        <tr class="trhover">
                            <td>{{ $p->company->name }}</td>
                            <td>{{ $p->grade->name }}</td>
                            <td>{{ $p->type }}</td>
                            <td>{{ $p->n_students }}</td>
                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <form action="{{route('petitions.edit', ['id' => $p->id])}}" method="get" style="float: left;">
                                    @csrf
                                    <button type="submit" class="btn btnEdit btn-sm"><i class="fas fa-edit"></i></button>
                                </form>
                                <form action="{{route('petitions.destroy', ['id' => $p->id])}}" method="post" style="float: left;">
                                   {{method_field('DELETE')}}
                                    @csrf
                                    <button type="submit" class="btn btnBorrar btn-sm" onclick="return confirm('¿Quieres borrar esta Solicitud?')"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row marginTitulo justify-content-center">
        <form action="{{ route('listadoPdf')}}" method="POST">
            @csrf
            {{-- <input type="hidden" name="petitions" value="{{$petitions}}"> --}}
            @if(isset($desde))
                <input type="hidden" name="desde" value="{{$hasta}}">
            @endif
            @if(isset($hasta))
                <input type="hidden" name="hasta" value="{{$desde}}">
            @endif
            @if(isset($grade))
                <input type="hidden" name="grade" value="{{$grade}}">
            @endif
            @if(isset($type))
                <input type="hidden" name="type" value="{{$type}}">
            @endif
            <button class="btn btn-danger btn-xs"><i class="fas fa-download"></i> Listado en Pdf</button>
        </form>
    </div>
{{-- modal Crear--}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Nueva Petición</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="{{route('petitions.store')}}">
                    @csrf
                <div class="modal-body">
                    <div class="form-group{{ $errors->has('id_company') ? ' has-error' : '' }}">
                        <label for="id_company" class="control-label">Empresa</label>
                        <select class="form-control" name="id_company" id="id_company" required>
                            <option value="" selected>---</option>
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select> 
                            @if ($errors->has('id_company'))
                            <span class="help-block">
                                <strong>{{ $errors->first('id_company') }}</strong>
                            </span>
                        @endif
                    </div>

                        <div class="form-group{{ $errors->has('id_grade') ? ' has-error' : '' }}">
                            <label for="id_grade" class="control-label">Curso</label>
                            <select class="form-control" name="id_grade" id="id_grade" required>
                                <option value="" selected>---</option>
                                @foreach($grades as $g)
                                    <option value="{{ $g->id }}">{{ $g->name }}</option>
                                @endforeach
                            </select> 
                                @if ($errors->has('id_grade'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('id_grade') }}</strong>
                                </span>
                            @endif
                    </div>

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="control-label">Tipo</label>
                            <select class="form-control" name="type" id="type" required>
                                <option value="" selected>---</option>
                                <option value="Prácticas de FTC">Prácticas de FTC</option>
                                <option value="Formación Dua">Formación Dual</option>
                                <option value="Contrato">Contrato</option>
                            </select> 
                                @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                    </div>

                    <div class="form-group{{ $errors->has('n_students') ? ' has-error' : '' }}">
                        <label for="n_students" class="control-label">Nº Estudiantes</label>
                            <input id="n_students" type="number" class="form-control" name="n_students" max="3" autofocus>

                            @if ($errors->has('n_students'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('n_students') }}</strong>
                                </span>
                            @endif
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
            <form method="post" action="{{route('petitions.update', ['id' => $petition->id])}}">
                {{method_field('PATCH')}}
                    @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="id_company">Empresa
                    </label>
                    <div class="">
                        <select class="form-control" name="id_company" required>
                            @foreach($companies as $c)
                                @if ($petition->id_company == $c->id)
                                    <option value="{{ $c->id }}" selected>{{ $c->name }}</option>
                                @else
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endif
                            @endforeach
                        </select> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="id_grade">Empresa
                    </label>
                    <div class="">
                        <select class="form-control" name="id_grade" required>
                            @foreach($grades as $g)
                                @if ($petition->id_grade == $g->id)
                                    <option value="{{ $g->id }}" selected>{{ $g->name }}</option>
                                @else
                                    <option value="{{ $g->id }}">{{ $g->name }}</option>
                                @endif
                            @endforeach
                        </select> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="type">Empresa
                    </label>
                    <div class="">
                        <select class="form-control" name="type" required>
                            @if ($petition->type == 'Prácticas de FTC')
                                <option value="Prácticas de FTC" selected>Prácticas de FTC</option>
                                <option value="Formación Dua">Formación Dual</option>
                                <option value="Contrato">Contrato</option>
                            @elseif($petition->type == 'Formación Dua')
                                <option value="Prácticas de FTC">Prácticas de FTC</option>
                                <option value="Formación Dua" selected>Formación Dual</option>
                                <option value="Contrato">Contrato</option>
                            @else
                                <option value="Prácticas de FTC">Prácticas de FTC</option>
                                <option value="Formación Dua">Formación Dual</option>
                                <option value="Contrato" selected>Contrato</option>
                            @endif
                        </select> 
                    </div>
                </div>

                <div class="form-group">
                    <label for="n_students" class="control-label">Nº Estudiantes</label>

                    <div class="">
                        <input id="n_students" type="number" class="form-control" name="n_students" value="{{ $petition->n_students}}">
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