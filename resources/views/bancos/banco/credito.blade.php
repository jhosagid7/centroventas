<div class="modal fade bd-example-modal-lg" aria-hidden="true" role="dialog" tabindex="-1" id="modal-pago">

    <form id="form1" action="{{ route('banco.store') }}" method="POST", class="submit-prevent-form">
        @csrf
        @method('POST')
        <div class="row">
            @isset($caja)

                <input name="estado" type="hidden" value="cierre">
                <input id="session_id" name="session_id" type="hidden" value="{{$caja->sessioncaja_id ?? ''}}">
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

                <input name="observacionesStock" type="hidden" value="">








                {{-- <input name="url" type="hidden" value="{{URL::previous()}}"> --}}
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
                    <h4 class="modal-title">Transferencias</b></h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="box box-info">
                        <div class="box-header with-border">
                            <div class="box-header with-border">


                                <div class="row">
                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header">S/Actual:</h5>
                                            <h5 class="description-header">S/debitado:</h5>



                                            <h5 class="description-header text-red">&nbsp;&nbsp;&nbsp;</h5>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">

                                            <h5 class="description-header">$.{{round($saldo_banco_dolar->saldo, 2) ?? '0.00'}}</h5>
                                            <span class="description-text">DOLAR</span>
                                            <input type="hidden" name="saldo_banco_dolar" id="saldo_banco_dolar" value="{{ floatval($saldo_banco_dolar->saldo) ?? ' 0,00' }}">
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">

                                            <h5 class="description-header">$.{{round($saldo_banco_peso->saldo, 2) ?? '0.00'}} </h5>
                                            <span class="description-text">PESO</span>
                                            <input type="hidden" name="saldo_banco_peso" id="saldo_banco_peso" value="{{ floatval($saldo_banco_peso->saldo) ?? ' 0,00' }}">
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">

                                            <h5 class="description-header">Bs.{{round($saldo_banco_punto->saldo, 2) ?? '0.00'}}</h5>
                                            <span class="description-text">PUNTO</span>
                                            <input type="hidden" name="saldo_banco_punto" id="saldo_banco_punto" value="{{ floatval($saldo_banco_punto->saldo) ?? ' 0,00' }}">
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->

                                    {{-- <div class="col-sm-2 col-xs-6">
                                        <div class="description-block border-right">

                                            <h5 class="description-header">Bs.{{round($saldo_banco_transferencia->saldo, 2) ?? '0.00'}}</h5>
                                            <span class="description-text">TRANS</span>
                                            <input type="hidden" name="saldo_banco_transferencia" id="saldo_banco_transferencia" value="{{ floatval($saldo_banco_transferencia->saldo) ?? ' 0,00' }}">
                                        </div>
                                    </div> --}}
                                    <!-- /.col -->

                                    <div class="col-sm-2 col-xs-6">
                                        <div class="description-block">

                                            <h5 class="description-header">Bs.{{round($saldo_banco_bolivar->saldo, 2) ?? '0.00'}}</h5>
                                            <span class="description-text">EFECTIVO</span>
                                            <input type="hidden" name="saldo_banco_bolivar" id="saldo_banco_bolivar" value="{{ floatval($saldo_banco_bolivar->saldo) ?? ' 0,00' }}">
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
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="description-block">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="accion">Banco de Origen</label>
                                                        <select required   class="form-control select2" name="bancoOrigen" id="bancoOrigen">
                                                            <option value="{{$banco_origen->id}}:{{$banco_origen->moneda}}">{{$banco_origen->moneda}}</option>


                                                        </select>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="description-block">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="accion">Seleccione banco de destino</label>
                                                        <select required   class="form-control select2" name="Bdestino" id="Bdestino">
                                                            <option value=""></option>
                                                            @foreach ($cuenta_tasa as $cat)
                                                            <option value="{{$cat->id}}:{{$cat->nombre}}">{{$cat->nombre}}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="description-block">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="accion">Total a transferir</label>
                                                        <h2 id="montoDestino" style="margin-top: 0px;">0.00</h2>


                                                    </div>

                                                </div>
                                            </div>


                                            <!-- /.description-block -->
                                        </div>
                                        <div class="col-sm-12 col-xs-12">

                                            <div class="description-block">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="accion">Monto a transferir</label>
                                                        <input type="text" id="montoOrigen">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="description-block">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="accion">Agregar Tasa</label>
                                                        <input type="Tdestino" id="Tdestino">

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>                       <!-- /.box-header -->
                        <div class="box-body">
                          <div class="table-responsive">
                            <table class="table no-margin">

                                <tbody>

                                    <tr>
                                        <td colspan="4"><h4><strong class="text-blue">Cuenta a debitar</strong></h4></td>
                                        <td><h4><b id="cuenta_origen_ver"></b></h4></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4"><h4><strong class="text-blue">Cuenta destino</strong></h4></td>
                                        <td><h4><b id="cuenta_destino_ver"></b></h4></td>

                                    </tr>
                                    {{-- @php
                                        dd(($cajas->SumaTotalVentas + $cajas->SumaTotalServicios));
                                        @endphp --}}
                                    <tr>
                                        <td colspan="4"><h4><strong class="text-blue">Tasa </strong></h4></td>
                                        <td><h4><b id="tasa_destino_ver">0.00</b></h4><input type="hidden" name="tasa_destino" id="tasa_destino" value=""></td>


                                    </tr>
                                    <tr>
                                        <td colspan="4"><h4><strong class="text-blue">Monto a debitar</strong></h4></td>
                                        <td><h4><b id="monto_debitar_ver">0.00</b></h4><input type="hidden" name="monto_debitar" id="monto_debitar" value=""></td>


                                    </tr>
                                    <tr>
                                        <td colspan="4"><h4><strong class="text-blue">Monto a transferir</strong></h4></td>
                                        <td><h4><b id="monto_transferir_ver">0.00</b></h4><input type="hidden" name="monto_transferir" id="monto_transferir"></td>


                                    </tr>
                                    <tr>
                                        <td><h4><strong class="text-blue">Concepto</strong></h4></td>
                                        <td colspan="5"><textarea name="Observaciones" id="Observaciones" cols="50" rows="4"></textarea></td>

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
                <div class="modal-footer">
                    <button type="button" class="btn btn default" data-dismiss="modal">Cerrar</button>
                    <button id="pagar" type="submit" class="btn btn-primary submit-prevent-button">Confirmar</button>
                </div>
            </div>
        </div>
    </form>
</div>
