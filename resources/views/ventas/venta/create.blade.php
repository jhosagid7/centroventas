@extends ('layouts.admin3')
@section('contenido')

    <div class="row">
        <div class="col-lg-6">

            @include('custom.message')
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="nav-tabs-custom margin">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#caja" data-toggle="tab">Caja</a></li>
                <li><a href="#ventas" data-toggle="tab">Ventas</a></li>
                <li><a href="#tasa" data-toggle="tab">Configurar tasa</a></li>
            </ul>
            <div class="tab-content">
                <a href="{{URL::action('CajaController@show', $caja->id)}}"><button class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-edit'> Cerrar caja</span></button></a>

                <div class="active tab-pane" id="caja">
                    <!-- Main content -->
                    <section class="content">
                        <!-- Info boxes -->
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Produc Vendidos</span>
                                        <span class="info-box-number">{{ $cajas->SumaArticulosVendidos ?? ' 0' }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Ventas Realizadas</span>
                                        <span class="info-box-number">{{ $cajas->SumaTotalCantidadVentas ?? ' 0,00' }}</span>
                                    </div>
                                    <!-- </.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <!-- fix for small devices only -->
                            <div class="clearfix visible-sm-block"></div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Ventas</span>
                                        <span class="info-box-number">$. {{ $cajas->SumaTotalVentas ?? ' 0,00' }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                                    @php
                                    $countMayor = 0;
                                    $countDetal = 0;
                                    $actual = 0;
                                    $stockDetal = 0;


                                @endphp
                                    @foreach ($articulos as $art)
                                        @if ($art->vender_al !== $actual)
                                        @php
                                        $actual = $art->vender_al;
                                        @endphp

                                        @endif
                                        @if ($art->isKilo)
                                            @php
                                                $stock = $art->stock / 1000;

                                            @endphp

                                        @else
                                            @php
                                                $stock = $art->stock;
                                            @endphp
                                        @endif
                                        @if ($art->vender_al == 'Mayor' && $stock <= 1)


                                            @php
                                            $countMayor += 1;
                                            @endphp
                                        @elseif($art->vender_al == 'Detal' && $stock <= 10)


                                            @php
                                            $countDetal += 1;
                                            @endphp

                                        @endif



                                    @endforeach

                                    <div class="info-box-content">
                                        <span class="info-box-text">Poco stock</span>
                                    <span class="info-box-number">Mayor {{$countMayor}}</span>
                                        <span class="info-box-number">Detal {{$countDetal}}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->





                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                    <h3 class="box-title">Montos Recividos en Caja </h3>

                                        <div class="row">
                                            <div class="col-sm-2 col-xs-6">
                                                <div class="description-block border-right">
                                                    <span class="description-text">INICIO DE CAJA</span>
                                                    <h5 class="description-header">Dolar: {{ number_format($caja->monto_dolar,3,',','.') ?? '' }}</h5>
                                                    <h5 class="description-header">Peso: {{ number_format($caja->monto_peso,2,',','.') ?? '' }}</h5>
                                                    <h5 class="description-header">Bolivar: {{ number_format($caja->monto_bolivar,2,',','.') ?? '' }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-xs-6">
                                                <div class="description-block border-right">
                                                    <span class="description-percentage text-green"><i
                                                            class="fa fa-caret-up"></i>
                                                        {{ $tasaDolar->porcentaje_ganancia }}%</span>
                                                    <h5 class="description-header">$. {{ number_format($cajas->SumaTotalDolar,3,',','.') ?? ' 0,00' }}</h5>
                                                    <span class="description-text">DOLAR</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-2 col-xs-6">
                                                <div class="description-block border-right">
                                                    <span class="description-percentage text-yellow"><i
                                                            class="fa fa-caret-left"></i>
                                                        {{ $tasaPeso->porcentaje_ganancia }}%</span>
                                                    <h5 class="description-header">$. {{ number_format($cajas->SumaTotalPeso,2,',','.') ?? ' 0,00' }}</h5>
                                                    <span class="description-text">PESO</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-2 col-xs-6">
                                                <div class="description-block border-right">
                                                    <span class="description-percentage text-green"><i
                                                            class="fa fa-caret-up"></i>
                                                        {{ $tasaTransferenciaPunto->porcentaje_ganancia }}%</span>
                                                    <h5 class="description-header">Bs. {{ number_format($cajas->SumaTotalPunto,2,',','.') ?? ' 0,00' }}</h5>
                                                    <span class="description-text">PUNTO</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-sm-2 col-xs-6">
                                                <div class="description-block border-right">
                                                    <span class="description-percentage text-green"><i
                                                            class="fa fa-caret-up"></i>
                                                        {{ $tasaTransferenciaPunto->porcentaje_ganancia }}%</span>
                                                    <h5 class="description-header">Bs. {{ number_format($cajas->SumaTotalTransferencia,2,',','.') ?? ' 0,00' }}</h5>
                                                    <span class="description-text">TRANS</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->

                                            <div class="col-sm-2 col-xs-6">
                                                <div class="description-block">
                                                    <span class="description-percentage text-red"><i
                                                            class="fa fa-caret-down"></i>
                                                        {{ $tasaEfectivo->porcentaje_ganancia }}%</span>
                                                    <h5 class="description-header">Bs. {{ number_format($cajas->SumaTotalBolivar,2,',','.') ?? ' 0,00' }}</h5>
                                                    <span class="description-text">EFECTIVO</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- Main row -->
                                    <div class="row">
                                        <!-- Left col -->
                                        <div class="col-md-8">
                                            <div class="box-body">

                                                <!-- TABLE: LATEST ORDERS -->
                                                <div class="box box-info">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Ventas</h3>

                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-box-tool"
                                                                data-widget="collapse"><i class="fa fa-minus"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-box-tool"
                                                                data-widget="remove"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            {{-- @include('ventas.venta.buscar') --}}
                                                        </div>
                                                    </div>
                                                    <!-- /.box-header -->
                                                    <div class="box-body">
                                                        <div class="table-responsive">
                                                            <table id="ven"
                                                                class="table table-striped table-bordered table-condensed table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>N° Fac</th>
                                                                        <th>Cliente</th>
                                                                        <th>Estado</th>
                                                                        <th>Total Venta</th>
                                                                        <th>Op</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($ventas as $venta)
                                                                        <tr>
                                                                            <td>{{ $venta->num_comprobante }}</td>
                                                                            <td>{{ $venta->nombre }}</td>
                                                                            <td>
                                                                                @if ($venta->estado === 'Aceptada')
                                                                                    <span
                                                                                        class="label label-success">{{ $venta->estado }}</span>
                                                                                @else
                                                                                    <span
                                                                                        class="label label-danger">{{ $venta->estado }}</span>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                <div class="sparkbar" data-color="#00a65a"
                                                                                    data-height="20">
                                                                                    <a
                                                                                        href="{{ URL::action('VentaController@show', $venta->id) }}">
                                                                                        {{ $venta->total_venta }}
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href=""
                                                                                    data-target="#modal-delete-{{ $venta->id }}"
                                                                                    data-toggle="modal"><button
                                                                                        class='btn btn-danger btn-xs'><i
                                                                                            class='glyphicon glyphicon-trash'></i></button></a>
                                                                            </td>
                                                                        </tr>
                                                                        @include('ventas.venta.modal')
                                                                    @endforeach



                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.table-responsive -->
                                                    </div>
                                                    <!-- /.box-body -->

                                                </div>
                                                <!-- /.box -->
                                            </div>
                                            <!-- ./box-body -->

                                        </div>
                                        <!-- /.box -->
                                        <div class="col-md-4 no-print">
                                            <div class="box-body">
                                                <div class="box box-info">
                                                    <div class="box-header with-border">
                                                      <h3 class="box-title">Productos con poco stock</h3>

                                                      <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                      </div>
                                                    </div>
                                                    <!-- /.box-header -->
                                                    <div class="box-body">
                                                      <ul class="products-list product-list-in-box">
                                                        @php
                                                        $count = 0;
                                                        $actual = 0;
                                                        $nombre = '';
                                                        $stock = 0;

                                                    @endphp
                                                        @foreach ($articulos as $art)

                                                        @if ($art->vender_al !== $actual)
                                                        @php
                                                        $actual = $art->vender_al;
                                                        @endphp

                                                            <!-- Productos al {{$actual}} -->
                                                        @endif
                                                        @if ($art->isKilo)
                                                        @php
                                                            $stock = $art->stock / 1000;

                                                        @endphp

                                                    @else
                                                        @php
                                                            $stock = $art->stock;
                                                        @endphp
                                                    @endif
                                                        @if ($art->vender_al == 'Mayor' && $stock <= 1)

                                                            <li class="item">
                                                                <div class="product-img">
                                                                <img src="{{asset('imagenes/articulos/'.$art->imagen)}}" alt="{{ $art->nombre }}" alt="Product Image">
                                                                </div>
                                                                <div class="product-info">
                                                                <a href="javascript:void(0)" class="product-title">{{$art->nombre}}
                                                                    <span class="label label-danger pull-right">
                                                                    @if ($art->isKilo)
                                                                    {{$art->stock / 1000}} Kg.
                                                                    @else
                                                                    {{$art->stock}}
                                                                    @endif


                                                                    </span></a>
                                                                <span class="product-description">
                                                                    {{$art->vender_al}}
                                                                    </span>
                                                                </div>
                                                            </li>

                                                        @elseif($art->vender_al == 'Detal' && $stock <= 10)

                                                            <li class="item">
                                                                <div class="product-img">
                                                                <img src="{{asset('imagenes/articulos/'.$art->imagen)}}" alt="Product Image">
                                                                </div>
                                                                <div class="product-info">
                                                                <a href="javascript:void(0)" class="product-title">{{$art->nombre}}
                                                                    <span class="label label-danger pull-right">
                                                                    @if ($art->isKilo)
                                                                    {{$art->stock / 1000}} Kg.
                                                                    @else
                                                                    {{$art->stock}}
                                                                    @endif


                                                                    </span></a>
                                                                <span class="product-description">
                                                                    {{$art->vender_al}}
                                                                    </span>
                                                                </div>
                                                            </li>


                                                        @endif



                                                        @endforeach


                                                      </ul>
                                                    </div>
                                                    <!-- /.box-body -->

                                                  </div>

                                            </div>
                                            <!-- ./box-body -->

                                        </div>
                                        <!-- /.box -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>


                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="ventas">
                    <!-- Ventas -->
                    <div class="container-small text-sm">
                        <form id="form1" action="{{ route('venta.store') }}" method="POST" autocomplete="off" class="submit-prevent-form">
                            @csrf
                            <input id="modo" name="modo" type="hidden" value="">
                            <input id="precio_costo_unidad" name="precio_costo_unidad" type="hidden" value="">
                            <input id="precio_costo" name="precio_costo" type="hidden" value="">
                            <input id="tipo_pago" name="tipo_pago" type="hidden" value="">
                        <input id="caja_id" name="caja_id" type="hidden" value="{{$caja->id}}">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="cliente">Cliente</label>
                                        <select name="idcliente" id="idcliente" class="form-control selectpicker"
                                            data-live-search="true">
                                            @foreach ($personas as $persona)
                                                <option value="{{ $persona->id }}">{{ $persona->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="tipo_comprobante">Tipo Comprobante</label>
                                        <select name="tipo_comprobante" class="form-control">
                                            <option value="Orden">Orden</option>
                                            <option value="Factura">Factura</option>
                                            <option value="Ticket">Ticket</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="serie_comprobante">Control Comprobante</label>
                                        <input readonly type="text" name="serie_comprobante" class="form-control"
                                    value="{{ old('serie_comprobante') }} {{ $num_comprobante ?? '' }}" placeholder="Control Comprobante...">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="num_comprobante">Número Comprobante</label>
                                        <input readonly type="text" name="num_comprobante" required class="form-control"
                                            value="{{ old('num_comprobante') }} {{ $serie_comprobante ?? '' }}" placeholder="Número Comprobante...">
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
                                                            <select autofocus name="jidarticulo" id="jidarticulo" class="form-control selectpicker" data-live-search="true">
                                                                <option value="0">Seleccione Articulo</option>
                                                                @foreach ($articulos as $articulo)
                                                                    <option
                                                                        value="{{ $articulo->id }}_{{ $articulo->stock }}_{{ $articulo->precio_costo }}_{{ $articulo->nombre }}_{{ $articulo->porEspecial ?? '' }}_{{ $articulo->isDolar ?? '' }}_{{ $articulo->isPeso ?? '' }}_{{ $articulo->isTransPunto ?? '' }}_{{ $articulo->isMixto ?? '' }}_{{ $articulo->isEfectivo ?? '' }}_{{ $articulo->isKilo ?? '' }}">
                                                                        {{ $articulo->articulo }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                                        <div id="procesarkilos" class="form group">
                                                            <!-- Small modal -->
                                                            <!-- Button trigger modal -->
                                                            <label for="kilos">Cantidad de Kilos</label>
                                                            <button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#exampleModalCenter">
                                                                Peso kilos
                                                            </button>
                                                        </div>
                                                        <div id="cantidadj" class="form group">
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
                                                        <div class="form group hidden">
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
                                                                <input type="hidden" name="tasaDolars" id="tasaDolars"
                                                                value="{{ $tasaDolar->tasa }}">
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
                                                                <input type="hidden" name="tasaPesos" id="tasaPesos"
                                                                value="{{ $tasaPeso->tasa }}">
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
                                                                                type="texto" id="DMontoDolar">
                                                                                <button type="button" id="cargarDolar" class="btn btn-primary btn-xs"> <i class="fa fa-exchange" aria-hidden="true"> </i></button>
                                                                        </td>

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
                                                                                type="texto" id="DMontoPeso">
                                                                                <button type="button" id="cargarPeso" class="btn btn-info btn-xs"> <i class="fa fa-exchange" aria-hidden="true"> </i></button>
                                                                        </td>
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
                                                                                type="texto" id="DMontoBolivar">
                                                                                <button type="button" id="cargarBolivar" class="btn btn-warning btn-xs"> <i class="fa fa-exchange" aria-hidden="true"> </i></button>
                                                                        </td>
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
                                                                                type="texto" id="DMontoPunto">
                                                                                <button type="button" id="cargarPunto" class="btn btn-danger btn-xs"> <i class="fa fa-exchange" aria-hidden="true"> </i></button>
                                                                            </td>
                                                                        <td>
                                                                            <input
                                                                            type="text" name="num_Punto" id="num_Punto" placeholder="N° de Punto..."
                                                                            value="">
                                                                            <input name="TasaTike[]" type="texto"
                                                                                class="enteros" id="TasaPunto" readonly value="{{ $tasaTransferenciaPunto->tasa }}">
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
                                                                                class="" type="texto" id="DMontoTrans">
                                                                                <button type="button" id="cargarTrans" class="btn btn-success btn-xs"> <i class="fa fa-exchange" aria-hidden="true"> </i></button>
                                                                            </td>
                                                                        <td>
                                                                            <input
                                                                            type="text" name="num_Trans" id="num_Trans" placeholder="N° de Transferencia..."
                                                                            value="">
                                                                            <input name="TasaTike[]" type="texto" readonly
                                                                                class="enteros" id="TasaTrans" value="{{ $tasaTransferenciaPunto->tasa }}">

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
                                                            <button id="enviar" class="btn btn-primary btn-block submit-prevent-button"
                                                                type="button">Guardar</button>
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
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane" id="tasa">



                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    @include('modal.kilo')


    {{-- {!! Form::close() !!} --}}

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
                        "lengthMenu": 'Mostrar <select >' +
                            '<option value="5">5</option>' +
                            '<option value="10">10</option>' +
                            '<option value="-1">Todos</option>' +
                            '</select> registros',
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "emptyTable": "No hay datos",
                        "zeroRecords": "No hay coincidencias",
                        "infoEmpty": "",
                        "infoFiltered": ""
                    },
                    "iDisplayLength": 5,
                    "order": [
                        [0, "desc"]
                    ],
                });
                $("#buscarTexto").keyup(function() {
                    dataTable.fnFilter(this.value);
                });
            });

        </script>
        <script>
            var cont            = 0;
            var total           = parseFloat(0.00);
            var porEspecial     = null;
            var isDolar         = null;
            var isPeso          = null;
            var isTransPunto    = null;
            var isMixto         = null;
            var isEfectivo      = null;
            var isKilo          = null;
            var stock            = 0;


            // var totalp=parseFloat(0.00);
            // var totaltp=parseFloat(0.00);
            // var totalm=parseFloat(0.00);
            // var totale=parseFloat(0.00);

            var total_d         = parseFloat(0.00);
            var total_p         = parseFloat(0.00);
            var total_tp        = parseFloat(0.00);
            var total_m         = parseFloat(0.00);
            var total_e         = parseFloat(0.00);
            var total_costo     = parseFloat(0.00);

            var precio_costo    = parseFloat(0.00);
            var jporEspecial    = parseFloat(0.00);
            var precio_venta    = parseFloat(0.00);
            var precio_compra   = parseFloat(0.00);

            subtotal    = [];

            subtotalPC  = [];
            subtotald   = [];
            subtotalp   = [];
            subtotaltp  = [];
            subtotalm   = [];
            subtotale   = [];
            subtotalc   = [];

            var tasaD   = parseFloat($("#TasaDolar").val());
            var tasaP   = parseFloat($("#TasaPeso").val());
            var tasaTP  = parseFloat($("#tasaTransPunto").val());
            var tasaM   = parseFloat($("#tasaMixto").val());
            var tasaE   = parseFloat($("#tasaEfectivo").val());

            var vcargar = 0;
            var vcargarp = 0;
            var vcargarb = 0;
            var vcargarpto = 0;
            var vcargart = 0;





            $("#guardar").hide();
            $("#gestionpago").hide();
            $("#jidarticulo").change(showValues);
            $("#jidarticulo").change(por);
            $('#bt_addD').hide();
            $('#bt_addP').hide();
            $('#bt_addTP').hide();
            $('#bt_addM').hide();
            $('#bt_addE').hide();
            $("#procesarkilos").hide();


            $(document).ready(function() {
                $("#enviar").on('click', function() {
                    $("#form1").submit();
                });

                $("#cargarDolar").on('click', function() {
                    if(vcargar == 0){
                        vcargar = 1;
                        vcargarp = 0;
                        vcargarb = 0;
                        vcargarpto = 0;
                        vcargart = 0;
                        $("#DMontoPeso").val('');
                        DMontoPeso();
                        $("#DMontoBolivar").val('');
                        DMontoBolivar();
                        $("#DMontoPunto").val('');
                        DMontoPunto();
                        $("#DMontoTrans").val('');
                        DMontoTrans();
                        let Rd    = document.getElementById('RestaDolar').value;
                        $("#DMontoDolar").val(Rd);
                        DMontoDolar();
                    }else{
                        vcargar = 0;
                        $("#DMontoDolar").val('');
                        DMontoDolar();
                    }
                });

                $("#cargarPeso").on('click', function() {
                    if(vcargarp == 0){
                        vcargarp = 1;
                        vcargar = 0;
                        vcargarb = 0;
                        vcargarpto = 0;
                        vcargart = 0;
                        $("#DMontoPunto").val('');
                        DMontoPunto();
                        $("#DMontoTrans").val('');
                        DMontoTrans();
                        $("#DMontoDolar").val('');
                        DMontoDolar();
                        $("#DMontoBolivar").val('');
                        DMontoBolivar();
                        let Rp    = document.getElementById('RestaPeso').value;
                        $("#DMontoPeso").val(Rp);
                        DMontoPeso();
                    }else{
                        vcargarp = 0;
                        $("#DMontoPeso").val('');
                        DMontoPeso();
                    }
                });

                $("#cargarBolivar").on('click', function() {
                    if(vcargarb == 0){
                        vcargarb = 1;
                        vcargar = 0;
                        vcargarp = 0;
                        vcargarpto = 0;
                        vcargart = 0;
                        $("#DMontoPunto").val('');
                        DMontoPunto();
                        $("#DMontoTrans").val('');
                        DMontoTrans();
                        $("#DMontoPeso").val('');
                        DMontoPeso();
                        $("#DMontoDolar").val('');
                        DMontoDolar();
                        let Rb    = document.getElementById('RestaBolivar').value;
                        $("#DMontoBolivar").val(Rb);
                        DMontoBolivar();
                    }else{
                        vcargarb = 0;
                        $("#DMontoBolivar").val('');
                        DMontoBolivar();
                    }
                });

                $("#cargarPunto").on('click', function() {
                    if(vcargarpto == 0){
                        vcargarpto = 1;
                        vcargar = 0;
                        vcargarp = 0;
                        vcargarb = 0;
                        vcargart = 0;
                        $("#DMontoTrans").val('');
                        DMontoTrans();
                        $("#DMontoBolivar").val('');
                        DMontoBolivar();
                        $("#DMontoPeso").val('');
                        DMontoPeso();
                        $("#DMontoDolar").val('');
                        DMontoDolar();
                        let Rpto    = document.getElementById('RestaPunto').value;
                        $("#DMontoPunto").val(Rpto);
                        DMontoPunto();
                    }else{
                        vcargarpto = 0;
                        $("#DMontoPunto").val('');
                        DMontoPunto();
                    }
                });

                $("#cargarTrans").on('click', function() {
                    if(vcargart == 0){
                        vcargart = 1;
                        vcargar = 0;
                        vcargarp = 0;
                        vcargarb = 0;
                        vcargarpto = 0;
                        $("#DMontoPunto").val('');
                        DMontoPunto();
                        $("#DMontoBolivar").val('');
                        DMontoBolivar();
                        $("#DMontoPeso").val('');
                        DMontoPeso();
                        $("#DMontoDolar").val('');
                        DMontoDolar();
                        let Rt    = document.getElementById('RestaTrans').value;
                        $("#DMontoTrans").val(Rt);
                        DMontoTrans();
                    }else{
                        vcargart = 0;
                        $("#DMontoTrans").val('');
                        DMontoTrans();
                    }
                });



            });

            function numDecimal(valor){
                let result = Number(valor).toFixed(3);

                return result;
            }



            $(document).ready(function() {
                // calculo();

                $("#bt_add").click(function() {
                    add_article();

                });

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
                            regexp = /.[0-9]{9}$/;
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

                function prepara() {
                    $("#DMontoDolar").val('');
                    $("#DMontoPeso").val('');
                    $("#DMontoBolivar").val('');
                    $("#DMontoPunto").val('');
                    $("#DMontoTrans").val('');

                    $("#RestaDolar").val('');
                    $("#RestaPeso").val('');
                    $("#RestaBolivar").val('');
                    $("#RestaPunto").val('');
                    $("#RestaTrans").val('');

                    $("#DolarToDolar").val('');
                    $("#DsubTotal").html('');
                    $("#RestaDolar").val();

                    $("#PesoToDolar").val('');
                    $("#PeSubTotal").html('');
                    $("#RestaPeso").val();

                    $("#BolivarToDolar").val('');
                    $("#BoSubTotal").html('');
                    $("#RestaBolivar").val();

                    $("#PuntoToDolar").val('');
                    $("#PuSubTotal").html('');
                    $("#RestaPunto").val();

                    $("#TransToDolar").val('');
                    $("#TrSubTotal").html('');
                    $("#RestaTrans").val();

                    $("#DMontoDolar").keyup();
                    $("#DMontoPeso").keyup();
                    $("#DMontoBolivar").keyup();
                    $("#DMontoPunto").keyup();
                    $("#DMontoTrans").keyup();
                }

                $("#bt_addD").click(function() {
                    vcargar = 0;
                    vcargarp = 0;
                    vcargarb = 0;
                    vcargarpto = 0;
                    vcargart = 0;
                    $("#gestionPago").html("<h4 class'bold'> Gestion de Pago en Dolar</h4>");
                    $("#PagoTtotal").html(numDecimal(total_d)); //aqui
                    $("#RestaTtotal").html(numDecimal(total_d)); //aqui
                    $("#total_venta").val(numDecimal(total_d));
                    $("#tipo_pago").val('');
                    $("#tipo_pago").val('Dolar');
                    $("#spTotal").html('0.00'); //aqui


                    prepara();


                    $('#trD').show("linear");
                    $('#trP').hide("linear");
                    $('#trTP').hide("linear");
                    $('#trT').hide("linear");
                    $('#trM').hide("linear");
                    $('#trE').hide("linear");

                    verify();
                    resta();
                });

                $("#bt_addP").click(function() {
                    vcargar = 0;
                    vcargarp = 0;
                    vcargarb = 0;
                    vcargarpto = 0;
                    vcargart = 0;
                    $("#gestionPago").html("<h4 class'bold'> Gestion de Pago en Peso</h4>");
                    $("#PagoTtotal").html(numDecimal(total_p)); //aqui
                    $("#RestaTtotal").html(numDecimal(total_p)); //aqui
                    $("#total_venta").val(numDecimal(total_p));
                    $("#tipo_pago").val('');
                    $("#tipo_pago").val('Peso');
                    $("#spTotal").html('0.00'); //aqui

                    $("#DMontoDolar").val('');
                    $("#DMontoPeso").val('');
                    $("#DMontoBolivar").val('');
                    $("#DMontoPunto").val('');
                    $("#DMontoTrans").val('');

                    $("#RestaDolar").val('');
                    $("#RestaPeso").val('');
                    $("#RestaBolivar").val('');
                    $("#RestaPunto").val('');
                    $("#RestaTrans").val('');

                    $("#DolarToDolar").val('');
                    $("#DsubTotal").html('');

                    $("#PesoToDolar").val('');
                    $("#PeSubTotal").html('');
                    $("#RestaPeso").val();

                    $("#BolivarToDolar").val('');
                    $("#BoSubTotal").html('');
                    $("#RestaBolivar").val();

                    $("#PuntoToDolar").val('');
                    $("#PuSubTotal").html('');
                    $("#RestaPunto").val();

                    $("#TransToDolar").val('');
                    $("#TrSubTotal").html('');
                    $("#RestaTrans").val();

                    $("#DMontoDolar").keyup();
                    $("#DMontoPeso").keyup();
                    $("#DMontoBolivar").keyup();
                    $("#DMontoPunto").keyup();
                    $("#DMontoTrans").keyup();

                    $('#trD').hide("linear");
                    $('#trP').show("linear");
                    $('#trTP').hide("linear");
                    $('#trT').hide("linear");
                    $('#trM').hide("linear");
                    $('#trE').hide("linear");

                    verify();
                    resta();
                });

                $("#bt_addTP").click(function() {
                    vcargar = 0;
                    vcargarp = 0;
                    vcargarb = 0;
                    vcargarpto = 0;
                    vcargart = 0;
                    $("#gestionPago").html(
                        "<h4 class'bold'> Gestion de Pago en Punto o Transferencia</h4>");
                    $("#PagoTtotal").html(numDecimal(total_tp)); //aqui
                    $("#RestaTtotal").html(numDecimal(total_tp)); //aqui
                    $("#total_venta").val(numDecimal(total_tp));
                    $("#tipo_pago").val('');
                    $("#tipo_pago").val('Trans/Punto');
                    $("#spTotal").html('0.00'); //aqui

                    $("#DMontoDolar").val('');
                    $("#DMontoPeso").val('');
                    $("#DMontoBolivar").val('');
                    $("#DMontoPunto").val('');
                    $("#DMontoTrans").val('');

                    $("#RestaDolar").val('');
                    $("#RestaPeso").val('');
                    $("#RestaBolivar").val('');
                    $("#RestaPunto").val('');
                    $("#RestaTrans").val('');

                    $("#DolarToDolar").val('');
                    $("#DsubTotal").html('');

                    $("#PesoToDolar").val('');
                    $("#PeSubTotal").html('');
                    $("#RestaPeso").val();

                    $("#BolivarToDolar").val('');
                    $("#BoSubTotal").html('');
                    $("#RestaBolivar").val();

                    $("#PuntoToDolar").val('');
                    $("#PuSubTotal").html('');
                    $("#RestaPunto").val();

                    $("#TransToDolar").val('');
                    $("#TrSubTotal").html('');
                    $("#RestaTrans").val();

                    $("#DMontoDolar").keyup();
                    $("#DMontoPeso").keyup();
                    $("#DMontoBolivar").keyup();
                    $("#DMontoPunto").keyup();
                    $("#DMontoTrans").keyup();


                    $('#trD').hide("linear");
                    $('#trP').hide("linear");
                    $('#trTP').show("linear");
                    $('#trT').show("linear");
                    $('#trM').hide("linear");
                    $('#trE').hide("linear");

                    verify();
                    resta();
                });


                $("#bt_addM").click(function() {
                    vcargar = 0;
                    vcargarp = 0;
                    vcargarb = 0;
                    vcargarpto = 0;
                    vcargart = 0;
                    $("#gestionPago").html("<h4 class'bold'> Gestion de Pago Mixto</h4>");
                    $("#PagoTtotal").html(numDecimal(total_m)); //aqui
                    $("#RestaTtotal").html(numDecimal(total_m)); //aqui
                    $("#total_venta").val(numDecimal(total_m));
                    $("#tipo_pago").val('');
                    $("#tipo_pago").val('Mixto');
                    $("#spTotal").html('0.00'); //aqui

                    $("#DMontoDolar").val('');
                    $("#DMontoPeso").val('');
                    $("#DMontoBolivar").val('');
                    $("#DMontoPunto").val('');
                    $("#DMontoTrans").val('');

                    $("#RestaDolar").val('');
                    $("#RestaPeso").val('');
                    $("#RestaBolivar").val('');
                    $("#RestaPunto").val('');
                    $("#RestaTrans").val('');

                    $("#DolarToDolar").val('');
                    $("#DsubTotal").html('');

                    $("#PesoToDolar").val('');
                    $("#PeSubTotal").html('');
                    $("#RestaPeso").val();

                    $("#BolivarToDolar").val('');
                    $("#BoSubTotal").html('');
                    $("#RestaBolivar").val();

                    $("#PuntoToDolar").val('');
                    $("#PuSubTotal").html('');
                    $("#RestaPunto").val();

                    $("#TransToDolar").val('');
                    $("#TrSubTotal").html('');
                    $("#RestaTrans").val();

                    $("#DMontoDolar").keyup();
                    $("#DMontoPeso").keyup();
                    $("#DMontoBolivar").keyup();
                    $("#DMontoPunto").keyup();
                    $("#DMontoTrans").keyup();

                    $('#trD').show("linear");
                    $('#trP').show("linear");
                    $('#trTP').show("linear");
                    $('#trT').show("linear");
                    $('#trM').show("linear");
                    $('#trE').show("linear");


                    verify();
                    resta();
                });

                $("#bt_addE").click(function() {
                    vcargar = 0;
                    vcargarp = 0;
                    vcargarb = 0;
                    vcargarpto = 0;
                    vcargart = 0;
                    $("#gestionPago").html("<h4 class'bold'> Gestion de Pago en Efectivo</h4>");
                    $("#PagoTtotal").html(numDecimal(total_e)); //aqui
                    $("#RestaTtotal").html(numDecimal(total_e)); //aqui
                    $("#total_venta").val(numDecimal(total_e));
                    $("#tipo_pago").val('');
                    $("#tipo_pago").val('Efectivo');
                    $("#spTotal").html('0.00'); //aqui

                    $("#DMontoDolar").val('');
                    $("#DMontoPeso").val('');
                    $("#DMontoBolivar").val('');
                    $("#DMontoPunto").val('');
                    $("#DMontoTrans").val('');

                    $("#RestaDolar").val('');
                    $("#RestaPeso").val('');
                    $("#RestaBolivar").val('');
                    $("#RestaPunto").val('');
                    $("#RestaTrans").val('');

                    $("#DolarToDolar").val('');
                    $("#DsubTotal").html('');

                    $("#PesoToDolar").val('');
                    $("#PeSubTotal").html('');
                    $("#RestaPeso").val();

                    $("#BolivarToDolar").val('');
                    $("#BoSubTotal").html('');
                    $("#RestaBolivar").val();

                    $("#PuntoToDolar").val('');
                    $("#PuSubTotal").html('');
                    $("#RestaPunto").val();

                    $("#TransToDolar").val('');
                    $("#TrSubTotal").html('');
                    $("#RestaTrans").val();

                    $("#DMontoDolar").keyup();
                    $("#DMontoPeso").keyup();
                    $("#DMontoBolivar").keyup();
                    $("#DMontoPunto").keyup();
                    $("#DMontoTrans").keyup();


                    $('#trD').hide("linear");
                    $('#trP').hide("linear");
                    $('#trTP').hide("linear");
                    $('#trT').hide("linear");
                    $('#trM').hide("linear");
                    $('#trE').show("linear");

                    verify();
                    resta()
                });

                // unionEnteroDecimalaEnteros('125,999');
                // divisorEnteroDecimala('125995');
            });

            function divisorEnteroDecimala(entero)
            {

                // alert("Numero: "+entero);
                entero = entero / 1000;
                entero = entero.toString();
                // alert("listo: "+entero);
                arr = entero.split('.');
                var resEntero = arr[0];
                var resDecimal = arr[1];
                if(resDecimal > 0 ){
                    resDecimal = resDecimal;
                }else{
                    resDecimal = 0;
                }

                var result = [resEntero, resDecimal];
                // alert(result);
                return result;


            }

            function unionEnteroDecimalaEnteros(entero = null,decimal = null){
                var result = 0;
                if ( entero.indexOf(".") > -1 )
                {
                    // alert( "found it ." );
                    entero = parseFloat(entero).toFixed(3);
                    // alert(entero);
                    arr = entero.split('.');
                    var resEntero = arr[0];
                    var resDecimal = arr[1];


                    if (resDecimal.length > 0) {
                        resDecimal = fijaLargoDerecha(resDecimal)
                        resDecimal = parseInt(resDecimal);
                        resEntero = parseInt(resEntero);
                        resEntero = resEntero * 1000;
                        // alert(resEntero);
                        result = resEntero + resDecimal;


                        return result;

                    }
                }else if ( entero.indexOf(",") > -1 )
                {
                    // alert( "found it ," );
                    entero = entero.replace(',','.');
                    entero = parseFloat(entero).toFixed(3);
                    // alert(entero);
                    arr = entero.split('.');
                    var resEntero = arr[0];
                    var resDecimal = arr[1];


                    if (resDecimal.length > 0) {
                        resDecimal = fijaLargoDerecha(resDecimal)
                        resDecimal = parseInt(resDecimal);
                        resEntero = parseInt(resEntero);
                        resEntero = resEntero * 1000;
                        // alert(resEntero);
                        result = resEntero + resDecimal;


                        return result;

                    }
                 }else
                {
                    if (entero > 0 && decimal > 0) {
                        entero = entero * 1000;
                        decimal = fijaLargoDerecha(decimal);

                        entero = parseInt(entero);
                        decimal = parseInt(decimal);

                        // alert(resEntero);
                        result = entero + decimal;
                        // alert('resultado '+result);
                        return result;
                    }else if (entero == '' || entero == null) {
                        decimal = fijaLargoDerecha(decimal);
                        // alert('decimal '+decimal+'sin enteros');
                        return decimal;
                    }else if (decimal == '' || decimal == null) {

                        entero = entero * 1000;
                        // alert('entero '+entero+'sin decimal');
                    return entero;
                    }


                }

            }

            function fijaLargoIzquierda(T) {

                var numero = T;
                var caracteres = 3;
                // T.setAttribute("maxlength", caracteres);

                while(numero.length < caracteres){
                    numero = "0"+numero;
                }
                return numero;
            }

            function fijaLargoDerecha(T) {

                var numero = T;
                var caracteres = 3;
                // T.setAttribute("maxlength", caracteres);

                while(numero.length < caracteres){
                    numero = numero+"0";
                }

                result = parseInt(numero);
                return result;
            }

            function showValues() {
                // alert('show');
                datosArticulo = document.getElementById('jidarticulo').value.split('_');
                // $("#jprecio_venta").val(datosArticulo[2]);
                $("#jprecio_compra").val(datosArticulo[2]);
                $("#jstock").val(datosArticulo[1]);


                stock           = datosArticulo[1];
                porEspecial     = datosArticulo[4];
                isDolar         = datosArticulo[5];
                isPeso          = datosArticulo[6];
                isTransPunto    = datosArticulo[7];
                isMixto         = datosArticulo[8];
                isEfectivo      = datosArticulo[9];
                isKilo          = datosArticulo[10];
                // $("#jmarjen_venta_dolar").val(12);
                // alert(isKilo);

               var exkilo = 0;
               var exgramos = 0;

               var res = divisorEnteroDecimala(stock);

               exkilo = res[0];
               exgramos = res[1];

                $("#exkilo").html(exkilo);
                $("#exgramos").html(fijaLargoDerecha(exgramos));
                $("#stockRealKilos").val(stock);

                $("#restaKilos").val(stock);



            }

            $(document).ready(function() {
                // var kilo = 0;
                // var gramos = 0;
                $("#kilo").keyup(function() {
                    restarKilos();
                });

                $("#gramos").keyup(function() {
                    restarKilos();
                });

                $("#procesaKilo").on('click',function() {
                    // alert('listo');
                    $("#kilo").val('');
                    $("#gramos").val('');
                    $("#ckilo").html('0');
                    $("#cgramos").html('0');
                    $('#exampleModalCenter').modal('toggle');
                    add_article();
                });

                function restarKilos(){
                    $("#restaKilos").val('');

                    $("#cantidadKilos").val('');
                    kilo =   $("#kilo").val();
                    gramos =   $("#gramos").val();
                    resultado = unionEnteroDecimalaEnteros(kilo,gramos);
                    // alert('gramos '+resultado);

                   $("#cantidadKilos").val(resultado);
                   cantidadKilos =  $("#cantidadKilos").val();
                   cantidad        = $("#jcantidad").val(cantidadKilos);

                    showCantidad=divisorEnteroDecimala(cantidadKilos);
                    showEntero = showCantidad[0];
                    showDecimal = showCantidad[1];kilosCompletos

                    cantidadMostrar = showEntero +"."+fijaLargoDerecha(showDecimal)+".Kg";

                    $("#ckilo").html(showEntero);
                    $("#cgramos").html(fijaLargoDerecha(showDecimal));

                   resta1 = stock - cantidadKilos;

                   $("#restaKilos").val(resta1);
                    // alert(cantidadKilos);

                    var res = divisorEnteroDecimala(resta1);

               exkilo = res[0];
               exgramos = res[1];

                $("#exkilo").html(exkilo);
                $("#exgramos").html(fijaLargoDerecha(exgramos));

                    cantidad = $("#jcantidad").val();
                    precio = $("#precio").val();

                    // precio_compra = precio/1000;

                    // alert(precio_compra);


                }



            });

            function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
                try {
                    decimalCount = Math.abs(decimalCount);
                    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                    const negativeSign = amount < 0 ? "-" : "";

                    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                    let j = (i.length > 3) ? i.length % 3 : 0;

                    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g,
                        "$1" +
                        thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
                } catch (e) {
                    console.log(e)
                }
            };
            function numDecimalExp(valor){
            let result = Number((valor)).toFixed(3);
            return result;
            }

            function por() {
                var precio_compra   = parseFloat($("#jprecio_compra").val());
                var porDolar        = parseFloat($("#jmarjen_ganancia_dolar").val());
                var porPeso         = parseFloat($("#jmarjen_ganancia_peso").val());
                var porTP           = parseFloat($("#jmarjen_ganancia_trans_punto").val());
                var porM            = parseFloat($("#jmarjen_ganancia_mixto").val());
                var porE            = parseFloat($("#jmarjen_ganancia_Efectivo").val());


                var tasaD           = parseFloat($("#TasaDolar").val());
                var tasaP           = parseFloat($("#TasaPeso").val());
                var tasaTP          = parseFloat($("#tasaTransPunto").val());
                var tasaM           = parseFloat($("#tasaMixto").val());
                var tasaE           = parseFloat($("#tasaEfectivo").val());
                // alert(tasaM);
                // alert('estoy en por '+porEspecial);

                if (isKilo) {
                    $('#exampleModalCenter').modal('toggle');
                    // alert('Venta por kilo');
                    $("#cantidadj").hide();
                    $("#cantidadj").addClass('readonly');
                    $("#procesarkilos").show();
                    pre = precio_compra*1000;
                    $("#campoPrecio").html(pre.toFixed(2));
                    $("#precio").val(precio_compra);
                    // precio_compra = precio_compra/1000

// alert('por kilo '+precio_compra);
                    // c]antidad.classList.add('readonly');




                }else{
                    $("#cantidadj").show();
                    $("#procesarkilos").hide();
                }

                if(porEspecial){
                    if (isDolar) {
                        var margenD = precio_compra * porEspecial / 100;
                        $("#porEspecial").val(porEspecial);
                    }else{
                        var margenD = precio_compra * porDolar / 100;
                        // $("#porEspecial").val(porDolar);
                    }
                    if (isPeso) {
                        var margenP = precio_compra * porEspecial / 100;
                        $("#porEspecial").val(porEspecial);
                    }else{
                        var margenP = precio_compra * porPeso / 100;
                        // $("#porEspecial").val(porPeso);
                    }
                    if (isTransPunto) {
                        var margenTP = precio_compra * porEspecial / 100;
                        $("#porEspecial").val(porEspecial);
                    }else{
                        var margenTP = precio_compra * porTP / 100;
                        // $("#porEspecial").val(porTP);
                    }
                    if (isMixto) {
                        var margenM = precio_compra * porEspecial / 100;
                        $("#porEspecial").val(porEspecial);
                    }else{
                        var margenM = precio_compra * porM / 100;
                        // $("#porEspecial").val(porM);
                    }
                    if (isEfectivo) {
                        var margenE = precio_compra * porEspecial / 100;
                        $("#porEspecial").val(porEspecial);
                    }else{
                        var margenE = precio_compra * porE / 100;
                        // $("#porEspecial").val(porE);
                    }
                }else{
                    var margenD     = precio_compra * porDolar / 100;
                    var margenP     = precio_compra * porPeso / 100;
                    var margenTP    = precio_compra * porTP / 100;
                    var margenM     = precio_compra * porM / 100;
                    var margenE     = precio_compra * porE / 100;
                }






                precio_compraD = precio_compra + margenD;
                precio_compraD = precio_compraD;
                $("#jprecio_venta_dolar").val(precio_compraD);
                $("#jprecio_venta_d_dolar").val(precio_compraD);
                $("#jprecio_venta").val(precio_compraD * tasaD);
                $("#vprecio_venta_dolar").html("<h4>$. " + precio_compraD * tasaD + "</h4>");

                precio_compraP = precio_compra + margenP;
                precio_compraP = precio_compraP;
                $("#jprecio_venta_p_dolar").val(precio_compraP);
                $("#jprecio_venta_peso").val(precio_compraP * tasaP);
                $("#vprecio_venta_peso").html("<h4>$. " + formatMoney(precio_compraP * tasaP, 2, ',', '.') + "</h4>");

                precio_compraTP = precio_compra + margenTP;
                precio_compraTP = precio_compraTP;
                $("#jprecio_venta_tp_dolar").val(precio_compraTP);
                $("#jprecio_venta_trans_punto").val(precio_compraTP * tasaTP);
                $("#vprecio_venta_trans_punto").html("<h4>Bs. " + formatMoney(precio_compraTP * tasaTP, 2, ',', '.') +
                    "</h4>");

                precio_compraM = precio_compra + margenM;
                precio_compraM = precio_compraM;
                $("#jprecio_venta_m_dolar").val(precio_compraM);
                $("#jprecio_venta_mixto").val(precio_compraM * tasaM);
                $("#vprecio_venta_mixto").html("<h4>Bs. " + formatMoney(precio_compraM * tasaM, 2, ',', '.') + "</h4>");

                precio_compraE = precio_compra + margenE;
                precio_compraE = precio_compraE;
                $("#jprecio_venta_e_dolar").val(precio_compraE);
                $("#jprecio_venta_Efectivo").val(precio_compraE * tasaE);
                $("#vprecio_venta_Efectivo").html("<h4>Bs. " + formatMoney(precio_compraE * tasaE, 2, ',', '.') + "</h4>");

                precio_costoc = precio_compra;
                precio_costoc = precio_costoc;
                $("#precio_costo").val(formatMoney(precio_costoc, 9, '.', ','));


            }

            $("#jidarticulo").on("change", function () {
                document.getElementById("jcantidad").focus();
                // $("#jidarticulo").val('0');
                // document.getElementById('jidarticulo').val('0');

            });

            focusMethod = function getFocus() {
                document.getElementById("jidarticulo").focus();
                $("#jidarticulo").val('default');
                $("#jidarticulo").selectpicker("refresh");
            }

            function add_article() {
                datosArticulo = document.getElementById('jidarticulo').value.split('_');


                idarticulo = datosArticulo[0];
                articulo = datosArticulo[3];



                // if(porEspecial){
                //     alert('Si tiene precio especial '+porEspecial);
                // }else{
                //     alert('No tiene precio especial '+porEspecial);
                // }

                // alert(articulo);
                cantidad        = $("#jcantidad").val();
                descuento       = $("#jdescuento").val();
                precio_compra   = $("#jprecio_compra").val();
                precio_venta    = $("#jprecio_venta").val();

                jporEspecial    = porEspecial;

                // alert('por especial'+jporEspecial);

                precio_venta_d  = $("#jprecio_venta_d_dolar").val();
                precio_venta_p  = $("#jprecio_venta_p_dolar").val();
                precio_venta_tp = $("#jprecio_venta_tp_dolar").val();
                precio_venta_m  = $("#jprecio_venta_m_dolar").val();
                precio_venta_e  = $("#jprecio_venta_e_dolar").val();
                precio_venta_c  = $("#precio_costo").val();



                $("#cantidadj").show();
                $("#procesarkilos").hide();



                stock = $("#jstock").val();

                if (idarticulo != "" && cantidad != "" && cantidad > 0 && precio_venta != "") {
                    var stock = parseInt(stock)
                    var cantidad = parseInt(cantidad)

                    // var tasaD = parseFloat($("#TasaDolar").val());
                    // var tasaP = parseFloat($("#TasaPeso").val());
                    // var tasaTP = parseFloat($("#tasaTransPunto").val());
                    // var tasaM = parseFloat($("#tasaMixto").val());
                    // var tasaE = parseFloat($("#tasaEfectivo").val());

                    // var descuento=parseFloat(0.00);

                    if (stock >= cantidad) {
                        subtotal[cont]      = (cantidad * precio_venta - descuento);
                        subtotalPC[cont]    = (cantidad * precio_venta_c);
                        subtotald[cont]     = (cantidad * precio_venta_d - descuento);
                        subtotalp[cont]     = (cantidad * precio_venta_p - descuento);
                        subtotaltp[cont]    = (cantidad * precio_venta_tp - descuento);
                        subtotalm[cont]     = (cantidad * precio_venta_m - descuento);
                        subtotale[cont]     = (cantidad * precio_venta_e);
                        subtotalc[cont]     = (cantidad * precio_venta_c);

                        // subtotal[cont]      = numDecimal(subtotal[cont]);
                        // subtotalPC[cont]    = numDecimal(subtotalPC[cont]);
                        // subtotald[cont]     = numDecimal(subtotald[cont]);
                        // subtotalp[cont]     = numDecimal(subtotalp[cont]);
                        // subtotaltp[cont]    = numDecimal(subtotaltp[cont]);
                        // subtotalm[cont]     = numDecimal(subtotalm[cont]);
                        // subtotale[cont]     = numDecimal(subtotale[cont]);
                        // subtotalc[cont]     = numDecimal(subtotalc[cont]);


                        total = total + subtotal[cont];

                        precio_costo = precio_costo + subtotalc[cont];

                        // $("#precio_costo_unidad").val(subtotalc[cont]);
                        $("#precio_costo").val(precio_costo);

                        // totalp=total+subtotalp[cont];
                        // totaltp=total+subtotaltp[cont];
                        // totalm=total+subtotalm[cont];
                        // totale=total+subtotale[cont];
                        total_costo = total_costo + subtotalPC[cont];
                        total_d     = total_d + subtotald[cont];
                        total_p     = total_p + subtotalp[cont];
                        total_tp    = total_tp + subtotaltp[cont];
                        total_m     = total_m + subtotalm[cont];
                        total_e     = total_e + subtotale[cont];

                        // verPreciod      = numDecimal(total_d) * tasaD;
                        // verPreciop      = numDecimal(total_p) * tasaP;
                        // verPreciotp     = numDecimal(total_tp) * tasaTP;
                        // verPreciom      = numDecimal(total_m) * tasaM;
                        // verPrecioe      = numDecimal(total_e) * tasaE;

                        verPreciod      = $("#jprecio_venta_dolar").val();
                        verPreciop      = $("#jprecio_venta_peso").val();
                        verPreciotp     = $("#jprecio_venta_trans_punto").val();
                        verPreciom      = $("#jprecio_venta_mixto").val();
                        verPrecioe      = $("#jprecio_venta_Efectivo").val();

                        // alert('nada');
                        if (descuento == "") {
                            descuento = 0;
                        }

                        if (isKilo) {
                            cantidadVer = cantidadMostrar;
                        } else {
                            cantidadVer  = cantidad;
                        }
                        // $("#total_venta").val(total.toFixed(2));
                        $("#precio_costo").val(numDecimal(total_costo));
                        $("#total_ventad").val(numDecimal(total_d));
                        $("#total_ventap").val(numDecimal(total_p));
                        $("#total_ventatp").val(numDecimal(total_tp));
                        $("#total_ventam").val(numDecimal(total_m));
                        $("#total_ventae").val(numDecimal(total_e));

                        var fila = '<tr class="selected" id="fila' + cont +
                            '"><td><button type="button" class="btn btn-warning btn-xs" onclick="eliminar(' + cont +
                            ');">X</button></td><td><input type="hidden" name="idarticulo[]" value="' + idarticulo + '">' +
                            articulo + '</td><td><input type="hidden" name="cantidad[]" value="' + cantidad + '">' + cantidadVer
                             +
                            '</td><td class="success"><input type="hidden" name="precio_venta[]" value="' + precio_venta +
                            '">' + verPreciod + '</td><td class="success">' + numDecimal(subtotal[cont]) +
                            '</td><td class="warning"><input type="hidden" name="precio_venta_p[]" value="' +
                            dividir(multiplicar(precio_venta_p)) +
                            '">' + formatMoney(verPreciop, 2, ',', '.') + '</td><td class="warning">' + formatMoney(

                                    numDecimal(subtotalp[cont]) * tasaP, 2, ',', '.') +
                            '</td><td  class="success"><input type="hidden" name="precio_venta_tp[]" value="' +
                                dividir(multiplicar(precio_venta_tp)) + '">' + formatMoney(verPreciotp, 2, ',', '.') + '</td><td class="success">' +
                            formatMoney(numDecimal(subtotaltp[cont]) * tasaTP, 2, ',', '.') +
                            '</td><td class="warning"><input type="hidden" name="precio_venta_m[]" value="' +
                                dividir(multiplicar(precio_venta_m)) +
                            '">' + formatMoney(verPreciom, 2, ',', '.') + '</td><td class="warning">' + formatMoney(
                                numDecimal(subtotalm[cont]) * tasaM, 2, ',', '.') +
                            '</td><td class="success"><input name="precio_costo_unidad[]" type="hidden" value="'+dividir(multiplicar(precio_venta_c))+'"><input type="hidden" name="precio_venta_e[]" value="' +
                                dividir(multiplicar(precio_venta_e)) +
                            '">' + formatMoney(verPrecioe, 2, ',', '.') + '</td><td class="success">' + formatMoney(
                                numDecimal(subtotale[cont]) * tasaE, 2, ',', '.') + '</td><td><input type="hidden" name="descuento[]" value="' +
                            parseFloat(descuento) + '">' + parseFloat(descuento) + '<input type="hidden" name="porEspecial[]" value="'+jporEspecial+'"></td></tr>';
                        cont++



                        clear();
                        // $("#total").html("<h4>$. " + total.toFixed(2) + "</h4>");

                        $("#totald").html("<h4 class='text-bold text-primary'>$. " + numDecimal(total_d * tasaD)+
                            "</h4>");
                        $("#totalp").html("<h4 class='text-bold text-primary'>$. " + formatMoney(numDecimal(total_p) * tasaP, 2, ',',
                                '.') +
                            "</h4>");
                        $("#totaltp").html("<h4 class='text-bold text-primary'>Bs. " + formatMoney(numDecimal(total_tp) * tasaTP, 2,
                            ',',
                            '.') + "</h4>");
                        $("#totalm").html("<h4 class='text-bold text-primary'>Bs. " + formatMoney(numDecimal(total_m) * tasaM, 2, ',',
                            '.') + "</h4>");
                        $("#totale").html("<h4 class='text-bold text-primary'>Bs. " + formatMoney(numDecimal(total_e) * tasaE, 2, ',',
                            '.') + "</h4>");

                        $("#PagoTtotal").html(numDecimal(total)); //aqui


                        // verify(); deplega el div gestion de pagos
                        mostrarBonotesPago();
                        $("#detalles").append(fila);
                        // alert('resta');
                        $("#DMontoDolar").keyup();
                        $("#DMontoPeso").keyup();
                        $("#DMontoBolivar").keyup();
                        $("#DMontoPunto").keyup();
                        $("#DMontoTrans").keyup();
                        $('#gestionpago').hide("linear");
                    } else {
                        alert('La cantidad a vender supera el stock...!');
                        $("#jcantidad").val('');
                    }

                } else {
                    alert("Error al ingresar el detalle de la venta, revise los datos del articulo");
                }
            };

            function clear() {
                $("#jcantidad").val("");
                $("#jstock").val("");
                $("#jdescuento").val("");
                $("#jprecio_venta").val("");

                $("#jprecio_venta_d_dolar").val("");
                $("#jprecio_venta_p_dolar").val("");
                $("#jprecio_venta_tp_dolar").val("");
                $("#jprecio_venta_m_dolar").val("");
                $("#jprecio_venta_e_dolar").val("");

                $("#jprecio_venta_dolar").val("");
                $("#jprecio_venta_peso").val("");
                $("#jprecio_venta_trans_punto").val("");
                $("#jprecio_venta_mixto").val("");
                $("#jprecio_venta_Efectivo").val("");

                $("#vprecio_venta_dolar").html("<h4>$. 0.00</h4>");
                $("#vprecio_venta_peso").html("<h4>$. 0.00</h4>");
                $("#vprecio_venta_trans_punto").html("<h4>Bs. 0.00</h4>");
                $("#vprecio_venta_mixto").html("<h4>Bs. 0.00</h4>");
                $("#vprecio_venta_Efectivo").html("<h4>Bs. 0.00</h4>");
                focusMethod();
            }

            function verify() {

                if (total > 0) {
                    $('#gestionpago').show("linear");
                } else {
                    $('#gestionpago').hide("linear");
                }
            }

            function mostrarBonotesPago() {
                // alert('Mostrar botones '+total);
                if (total > 0) {
                    $('#bt_addD').show("linear");
                    $('#bt_addP').show("linear");
                    $('#bt_addTP').show("linear");
                    $('#bt_addM').show("linear");
                    $('#bt_addE').show("linear");
                } else {
                    $('#bt_addD').hide("linear");
                    $('#bt_addP').hide("linear");
                    $('#bt_addTP').hide("linear");
                    $('#bt_addM').hide("linear");
                    $('#bt_addE').hide("linear");
                }
            }

            function eliminar(index) {

                // $("#gestionpago").hide("linear");
                total_costo = total_costo - subtotalPC[index];
                total       = total - subtotal[index];
                //  alert('total '+total);
                total_d     = total_d - subtotald[index];
                //  alert('total d '+total_d);
                total_p     = total_p - subtotalp[index];
                // alert('total p '+total_p);
                total_tp    = total_tp - subtotaltp[index];
                // alert('total tp '+total_tp);
                total_m     = total_m - subtotalm[index];
                // alert('total m '+total_m);
                total_e     = total_e -subtotale[index];
                // alert('total e '+total_e);
                //precosto =  $("#precio_costo").val();
                //total_costo = precosto - subtotalc[index];
                // alert(total_costo.toFixed(2));
                //alert(total_costo);
                $("#precio_costo").val(numDecimal(total_costo));

                // formatMoney(total_d*tasaD,2,',','.')

                $("#total").html("$/. " + numDecimal(total));
                $("#PagoTtotal").html(numDecimal(total));
                //$("#precio_costo").html(total.toFixed(2));
                // $("#total_venta").val(total.toFixed(2));
                // ddç


                $("#bt_addP").click();
                $("#bt_addTP").click();
                $("#bt_addM").click();
                $("#bt_addE").click();
                $("#bt_addD").click();


                $("#total_ventad").val(numDecimal(total_d));
                $("#total_ventap").val(numDecimal(total_p));
                $("#total_ventatp").val(numDecimal(total_tp));
                $("#total_ventam").val(numDecimal(total_m));
                $("#total_ventae").val(numDecimal(total_e));

                $("#totald").html("<h4 class='text-bold text-primary'>$. " + numDecimal(total_d *tasaD) + "</h4>");
                $("#totalp").html("<h4 class='text-bold text-primary'>$. " + formatMoney(numDecimal(total_p) * tasaP, 2, ',', '.') + "</h4>");
                $("#totaltp").html("<h4 class='text-bold text-primary'>Bs. " + formatMoney(numDecimal(total_tp) * tasaTP, 2, ',', '.') + "</h4>");
                $("#totalm").html("<h4 class='text-bold text-primary'>Bs. " + formatMoney(numDecimal(total_m) * tasaM, 2, ',', '.') + "</h4>");
                $("#totale").html("<h4 class='text-bold text-primary'>Bs. " + formatMoney(numDecimal(total_e) * tasaE, 2, ',', '.') + "</h4>");

                $("#fila" + index).remove();
                mostrarBonotesPago();
                // verify();
                resta();
                $('#gestionpago').hide("linear");


            };

            function multiplicar(decimal) {
                return decimal*1000;
            }

            function dividir(decimal) {
                return decimal/1000;
            }

            // Gestion de pagos

            /* Restar dos números. */
            function resta() {
                // alert('resta');
                const RestaTotal    = document.getElementById('RestaTtotal');
                const PagoTtotal    = document.getElementById('PagoTtotal');
                const spTotal       = document.getElementById('spTotal');
                const tp            = document.getElementById('tp');
                const r             = document.getElementById('r');
                const tap           = document.getElementById('tap');



                var valor           = PagoTtotal.innerHTML;
                var valor_restar    = spTotal.innerHTML;
                var resta           = numDecimal(valor -valor_restar);

                RestaTotal.innerHTML = numDecimal(resta); //se llena el campo resta



                if (RestaTotal.innerHTML <= 0) {
                    // alert('soy menor');
                    RestaTotal.classList.remove('text-primary');
                    RestaTotal.classList.add('text-danger');
                    r.classList.remove('text-primary');
                    r.classList.add('text-danger');

                    PagoTtotal.classList.add('text-success');
                    tap.classList.add('text-success');

                    $("#tap").html("MONTO COMPLETO...");
                    $("#r").html("VUELTOS...");
                    // verify();
                    $("#guardar").show("linear");;




                }
                if (RestaTotal.innerHTML > 0) {
                    // alert('soy mayor');
                    RestaTotal.classList.remove('text-danger');
                    RestaTotal.classList.add('text-primary');
                    r.classList.remove('text-danger');
                    r.classList.add('text-primary');

                    PagoTtotal.classList.remove('text-success');
                    tap.classList.remove('text-success');

                    $("#r").html("RESTA");
                    $("#tap").html("TOTAL A PAGAR");
                    $("#guardar").hide("linear");
                }



                // document.getElementById('RestaTtotal').addClass('btn btn-primary');
            }
            // color
            $(document).ready(function() {
                $("#mostrar").click(function() {
                    $('.target').show("swing");
                });
                $("#ocultar").click(function() {
                    $('.target').hide("linear");
                });
            });

            /* Sumar dos números. */
            function sumar() {
                var total_suma = 0;
                $(".monto").each(function() {
                    if (isNaN(parseFloat($(this).val()))) {
                        total_suma += 0;
                    } else {
                        total_suma += parseFloat($(this).val());
                    }
                });
                // alert(total_suma);
                document.getElementById('spTotal').innerHTML = numDecimal(total_suma);

            }

            function DMontoDolar(){
                     // alert('clic');
                     Mdolar      = $("#DMontoDolar").val();
                    Tdolar      = $("#TasaDolar").val();
                    Tpeso       = $("#TasaPeso").val();
                    Tbolivar    = $("#TasaBolivar").val();
                    Tpunto      = $("#TasaPunto").val();
                    Ttrans      = $("#TasaTrans").val();

                    DsupTotal = Mdolar * Tdolar;
                    $("#DolarToDolar").val(DsupTotal);
                    $("#DsubTotal").html(DsupTotal);

                    sumar();
                    resta();
                    const Resta     = document.getElementById('RestaTtotal');
                    var valor       = Resta.innerHTML;
                    var RmultD      = valor * Tdolar;
                    $("#RestaDolar").val(RmultD);
                    var RmultP      = valor * Tpeso;
                    $("#RestaPeso").val(RmultP);
                    var RmultB      = valor * Tbolivar;
                    $("#RestaBolivar").val(RmultB);
                    var RmultPu     = valor * Tpunto;
                    $("#RestaPunto").val(RmultPu);
                    var RmultT      = valor * Ttrans;
                    $("#RestaTrans").val(RmultT);
                }

                function DMontoPeso(){
                    Mpeso       = $("#DMontoPeso").val();
                    Tdolar      = $("#TasaDolar").val();
                    Tpeso       = $("#TasaPeso").val();
                    Tbolivar    = $("#TasaBolivar").val();
                    Tpunto      = $("#TasaPunto").val();
                    Ttrans      = $("#TasaTrans").val();

                    PsupTotal = Mpeso / Tpeso;
                    $("#PesoToDolar").val(PsupTotal);
                    $("#PeSubTotal").html(PsupTotal);
                    $("#RestaPeso").val();
                    sumar();
                    resta();
                    const Resta = document.getElementById('RestaTtotal');
                    var valor   = Resta.innerHTML;
                    var RmultD  = valor * Tdolar;
                    $("#RestaDolar").val(RmultD);
                    var RmultP  = valor * Tpeso;
                    $("#RestaPeso").val(RmultP);
                    var RmultB  = valor * Tbolivar;
                    $("#RestaBolivar").val(RmultB);
                    var RmultPu = valor * Tpunto;
                    $("#RestaPunto").val(RmultPu);
                    var RmultT = valor * Ttrans;
                    $("#RestaTrans").val(RmultT);
                }

                function DMontoBolivar(){
                    Mbolivar = $("#DMontoBolivar").val();
                    Tdolar   = $("#TasaDolar").val();
                    Tpeso    = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto   = $("#TasaPunto").val();
                    Ttrans   = $("#TasaTrans").val();

                    peso = $("#RestaPeso").val();
                    // 10767280  alert(Mpeso);
                    BsupTotal = Mbolivar / Tbolivar;
                    $("#BolivarToDolar").val(BsupTotal);
                    $("#BoSubTotal").html(BsupTotal);
                    $("#RestaBolivar").val();
                    sumar();
                    resta();
                    const Resta = document.getElementById('RestaTtotal');
                    var valor = Resta.innerHTML;
                    var RmultD = valor * Tdolar;
                    $("#RestaDolar").val(RmultD);
                    var RmultP = valor * Tpeso;
                    $("#RestaPeso").val(RmultP);
                    var RmultB = valor * Tbolivar;
                    $("#RestaBolivar").val(RmultB);
                    var RmultPu = valor * Tpunto;
                    $("#RestaPunto").val(RmultPu);
                    var RmultT = valor * Ttrans;
                    $("#RestaTrans").val(RmultT);
                }

                function DMontoPunto(){
                    MPunto = $("#DMontoPunto").val();
                    Tdolar = $("#TasaDolar").val();
                    Tpeso = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto = $("#TasaPunto").val();
                    Ttrans = $("#TasaTrans").val();

                    peso = $("#RestaPeso").val();
                    // 10767280  alert(Mpeso);
                    PusupTotal = MPunto / Tpunto;
                    $("#PuntoToDolar").val(PusupTotal);
                    $("#PuSubTotal").html(PusupTotal);
                    $("#RestaPunto").val();
                    sumar();
                    resta();
                    const Resta = document.getElementById('RestaTtotal');
                    var valor = Resta.innerHTML;
                    var RmultD = valor * Tdolar;
                    $("#RestaDolar").val(RmultD);
                    var RmultP = valor * Tpeso;
                    $("#RestaPeso").val(RmultP);
                    var RmultB = valor * Tbolivar;
                    $("#RestaBolivar").val(RmultB);
                    var RmultPu = valor * Tpunto;
                    $("#RestaPunto").val(RmultPu);
                    var RmultT = valor * Ttrans;
                    $("#RestaTrans").val(RmultT);
                }

                function DMontoTrans(){
                    Mtrans = $("#DMontoTrans").val();
                    Tdolar = $("#TasaDolar").val();
                    Tpeso = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto = $("#TasaPunto").val();
                    Ttrans = $("#TasaTrans").val();

                    peso = $("#RestaPeso").val();
                    // 10767280  alert(Mpeso);
                    TsupTotal = Mtrans / Ttrans;
                    $("#TransToDolar").val(TsupTotal);
                    $("#TrSubTotal").html(TsupTotal);
                    $("#RestaTrans").val();
                    sumar();
                    resta();
                    const Resta = document.getElementById('RestaTtotal');
                    var valor = Resta.innerHTML;
                    var RmultD = valor * Tdolar;
                    $("#RestaDolar").val(RmultD);
                    var RmultP = valor * Tpeso;
                    $("#RestaPeso").val(RmultP);
                    var RmultB = valor * Tbolivar;
                    $("#RestaBolivar").val(RmultB);
                    var RmultPu = valor * Tpunto;
                    $("#RestaPunto").val(RmultPu);
                    var RmultT = valor * Ttrans;
                    $("#RestaTrans").val(RmultT);
                }

            $(document).ready(function() {


                $("#DMontoDolar").keyup(function() {
                    DMontoDolar();
                });

                $("#DMontoPeso").keyup(function() {
                    DMontoPeso();
                });

                $("#DMontoBolivar").keyup(function() {
                    DMontoBolivar();
                });

                $("#DMontoPunto").keyup(function() {
                    DMontoPunto();
                });

                $("#DMontoTrans").keyup(function() {
                    DMontoTrans();
                });



            });

        </script>
    @endpush

@endsection
