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

        <section id="imprimir" class="invoice">
            <!-- title row -->
            <div class="row">
              <div class="col-xs-12">
                <h2 class="page-header">
                  <i class="fa fa-globe"></i> VillaSoft Punto
                <small class="pull-right">Fecha: {{date('d-m-y')}}</small>
                </h2>
              </div>
              <!-- /.col -->
            </div>
            <h3 class="box-title">@isset($title)
                {{$title}}
                @else
                {!!"Sistema"!!}
            @endisset</h3>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="operador">Operador</label>
                    <p>{{ $transferencia->operador ?? ''}}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="proveedor">Acción Realizada</label>
                    <p>Pasó de {{ $transferencia->accion ?? ''}}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="proveedor">Fecha</label>
                    <p>{{ $transferencia->created_at ?? '' }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="tipo_comprobante">Producto Origen Vender al {{$transferencia->origenVender_al ?? ''}}</label>
                    <p>{{ $transferencia->origenNombreProducto ?? ''}}</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Producto Destino Vender al {{$transferencia->destinoVender_al ?? ''}}</label>
                    <p>{{ $transferencia->destinoNombreProducto ?? ''}}</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Cantidad</label>
                    <p>{{ $transferencia->cantidadSumarDestino ?? ''}}</p>
                </div>
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
                                <th>ID</th>
                                <th>Producto Origen</th>
                                <th>Stock Ini.</th>
                                <th>Cant. Restar</th>
                                <th>Stock Fin.</th>
                                <th>Unidades</th>
                                <th>Producto Destino</th>
                                <th>Stock Ini.</th>
                                <th>Cant. Restar</th>
                                <th>Stock Fin.</th>
                                <th>Unidades</th>
                            </thead>
                            <tfoot>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>

                            {{-- <th><h4 id="total"><b>$. {{$transferencia->total ?? ''}}</b></h4></th> --}}
                            </tfoot>
                            <tbody>

                                    <tr>
                                    <td>{{$transferencia->id ?? ''}}</td>
                                    <td>{{$transferencia->origenNombreProducto ?? ''}}</td>
                                    <td>{{$transferencia->origenStockInicial ?? ''}}</td>
                                    <td>{{$transferencia->cantidadRestarOrigen}}</td>
                                    <td>{{$transferencia->origenStockFinal}}</td>
                                    <td>{{$transferencia->origenUnidades}}</td>
                                    <td>{{$transferencia->destinoNombreProducto ?? ''}}</td>
                                    <td>{{$transferencia->destinoStockInicial ?? ''}}</td>
                                    <td>{{$transferencia->cantidadSumarDestino}}</td>
                                    <td>{{$transferencia->destinoStockFinal}}</td>
                                    <td>{{$transferencia->destinoUnidades}}</td>

                                    </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>



        </div>
    </div>

{{-- fin de la cabecera de box --}}
</div>
<!-- /.box-body -->
<div class="box-footer">
    <a class="btn btn-danger no-print" href="{{ url()->previous() }}">{{__('Regresar')}}</a>
    <a onClick="imprimirContenido('imprimir')" target="_blank" class="btn btn-primary  hidden-print">
        <i class="fa fa-print"></i>
        Imprimir
    </a>
</div>
<!-- /.box-footer-->
</div>
<!-- /.box -->
</section>
@push('sciptsMain')

<script language="javascript">

    function imprimirContenido(el){
        // $('#guion').show();
        var restaurarPagina = document.body.innerHTML;
        // var urlPagina = window.location.href;

//        alert(urlPagina);
        // $('#headerPagina').show();
        // $('#firmaPagina').show();
        var imprimircontenido = document.getElementById(el).innerHTML;
        document.body.innerHTML = imprimircontenido;
        window.print();
        // $('#headerPagina').hide();
        // $('#firmaPagina').hide();
        document.body.innerHTML = restaurarPagina;
        // $('#guion').show();
        // window.location= urlPagina;

    }
//     $( document ).ready( function() {
// $("#print_button1").click(function(){
//     alert('entro');
//             var mode = 'iframe'; // popup
//             var close = mode == "popup";
//             var options = { mode : mode, popClose : close};
//             $("div.contePrint").printArea( options );
//         });
// });
</script>
@endpush

@endsection
