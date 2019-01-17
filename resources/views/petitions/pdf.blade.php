<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{asset('bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
</head>
<body>
    <h1>Listado de Solicitudes</h1>
    <br>
    <div class="row">
        <div class="col-md-12">
                <div class="col-md-3">
                        @if($desde !=null)
                            <p>Desde: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y')}}</p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        @if($hasta !=null)
                            <p>hasta: {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y')}}</p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        @if($type !=null)
                            <p>Tipo de solicitud: {{$type}}</p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        @if($grade !=null)
                            <p>Grado: {{$grade}}</p>
                        @endif
                    </div>
        </div>  
    </div>

        <table class="table table-striped" id="myTable">
                <thead class="thead-default">
                    <tr>
                        <th>Empresa</th>
                        <th>Curso</th>
                        <th>Tipo</th>
                        <th>Nº Estudiantes</th>
                        <th>Fecha Creación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($petitions as $p)
                        <tr class="trhover">
                            <td width=35%;>{{ $p->company->name }}</td>
                            <td width=35%;>{{ $p->grade->name }}</td>
                            <td>{{ $p->type }}</td>
                            <td>{{ $p->n_students }}</td>
                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
</body>
</html>