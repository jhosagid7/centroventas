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
            <h3>Editar Cliente: {{$persona->nombre}}</h3>
            @include('custom.message')
        </div>
    </div>


            <form action="{{ route('cliente.update', $persona->id)}}" method="POST" autocomplete="off" role="buscar">
                @csrf
                @method('PUT')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input required type="text" name="nombre" class="form-control titulo" value="{{$persona->nombre}}" placeholder="Nombre...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="tipo_documento">Tipo Documento</label>
                <select required class="form-control" name="tipo_documento">
                    @if ($persona->tipo_documento=='CI.V-')
                        <option value="CI.V-" selected>CI.V-</option>
                        <option value="CI.E-">CI.E-</option>
                        <option value="RIF">RIF</option>
                    <option value="PAS">PAS</option>
                    @elseif($persona->tipo_documento=='CI.E-')
                        <option value="CI.V-">CI.V-</option>
                        <option value="CI.E-" selected>CI.E-</option>
                        <option value="RIF">RIF</option>
                        <option value="PAS">PAS</option>
                    @elseif($persona->tipo_documento=='RIF')
                        <option value="CI.V-">CI.V-</option>
                        <option value="CI.E-">CI.E-</option>
                        <option value="RIF" selected>RIF</option>
                        <option value="PAS">PAS</option>
                    @else
                        <option value="CI.V-">CI.V-</option>
                        <option value="CI.E-">CI.E-</option>
                        <option value="RIF">RIF</option>
                        <option value="PAS" selected>PAS</option>
                    @endif
                </select>

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="num_documento">Número de Documento</label>
                <input required type="text" name="num_documento" class="form-control enteros" value="{{$persona->num_documento}}" placeholder="Número de Documento...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input required type="text" name="direccion" class="form-control mayuscula" value="{{$persona->direccion}}" placeholder="Dirección...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input required type="text" name="telefono" class="form-control" data-inputmask='"mask": "(9999) 999-9999"' data-mask value="{{$persona->telefono}}" placeholder="Teléfono...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="email">Email</label>
                <input required type="email" name="email" class="form-control" value="{{$persona->email}}" placeholder="Email...">
            </div>
        </div>
        {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" class="form-control">
            @if(($persona->imagen) !="")
                <img src="{{asset('imagenes/personas/'.$persona->imagen)}}" alt="{{$persona->nombre}}" height="100px" width="100px">
            @endif
            </div>
        </div> --}}
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a class="btn btn-danger" href="{{ url()->previous() }}">{{__('Regresar')}}</a>
            </div>
        </div>
    </div>

            </form>

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
                $(function() {
    $('.enteros').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});

$('.decimal').on('keypress', function(e) {
    // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
    var field = $(this);
    key = e.keyCode ? e.keyCode : e.which;

    if (key == 8) return true;
    if (key > 47 && key < 58) {
        if (field.val() === "") return true;
        var existePto = (/[.]/).test(field.val());
        if (existePto === false) {
            regexp = /.[0-9]{10}$/;
        } else {
            regexp = /.[0-9]{2}$/;
        }

        return !(regexp.test(field.val()));
    }
    if (key == 46) {
        if (field.val() === "") return false;
        regexp = /^[0-9]+$/;
        return regexp.test(field.val());
    }
    return false;
});
            });

        </script>
        @endpush
@endsection
