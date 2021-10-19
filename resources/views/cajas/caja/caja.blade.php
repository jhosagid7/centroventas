<div class="modal fade bd-example-modal-lg" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$caja->id}}">

    <form action="{{ route('caja.update', $caja->id)}}" method="POST" class="submit-prevent-form">
        @csrf
        @method('PUT')
        <div class="row">
            @isset($caja)
                <input name="estado" type="hidden" value="cierre">
                <input id="session_id" name="session_id" type="hidden" value="{{$caja->sessioncaja_id}}">
                <input id="caja_id" name="caja_id" type="hidden" value="{{ $caja->id ?? '' }}">
                {{-- <input id="estatus_caja" name="estatus_caja" type="hidden" value="{{$estatus_caja}}"> --}}
                <input id="total_dolar" name="total_dolar" type="hidden" value="0">
                <input id="total_peso" name="total_peso" type="hidden" value="0">
                <input id="total_bolivar" name="total_bolivar" type="hidden" value="0">
                <input id="total_punto" name="total_punto" type="hidden" value="0">
                <input id="total_trans" name="total_trans" type="hidden" value="0">
                <input id="total_dolar_dif" name="total_dolar_dif" type="hidden" value="0">
                <input id="total_peso_dif" name="total_peso_dif" type="hidden" value="0">
                <input id="total_bolivar_dif" name="total_bolivar_dif" type="hidden" value="0">
                <input id="total_punto_dif" name="total_punto_dif" type="hidden" value="0">
                <input id="total_trans_dif" name="total_trans_dif" type="hidden" value="0">
                <input name="idusuario" type="hidden" value="{{Auth::user()->id}}">
                {{-- cargadmos el historial de los creditos para que no se modifiquen cuando hagan un pago despues de cerrar la caja --}}
                {{-- <input name="hist_creditos_vigentes" type="hidden" value="{{ $cajas->SumaTotalCantidadCreditosVigentes ?? '0' }}">
                <input name="hist_creditos_vencidos" type="hidden" value="{{ $cajas->SumaTotalCantidadCreditosVencidos ?? '0' }}">
                <input name="hist_creditos_pagados" type="hidden" value="{{$cajas->SumaTotalCantidadCreditosPagadosTotales ?? '0'}}">
                <input name="hist_creditos_nuevos" type="hidden" value="{{ $cajas->SumaTotalCantidadServiciosPorPagar + $cajas->SumaTotalCantidadVentasCredito ?? '0' }}">
                <input name="hist_total_creditos" type="hidden" value="{{$cajas->SumaTotalCantidadCreditosVigentes + $cajas->SumaTotalCantidadCreditosVencidos + $cajas->SumaTotalCantidadCreditosPagadosTotales ?? '0'}}"> --}}
                <input name="stock_cierre_operador" type="hidden" value="">
                <input name="observacionesStock" type="hidden" value="">


                <input name="url" type="hidden" value="{{URL::previous()}}">
                {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group col-md-3">
                        <h3><button class="btn btn-danger" type="submit"><span class='glyphicon glyphicon-save'></span> Cerrar</button></h3>
                    </div>
                    <div class="form-group col-md-3">
                        <h3><a  id="cerrarModal" class="btn btn-success" href="#"><span class='glyphicon glyphicon-step-backward'></span> <span class="button" data-dismiss="modal" aria-label="Close">cancel</span></a></h3>
                    </div>
                </div> --}}
            @endisset
            </div>

     <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidder="true">X</span>
                    </button>
                    <h4 class="modal-title">Cerrar caja N° <b>{{$caja->codigo ?? ''}}</b></h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="box box-info">
                        <div class="box-header with-border">
                            <div class="box-header with-border">


                                <div class="row">
                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header">Caja Chica:</h5>
                                            {{-- <h5 class="description-header">Vtos/Pendientes:</h5> --}}



                                            <h5 class="description-header text-red">&nbsp;&nbsp;&nbsp;</h5>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">

                                            <h5 class="description-header">$. {{ number_format(floatval($caja->monto_dolar),2,',','.') ?? ' 0,00' }}</h5>
                                            {{-- <h5 class="description-header">$. {{ number_format(floatval($cajas->SumaVueltosPendientesDolarDivisa),2,',','.') ?? ' 0,00' }}</h5> --}}
                                            <span class="description-text">DOLAR</span>
                                            {{-- <input type="hidden" name="dolar_sistema" id="dolar_sistema" value="{{ floatval((($cajas->SumaTotalDolarCredConsumo + $cajas->SumaTotalDolarCredServicio) + ($cajas->SumaVueltosExcedenteNuevoDolarDivisa) + ($cajas->SumaTotalDolarServ + $cajas->SumaTotalDolar) + ($cajas->SumaVueltosDevueltosDolarDivisa + $cajas->SumaTotalDolarServDflotante + $cajas->SumaVueltosPagarOficinaDolarDivisa) - $cajas->SumaTotalDolarVueltos)) ?? ' 0,00' }}"> --}}
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">

                                            <h5 class="description-header">$. {{ number_format(floatval($caja->monto_peso),2,',','.') ?? ' 0,00' }}</h5>
                                            {{-- <h5 class="description-header">$. {{ number_format(floatval($cajas->SumaVueltosPendientesPesoDivisa),2,',','.') ?? ' 0,00' }}</h5> --}}
                                            <span class="description-text">PESO</span>
                                            {{-- <input type="hidden" name="peso_sistema" id="peso_sistema" value="{{(($cajas->SumaTotalPesoCredConsumo + $cajas->SumaTotalPesoCredServicio) + ($cajas->SumaVueltosExcedenteNuevoPesoDivisa) + ($cajas->SumaTotalPesoServ + $cajas->SumaTotalPeso) + ($cajas->SumaVueltosDevueltosPesoDivisa + $cajas->SumaTotalPesoServDflotante + $cajas->SumaVueltosPagarOficinaPesoDivisa) - $cajas->SumaTotalPesoVueltos) ?? '00'}}"> --}}
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">

                                            <h5 class="description-header">Bs. {{ number_format(floatval($caja->monto_punto),2,',','.') ?? ' 0,00' }}</h5>
                                            {{-- <h5 class="description-header">Bs. {{ number_format($cajas->SumaVueltosPendientesPuntoDivisa,2,',','.') ?? ' 0,00' }}</h5> --}}
                                            <span class="description-text">PUNTO</span>
                                            {{-- <input type="hidden" name="punto_sistema" id="punto_sistema" value="{{(($cajas->SumaTotalPuntoCredConsumo + $cajas->SumaTotalPuntoCredServicio) + ($cajas->SumaVueltosExcedenteNuevoPuntoDivisa) + ($cajas->SumaTotalPuntoServ + $cajas->SumaTotalPunto) + ($cajas->SumaVueltosDevueltosPuntoDivisa + $cajas->SumaTotalPuntoServDflotante + $cajas->SumaVueltosPagarOficinaPuntoDivisa) - $cajas->SumaTotalPuntoVueltos) ?? '00'}}"> --}}
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">

                                            <h5 class="description-header">Bs. {{ number_format(floatval($caja->monto_trans),2,',','.') ?? ' 0,00' }}</h5>
                                            {{-- <h5 class="description-header">Bs. {{ number_format($cajas->SumaVueltosPendientesTransferenciaDivisa,2,',','.') ?? ' 0,00' }}</h5> --}}
                                            <span class="description-text">TRANS</span>
                                            {{-- <input type="hidden" name="trans_sistema" id="trans_sistema" value="{{(($cajas->SumaTotalTransferenciaCredConsumo + $cajas->SumaTotalTransferenciaCredServicio) + ($cajas->SumaVueltosExcedenteNuevoTransferenciaDivisa) + ($cajas->SumaTotalTransferenciaServ + $cajas->SumaTotalTransferencia) + ($cajas->SumaVueltosDevueltosTransferenciaDivisa + $cajas->SumaTotalTransferenciaServDflotante + $cajas->SumaVueltosPagarOficinaTransferenciaDivisa) - $cajas->SumaTotalTransferenciaVueltos) ?? '00'}}"> --}}
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block">

                                            <h5 class="description-header">Bs. {{ number_format(floatval($caja->monto_bolivar),2,',','.') ?? ' 0,00' }}</h5>
                                            {{-- <h5 class="description-header">Bs. {{ number_format($cajas->SumaVueltosPendientesBolivarDivisa,2,',','.') ?? ' 0,00' }}</h5> --}}
                                            <span class="description-text">EFECTIVO</span>
                                            {{-- <input type="hidden" name="efectivo_sistema" id="efectivo_sistema" value="{{(($cajas->SumaTotalBolivarCredConsumo + $cajas->SumaTotalBolivarCredServicio) + ($cajas->SumaVueltosExcedenteNuevoBolivarDivisa) + ($cajas->SumaTotalBolivarServ + $cajas->SumaTotalBolivar) + ($cajas->SumaVueltosDevueltosBolivarDivisa + $cajas->SumaTotalBolivarServDflotante + $cajas->SumaVueltosPagarOficinaBolivarDivisa) - $cajas->SumaTotalBolivarVueltos) ?? '00'}}"> --}}
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="box box-info">
                        <div class="box-header with-border">
                            <div class="box-header with-border">


                                <div class="row">

                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"><i
                                                    class="fa fa-caret-up"></i>
                                                {{ $tasaDolar->porcentaje_ganancia ?? ''}}%</span>
                                            <h5 class="description-header">$. {{ number_format(floatval($cajas->SumaTotalDolar),2,',','.') ?? ' 0,00' }}</h5>
                                            <span class="description-text">DOLAR</span><input type="hidden" name="dolar_sistema" id="dolar_sistema" value="{{ floatval($cajas->SumaTotalDolar) ?? ' 0,00' }}">
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-yellow"><i
                                                    class="fa fa-caret-left"></i>
                                                {{ $tasaPeso->porcentaje_ganancia  ?? ''}}%</span>
                                            <h5 class="description-header">$. {{ number_format(floatval($cajas->SumaTotalPeso),2,',','.') ?? ' 0,00' }}</h5>
                                            <span class="description-text">PESO</span><input type="hidden" name="peso_sistema" id="peso_sistema" value="{{floatval($cajas->SumaTotalPeso) ?? '00'}}">
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"><i
                                                    class="fa fa-caret-up"></i>
                                                {{ $tasaTransferenciaPunto->porcentaje_ganancia  ?? ''}}%</span>
                                            <h5 class="description-header">Bs. {{ number_format(floatval($cajas->SumaTotalPunto),2,',','.') ?? ' 0,00' }}</h5>
                                            <span class="description-text">PUNTO</span><input type="hidden" name="punto_sistema" id="punto_sistema" value="{{floatval($cajas->SumaTotalPunto) ?? '00'}}">
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-sm-3 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"><i
                                                    class="fa fa-caret-up"></i>
                                                {{ $tasaTransferenciaPunto->porcentaje_ganancia }}%</span>
                                            <h5 class="description-header">Bs. {{ number_format(floatval($cajas->SumaTotalTransferencia),2,',','.') ?? ' 0,00' }}</h5>
                                            <span class="description-text">TRANS</span><input type="hidden" name="trans_sistema" id="trans_sistema" value="{{floatval($cajas->SumaTotalTransferencia) ?? '00'}}">
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block">
                                            <span class="description-percentage text-red"><i
                                                    class="fa fa-caret-down"></i>
                                                {{ $tasaEfectivo->porcentaje_ganancia }}%</span>
                                            <h5 class="description-header">Bs. {{ number_format(floatval($cajas->SumaTotalBolivar),2,',','.') ?? ' 0,00' }}</h5>
                                            <span class="description-text">EFECTIVO</span><input type="hidden" name="efectivo_sistema" id="efectivo_sistema" value="{{floatval($cajas->SumaTotalBolivar) ?? '00'}}">
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>Modo</th>
                                        <th>Cantidad</th>
                                        <th>Dif/Moneda</th>
                                        <th>Dif/Dolar</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dolar</td>
                                        <td><input type="text" id="cantidad_dolar_rep" name="cantidad_dolar_rep"><input type="hidden" id="TasaDolar" name="TasaDolar" value="{{$tasaDolar->tasa}}"></td>
                                        <td><b id="dif_moneda_dolar_to_tasa">0.00</b><input type="hidden" id="dif_moneda_dolar_to_tasa_input" name="dif_moneda_dolar_to_tasa_input"></td>
                                        <td><b id="dif_moneda_dolar_to_dolar">0.00</b><input onchange="sumar();" class="monto" type="hidden" id="dif_moneda_dolar_to_dolar_input" name="dif_moneda_dolar_to_dolar_input"></td>

                                    </tr>
                                    <tr>
                                        <td>Peso</td>
                                        <td><input type="text" id="cantidad_peso_rep" name="cantidad_peso_rep"><input type="hidden" id="TasaPeso" name="TasaPeso" value="{{$tasaPeso->tasa}}"></td>
                                        <td><b id="dif_moneda_peso_to_tasa">0.00</b><input type="hidden" id="dif_moneda_peso_to_tasa_input" name="dif_moneda_peso_to_tasa_input"></td>
                                        <td><b id="dif_moneda_peso_to_dolar">0.00</b><input onchange="sumar();" class="monto" type="hidden" id="dif_moneda_peso_to_dolar_input" name="dif_moneda_peso_to_dolar_input"></td>

                                    </tr>
                                    <tr>
                                        <td>Punto</td>
                                        <td><input type="text" id="cantidad_punto_rep" name="cantidad_punto_rep"><input type="hidden" id="TasaPunto" name="TasaPunto" value="{{$tasaTransferenciaPunto->tasa}}"></td>
                                        <td><b id="dif_moneda_punto_to_tasa">0.00</b><input type="hidden" id="dif_moneda_punto_to_tasa_input" name="dif_moneda_punto_to_tasa_input"></td>
                                        <td><b id="dif_moneda_punto_to_dolar">0.00</b><input onchange="sumar();" class="monto" type="hidden" id="dif_moneda_punto_to_dolar_input" name="dif_moneda_punto_to_dolar_input"></td>

                                    </tr>
                                    <tr>
                                        <td>Trans</td>
                                        <td><input type="text" id="cantidad_trans_rep" name="cantidad_trans_rep"><input type="hidden" id="TasaTrans" name="TasaTrans" value="{{$tasaTransferenciaPunto->tasa}}"></td>
                                        <td><b id="dif_moneda_trans_to_tasa">0.00</b><input type="hidden" id="dif_moneda_trans_to_tasa_input" name="dif_moneda_trans_to_tasa_input"></td>
                                        <td><b id="dif_moneda_trans_to_dolar">0.00</b><input onchange="sumar();" class="monto" type="hidden" id="dif_moneda_trans_to_dolar_input" name="dif_moneda_trans_to_dolar_input"></td>

                                    </tr>
                                    <tr>
                                        <td>Efectivo</td>
                                        <td><input type="text" id="cantidad_efectivo_rep" name="cantidad_efectivo_rep"><input type="hidden" id="TasaBolivar" name="TasaBolivar" value="{{$tasaEfectivo->tasa}}"></td>
                                        <td><b id="dif_moneda_efectivo_to_tasa">0.00</b><input type="hidden" id="dif_moneda_efectivo_to_tasa_input" name="dif_moneda_efectivo_to_tasa_input"></td>
                                        <td><b id="dif_moneda_efectivo_to_dolar">0.00</b><input onchange="sumar();" class="monto" type="hidden" id="dif_moneda_efectivo_to_dolar_input" name="dif_moneda_efectivo_to_dolar_input"></td>

                                    </tr>
                                    <tr>
                                        <td colspan="3"><h4><strong class="text-blue">Registrado por Operador</strong></h4></td>
                                        <td><h4><b id="total_operador_reg">0.00</b></h4><input type="hidden" name="total_operador_reg_input" id="total_operador_reg_input"></td>

                                    </tr>
                                    {{-- @php
                                        dd(($cajas->SumaTotalVentas + $cajas->SumaTotalServicios));
                                    @endphp --}}
                                    <tr>
                                        <td colspan="3"><h4><strong class="text-blue">Registrado por Sistema </strong></h4></td>
                                        <td><h4><b id="total_sistema_reg">0.00</b></h4><input type="hidden" name="total_sistema_reg_input" id="total_sistema_reg_input" value="{{(($cajas->SumaTotalDolarDolar + $cajas->SumaTotalPesoDolar) + ($cajas->SumaTotalPuntoDolar + $cajas->SumaTotalTransferenciaDolar + $cajas->SumaTotalBolivarDolar)) ?? '0.00'}}"></td>


                                    </tr>
                                    <tr>
                                        <td colspan="3"><h4><strong class="text-blue">Diferencia</strong></h4></td>
                                        <td><h4><b id="total_dif">0.00</b></h4><input type="hidden" name="total_dif_input" id="total_dif_input"></td>


                                    </tr>
                                    <tr>
                                        <td><h4><strong class="text-blue">Observaciones</strong></h4></td>

                                        <td colspan="4"><textarea name="Observaciones" id="Observaciones" cols="50" rows="4"></textarea></td>

                                    </tr>
                                 </tbody>
                            </table>
                          </div>
                          <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        {{-- <div class="box-footer clearfix">
                          <h3><strong class="text-primary">Totol Dolares</strong> <strong id="dtotal">0.00</strong></h3>
                        </div> --}}
                        <!-- /.box-footer -->
                      </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary submit-prevent-button">Confirmar</button>
                </div>
            </div>
        </div>
    </form>
</div>
