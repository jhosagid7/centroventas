@extends ('layouts.admin3')
@section('contenido')





    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border  no-print">
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

        <!-- /.box-body -->
        <div class="box-footer no-print">
            @if ($caja->estado === 'Abierta')
            <a href="" data-target="#modal-delete-{{$caja->id}}" data-toggle="modal"><button class='btn btn-danger'><i class='glyphicon glyphicon-trash'></i> Cerrar caja</button></a>
            @can('haveaccess', 'ventas.create')
            <a class="btn btn-success" href="{{route('venta.create')}}">{{__('Ir a ventas')}}</a>
            @endcan
            @endif
            <a class="btn btn-warning" href="{{route('caja.index')}}">{{__('Ir a cajas')}}</a>
            <a onClick="imprimir('imprimir')" target="_blank" class="btn btn-primary  hidden-print">
                <i class="fa fa-print"></i>
                Imprimir
            </a>
            {{-- <button onclick="imprimir()">Imprimir pantalla</button> --}}

        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->
    <!-- Main content -->
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
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <h4><strong>Datos de Caja:</strong></h4>
        <address>
        <strong>Código: </strong> {{ $caja->codigo}}<br>
        <strong>Operador: </strong> {{ $caja->user->name}}<br>
        <strong>Fecha: </strong> {{ $caja->fecha->format('d-m-Y')}}<br>
        <strong>Estado: </strong> {{ $caja->estado}}<br>
        <strong>Ventas Realizadas: </strong> {{ $cajas->SumaTotalCantidadVentas ?? '0' }}<br>
        <strong>Articulos Vendidos: </strong> {{ $cajas->SumaArticulosVendidos ?? '0' }}<br>
        @can('haveaccess', 'cajautilidad.show')
        <strong>Tasa Venta Efectivo: </strong> {{ $cajas->tasaActualVenta ?? '0' }}<br>
        <strong>% Venta Efectivo: </strong> {{ $cajas->margenActualVenta ?? '0' }}<br>
        @endcan
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <h4><strong>Bolsa Ventas:</strong></h4>
             @php
                if($cajas->margenActualVenta){
                    $utilidadEfectivo = $cajas->SumaTotalBolivar*$cajas->margenActualVenta/100;
                    if($utilidadEfectivo == 0){
                        $margenGananciaVentaEfectivo = 0;
                    }else{
                        $totalVentaEfectivo = $utilidadEfectivo + $cajas->SumaTotalBolivar;
                        $margenGananciaVentaEfectivo = $utilidadEfectivo/ $totalVentaEfectivo;
                    }
                }else{
                    $utilidadEfectivo = 0;
                }



                if($cajas->tasaActualVenta){
                    $efectivoToDolar = $utilidadEfectivo/$cajas->tasaActualVenta;

                }

                else{
                    $efectivoToDolar = 0;
                }
            @endphp
        <address>
            <strong>Total Dolar: </strong> {{ $cajas->SumaTotalDolar ?? '0.000' }}<br>
            <strong>Total Peso: </strong> {{ number_format($cajas->SumaTotalPeso,2,'.',',') ?? '0.00' }}<br>
            <strong>Total Punto: </strong> {{ number_format($cajas->SumaTotalPunto,2,'.',',') ?? '0.00' }}<br>
            <strong>Total Transf: </strong> {{ number_format($cajas->SumaTotalTransferencia,2,'.',',') ?? '0.00' }}<br>
            <strong>Total Bolivar: </strong> {{ number_format($cajas->SumaTotalBolivar,2,'.',',') ?? '0.00' }}<br>
            @can('haveaccess', 'cajautilidad.show')
            <strong>Total Efectivo venta: </strong> {{ number_format($utilidadEfectivo,2,'.',',') ?? '0.00' }}<br>
            @endcan
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <h4><strong>Totales:</strong></h4>
        <address>

            <div class="table-responsive">
            @can('haveaccess', 'cajatotales.show')
                <table class="table">
                    @can('haveaccess', 'cajapreciocosto.show')
                  <tr>
                    <th style="width:60%">Precio Costo:</th>
                    <td>${{ number_format($cajas->SumaTotalCostoVentas, 3,',','.') ?? '0.00' }}</td>
                  </tr>
                  @endcan
                  @can('haveaccess', 'cajautilidad.show')
                  <tr>
                    <th>
                        @if ($cajas->SumaTotalVentas)
                            Utilidad ({{ number_format($cajas->SumaTotalUtilidadVentas / $cajas->SumaTotalVentas,3,',','.') ?? '0.00' }}%)
                        @else
                            Utilidad ({{ number_format(0,2,',','.') ?? '0.000' }}%)
                        @endif

                    </th>
                    <td>${{ $cajas->SumaTotalUtilidadVentas ?? '0.000' }}</td>
                  </tr>
                  @endcan
                  @can('haveaccess', 'cajatotalventa.show')
                  <tr>
                    <th>Total Venta:</th>
                    <td>${{ $cajas->SumaTotalVentas ?? '0.000' }}</td>
                  </tr>
                  @endcan
                  @can('haveaccess', 'cajautilidad.show')
                  <tr>
                    <th>Utilidad V/EF ({{ number_format($margenGananciaVentaEfectivo,3,',','.') ?? '0.000' }}%)</th>
                    <td>${{ number_format($efectivoToDolar,3,',','.') ?? '0.000' }}</td>
                  </tr>
                  <tr>
                    <th>Total Operación:</th>
                    <td>${{ number_format($cajas->SumaTotalVentas+$efectivoToDolar,3,',','.') ?? '0.000' }}</td>
                  </tr>
                  @endcan
                </table>
                @endcan
              </div>

        </address>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">

            <div class="panel panel-primary">
                <div class="panel-body">
                    <h4><strong>Datos de Caja</strong></h4>
                        <table id="detalles" class="table table-striped table-borderd table-condensed table-hover">
                            <thead style="background-color: #A9D0F5">
                    <tr>
                        <th>Codigo</th>
                        <th>Fecha</th>
                        <th>Hora inicio</th>
                        <th>Hora cierre</th>
                        <th>Inicio Dolar</th>
                        <th>Inicio Peso</th>
                        <th>Inicio Bolivar</th>
                        <th>Cierre Dolar</th>
                        <th>Cierre Peso</th>
                        <th>Cierre Bolivar</th>
                        <th>Estado</th>
                        <th>Caja</th>
                    </tr>
                </thead>
                <tbody id="listarcaja">

                    <tr>
                        <td>{{ $caja->codigo }}</td>
                        <td>{{ $caja->created_at->diffForHumans() }}</td>
                        <td>{{ $caja->hora }}</td>
                        <td>{{ $caja->hora_cierre }}</td>
                        <td>{{ $caja->monto_dolar }}</td>
                        <td>{{ $caja->monto_peso }}</td>
                        <td>{{ $caja->monto_bolivar }}</td>
                        <td>{{ $caja->monto_dolar_cierre }}</td>
                        <td>{{ $caja->monto_peso_cierre }}</td>
                        <td>{{ $caja->monto_bolivar_cierre }}</td>
                        <td>{{ $caja->estado }}</td>
                        <td>{{ $caja->caja }}</td>
                </tr>



                </tbody>
            </table>

            @include('cajas.caja.caja')
    </div></div></div>

    @can('haveaccess', 'cajadatosventas.show')
    <!-- Table row -->
    <div class="row">
        <div class="panel panel-primary">
      <div class="col-xs-12 table-responsive">

        <h4><strong>Datos de Ventas</strong></h4>
        <table class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>ID</th>
                <th>Fecha</th>
                <th>Comprobante</th>
                <th>Tasa</th>
                <th>Tipo Pago</th>
                @can('haveaccess', 'cajacosto.show')
                <th>Precio Costo</th>
                <th>% Ganancia</th>
                @endcan

                <th>Precio Venta</th>

                @can('haveaccess', 'cajacosto.show')
                <th>Utilidad</th>
                @endcan
                <th>Estado</th>

            </thead>
            <tbody>
                @foreach ($cajas->ventas as $venta)
                    @if ($venta->estado == 'Cancelada')
                        <tr style="background-color: red;" class="text-black ">
                    @else
                        <tr style="background-color: lightblue;" class="text-black ">
                    @endif
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->fecha_hora }}</td>
                    <td>{{ $venta->serie_comprobante }}</td>
                    <td>{{ $venta->tasaTransPunto }}</td>
                    <td>{{ $venta->tipo_pago }}</td>
                    @can('haveaccess', 'cajacosto.show')
                    <td>{{ floatval($venta->precio_costo) ?? '' }}</td>
                    <td>{{ $venta->margen_ganancia }}</td>
                    @endcan

                    <td>{{ floatval($venta->total_venta) ?? '' }}</td>

                    @can('haveaccess', 'cajacosto.show')
                    <td>{{ floatval($venta->ganancia_neta) ?? '' }}</td>
                    @endcan
                    <td>{{ $venta->estado }}</td>

                </tr>

                @endforeach
            </tbody>
        </table>
      </div>
    </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    @endcan
    @can('haveaccess', 'cajadatosarticulos.show')
    <div class="row">
        <div class="margin"></div>
        <div class="margin"></div>
        <div class="margin"></div>
        <div class="margin"></div>
        <div class="panel panel-primary">
            <div class="col-xs-12 table-responsive">

                <h4><strong>Datos de Articulos</strong></h4>
                <table class="table table-striped table-bordered table-condensed table-hover">

                    <tbody>
                        @php
                            $count = 0;
                            $actual = 0;

                        @endphp

                        @foreach ($cajas->articulo_ventas  as $art)
                        @if ($art->venta_id !== $actual)
                            @php
                            $actual = $art->venta_id;



                            @endphp
                            @if ($art->venta->estado == 'Cancelada')
                                <tr style="background-color: red;" class="text-black ">
                            @else
                                <tr style="background-color: lightblue;" class="text-black ">
                            @endif
                                <td colspan="2"><b>ID Factura: </b> {{$actual}}</td><td colspan="2"> <b>Tipo pago: </b> {{$art->venta->tipo_pago}}
                                     @if ($art->venta->tipo_pago == 'Trans/Punto')
                                        @if ($art->venta->num_Punto !== null)<b> &nbsp; Nº Punto:</b>{{$art->venta->num_Punto}}@endif
                                        @if ($art->venta->num_Trans !== null)<b> &nbsp; Nº Trans:</b>{{$art->venta->num_Trans}}@endif
                                    @endif
                                    @if ($art->venta->tipo_pago == 'Mixto')
                                        @if ($art->venta->num_Punto !== null)<b>&nbsp; Nº Punto:</b>{{$art->venta->num_Punto}}@endif
                                        @if ($art->venta->num_Trans !== null)<b>&nbsp; Nº Trans:</b>{{$art->venta->num_Trans}}@endif
                                    @endif
                                </td><td colspan="2"> <b>Tasa: </b> {{$art->venta->tasaTransPunto}}
                                </td><td colspan="3"><b>Porcentaje: </b>
                                     @if ($art->venta->tipo_pago == 'Dolar')

                                        {{$art->venta->porDolar}} %
                                     @endif
                                     @if ($art->venta->tipo_pago == 'Peso')
                                             @php
                                             if($art->porEspecial && $art->venta->tipo_pago == 'Peso' && $art->isPeso == '1'){
                                                 $v = 1;
                                             }
                                             @endphp
                                        {{$art->venta->porPeso}} %
                                     @endif
                                     @if ($art->venta->tipo_pago == 'Trans/Punto')
                                             @php
                                             if($art->porEspecial && $art->venta->tipo_pago == 'Trans/Punto' && $art->isTransPunto == '1'){
                                                 $v = 1;
                                             }
                                             @endphp
                                        {{$art->venta->porTransPunto}} %
                                     @endif
                                     @if ($art->venta->tipo_pago == 'Mixto')
                                             @php
                                             if($art->porEspecial && $art->venta->tipo_pago == 'Mixto' && $art->isMixto == '1'){
                                                 $v = 1;
                                             }
                                             @endphp
                                        {{$art->venta->porMixto}} %
                                     @endif
                                     @if ($art->venta->tipo_pago == 'Efectivo')
                                             @php
                                             if($art->porEspecial && $art->venta->tipo_pago == 'Efectivo' && $art->isEfectivo == '1'){
                                                $v = 1;
                                             }
                                             @endphp
                                        {{$art->venta->porEfectivo}} %
                                     @endif

                                    </td>
                                    <td colspan="2"><b>Operacion: </b>{{$art->venta->estado}}</td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                @can('haveaccess', 'cajacosto.show')
                                <th>P/Costo</th>
                                <th>%/Espal</th>
                                @endcan
                                <th>Cant.</th>
                                @can('haveaccess', 'cajacosto.show')
                                <th>T/Costo.</th>
                                @endcan
                                <th>P/Venta</th>
                                <th>T/Venta.</th>
                                <th>Utilidad.</th>
                                <th>% Margen.</th>


                            </tr>

                        @endif

                        <tr>
                            <td>{{ $art->id ?? '' }}</td>
                            <th>{{ $cajas->nombreArticulos[$count]->codigo ?? '' }}</th>
                            <td>{{ $cajas->nombreArticulos[$count]->nombre ?? '' }}</td>
                            @can('haveaccess', 'cajacosto.show')
                            <td>{{ floatval($art->precio_costo_unidad) ?? '' }}</td>
                            <td>
                                @if ($art->porEspecial != null  && $art->isDolar == '1' && $art->venta->tipo_pago == 'Dolar')
                                    {{ $art->porEspecial ?? '-'}}
                                @elseif($art->porEspecial != null  && $art->isPeso == '1' && $art->venta->tipo_pago == 'Peso')
                                    {{ $art->porEspecial ?? '-'}}
                                @elseif($art->porEspecial != null  && $art->isTransPunto == '1' && $art->venta->tipo_pago == 'Trans/Punto')
                                    {{ $art->porEspecial ?? '-'}}
                                @elseif($art->porEspecial != null  && $art->isMixto == '1' && $art->venta->tipo_pago == 'Mixto')
                                    {{ $art->porEspecial ?? '-'}}
                                @elseif($art->porEspecial != null && $art->isEfectivo == '1' && $art->venta->tipo_pago == 'Efectivo')
                                    {{ $art->porEspecial ?? '-'}}
                                @endif
                            </td>
                            @endcan
                            <td>{{ $art->cantidad ?? '' }}</td>
                            @can('haveaccess', 'cajacosto.show')
                            <td>{{ floatval($art->cantidad * $art->precio_costo_unidad) ?? '' }}</td>
                            @endcan
                            <td>{{ floatval($art->precio_venta_unidad) ?? '' }}</td>
                            <td>{{ floatval(($art->cantidad * $art->precio_venta_unidad)) ?? '' }}</td>
                            <td>{{ number_format(floatval(($art->cantidad * $art->precio_venta_unidad) - ($art->cantidad * $art->precio_costo_unidad)),3,'.',',') ?? '' }}</td>
                            <td>{{ number_format(floatval(($art->cantidad * $art->precio_venta_unidad - $art->cantidad * $art->precio_costo_unidad)) / ($art->cantidad * $art->precio_venta_unidad),2,'.',',') ?? '' }}</td>


                        </tr>
                        @php
                            $count++;
                        @endphp
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <th></th>
                        <th></th>
                        <th>Totales:</th>
                        @can('haveaccess', 'cajacosto.show')
                        <th>P/Costo</th>
                        @endcan
                        <th>Cant.</th>
                        @can('haveaccess', 'cajacosto.show')
                        <th>T/Costo.</th>
                        @endcan
                        <th>P/Venta</th>
                        <th>T/Venta.</th>


                    </tfoot> --}}
                </table>
            </div>

        </div>
      <!-- /.col -->
    </div>
    @endcan

</section></section>
  <!-- /.content -->
  <div class="clearfix"></div>
@push('sciptsMain')
<script>

    $(document).ready(function() {
       var dataTable = $('#ven').dataTable({
        "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior",
                    },
                    "lengthMenu": 'Mostrar <select >'+
                                '<option value="5">5</option>'+
                                '<option value="10">10</option>'+
                                '<option value="-1">Todos</option>'+
                                '</select> registros',
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "emptyTable": "No hay datos",
                    "zeroRecords": "No hay coincidencias",
                    "infoEmpty": "",
                    "infoFiltered": ""
                },
                "iDisplayLength" : 5,
       });
       $("#buscarTexto").keyup(function() {
           dataTable.fnFilter(this.value);
       });
   });
</script>

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
