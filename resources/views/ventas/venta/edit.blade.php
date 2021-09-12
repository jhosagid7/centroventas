@extends ('layouts.admin3')
@section('contenido')

    <div class="row">
        <div class="col-lg-6">
            <h3>Editar Cliente: {{$persona->nombre}}</h3>
            @include('custom.message')
        </div>
    </div>

            {{-- {!! Form::model($persona,['route'=>['proveedor.update', $persona->idpersona], 'method'=>'PATCH']) !!}
            {{ Form::token() }} --}}
            <form action="{{ route('proveedor.update', $persona->id)}}" enctype="multipart/form-data" method="POST" autocomplete="off" role="buscar">
                @csrf
                @method('PUT')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{$persona->nombre}}" placeholder="Nombre...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="tipo_documento">Tipo Documento</label>
                <input type="text" name="tipo_documento" class="form-control" value="{{$persona->tipo_documento}}" placeholder="Tipo Documento...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="num_documento">Número de Documento</label>
                <input type="text" name="num_documento" class="form-control" value="{{$persona->num_documento}}" placeholder="Número de Documento...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="{{$persona->direccion}}" placeholder="Dirección...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{$persona->telefono}}" placeholder="Teléfono...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" value="{{$persona->email}}" placeholder="Email...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>
            </form>
            {{-- {!! Form::close() !!} --}}


@endsection
