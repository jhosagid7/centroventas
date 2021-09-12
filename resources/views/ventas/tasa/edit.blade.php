@extends ('layouts.admin3')
@section('contenido')

<!-- Default box -->
<!-- Content Header (Page header) -->
    {{-- <section class="content-header">
      <h1>
        <!--Blank page-->
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section> --}}

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
          <h3 class="box-title">@isset($title)
              {{$title}}
              @else
              {!!"Sistema"!!}
          @endisset</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
        {{-- cabecera de box --}}

    <div class="row">
        <div class="col-lg-6">
            <h3>Configurar tasa: {{$tasa->nombre}}</h3>
            @include('custom.message')
        </div>
    </div>

            {{-- {!! Form::model($articulo,['route'=>['articulo.update', $articulo->idarticulo], 'method'=>'PATCH', 'files'=>'true']) !!}
            {{ Form::token() }} --}}
    <form action="{{ route('tasa.update', $tasa->id)}}" enctype="multipart/form-data" method="POST" autocomplete="off" role="buscar">
    @csrf
    @method('PUT')
    <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input readonly type="text" name="nombre" required value="{{$tasa->nombre}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="tasa">Tasa</label>
                <input autofocus type="text" name="tasa" required value="{{$tasa->tasa}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="porcentaje_ganancia">Margen ganancia</label>
                <input type="text" name="porcentaje_ganancia" required value="{{$tasa->porcentaje_ganancia}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="">Estado</label>
                <select name="estado" id="estado" class="form-control">

                    @if($tasa->estado)
                    <option value="{{$tasa->estado}}" selected>{{$tasa->estado}}</option>
                    <option value="Activo">Activo</option>
                    <option value="Cancealdo">Cancealdo</option>
                    <option value="Suspendido">Suspendido</option>
                    @else
                    <option value="Activo">Activo</option>
                    <option value="Cancealdo">Cancealdo</option>
                    <option value="Suspendido">Suspendido</option>
                    @endif

                </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="created_at">Creado el:</label>
                <input readonly type="text" name="created_at" required value="{{$tasa->created_at}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="updated_at">Actualizado el:</label>
                <input readonly type="text" name="updated_at" required value="{{$tasa->updated_at}}" class="form-control">
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
        </div>
    </div>


    {{-- fin de la cabecera de box --}}
</div>
<!-- /.box-body -->
<div class="box-footer">
  {{-- Footer --}}
</div>
<!-- /.box-footer-->
</div>
<!-- /.box -->
@push('sciptsMain')
        <script>
            $(document).ready(function() {
                var getJSON = function(url, callback) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('get', url, true);
                    xhr.responseType = 'json';
                    xhr.onload = function() {
                        var status = xhr.status;
                        if (status == 200) {
                            callback(null, xhr.response);
                        } else {
                            callback(status);
                        }
                    };
                    xhr.send();
                };
            });
            getJSON('https://www.googleapis.com/freebase/v1/text/en/bob_dylan', function(err, data) {
     if (err != null) {
       alert('Something went wrong: ' + err);
     } else {
       alert('Your Json result is:  ' + data.result);
    //    result.innerText = data.result;
       result.innerText =JSON.stringify(data);
     }
});
</script>
@endpush
@endsection
