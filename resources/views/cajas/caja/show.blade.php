@extends ('layouts.admin3')
@section('contenido')

    <!-- Main content -->
    <section class="content text-sm">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border  no-print">
                <h3 class="box-title">
                    @isset($title)
                        {{$title}}
                    @else
                        {!!"Sistema"!!}
                    @endisset
                </h3>

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
                        <a onclick="printDiv('areaImprimir')" target="_blank" class="btn btn-primary  hidden-print">
                            <i class="fa fa-print"></i>
                            imprimir Resumen
                        </a>
                    </div>
                <!-- /.box-footer-->
                </div>
                <!-- /.box -->
                <!-- Main content -->
                <div id="areaImprimir" class="invoice">
                    <section id="imprimir" class="invoice">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                <i class="fa fa-globe"></i> {{ config('app.name', 'VillaSoft Hotel') }}
                                <small class="pull-right">Fecha: {{date('d-m-y')}}</small>
                                </h2>
                            </div>
                            <!-- /.col -->
                        </div>

                        <!-- info row -->
                        <div class="row invoice-info">
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
                                <!-- /.col -->

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


                            <div class="col-sm-12  ">
                                <h2>
                                    <strong>
                                        @isset($title)
                                            {{$title}}
                                        @else
                                            {!!"Sistema"!!}
                                        @endisset
                                    </strong>
                                </h2>
                                <address>
                                    @php
                                        $totalCreditosPagadosPorCaja       = 0;
                                        $consumoCreditosPagadosPorCaja     = 0;
                                        $totalCreditosPagadosPorOficina    = 0;
                                        $servicioCreditosPagadosPorCaja    = 0;
                                        $consumoCreditosPagadosPorOficina  = 0;
                                        $servicioCreditosPagadosPorOficina = 0;
                                        $consumoCreditosPagadosPorCajaDolar = 0;
                                        $servicioCreditosPagadosPorCajaDolar = 0;
                                        $consumoCreditosPagadosPorCajaPeso = 0;
                                        $servicioCreditosPagadosPorCajaPeso = 0;
                                        $servicioCreditosPagadosPorCajaPunto = 0;
                                        $servicioCreditosPagadosPorCajaTransferencia = 0;
                                        $consumoCreditosPagadosPorCajaPunto = 0;
                                        $consumoCreditosPagadosPorCajaTransferencia = 0;
                                        $consumoCreditosPagadosPorCajaBolivar = 0;
                                        $consumoCreditosPagadosPorCajaTransferenciaPunto  = 0;
                                        $servicioCreditosPagadosPorCajaTransferenciaPunto = 0;
                                        $pago_creditos = 0;
                                        $tr = '';
                                    @endphp

                                    <div class="table-responsive">
                                        @can('haveaccess', 'cajatotales.show')
                                            <table class="table table-sm table-striped">
                                                @can('haveaccess', 'cajatotalventa.show')
                                                <tr>
                                                    <th colspan="3">
                                                        <h4><strong class="text-blue">N?? Caja:</strong> <strong>{{ $caja->codigo ?? ''}}</strong>
                                                            <br>
                                                            <strong class="text-blue">Estado:</strong> <strong>{{ $caja->estado ?? ''}}</strong>
                                                        </h4>
                                                    </th>

                                                    <th  colspan="5">
                                                        <h4>
                                                            <strong class="text-blue">Operador:</strong> <strong>{{ $caja->user->name ?? ''}}</strong>
                                                            <br>
                                                            <strong class="text-blue">Hora Inicio:</strong> <strong>{{ $caja->hora ?? ''}}</strong>
                                                        </h4>
                                                    </th>

                                                    <th  colspan="3">
                                                        <h4>
                                                            <strong class="text-blue">Fecha:</strong> <strong>{{ $caja->fecha->format('d-m-Y') ?? ''}}</strong>
                                                            <br>
                                                            <strong class="text-blue">Hora Cierre:</strong> <strong>{{ $caja->hora_cierre ?? ''}}</strong>
                                                        </h4>
                                                    </th>


                                                </tr>
                                                </table>
                                                @endcan

                                                @can('haveaccess', 'cajatotalventa.show')
                                                <table class="table">
                                                <tr>
                                                    <th><h4><strong class="text-blue">Ventas:</strong></h4></th>
                                                    <td></td>
                                                    <th class="text-blue"></th>


                                                    <th><h4><strong class="text-blue">Cr??ditos:</strong></h4></th>
                                                    <td></td>
                                                    <th class="text-blue"></th>
                                                    <th><h4><strong class="text-blue">Totales:</h4></strong></th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @endcan

                                                @can('haveaccess', 'cajatotalventa.show')
                                                <tr>
                                                    <th></th>
                                                    <td></td>
                                                    <th></th>
                                                    <td></td>
                                                    <th></th>
                                                    <td></td>
                                                    <th></th>
                                                    <td></td>
                                                    <th></th>
                                                    <td></td>
                                                </tr>
                                                @endcan
                                                @can('haveaccess', 'cajautilidad.show')

                                                <tr>
                                                    <th><h4><strong class="text-aqua">Ventas/Contado:</h4></strong></th>
                                                    <td><h4><strong>{{ $cajas->SumaTotalCantidadVentas ?? '0' }}</h4></strong></td>
                                                    <td></td>

                                                    <th><h4><strong class="text-aqua">Cr??ditos/Vigentes:</h4></strong></th>
                                                    <td><h4><strong>{{ $cajas->SumaTotalCantidadCreditosVigentes ?? '0' }}</h4></strong></td>
                                                    <td></td>
                                                    <th><h4><strong class="text-aqua">Total/Ventas/Contado:</h4></strong></th>
                                                    <td><h4><strong>${{ number_format($cajas->SumaTotalVentas,2,',','.') ?? '0.000' }}</h4></strong></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @endcan
                                                                                                @can('haveaccess', 'cajatotalventa.show')
                                                <tr>
                                                    <th><h4><strong class="text-danger">Ventas/Cr??dito:</strong></h4></th>
                                                    <td><h4><strong class="text-danger">{{ $cajas->SumaTotalCantidadVentasCredito ?? '0' }}</h4></strong></td>
                                                    <th class="text-blue"></th>

                                                    <th><h4><strong class="text-danger">Cr??ditos/Vencidos:</strong></h4></th>
                                                    <td><h4><strong class="text-danger">{{ $cajas->SumaTotalCantidadCreditosVencidos ?? '0' }}</h4></strong></td>
                                                    <td></td>
                                                    <th><h4><strong class="text-danger">Total/Ventas/Cr??d/Nuevos:</strong></h4></th>
                                                    <td><h4><strong class="text-danger">${{ number_format($cajas->SumaTotalVentasCredito,2,'.',',') ?? '0.000' }}</h4></strong></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @endcan
                                                @can('haveaccess', 'cajatotalventa.show')
                                                <tr>
                                                    <th><h4><strong class="text-blue">Total/Ventas:</strong></h4></th>
                                                    <td><h4><strong>{{ $cajas->SumaTotalCantidadVentas + $cajas->SumaTotalCantidadVentasCredito ?? '0' }}</strong></h4></td>
                                                    <th class="text-blue"></th>

                                                    <th><h4><strong class="text-blue">Cr??ditos/Pagados:</strong></h4></th>
                                                    <td><h4><strong>{{$cajas->SumaTotalCantidadVentasCreditoPagados ?? '0'}}</strong></h4></td>
                                                    <td></td>
                                                    <th><h4><strong class="text-blue">Total/Venta Bruto:</strong></h4></th>
                                                    <td><h4><strong>${{ number_format($cajas->SumaTotalVentasCredito + $cajas->SumaTotalVentas,2,'.',',') ?? '0.000' }}</h4></strong></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @endcan


                                                @can('haveaccess', 'cajautilidad.show')

                                                <tr>
                                                    <th><h4><strong class="text-aqua"></h4></strong></th>
                                                    <td><h4><strong></h4></strong></td>
                                                    <td></td>

                                                    <th><h4><strong class="text-aqua">Cr??ditos/Nuevos:</h4></strong></th>
                                                    <td><h4><strong>@if ($cajas->estado == 'Abierta')
                                                        {{ $cajas->SumaTotalCantidadVentasCredito ?? '0' }}
                                                    @else
                                                        {{ $cajas->hist_creditos_nuevos ?? '0' }}
                                                    @endif</h4></strong></td>
                                                    <td></td>
                                                    <th><h4><strong class="text-aqua">Total/Ventas/Cr??ditos/Pagados:</h4></strong></th>
                                                    <td><h4><strong>${{ number_format($cajas->SumaTotalCreditosPagados,2,',','.') ?? '0.000' }}</h4></strong></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @endcan

                                                @can('haveaccess', 'cajautilidad.show')

                                                <tr>
                                                    <th></th>
                                                    <td></td>
                                                    <td></td>

                                                    <th><h4><strong class="text-blue">Total/Cred??tos:</h4></strong></th>
                                                    <td><h4><strong>@if ($cajas->estado == 'Abierta')
                                                        {{$cajas->SumaTotalCantidadCreditosVigentes + $cajas->SumaTotalCantidadCreditosVencidos + $cajas->SumaTotalCantidadVentasCreditoPagados ?? '0'}}
                                                    @else
                                                        {{ $cajas->hist_total_creditos ?? '0'}}
                                                    @endif
                                                    </h4></strong></td>
                                                    <td></td>
                                                    <th><h4><strong class="text-blue">Total/Ventas/Total/Contable:</h4></strong></th>
                                                    <td><h4><strong>${{ number_format($cajas->SumaTotalCreditosPagados + $cajas->SumaTotalVentas,2,',','.') ?? '0.000' }}</h4></strong></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @endcan

                                            </table>
                                        @endcan
                                    </div>

                                </address>
                            </div>
                            <!-- /.col -->
                            {{-- </div> --}}
                            <!-- /.row -->
                            <div class="row">
                                <div class="panel panel-primary">
                                    @include('cajas.caja.caja')
                                    {{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
                                    {{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
                                    <div class="content"><div class="box-header with-border">
                                        <h3 class="box-title text-bold text-blue">Resumen de Caja </h3>
                                        <div class="row">
                                            <div class="col-sm-2 col-xs-6">
                                                <div class="description-block border-right">
                                                    <span class="description-text">Operaciones</span>
                                                    {{-- <h5 class="description-header">______________</h5>
                                                    <h5 class="box-title text-bold text-blue">Total Contable:</h5> --}}
                                                    {{-- <h5 class="box-title text-bold">Vtos/Pagar/Oficina:</h5> --}}
                                                    <h5 class="description-header">______________</h5>
                                                    <h5 class="box-title text-bold">Regis. por Sistema:</h5>
                                                    <h5 class="box-title text-bold text-red">- Regis. por Operador:</h5>
                                                    <h5 class="description-header">______________</h5>
                                                    <h5 class="box-title text-bold text-red">Diferencia:</h5>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-6">
                                                <div class="description-block border-right">
                                                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i>Dolar $</span>
                                                    {{-- <h5 class="description-header">______________</h5>
                                                    <h5 class="box-title text-bold text-blue">$. {{ number_format($cajas->SumaTotalVentas,2,',','.') ?? '0.000' }}</h5> --}}
                                                    <br>
                                                    {{-- <h5 class="box-title text-bold">$. {{ number_format(($cajas->TotalSumaVueltosPagarOficinaDolarToDolar),2,',','.') ?? '0.000' }}</h5> --}}
                                                    <h5 class="description-header">______________</h5>
                                                    <h5 class="box-title text-bold">$. {{ number_format($cajas->SumaTotalVentas + $cajas->SumaTotalCreditosPagados,2,',','.') ?? '0.000' }}</h5>
                                                    <br>
                                                    <h5 class="box-title text-bold text-red">$. {{ number_format(floatval($cajas->total_operador_reg),2,',','.') ?? ' 0,00' }}</h5>
                                                    <h5 class="description-header">______________</h5>
                                                    <h5 class="box-title text-bold text-red">$. {{ number_format(floatval($cajas->total_diferencia),2,',','.') ?? ' 0,00' }}</h5>
                                                    <br>
                                                    <span class="description-text">DOLAR</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                        <div>

                                    </div>
                                <div>

                            </div>
                            <!-- /.col -->

                            <div class="col-sm-8 col-xs-6">
                                <div class="text-left">
                                    <br>
                                    <br>

                                    <span class="box-title text-bold">OBSERVACIONES:</span>

                                    <div  class="text-left">
                                        {{$cajas->Observaciones}}
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        @php
                        $totalDolarShow =0;
                        $totalPagadosShow =0;
                        $totalVueltosShow =0;
                        $totalCajasShow =0;
                        $totalExcedentesShow =0;
                        $totalPagarPorOficinasShow =0;
                        $totalPagarPorOficinasShow =0;
                        $totalContablesShow =0;
                        @endphp
                        <div class="row">
                            <div class="col-sm-2 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage box-title text-bold text-blue"><i class="fa fa-dollar"> </i> {{ number_format(floatval((($cajas->SumaTotalDolarDolar + $cajas->SumaTotalDolarDolarCredito + $cajas->SumaTotalPesoDolar + $cajas->SumaTotalPesoDolarCredito) + ($cajas->SumaTotalPuntoDolar +$cajas->SumaTotalPuntoDolarCredito + $cajas->SumaTotalTransferenciaDolar + $cajas->SumaTotalTransferenciaDolarCredito + $cajas->SumaTotalBolivarDolar + $cajas->SumaTotalBolivarDolarCredito))),2,',','.') ?? ''}}</span>
                                    <h5 class="description-header">______________</h5>
                                    <h5 class="box-title text-bold">Regis. por Sistema:</h5>
                                    <h5 class="box-title text-bold text-red">- Regis. por Operador:</h5>
                                    <h5 class="description-header">______________</h5>
                                    <h5 class="box-title text-bold text-red">Diferencia:</h5><br><br>
                                    @if ($cajas->estado == 'Abierta')
                                    <h5 class="box-title text-bold text-blue">Tasa:</h5><br>
                                    <h5 class="box-title text-bold text-blue">%/Ganancia:</h5>
                                    @else
                                    <h5 class="box-title text-bold text-blue">Tasa Apertura:</h5><br>
                                    <h5 class="box-title text-bold text-green">Tasa Cierre:</h5><br>
                                    <h5 class="box-title text-bold text-blue">%/Ganancia Apertura:</h5>
                                    <h5 class="box-title text-bold text-green">%/Ganancia Cierre:</h5>
                                    @endif

                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-green"><i class="fa fa-dollar"></i> {{ number_format(floatval($cajas->SumaTotalDolarDolar + $cajas->SumaTotalDolarDolarCredito),2,',','.') ?? ''}}</span>
                                    <h5 class="description-header">______________</h5>
                                    {{-- <h5 class="box-title text-bold text-blue">$. {{ number_format(floatval(($cajas->SumaTotalDolarServFinal + $cajas->TotalSumaVueltosCajaAnteriorPendientesDolarDivisa - $cajas->SumaTotalDolarVueltosFinal - $cajas->SumaTotalDolarExcedenteFinal - $cajas->SumaTotalDolarPagarOficinaFinal) + ($cajas->SumaTotalDolarConsFinal - $cajas->SumaTotalDolarVueltosFinalConsumo - $cajas->SumaTotalDolarExcedenteFinalConsumo - $cajas->SumaTotalDolarPagarOficinaFinalConsumo) + ($cajas->SumaTotalDolarCreditoFinal - $cajas->SumaTotalDolarVueltosFinalCredito - $cajas->SumaTotalDolarExcedenteFinalCredito - $cajas->SumaTotalDolarPagarOficinaFinalCredito) + ($cajas->SumaTotalDolarHorasExtrasFinal - $cajas->SumaTotalDolarVueltosFinalHorasExtras - $cajas->SumaTotalDolarExcedenteFinalHorasExtras - $cajas->SumaTotalDolarPagarOficinaFinalHorasExtras)),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <h5 class="box-title text-bold">$. {{ number_format(floatval(($cajas->SumaTotalDolarPagarOficinaFinal) + ($cajas->SumaTotalDolarPagarOficinaFinalConsumo) + ($cajas->SumaTotalDolarPagarOficinaFinalHorasExtras)),2,',','.') ?? ' 0,00' }}</h5>
                                    <h5 class="description-header">______________</h5> --}}
                                    <h5 class="box-title text-bold">$. {{ number_format(floatval($cajas->SumaTotalDolar + $cajas->SumaTotalDolarCredito),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <h5 class="box-title text-bold text-red">$. {{ number_format(floatval($cajas->monto_dolar_cierre),2,',','.') ?? ' 0,00' }}</h5>
                                    <h5 class="description-header">______________</h5>
                                    <h5 class="box-title text-bold text-red">$. {{ number_format(floatval($cajas->monto_dolar_cierre_dif),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <span class="description-text">DOLAR</span><br>
                                    @if ($cajas->estado == 'Abierta')
                                        <span class="description-text text-blue">{{$cajas->tasaDolarOpen ?? ''}}</span><br>
                                        <span class="description-text text-blue">{{$cajas->tasaDolarOpenPorcentajeGanancia ?? ''}}</span>
                                    @else
                                    <span class="description-text text-blue">{{$cajas->tasaDolarOpen ?? ''}}</span><br>
                                    <span class="description-text text-green">{{$cajas->tasaDolarClose ?? ''}}</span><br>
                                    <span class="description-text text-blue">{{$cajas->tasaDolarOpenPorcentajeGanancia ?? ''}} </span><br>
                                    <span class="description-text text-green">{{$cajas->tasaDolarClosePorcentajeGanancia ?? ''}}</span>
                                    @endif

                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-green"><i class="fa fa-dollar"></i> {{ number_format(floatval($cajas->SumaTotalPesoDolar + $cajas->SumaTotalPesoDolarCredito),2,',','.') ?? ''}}</span>
                                    <h5 class="description-header">______________</h5>
                                    <h5 class="box-title text-bold">$. {{ number_format(floatval($cajas->SumaTotalPeso + $cajas->SumaTotalPesoCredito),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <h5 class="box-title text-bold text-red">$. {{ number_format(floatval($cajas->monto_peso_cierre),2,',','.') ?? ' 0,00' }}</h5>
                                    <h5 class="description-header">______________</h5>
                                    <h5 class="box-title text-bold text-red">$. {{ number_format(floatval($cajas->monto_peso_cierre_dif),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <span class="description-text">PESO</span><br>
                                    @if ($cajas->estado == 'Abierta')
                                        <span class="description-text text-blue">{{$cajas->tasaPesoOpen ?? ''}}</span><br>
                                        <span class="description-text text-blue">{{$cajas->tasaPesoOpenPorcentajeGanancia ?? ''}}</span>
                                    @else
                                    <span class="description-text text-blue">{{$cajas->tasaPesoOpen ?? ''}}</span><br>
                                    <span class="description-text text-green">{{$cajas->tasaPesoClose ?? ''}}</span><br>
                                    <span class="description-text text-blue">{{$cajas->tasaPesoOpenPorcentajeGanancia ?? ''}} </span><br>
                                    <span class="description-text text-green">{{$cajas->tasaPesoClosePorcentajeGanancia ?? ''}}</span>
                                    @endif
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-green"><i class="fa fa-dollar"></i>{{ number_format(floatval($cajas->SumaTotalPuntoDolar + $cajas->SumaTotalPuntoDolarCredito),2,',','.') ?? ''}}</span>
                                    <h5 class="description-header">______________</h5>
                                    <h5 class="box-title text-bold">Bs. {{ number_format(floatval($cajas->SumaTotalPunto + $cajas->SumaTotalPuntoCredito),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <h5 class="box-title text-bold text-red">Bs. {{ number_format(floatval($cajas->monto_punto_cierre),2,',','.') ?? ' 0,00' }}</h5>
                                    <h5 class="description-header">______________</h5>
                                    <h5 class="box-title text-bold text-red">Bs. {{ number_format(floatval($cajas->monto_punto_cierre_dif),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <span class="description-text">PUNTO</span><br>
                                    @if ($cajas->estado == 'Abierta')
                                        <span class="description-text text-blue">{{$cajas->tasaTransferenciaPuntoOpen ?? ''}}</span><br>
                                        <span class="description-text text-blue">{{$cajas->tasaTransferenciaPuntoOpenPorcentajeGanancia ?? ''}}</span>
                                    @else
                                    <span class="description-text text-blue">{{$cajas->tasaTransferenciaPuntoOpen ?? ''}}</span><br>
                                    <span class="description-text text-green">{{$cajas->tasaTransferenciaPuntoClose ?? ''}}</span><br>
                                    <span class="description-text text-blue">{{$cajas->tasaTransferenciaPuntoOpenPorcentajeGanancia ?? ''}} </span><br>
                                    <span class="description-text text-green">{{$cajas->tasaTransferenciaPuntoClosePorcentajeGanancia ?? ''}}</span>
                                    @endif
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-green"><i class="fa fa-dollar"></i>{{ number_format(floatval($cajas->SumaTotalTransferenciaDolar + $cajas->SumaTotalTransferenciaDolarCredito),2,',','.') ?? ''}}</span>
                                    <h5 class="description-header">______________</h5>
                                    {{-- <h5 class="box-title text-bold text-blue">$. {{ number_format(floatval(($cajas->SumaTotalTransferenciaServFinal + $cajas->TotalSumaVueltosCajaAnteriorPendientesTransferenciaDivisa - $cajas->SumaTotalTransferenciaVueltosFinal - $cajas->SumaTotalTransferenciaExcedenteFinal - $cajas->SumaTotalTransferenciaPagarOficinaFinal) + ($cajas->SumaTotalTransferenciaConsFinal - $cajas->SumaTotalTransferenciaVueltosFinalConsumo - $cajas->SumaTotalTransferenciaExcedenteFinalConsumo - $cajas->SumaTotalTransferenciaPagarOficinaFinalConsumo) + ($cajas->SumaTotalTransferenciaCreditoFinal - $cajas->SumaTotalTransferenciaVueltosFinalCredito - $cajas->SumaTotalTransferenciaExcedenteFinalCredito - $cajas->SumaTotalTransferenciaPagarOficinaFinalCredito) + ($cajas->SumaTotalTransferenciaHorasExtrasFinal - $cajas->SumaTotalTransferenciaVueltosFinalHorasExtras - $cajas->SumaTotalTransferenciaExcedenteFinalHorasExtras - $cajas->SumaTotalTransferenciaPagarOficinaFinalHorasExtras)),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <h5 class="box-title text-bold">$. {{ number_format(floatval(($cajas->SumaTotalTransferenciaPagarOficinaFinal) + ($cajas->SumaTotalTransferenciaPagarOficinaFinalConsumo) + ($cajas->SumaTotalTransferenciaPagarOficinaFinalHorasExtras)),2,',','.') ?? ' 0,00' }}</h5>
                                    <h5 class="description-header">______________</h5> --}}
                                    <h5 class="box-title text-bold">Bs. {{ number_format(floatval($cajas->SumaTotalTransferencia + $cajas->SumaTotalTransferenciaCredito),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <h5 class="box-title text-bold text-red">Bs. {{ number_format(floatval($cajas->monto_trans_cierre),2,',','.') ?? ' 0,00' }}</h5>
                                    <h5 class="description-header">______________</h5>
                                    <h5 class="box-title text-bold text-red">Bs. {{ number_format(floatval($cajas->monto_trans_cierre_dif),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <span class="description-text">TRANS</span><br>
                                    @if ($cajas->estado == 'Abierta')
                                        <span class="description-text text-blue">{{$cajas->tasaTransferenciaPuntoOpen ?? ''}}</span><br>
                                        <span class="description-text text-blue">{{$cajas->tasaTransferenciaPuntoOpenPorcentajeGanancia ?? ''}}</span>
                                    @else
                                    <span class="description-text text-blue">{{$cajas->tasaTransferenciaPuntoOpen ?? ''}}</span><br>
                                    <span class="description-text text-green">{{$cajas->tasaTransferenciaPuntoClose ?? ''}}</span><br>
                                    <span class="description-text text-blue">{{$cajas->tasaTransferenciaPuntoOpenPorcentajeGanancia ?? ''}} </span><br>
                                    <span class="description-text text-green">{{$cajas->tasaTransferenciaPuntoClosePorcentajeGanancia ?? ''}}</span>
                                    @endif
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-xs-6">
                                <div class="description-block">
                                    <span class="description-percentage text-green"><i class="fa fa-dollar"></i>{{ number_format(floatval($cajas->SumaTotalBolivarDolar + $cajas->SumaTotalBolivarDolarCredito),2,',','.') ?? ''}}</span>
                                    <h5 class="description-header">______________</h5>
                                    {{-- <h5 class="box-title text-bold text-blue">$. {{ number_format(floatval(($cajas->SumaTotalBolivarServFinal + $cajas->TotalSumaVueltosCajaAnteriorPendientesBolivarDivisa - $cajas->SumaTotalBolivarVueltosFinal - $cajas->SumaTotalBolivarExcedenteFinal - $cajas->SumaTotalBolivarPagarOficinaFinal) + ($cajas->SumaTotalBolivarConsFinal - $cajas->SumaTotalBolivarVueltosFinalConsumo - $cajas->SumaTotalBolivarExcedenteFinalConsumo - $cajas->SumaTotalBolivarPagarOficinaFinalConsumo) + ($cajas->SumaTotalBolivarCreditoFinal - $cajas->SumaTotalBolivarVueltosFinalCredito - $cajas->SumaTotalBolivarExcedenteFinalCredito - $cajas->SumaTotalBolivarPagarOficinaFinalCredito) + ($cajas->SumaTotalBolivarHorasExtrasFinal - $cajas->SumaTotalBolivarVueltosFinalHorasExtras - $cajas->SumaTotalBolivarExcedenteFinalHorasExtras - $cajas->SumaTotalBolivarPagarOficinaFinalHorasExtras)),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <h5 class="box-title text-bold">$. {{ number_format(floatval(($cajas->SumaTotalBolivarPagarOficinaFinal) + ($cajas->SumaTotalBolivarPagarOficinaFinalConsumo) + ($cajas->SumaTotalBolivarPagarOficinaFinalHorasExtras)),2,',','.') ?? ' 0,00' }}</h5>
                                    <h5 class="description-header">______________</h5> --}}
                                    <h5 class="box-title text-bold">Bs. {{ number_format(floatval($cajas->SumaTotalBolivar + $cajas->SumaTotalBolivarCredito),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <h5 class="box-title text-bold text-red">Bs. {{ number_format(floatval($cajas->monto_bolivar_cierre),2,',','.') ?? ' 0,00' }}</h5>
                                    <h5 class="description-header">______________</h5>
                                    <h5 class="box-title text-bold text-red">Bs. {{ number_format(floatval($cajas->monto_bolivar_cierre_dif),2,',','.') ?? ' 0,00' }}</h5>
                                    <br>
                                    <span class="description-text">EFECTIVO</span><br>
                                    @if ($cajas->estado == 'Abierta')
                                        <span class="description-text text-blue">{{$cajas->tasaEfectivoOpen ?? ''}}</span><br>
                                        <span class="description-text text-blue">{{$cajas->tasaEfectivoOpenPorcentajeGanancia ?? ''}}</span>
                                    @else
                                    <span class="description-text text-blue">{{$cajas->tasaEfectivoOpen ?? ''}}</span><br>
                                    <span class="description-text text-green">{{$cajas->tasaEfectivoClose ?? ''}}</span><br>
                                    <span class="description-text text-blue">{{$cajas->tasaEfectivoOpenPorcentajeGanancia ?? ''}} </span><br>
                                    <span class="description-text text-green">{{$cajas->tasaEfectivoClosePorcentajeGanancia ?? ''}}</span>
                                    @endif
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div> <!-- row -->
                    </section>
                </div>
                <!-- /row -->
                @can('haveaccess', 'cajadatosventas.show')
                <!-- Table row -->
                <div class="col-sm-12 col-xs-12">
                <div class="col-sm-12 col-xs-12">
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

                                        @if($venta->tipo_pago_condicion == 'Credito')
                                            <tr style="background-color: rgba(198, 250, 191, 0.692);" class="text-black detalleVerde">
                                        @else
                                            <tr style="background-color: rgba(174, 221, 236, 0.555);" class="text-black detalleAzul">
                                        @endif

                                        @if ($venta->estado == 'Cancelada')
                                            <tr style="background-color: rgb(247, 191, 191);" class="text-black detalleRojo">
                                        @endif
                                            {{-- @if ($venta->estado == 'Cancelada')
                                                <tr style="background-color: red;" class="text-black ">
                                            @else
                                                <tr style="background-color: lightblue;" class="text-black ">
                                            @endif --}}
                                                    <td>{{ $venta->id }}</td>
                                                    <td>{{ $venta->fecha_hora }}</td>
                                                    <td>{{ $venta->serie_comprobante }}</td>
                                                    <td>{{ $venta->tasaTransPunto }}</td>
                                                    <td>{{ $venta->tipo_pago ?? $venta->tipo_pago_condicion}}</td>
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
                                                {{-- @if ($art->venta->estado == 'Cancelada')
                                                    <tr style="background-color: red;" class="text-black ">
                                                @else
                                                    <tr style="background-color: lightblue;" class="text-black ">
                                                @endif --}}

                                                @if($art->venta->tipo_pago_condicion == 'Credito')
                                                    <tr style="background-color: rgba(198, 250, 191, 0.692);" class="text-black detalleVerde">
                                                @else
                                                    <tr style="background-color: rgba(174, 221, 236, 0.555);" class="text-black detalleAzul">
                                                @endif

                                                @if ($art->venta->estado == 'Cancelada')
                                                    <tr style="background-color: rgb(247, 191, 191);" class="text-black detalleRojo">
                                                @endif

                                                        <td colspan="2"><b>ID Factura: </b> {{$actual}}</td><td colspan="2"> <b>Tipo pago: </b> {{$art->venta->tipo_pago ?? $art->venta->tipo_pago_condicion}}

                                                        @if ($art->venta->tipo_pago == 'Trans/Punto')
                                                        @if ($art->venta->num_Punto !== null)<b> &nbsp; N?? Punto:</b>{{$art->venta->num_Punto}}@endif
                                                        @if ($art->venta->num_Trans !== null)<b> &nbsp; N?? Trans:</b>{{$art->venta->num_Trans}}@endif
                                                        @endif
                                                        @if ($art->venta->tipo_pago == 'Mixto')
                                                            @if ($art->venta->num_Punto !== null)<b>&nbsp; N?? Punto:</b>{{$art->venta->num_Punto}}@endif
                                                            @if ($art->venta->num_Trans !== null)<b>&nbsp; N?? Trans:</b>{{$art->venta->num_Trans}}@endif
                                                        @endif
                                                        </td><td colspan="2"> <b>Tasa: </b> {{$art->venta->tasaTransPunto}}
                                                        </td><td colspan="3"><b>Porcentaje: </b>
                                                        @if ($art->venta->tipo_pago_condicion == 'Credito')

                                                        {{$art->venta->porDolar}} %
                                                        @endif
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
                                                        <th>C??digo</th>
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
                                </table>
                            </div>

                        </div>
                        <!-- /.col -->
                    </div>
                @endcan
                @can('haveaccess', 'cajadatosarticulos.show')
                    <div class="row">
                        <div class="margin"></div>
                        <div class="margin"></div>
                        <div class="margin"></div>
                        <div class="margin"></div>
                        <div class="panel panel-primary">
                            <div class="col-xs-12 table-responsive">
                                <h4><strong>Creditos Pagados</strong></h4>
                                <table class="table table-striped table-bordered table-condensed table-hover">
                                    <tbody>
                                        @php
                                            $count = 0;
                                            $actual = 0;
                                        @endphp
                                        {{-- $cajas->pago_creditos[1]->venta->articulo_ventas; --}}
                                        @foreach ($cajas->pago_creditos  as $art)
                                        {{-- {{$art->venta}} --}}
                                        @if($art->venta->tipo_pago_condicion == 'Credito' && $art->venta->status == 'Pagado')
                                            @if ($art->venta->id !== $actual)
                                                @php
                                                    $actual = $art->venta->id;
                                                @endphp
                                                {{-- @if ($art->venta->estado == 'Cancelada')
                                                    <tr style="background-color: red;" class="text-black ">
                                                @else
                                                    <tr style="background-color: lightblue;" class="text-black ">
                                                @endif --}}

                                                @if($art->venta->tipo_pago_condicion == 'Credito')
                                                    <tr style="background-color: rgba(174, 221, 236, 0.555);" class="text-black detalleVerde">
                                                @else
                                                    <tr style="background-color: rgba(174, 221, 236, 0.555);" class="text-black detalleAzul">
                                                @endif

                                                @if ($art->venta->estado == 'Cancelada')
                                                    <tr style="background-color: rgb(247, 191, 191);" class="text-black detalleRojo">
                                                @endif

                                                        <td colspan="2"><b>ID Factura: </b> {{$actual}}</td><td colspan="2"> <b>Tipo pago: </b> {{$art->venta->tipo_pago ?? $art->venta->tipo_pago_condicion}}

                                                        @if ($art->venta->tipo_pago == 'Trans/Punto')
                                                        @if ($art->venta->num_Punto !== null)<b> &nbsp; N?? Punto:</b>{{$art->venta->num_Punto}}@endif
                                                        @if ($art->venta->num_Trans !== null)<b> &nbsp; N?? Trans:</b>{{$art->venta->num_Trans}}@endif
                                                        @endif
                                                        @if ($art->venta->tipo_pago == 'Mixto')
                                                            @if ($art->venta->num_Punto !== null)<b>&nbsp; N?? Punto:</b>{{$art->venta->num_Punto}}@endif
                                                            @if ($art->venta->num_Trans !== null)<b>&nbsp; N?? Trans:</b>{{$art->venta->num_Trans}}@endif
                                                        @endif
                                                        </td><td colspan="2"> <b>Tasa: </b> {{$art->venta->tasaTransPunto}}
                                                        </td><td colspan="3"><b>Porcentaje: {{$art->venta->porDolar}}</b>

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

                                                    </tr>
                                                    <tr>
                                                        <th>Cliente</th>
                                                        <th>Precio Costo</th>
                                                            <th>% Ganancia</th>
                                                            <th>Precio Venta</th>
                                                            <th>Utilidad</th>
                                                            <th>N?? Caja</th>
                                                            <th>created_at</th>

                                                    </tr>


                                                    <tr>
                                                        <td>{{ $art->venta->persona->nombre ?? '' }}</td>
                                                        <td>{{ number_format(floatval($art->venta->precio_costo),3,'.',',') ?? '' }}</td>
                                                        <th>{{ $art->venta->margen_ganancia ?? '' }}</th>
                                                        <td>{{ number_format(floatval($art->venta->total_venta),3,'.',',') ?? '' }}</td>
                                                        <td>{{ $art->venta->ganancia_neta ?? '' }}</td>
                                                        <td>{{ $art->venta->caja_id ?? '' }}</td>
                                                        <td>{{ $art->venta->created_at ?? '' }}</td>

                                                        {{-- <td>{{ number_format(floatval(($art->cantidad * $art->precio_venta_unidad) - ($art->cantidad * $art->precio_costo_unidad)),3,'.',',') ?? '' }}</td>
                                                        <td>{{ number_format(floatval(($art->cantidad * $art->precio_venta_unidad - $art->cantidad * $art->precio_costo_unidad)) / ($art->cantidad * $art->precio_venta_unidad),2,'.',',') ?? '' }}</td> --}}


                                                    </tr>
                                                    @endif
                                            @php
                                                $count++;
                                            @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.col -->
                    </div>
                @endcan
            </div>
        </div>
        </div>
        </div>




        {{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
        {{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
        <br>


    </section>
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

    function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}

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
<script>


var tsri      = $("#total_sistema_reg_input").val();
$("#total_sistema_reg").html(numDecimal(tsri));
    /* Sumar dos n??meros. */
    function sumar() {
            // alert('suma');
                var total_suma = 0;
                $(".monto").each(function() {
                    if (isNaN(parseFloat($(this).val()))) {
                        total_suma += 0;
                    } else {
                        total_suma += parseFloat($(this).val());
                    }
                });
                // alert(total_suma);
                document.getElementById('total_operador_reg').innerHTML = numDecimal(total_suma);
                $("#total_operador_reg_input").val(total_suma);

            }

            function numDecimal(valor){
                let result = Number(valor).toFixed(2);

                return result;
            }

     /* Restar dos n??meros. */
     function resta() {

                let reg_sistama = $("#total_sistema_reg_input").val();
                let reg_operador = $("#total_operador_reg_input").val();
                let result = reg_operador - reg_sistama;

                $("#total_dif_input").val(numDecimal(result));
                $("#total_dif").html(numDecimal(result));

                // if (result <= 0) {
                //     // alert('soy menor');
                //     RestaTotal.classList.remove('text-primary');
                //     RestaTotal.classList.add('text-danger');
                //     r.classList.remove('text-primary');
                //     r.classList.add('text-danger');

                //     PagoTtotal.classList.add('text-success');
                //     tap.classList.add('text-success');

                //     $("#tap").html("MONTO COMPLETO...");
                //     $("#r").html("VUELTOS...");
                //     // verify();
                //     $("#guardar").show("linear");;




                // }
                // if (result > 0) {
                //     // alert('soy mayor');
                //     RestaTotal.classList.remove('text-danger');
                //     RestaTotal.classList.add('text-primary');
                //     r.classList.remove('text-danger');
                //     r.classList.add('text-primary');

                //     PagoTtotal.classList.remove('text-success');
                //     tap.classList.remove('text-success');

                //     $("#r").html("RESTA");
                //     $("#tap").html("TOTAL A PAGAR");
                //     $("#guardar").hide("linear");
                // }


            }
    $(document).ready(function() {

        DMontoDolarRep();
        DMontoPesoRep();
        DMontoBolivarRep();
        DMontoPuntoRep();
        DMontoTransRep();

            function DMontoDolarRep(){

                    Mdolar      = $("#cantidad_dolar_rep").val();
                    MdolarSistema       = $("#dolar_sistema").val();

                    Tdolar      = $("#TasaDolar").val();

                    Tpeso       = $("#TasaPeso").val();
                    Tbolivar    = $("#TasaBolivar").val();
                    Tpunto      = $("#TasaPunto").val();
                    Ttrans      = $("#TasaTrans").val();

                    TdolarToDolarSis = MdolarSistema / Tdolar;

                    DsupTotal = Mdolar * Tdolar;

                    DsupTotalDolar = DsupTotal * Tdolar;
                    $("#dif_moneda_dolar_to_tasa_input").val(numDecimal(DsupTotalDolar));
                    $("#dif_moneda_dolar_to_tasa").html(numDecimal(DsupTotalDolar - MdolarSistema));
                    $("#total_dolar_dif").val(numDecimal(DsupTotalDolar - MdolarSistema));
                    $("#total_dolar").val(DsupTotalDolar);
                    $("#dif_moneda_dolar_to_dolar_input").val(numDecimal(DsupTotal));
                    $("#dif_moneda_dolar_to_dolar").html(numDecimal(DsupTotal - TdolarToDolarSis));

                    sumar();

                    resta();

                }

                function DMontoPesoRep(){

                    Mpeso       = $("#cantidad_peso_rep").val();
                    MpesoSistema       = $("#peso_sistema").val();
                    Tdolar      = $("#TasaDolar").val();
                    Tpeso       = $("#TasaPeso").val();
                    Tbolivar    = $("#TasaBolivar").val();
                    Tpunto      = $("#TasaPunto").val();
                    Ttrans      = $("#TasaTrans").val();

                    TpesoToDolarSis = MpesoSistema / Tpeso;

                    PsupTotal = Mpeso / Tpeso;
                    PsupTotalDolar = PsupTotal * Tpeso;
                    $("#dif_moneda_peso_to_tasa_input").val(numDecimal(PsupTotalDolar));
                    $("#dif_moneda_peso_to_tasa").html(numDecimal(PsupTotalDolar - MpesoSistema));
                    $("#total_peso_dif").val(numDecimal(PsupTotalDolar - MpesoSistema));
                    $("#total_peso").val(numDecimal(PsupTotalDolar));
                    $("#dif_moneda_peso_to_dolar_input").val(numDecimal(PsupTotal));
                    $("#dif_moneda_peso_to_dolar").html(numDecimal(PsupTotal - TpesoToDolarSis));
                    sumar();
                    resta();

                }

                function DMontoBolivarRep(){
                    Mbolivar = $("#cantidad_efectivo_rep").val();
                    MbolivarSistema       = $("#efectivo_sistema").val();
                    Tdolar   = $("#TasaDolar").val();
                    Tpeso    = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto   = $("#TasaPunto").val();
                    Ttrans   = $("#TasaTrans").val();

                    TbolivarToDolarSis = MbolivarSistema / Tbolivar;


                    BsupTotal = Mbolivar / Tbolivar;
                    BsupTotalDolar = BsupTotal * Tbolivar;
                    $("#dif_moneda_efectivo_to_tasa_input").val(numDecimal(BsupTotalDolar));
                    $("#dif_moneda_efectivo_to_tasa").html(numDecimal(BsupTotalDolar - MbolivarSistema));
                    $("#total_bolivar_dif").val(numDecimal(BsupTotalDolar - MbolivarSistema));
                    $("#total_bolivar").val(numDecimal(BsupTotalDolar));
                    $("#dif_moneda_efectivo_to_dolar_input").val(numDecimal(BsupTotal));
                    $("#dif_moneda_efectivo_to_dolar").html(numDecimal(BsupTotal - TbolivarToDolarSis));
                    sumar();
                    resta();

                }

                function DMontoPuntoRep(){
                    Mpunto = $("#cantidad_punto_rep").val();
                    MpuntoSistema       = $("#punto_sistema").val();
                    Tdolar   = $("#TasaDolar").val();
                    Tpeso    = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto   = $("#TasaPunto").val();
                    Ttrans   = $("#TasaTrans").val();

                    TpuntoToDolarSis = MpuntoSistema / Tpunto;


                    PTsupTotal = Mpunto / Tbolivar;
                    PTsupTotalDolar = PTsupTotal * Tpunto;
                    $("#dif_moneda_punto_to_tasa_input").val(numDecimal(PTsupTotalDolar));
                    $("#dif_moneda_punto_to_tasa").html(numDecimal(PTsupTotalDolar - MpuntoSistema));
                    $("#total_punto_dif").val(numDecimal(PTsupTotalDolar - MpuntoSistema));
                    $("#total_punto").val(numDecimal(PTsupTotalDolar));
                    $("#dif_moneda_punto_to_dolar_input").val(numDecimal(PTsupTotal));
                    $("#dif_moneda_punto_to_dolar").html(numDecimal(PTsupTotal - TpuntoToDolarSis));
                    sumar();
                    resta();

                }

                function DMontoTransRep(){
                    Mtrans = $("#cantidad_trans_rep").val();
                    MtransSistema       = $("#trans_sistema").val();
                    Tdolar   = $("#TasaDolar").val();
                    Tpeso    = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto   = $("#TasaPunto").val();
                    Ttrans   = $("#TasaTrans").val();

                    TtransToDolarSis = MtransSistema / Ttrans;


                    TsupTotal = Mtrans / Ttrans;
                    TsupTotalDolar = TsupTotal * Ttrans;
                    $("#dif_moneda_trans_to_tasa_input").val(numDecimal(TsupTotalDolar));
                    $("#dif_moneda_trans_to_tasa").html(numDecimal(TsupTotalDolar - MtransSistema));
                    $("#total_trans_dif").val(numDecimal(TsupTotalDolar - MtransSistema));
                    $("#total_trans").val(numDecimal(TsupTotalDolar));
                    $("#dif_moneda_trans_to_dolar_input").val(numDecimal(TsupTotal));
                    $("#dif_moneda_trans_to_dolar").html(numDecimal(TsupTotal - TtransToDolarSis));
                    sumar();
                    resta();

                }


            $("#cantidad_dolar_rep").keyup(function() {
                DMontoDolarRep();
            });

            $("#cantidad_peso_rep").keyup(function() {
                DMontoPesoRep();
            });

            $("#cantidad_efectivo_rep").keyup(function() {
                DMontoBolivarRep();
            });

            $("#cantidad_punto_rep").keyup(function() {
                DMontoPuntoRep();
            });

            $("#cantidad_trans_rep").keyup(function() {
                DMontoTransRep();
            });
    });
</script>
@endpush
@endsection
