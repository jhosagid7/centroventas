@extends ('layouts.admin3')
@section('contenido')




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

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <p>{{ $venta->nombre}}</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="tipo_comprobante">Tipo Comprobante</label>
                <p>{{ $venta->tipo_comprobante}}</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="serie_comprobante">Control Comprobante</label>
                <p>{{ $venta->serie_comprobante}}</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="num_comprobante">Número Comprobante</label>
                <p>{{ $venta->num_comprobante}}</p>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <table id="detalles" class="table table-striped table-borderd table-condensed table-hover">
                            <thead style="background-color: #A9D0F5">
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Precio Venta</th>
                                <th>Descuento</th>
                                <th>Subtotal</th>
                            </thead>
                            <tfoot>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            <th><h4 id="total"><b>$. {{$venta->total_venta}}</b></h4></th>
                            </tfoot>
                            <tbody>
                                @foreach ($detalles as $detalle)
                                    <tr>
                                    <td>{{$detalle->articulo}}</td>
                                    <td>{{$detalle->cantidad}}</td>
                                    <td>{{$detalle->precio_venta_unidad}}</td>
                                    <td>{{$detalle->descuento}}</td>
                                    <td>{{$detalle->cantidad*$detalle->precio_venta_unidad-$detalle->descuento}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a class="btn btn-warning" href="{{route('venta.index')}}">{{__('Back')}}</a>
                </div>

            </div>



        </div>
    </div>

</div>
</div>


@endsection
