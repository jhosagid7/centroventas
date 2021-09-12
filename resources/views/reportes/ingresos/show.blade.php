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
            @if (1 == 1)

            <a class="btn btn-success" href="{{route('reporte-ingreso')}}">{{__('Nueva Busqueda')}}</a>
            @endif
            <a class="btn btn-warning" href="{{route('ingreso.index')}}">{{__('Ir a ingresos')}}</a>
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
        <small class="pull-right">Fecha: {{date('d-m-y')}}<br>Hora: {{date('H:m A')}}</small>
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
    @php

                            $totalDevolucion = 0;
                            $totalCompras = 0;
                            $totalD = 0;
                            $totalC = 0;
                            $mayorD = 0;
                            $detalD = 0;
                            $mayorC = 0;
                            $detalC = 0;
                            $operacones = 0;
                            $operaconesD = 0;
                            $operaconesC = 0;
                        @endphp
                        @foreach ($ingresos as $ing)
                        @php
                        $operacones++;
                        if ($ing->estado == 'Cancelado') {
                            $totalDevolucion += $ing->precio_compra;
                            $operaconesD++;
                        } else {
                            $totalCompras += $ing->precio_compra;
                            $operaconesC++;
                        }
                        @endphp

                        @foreach ($ing->articulo_ingresos as $art)
                        @php
                        if ($ing->estado == 'Cancelado') {

                            $totalD += $art->cantidad * $art->precio_costo_unidad;
                            if ($art->articulo->vender_al == 'Mayor') {
                                $mayorD += $art->cantidad;
                            } else {
                                $detalD += $art->cantidad;
                            }
                        } else {
                            $totalC += $art->cantidad * $art->precio_costo_unidad;
                            if ($art->articulo->vender_al == 'Mayor') {
                                $mayorC += $art->cantidad;
                            } else {
                                $detalC += $art->cantidad;
                            }

                        }
                        @endphp

                        @endforeach
                        @endforeach
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <h4><strong>Datos de Busqueda:</strong></h4>

        <address>
        <strong>Desde: </strong> {{$fecha_inicio}}<br>
        <strong>Hasta: </strong> {{$fecha_fin}}<br>
        <strong>Operador: </strong>{{ Auth::user()->name}} <br>
        <strong>Total Operaciones: </strong>{{$operacones}} <br>


        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <h4><strong>Datos de Compras:</strong></h4>
        <address>
            <strong>Compras Aceptadas: </strong> {{$operaconesC}}<br>
            <strong>Cant/Mayor: </strong> {{number_format($mayorC,0,',','.') ?? '0'}} &nbsp;<strong>Cant/Detal: </strong> {{number_format($detalC,0,',','.') ?? '0'}}<br>

            <strong>Compras Devueltas: </strong> {{$operaconesD}}<br>
            <strong>Cant/Mayor: </strong> {{number_format($mayorD,0,',','.') ?? '0'}}&nbsp;<strong>Cant/Detal: </strong> {{number_format($detalD,0,',','.') ?? '0'}}<br>
            {{-- <strong>Monto Devuelto: </strong> $ {{$totalDevolucion}}<br> --}}

            {{-- <strong>Articulos comprados: </strong> <br> --}}

        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <h4><strong>Totales:</strong></h4>
        <address>

            <div class="table-responsive">
            {{-- @can('haveaccess', 'role.index') --}}
                <table class="table">

                  <tr>
                    <th style="width:50%">Total Compras:</th>
                    <td><b>$ {{ number_format($totalCompras,3,',','.') ?? '0'}}</b></td>
                  </tr>
                  <tr>
                    <th>Total Devoluciones:</th>
                  <td>$ {{number_format($totalDevolucion,3,',','.') ?? '0'}}</td>
                  </tr>
                  <tr>
                    <th>
                        &nbsp;

                    </th>
                    <td>&nbsp;</td>
                  </tr>

                </table>
                {{-- @endcan --}}
              </div>

        </address>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">

    </div>

<div class="row ">
        <div class="margin"></div>
        <div class="margin"></div>
        <div class="margin"></div>
        <div class="margin"></div>
        <div class="panel panel-primary">
            <div class="col-xs-12 table-responsive">

                <h4><strong>Detalle de Cada Transaccion</strong></h4>
                <table class="table table-striped table-bordered table-condensed table-hover">

                    <tbody>
                        @php
                            $count = 0;
                            $actual = 0;
                            // $totalDevolucion = 0;
                            // $totalCompras = 0;
                        @endphp
                        @foreach ($ingresos as $ing)
                    {{-- {!! ' hola ' !!} --}}
                            {{-- {{$ing->persona}}
                            {{ $ing->user}} --}}
                        @if ($ing->id !== $actual)
                            @php
                            $actual = $ing->created_at;

                            // if ($ing->estado == 'Cancelado') {
                            //     $totalDevolucion += $ing->precio_compra;
                            // } else {
                            //     $totalCompras += $ing->precio_compra;
                            // }



                            @endphp

                        @if ($ing->estado == 'Cancelado')
                            <tr style="background-color: red;" class="text-black ">
                        @else
                            <tr style="background-color: lightblue;" class="text-black ">
                        @endif

                            <td>{{$ing->id}}</td>
                            <td colspan="2"><b>Fecha:</b> {{$actual}}&nbsp;&nbsp; <b>N°:</b> {{$ing->num_comprobante}}&nbsp;&nbsp; <b>Operador:</b> {{$ing->user->name}}&nbsp;&nbsp; <b>Proveedor:</b> {{$ing->persona->nombre}}</td>
                            @if ($ing->estado == 'Cancelado')
                                <td colspan="3"><b>Devolucion:</b> {{ number_format($ing->precio_compra, 3,',','.') ?? '' }}</td>
                            @else
                                <td colspan="3"><b>Total compra:</b> {{ number_format($ing->precio_compra, 3,',','.') ?? '' }}</td>
                            @endif





                        </tr>
                        <tr class="{{$detallado ?? ''}}">
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            {{-- @can('haveaccess', 'cajacosto.show') --}}
                            <th>Cant.</th>
                            <th>P/Costo</th>
                            {{-- @endcan --}}
                            {{-- @can('haveaccess', 'cajacosto.show') --}}
                            <th>Sub/Total</th>
                            {{-- @endcan --}}



                        </tr>

                        @php
                            $count++;
                        @endphp
                        @endif

                        @foreach ($ing->articulo_ingresos as $art)
                        <tr class="{{ $detallado ?? '' }}">
                            <th>{{ $art->articulo->id ?? '' }}</th>
                            <th>{{ $art->articulo->codigo ?? '' }}</th>
                            {{-- @can('haveaccess', 'cajacosto.show') --}}
                            <th>{{ $art->articulo->nombre ?? '' }}</th>
                            <th>{{ $art->cantidad ?? '' }}</th>
                            <th>{{ floatval($art->precio_costo_unidad) ?? '' }}</th>
                            {{-- @endcan --}}
                            <th>{{ floatval($art->cantidad * $art->precio_costo_unidad) ?? '' }}</th>



                        </tr>

                        @endforeach
                        @endforeach
                        {{-- @endforeach --}}
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



                    </tfoot> --}}
                </table>
            </div>

        </div>
      <!-- /.col -->
    </div>


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
