<!-- Ventas -->
<div class="container-small text-sm">
    <form action="{{ route('venta.store') }}" method="POST" autocomplete="off">
        @csrf

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="cliente">Cliente</label>
                    <select name="idcliente" id="idcliente" class="form-control selectpicker"
                        data-live-search="true">
                        @foreach ($personas as $persona)
                            <option value="{{ $persona->idpersona }}">{{ $persona->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="tipo_comprobante">Tipo Comprobante</label>
                    <select name="tipo_comprobante" class="form-control">
                        <option value="Oreden">Oreden</option>
                        <option value="Factura">Factura</option>
                        <option value="Ticket">Ticket</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Control Comprobante</label>
                    <input type="text" name="serie_comprobante" class="form-control"
                        value="{{ old('serie_comprobante') }}" placeholder="Control Comprobante...">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Número Comprobante</label>
                    <input type="text" name="num_comprobante" required class="form-control"
                        value="{{ old('num_comprobante') }}" placeholder="Número Comprobante...">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="row margin-bottom">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="articulo">Artículo</label>
                                        <select name="jidarticulo" id="jidarticulo"
                                            class="form-control selectpicker" data-live-search="true">
                                            <option value="seleccione...">Seleccione Articulo</option>
                                            @foreach ($articulos as $articulo)
                                                <option
                                                    value="{{ $articulo->idarticulo }}_{{ $articulo->stock }}_{{ $articulo->precio_compra }}_{{ $articulo->nombre }}">
                                                    {{ $articulo->articulo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <div class="form group">
                                        <label for="cantidad">Cantidad</label>
                                        <input type="text" name="jcantidad" id="jcantidad"
                                            class="form-control enteros" placeholder="Cantidad...">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <div class="form group">
                                        <label for="stock">Stock</label>
                                        <input type="text" readonly name="jstock" id="jstock"
                                            class="form-control" placeholder="Stock...">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                    <div class="form group">
                                        <label for="descuento">Descuento</label>
                                        <input type="text" name="jdescuento" id="jdescuento"
                                            class="form-control decimal" placeholder="Descuento...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                    <div class="form group">
                                        <label for="precio_venta_dolar">Precio Dolar</label>
                                        <h4 class="font-weight-bold" id="vprecio_venta_dolar">$. 0.00
                                        </h4>
                                        <input type="hidden" name="jprecio_venta_d_dolar"
                                            id="jprecio_venta_d_dolar" class="form-control">
                                        <input type="hidden" name="jprecio_compra" id="jprecio_compra"
                                            class="form-control" placeholder="Precio venta dolar...">
                                        <input type="hidden" name="jprecio_venta" id="jprecio_venta"
                                            class="form-control" placeholder="Precio dolar...">
                                        <input type="hidden" name="jprecio_venta_dolar"
                                            id="jprecio_venta_dolar" class="form-control"
                                            placeholder="Precio dolar...">
                                        <input type="hidden" name="jmarjen_ganancia_dolar"
                                            id="jmarjen_ganancia_dolar"
                                            value="{{ $tasaDolar->porcentaje_ganancia }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                    <div class="form group">
                                        <label for="jprecio_venta_peso">Precio Pesos</label>
                                        <h4 class="font-weight-bold" id="vprecio_venta_peso">$. 0.00
                                        </h4>
                                        <input type="hidden" name="jprecio_venta_p_dolar"
                                            id="jprecio_venta_p_dolar" class="form-control">
                                        <input type="hidden" name="jprecio_venta_peso"
                                            id="jprecio_venta_peso" class="form-control"
                                            placeholder="Precio pesos...">
                                        <input type="hidden" name="jmarjen_ganancia_peso"
                                            id="jmarjen_ganancia_peso"
                                            value="{{ $tasaPeso->porcentaje_ganancia }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                    <div class="form group">
                                        <label for="jprecio_venta_trans_punto">Precio
                                            Trans/Punto</label>
                                        <h4 class="font-weight-bold" id="vprecio_venta_trans_punto">Bs.
                                            0.00
                                        </h4>
                                        <input type="hidden" name="jprecio_venta_tp_dolar"
                                            id="jprecio_venta_tp_dolar" class="form-control">
                                        <input type="hidden" name="jprecio_venta_trans_punto"
                                            id="jprecio_venta_trans_punto" class="form-control"
                                            placeholder="Precio trans/punto...">
                                        <input type="hidden" name="jmarjen_ganancia_trans_punto"
                                            id="jmarjen_ganancia_trans_punto"
                                            value="{{ $tasaTransferenciaPunto->porcentaje_ganancia }}">
                                        <input type="hidden" name="tasaTransPunto" id="tasaTransPunto"
                                            value="{{ $tasaTransferenciaPunto->tasa }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                    <div class="form group">
                                        <label for="jprecio_venta_mixto">Precio Mixto</label>
                                        <h4 class="font-weight-bold" id="vprecio_venta_mixto">Bs. 0.00
                                        </h4>
                                        <input type="hidden" name="jprecio_venta_m_dolar"
                                            id="jprecio_venta_m_dolar" class="form-control">
                                        <input type="hidden" name="jprecio_venta_mixto"
                                            id="jprecio_venta_mixto" class="form-control"
                                            placeholder="Precio Mixto...">
                                        <input type="hidden" name="jmarjen_ganancia_mixto"
                                            id="jmarjen_ganancia_mixto"
                                            value="{{ $tasaMixto->porcentaje_ganancia }}">
                                        <input type="hidden" name="tasaMixto" id="tasaMixto"
                                            value="{{ $tasaMixto->tasa }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                    <div class="form group">
                                        <label for="precio_venta_Efectivo">Precio Efectivo</label>
                                        <h4 class="font-weight-bold" id="vprecio_venta_Efectivo">Bs.
                                            0.00
                                        </h4>
                                        <input type="hidden" name="jprecio_venta_e_dolar"
                                            id="jprecio_venta_e_dolar" class="form-control">
                                        <input type="hidden" name="jprecio_venta_Efectivo"
                                            id="jprecio_venta_Efectivo" class="form-control"
                                            placeholder="Precio venta efecti...">
                                        <input type="hidden" name="jmarjen_ganancia_Efectivo"
                                            id="jmarjen_ganancia_Efectivo"
                                            value="{{ $tasaEfectivo->porcentaje_ganancia }}">
                                        <input type="hidden" name="tasaEfectivo" id="tasaEfectivo"
                                            value="{{ $tasaEfectivo->tasa }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                    <div class="form group">
                                        <button id="bt_add" type="button"
                                            class="btn btn-primary btn-md btn-block">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Cargar Artículos</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table id="detalles"
                                                class="table table-striped table-borderd table-condensed table-hover">
                                                <thead>
                                                    <th class="info">Op</th>
                                                    <th class="info">Artículo</th>
                                                    <th class="info">Cant</th>
                                                    <th class="success">P/Dolar</th>
                                                    <th class="success">S/Total</th>
                                                    <th class="warning">P/Peso</th>
                                                    <th class="warning">S/Total</th>
                                                    <th class="success">P/T/P</th>
                                                    <th class="success">S/Total</th>
                                                    <th class="warning">P/Mixto</th>
                                                    <th class="warning">S/Total</th>
                                                    <th class="success">P/Efect</th>
                                                    <th class="success">S/Total</th>
                                                    <th class="info">Desto</th>
                                                    {{-- <th class="info">
                                                        Subtotal</th> --}}
                                                </thead>
                                                <tfoot>
                                                    <th colspan="3">TOTAL</th>
                                                    <th colspan="2">
                                                        <h4 class="font-weight-bold" id="totald">$. 0.00
                                                        </h4>
                                                    </th>
                                                    <th colspan="2">
                                                        <h4 class="font-weight-bold" id="totalp">$. 0.00
                                                        </h4>
                                                    </th>
                                                    <th colspan="2">
                                                        <h4 class="font-weight-bold" id="totaltp">Bs.
                                                            0.00
                                                        </h4>
                                                    </th>
                                                    <th colspan="2">
                                                        <h4 class="font-weight-bold" id="totalm">Bs.
                                                            0.00
                                                        </h4>
                                                    </th>
                                                    <th colspan="2">
                                                        <h4 class="font-weight-bold" id="totale">Bs.
                                                            0.00
                                                        </h4>
                                                    </th><input type="hidden" name="total_venta"
                                                        id="total_venta"><input type="hidden"
                                                        name="total_ventad" id="total_ventad"><input
                                                        type="hidden" name="total_ventap"
                                                        id="total_ventap"><input type="hidden"
                                                        name="total_ventatp" id="total_ventatp"><input
                                                        type="hidden" name="total_ventam"
                                                        id="total_ventam"><input type="hidden"
                                                        name="total_ventae" id="total_ventae">
                                                    <th></th>
                                                </tfoot>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="container-fluit">
                                        <div class="row">
                                            <div
                                                class="panel-group col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                                <button id='bt_addD' type='button'
                                                    class='btn btn-sm btn-primary btn-block col-lg-pull-2'>Dolar</button>
                                            </div>
                                            <div
                                                class="panel-group col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                                <button id='bt_addP' type='button'
                                                    class='btn btn-sm btn-primary btn-block col-lg-pull-2'>Peso</button>
                                            </div>
                                            <div
                                                class="panel-group col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                                <button id='bt_addTP' type='button'
                                                    class='btn btn-sm btn-primary btn-block col-lg-pull-2'>Punto/Trans</button>
                                            </div>
                                            <div
                                                class="panel-group col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                                <button id='bt_addM' type='button'
                                                    class='btn btn-sm btn-primary btn-block col-lg-pull-2'>Mixto</button>
                                            </div>
                                            <div
                                                class="panel-group col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                                <button id='bt_addE' type='button'
                                                    class='btn btn-sm btn-primary btn-block col-lg-pull-2'>Efectivo</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="gestionpago">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 id="gestionPago" class="panel-title">Gestion de pagos efectivo
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="pagos"
                                            class="table table-striped table-borderd table-condensed table-hover">
                                            <thead>
                                                <th>Divisa</th>
                                                <th>Monto</th>
                                                <th>Tasa</th>
                                                <th>Divisa a dolar</th>
                                                <th>Resta</th>
                                                <th>Subtotal</th>
                                            </thead>
                                            <tbody>
                                                <tr id="trD">
                                                    <td>
                                                        <h4 class="text-bold text-primary">Dolar</h4>
                                                    </td><input name="divisa[]" value="Dolar"
                                                        type="hidden">
                                                    <td><input name="MontoDivisa[]" class="decimal"
                                                            type="texto" id="DMontoDolar"></td>
                                                    <td><input name="TasaTike[]" type="texto" readonly
                                                            id="TasaDolar"
                                                            value="{{ $tasaDolar->tasa }}">
                                                    </td>
                                                    <td><input name="MontoDolar[]" type="text" readonly
                                                            id="DolarToDolar" class="monto"
                                                            onchange="sumar();"></td>
                                                    <td><input name="Veltos[]" type="text" readonly
                                                            id="RestaDolar"></td>
                                                    <td id="DsubTotal"></td>
                                                </tr>
                                                <tr id="trP">
                                                    <td>
                                                        <h4 class="text-bold text-primary">Peso</h4>
                                                    </td>
                                                    </th><input name="divisa[]" value="Peso"
                                                        type="hidden">
                                                    <td><input name="MontoDivisa[]" class="decimal"
                                                            type="texto" id="DMontoPeso"></td>
                                                    <td><input name="TasaTike[]" type="texto" readonly
                                                            id="TasaPeso" value="{{ $tasaPeso->tasa }}">
                                                    </td>
                                                    <td><input name="MontoDolar[]" type="text" readonly
                                                            id="PesoToDolar" class="monto"
                                                            onchange="sumar();"></td>
                                                    <td><input name="Veltos[]" type="text" readonly
                                                            id="RestaPeso"></td>
                                                    <td id="PeSubTotal"></td>
                                                </tr>
                                                <tr id="trE">
                                                    <td>
                                                        <h4 class="text-bold text-primary">Efectivo</h4>
                                                    </td>
                                                    </th><input name="divisa[]" value="Bolivar"
                                                        type="hidden">
                                                    <td><input name="MontoDivisa[]" class="decimal"
                                                            type="texto" id="DMontoBolivar"></td>
                                                    <td><input name="TasaTike[]" type="texto" readonly
                                                            id="TasaBolivar"
                                                            value="{{ $tasaTransferenciaPunto->tasa }}">
                                                    </td>
                                                    <td><input name="MontoDolar[]" type="texto" readonly
                                                            id="BolivarToDolar" class="monto"
                                                            onchange="sumar();"></td>
                                                    <td><input name="Veltos[]" type="text" readonly
                                                            id="RestaBolivar"></td>
                                                    <td id="BoSubTotal"></td>
                                                </tr>
                                                <tr id="trTP">
                                                    <td>
                                                        <h4 class="text-bold text-primary">Punto</h4>
                                                    </td>
                                                    </th><input name="divisa[]" value="Punto"
                                                        type="hidden">
                                                    <td><input name="MontoDivisa[]" class="decimal"
                                                            type="texto" id="DMontoPunto"></td>
                                                    <td><input name="TasaTike[]" type="texto"
                                                            class="enteros" id="NumTiker" value=""
                                                            placeholder="N° de tiket..."><input
                                                            type="hidden" id="TasaPunto"
                                                            value="{{ $tasaTransferenciaPunto->tasa }}">
                                                    </td>
                                                    <td><input name="MontoDolar[]" readonly type="texto"
                                                            id="PuntoToDolar" class="monto"
                                                            onchange="sumar();"></td>
                                                    <td><input name="Veltos[]" readonly type="text"
                                                            id="RestaPunto"></td>
                                                    <td id="PuSubTotal"></td>
                                                </tr>
                                                <tr id="trT">
                                                    <td>
                                                        <h4 class="text-bold text-primary">Transf
                                                        </h4>
                                                    </td>
                                                    </th><input name="divisa[]" value="Transferencia"
                                                        type="hidden">
                                                    <td><input name="MontoDivisa[]" class="decimal"
                                                            class="" type="texto" id="DMontoTrans"></td>
                                                    <td><input name="TasaTike[]" type="texto"
                                                            class="enteros" id="NumtTrans" value=""
                                                            placeholder="N° de Transferencia..."><input
                                                            type="hidden" id="TasaTrans"
                                                            value="{{ $tasaTransferenciaPunto->tasa }}">
                                                    </td>
                                                    <td><input name="MontoDolar[]" type="texto" readonly
                                                            id="TransToDolar" class="monto"
                                                            onchange="sumar();"></td>
                                                    <td><input name="Veltos[]" type="text" readonly
                                                            id="RestaTrans"></td>
                                                    <td id="TrSubTotal"></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>
                                                    <h4 id="tp" class="text-bold">TOTAL PAGADO</h4>
                                                    <h4 id="r" class="text-bold">RESTA</h4>
                                                    <h4 id="tap" class="text-bold">TOTAL A PAGAR</h4>
                                                <th>
                                                    <h4 class="text-bold" id="spTotal">0.00</h4>
                                                    <h4 class="text-bold" id="RestaTtotal">0.00</h4>
                                                    <h4 class="text-bold" id="PagoTtotal">0.00</h4>
                                                </th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel-footer" id="guardar">
                                    <div class="panel-group col-lg-2 col-sm-2 col-md-2 col-xs-12"
                                        id="guardar">
                                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                        <button class="btn btn-primary btn-block"
                                            type="submit">Guardar</button>
                                    </div>
                                    <div class="panel-group col-lg-2 col-sm-2 col-md-2 col-xs-12"
                                        id="guardar">
                                        <button class="btn btn-danger btn-block"
                                            type="reset">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

