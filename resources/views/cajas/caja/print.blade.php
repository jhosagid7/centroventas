<body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
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
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <h4><strong>Datos de Caja:</strong></h4>
            <address>
            <strong>Código: </strong> {{ $caja->codigo}}<br>
            <strong>Operador: </strong> {{ $caja->user->name}}<br>
            <strong>Fecha: </strong> {{ $caja->fecha->format('d-m-Y')}}<br>
            <strong>Estado: </strong> {{ $caja->estado}}<br>
            <strong>Ventas Realizadas: </strong> {{ $cajas->SumaTotalCantidadVentas}}<br>
            <strong>Articulos Vendidos: </strong> {{ $cajas->SumaArticulosVendidos}}<br>

            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <h4><strong>Bolsa Ventas:</strong></h4>
            <address>
                <strong>Total Dolar: </strong> {{ $cajas->SumaTotalDolar ?? '0.00' }}<br>
                <strong>Total Peso: </strong> {{ number_format($cajas->SumaTotalPeso,2,'.',',') ?? '0.00' }}<br>
                <strong>Total Punto: </strong> {{ number_format($cajas->SumaTotalPunto,2,'.',',') ?? '0.00' }}<br>
                <strong>Total Transf: </strong> {{ number_format($cajas->SumaTotalTransferencia,2,'.',',') ?? '0.00' }}<br>
                <strong>Total Bolivar: </strong> {{ number_format($cajas->SumaTotalBolivar,2,'.',',') ?? '0.00' }}<br>

            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <h4><strong>Totales:</strong></h4>
            <address>

                <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Precio Costo:</th>
                        <td>${{ $cajas->SumaTotalCostoVentas ?? '0.00' }}</td>
                      </tr>
                      <tr>
                        <th>Utilidad ({{ number_format($cajas->SumaTotalUtilidadVentas / $cajas->SumaTotalVentas,2,',','.') ?? '0.00' }}%)</th>
                        <td>${{ $cajas->SumaTotalUtilidadVentas ?? '0.00' }}</td>
                      </tr>
                      <tr>
                        <th>Total Venta:</th>
                        <td>${{ $cajas->SumaTotalVentas ?? '0.00' }}</td>
                      </tr>

                    </table>
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

                {{-- @include('cajas.caja.caja') --}}
        </div></div></div>
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
                    <th>Tipo Pago</th>
                    <th>Precio Costo</th>
                    <th>% Ganancia</th>
                    <th>Precio Venta</th>
                    <th>Utilidad</th>
                    <th>Estado</th>

                </thead>
                <tbody>
                    @foreach ($cajas->ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->fecha_hora }}</td>
                        <td>{{ $venta->tipo_comprobante . ': ' . $venta->serie_comprobante . '-' . $venta->num_comprobante }}</td>
                        <td>{{ $venta->tipo_pago }}</td>
                        <td>{{ $venta->precio_costo }}</td>
                        <td>{{ $venta->margen_ganancia }}</td>
                        <td>{{ $venta->total_venta }}</td>
                        <td>{{ $venta->ganancia_neta }}</td>
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

        {{-- <div class="row">


          <!-- /.col -->
        </div> --}}
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-xs-12">
            <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
            </button>
            <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
              <i class="fa fa-download"></i> Generate PDF
            </button>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    </body>
