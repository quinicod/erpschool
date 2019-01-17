@extends('layouts.app')

@section('content')
    <div class="row page-header">
        <div class="col-md-10">
            <h1>Empresas</h1>
        </div>
        <div class="col-md-2">
            <a href="" class="btn botones" data-toggle="modal" data-target="#exampleModal"> Nueva Empresa</a>
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
                        <th>Ciudad</th>
                        <th>Codigo Postal</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $c)
                        <tr class="trhover">
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->city }}</td>
                            <td>{{ $c->cp }}</td>
                            <td>{{ $c->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <form action="{{route('companies.edit', ['id' => $c->id])}}" method="get" style="float: left;">
                                    @csrf
                                    <button type="submit" class="btn btnEdit btn-sm"><i class="fas fa-edit"></i></button>
                                </form>
                                <form action="{{route('companies.destroy', ['id' => $c->id])}}" method="post" style="float: left;">
                                   {{method_field('DELETE')}}
                                    @csrf
                                    <button type="submit" class="btn btnBorrar btn-sm" onclick="return confirm('¿Quieres borrar esta empresa?')"><i class="fas fa-trash-alt"></i></button>
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
              <h5 class="modal-title" id="exampleModalLabel">Nueva Empresa</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="{{route('companies.store')}}">
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
                                <label for="city" class="col-md-4 col-form-label text-md-right">Ciudad</label>
    
                                <div class="col-md-6">
                                    <input id="city" style="text-transform: capitalize;" type="city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}" required>
    
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="cp" class="col-md-4 col-form-label text-md-right">{{ __('Cp') }}</label>
    
                                <div class="col-md-6">
                                    <input id="cp" type="cp" class="form-control{{ $errors->has('cp') ? ' is-invalid' : '' }}" name="cp" required>
    
                                    @if ($errors->has('cp'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cp') }}</strong>
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
              <h5 class="modal-title" id="exampleModalLabel">Edición Empresa</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post" action="{{route('companies.update', ['id' => $company->id])}}">
                {{method_field('PATCH')}}
                    @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">Nombre</label>

                    <div class="">
                        <input id="name" style="text-transform: capitalize;" type="text"  class="form-control" name="name" value="{{ $company->name}}" maxlength="100" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="city" class="control-label">City</label>

                    <div class="">
                        <input id="city" style="text-transform: capitalize;" type="text"  class="form-control" name="city" value="{{ $company->city}}" maxlength="100" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cp" class="control-label">Cp</label>

                    <div class="">
                        <input id="cp" type="text"  class="form-control" name="cp" value="{{ $company->cp}}" maxlength="5" minlength="5" required autofocus>
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