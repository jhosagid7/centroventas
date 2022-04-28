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
                <h3 class="box-title">
                    @isset($title)
                        {{$title}}
                    @else
                        {!!"Sistema"!!}
                    @endisset
                </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        <div class="box-body">
            {{-- cabecera de box --}}

            <div class="row">
                <div class="col-lg-6">
                    <h3>Nuevo Cliente</h3>
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>


            <form action="{{ route('cliente.store')}}" enctype="multipart/form-data" method="POST" autocomplete="off">

                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input required type="text" name="nombre" class="form-control titulo" value="{{old('nombre')}}" placeholder="Nombre...">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="tipo_documento">Tipo Documento</label>
                            <select required class="form-control" name="tipo_documento">
                                <option value="CI">CI.V-</option>
                                <option value="CI">CI.E-</option>
                                <option value="RIF">RIF</option>
                                <option value="PAS">PAS</option>
                            </select>

                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="num_documento">Número de Documento</label>
                            <input required type="number" name="num_documento" class="form-control enteros" value="{{old('num_documento')}}" placeholder="Número de Documento...">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input required type="text" name="direccion" class="form-control mayuscula" value="{{old('direccion')}}" placeholder="Dirección...">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input required type="text" name="telefono" class="form-control"  data-inputmask='"mask": "(9999) 999-9999"' data-mask value="{{old('telefono')}}" placeholder="Teléfono...">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input required type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Email...">
                        </div>
                    </div>
                    {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="imagen">Imagen</label>
                            <input required type="file" name="imagen" class="form-control" accept="image/*">
                        </div>
                    </div> --}}

                </div>
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Conceder Privilegios</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">

                                <tbody style="padding: 0px;">
                                    <tr style="padding: 0px;">
                                        <td><h4 class="text-primary" style="margin-top: 0px !important;">Puede tener Cortesía: &nbsp;&nbsp;&nbsp; </h4></td>
                                        <td>
                                            <label>
                                                <input name="isCortesia" type="checkbox">
                                            </label>
                                        </td>
                                        <td><h4 class="text-primary" style="margin-top: 0px !important;">Puede tener Crédito: &nbsp;&nbsp;&nbsp;</h4></td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20"><label>
                                                <input name="isCredito" type="checkbox">

                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="padding: 0px;">
                                        <td><h4 class="text-primary" style="margin-top: 0px !important;">Fecha limite: (en días)&nbsp;&nbsp;&nbsp; </h4></td>
                                        <td><label>
                                            <input required type="limite_fecha" name="limite_fecha" class="form-control" value="{{old('limite_fecha')}}" placeholder="Fecha limite... (15)">

                                        </label></td>
                                        <td><h4 class="text-primary" style="margin-top: 0px !important;">Monto limite de crédito: (en Dolar)&nbsp;&nbsp;&nbsp;</h4></td>
                                        <td>
                                        <div class="sparkbar" data-color="#00a65a" data-height="20"><label>
                                            <input required type="limite_monto" name="limite_monto" class="form-control" value="{{old('limite_monto')}}" placeholder="Monto limite crédito... (40)">

                                        </label></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="estado_credito">Estado credito</label>
                                                    <select required class="form-control" name="estado_credito">
                                                        <option value="Activo">Activo</option>
                                                        <option value="Moroso">Moroso</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                </tbody>
                            </table>

                        </div>
                        <!-- /.table-responsive -->
                    </div>


                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <a class="btn btn-danger" href="{{ url()->previous() }}">{{__('Regresar')}}</a>
                    </div>
                </div>
                <!-- /.box -->
                <!-- /.box-body -->
                <div class="box-footer">
                    {{-- Footer --}}
                </div>
                <!-- /.box-footer-->
            </form>

        {{-- fin de la cabecera de box --}}
        </div>

{{-- </div> --}}
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
