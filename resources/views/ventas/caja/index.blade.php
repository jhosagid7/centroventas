@extends ('layouts.admin3')
@section('contenido')

    <div class="col-md-12 ">
        <div class="col-2 margin-bottom">

            <a id="abrircaja" href="{{URL::action('CajaController@create')}}"><button class='btn btn-primary'><span class='glyphicon glyphicon-open'></span> Crear caja</button></a></h3>
            <a id="mganancia" href="{{URL::action('TasaController@create')}}"><button class='btn btn-success'><span class='glyphicon glyphicon-usd'></span> Margen de Ganancia</button></a></h3>

            {{-- <a href="#ventas" data-toggle="tab">Ventas</a> --}}
        </div>
        <div class="nav-tabs-custom">
            @include('custom.message')
            <ul class="nav nav-tabs">
                <li id="licaja" class="active"><a href="#caja" data-toggle="tab">Caja</a></li>
                <li id="liventas"><a href="#ventas" data-toggle="tab">Ventas</a></li>
                <li id="liconf"><a href="#conf" data-toggle="tab">Conf Tasa</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="caja">
                    <!-- Post -->

                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="ven"
                                class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Fecha</th>
                                        <th>Hora cierre</th>
                                        <th>Hora inicio</th>
                                        <th>Monto cierre</th>
                                        <th>Monto inicio</th>
                                        <th>Estado</th>
                                        <th>Caja</th>
                                    </tr>
                                </thead>
                                <tbody id="listarcaja">

                                    <tr>
                                        <td>{{$caja->codigo}}</td>

                                    <td>{{$caja->fecha}}</td>

                                    <td>{{$caja->hora_cierre}}</td>

                                    <td>{{$caja->hora}}</td>

                                    <td>{{$caja->monto_cierre}}</td>

                                    <td>{{$caja->monto}}</td>

                                    <td>{{$caja->estado}}</td>

                                    <td>{{$caja->caja}}</td>
                                </tr>



                                </tbody>
                            </table>
                        </div>


                        <!-- /.table-responsive -->
                    </div>
                    <div class="box-body">
                        {{-- cabecera de box --}}
                        <form action="{{ route('caja.update', $caja->id)}}" enctype="multipart/form-data" method="POST" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    @isset($caja)
                                        <input name="estado" type="hidden" value="Apertura">
                                        <input id="session_id" name="session_id" type="hidden" value="{{$caja->id}}">
                                        <input id="caja_id" name="caja_id" type="hidden" value="{{ $id_caja_activa ?? '' }}">
                                        <input id="estatus_caja" name="estatus_caja" type="hidden" value="{{$estatus_caja}}">
                                        <input id="total_dolar" name="total_dolar" type="hidden" value="0">
                                        <input id="total_peso" name="total_peso" type="hidden" value="0">
                                        <input id="total_bolivar" name="total_bolivar" type="hidden" value="0">
                                        <input name="idusuario" type="hidden" value="{{Auth::user()->id}}">
                                        <input name="url" type="hidden" value="{{URL::previous()}}">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group col-md-3">
                                                <h3><button class="btn btn-primary" type="submit"><span class='glyphicon glyphicon-save'></span> Abrir caja</button></h3>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <h3><a class="btn btn-danger" href="{{ url()->previous() }}"><span class='glyphicon glyphicon-step-backward'></span> Regresar</a></h3>
                                            </div>
                                        </div>
                                    @endisset
                                </div>
                                <div class="row">
                                    @isset($caja)


                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="caja">Selecciones caja</label>
                                            <select name="caja" class="form-control">
                                                <option value="Caja 1">Caja 1</option>

                                            </select>
                                        </div>
                                    </div>
                                    @endisset
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Dolar &nbsp;&nbsp;&nbsp;</strong>  <strong class="text-primary" id="totold"> 0.00</strong></h3>

                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table no-margin">
                                                    <thead>
                                                        <tr>
                                                            <th>Denominacion</th>
                                                            <th>Cantidad</th>
                                                            <th>Valor</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            @php
                                                                $i = 0;
                                                            @endphp
                                                            @foreach ($denominacion_dolar as $denod)
                                                                <tr>
                                                                <td>{{ $denod->denominacion }}</td>
                                                                <td><input name="dcantidad[{{$i}}]" id="dcantidad_{{$i}}" type="number" class="form-control enteros" value="">
                                                                    <input name="DsubTotald[{{$i}}]" id="DsubTotald_{{$i}}" type="text" class="form-control"  value="">
                                                                </td>
                                                                <td>{{ $denod->valor }}</td>
                                                                <input name="dvalor[{{$i}}]"  id="dvalor_{{$i}}" type="hidden" class="form-control" value="{{ $denod->valor }}">
                                                                <input name="ddenominacion[{{$i}}]"  id="ddenominacion_{{$i}}" type="hidden" class="form-control" value="{{ $denod->denominacion }}">
                                                                <input name="dtipo[{{$i}}]"  id="dtipo_{{$i}}" type="hidden" class="form-control" value="{{ $denod->tipo }}">
                                                                </tr>
                                                            @php
                                                                $i++;
                                                            @endphp
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer clearfix">
                                            <h3><strong class="text-primary">Totol Dolares</strong> <strong id="dtotal">0.00</strong></h3>
                                        </div>
                                        <!-- /.box-footer -->
                                    </div>
                                    <!-- col-4-->
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Peso &nbsp;&nbsp;&nbsp;</strong>  <strong class="text-primary" id="totolp"> 0.00</strong></h3>


                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table no-margin">
                                                    <thead>
                                                        <tr>
                                                            <th>Denominacion</th>
                                                            <th>Cantidad</th>
                                                            <th>Valor</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $p = 0;
                                                        @endphp
                                                        @foreach ($denominacion_peso as $penod)
                                                        <tr>
                                                            <td>{{ $penod->denominacion }}</td>
                                                        <td><input name="pcantidad[{{$p}}]" id="pcantidad_{{$p}}" type="number" class="form-control enteros" value="">
                                                            <input name="PsubTotald[{{$p}}]" id="PsubTotald_{{$p}}" type="text" class="form-control"  value="">
                                                        </td>
                                                        <td>{{ $penod->valor }}</td>
                                                            <input name="pvalor[{{$p}}]"  id="pvalor_{{$p}}" type="hidden" class="form-control" value="{{ $penod->valor }}">
                                                            <input name="pdenominacion[{{$p}}]"  id="pdenominacion_{{$p}}" type="hidden" class="form-control" value="{{ $penod->denominacion }}">
                                                            <input name="ptipo[{{$p}}]"  id="ptipo_{{$p}}" type="hidden" class="form-control" value="{{ $penod->tipo }}">

                                                        </tr>
                                                        @php
                                                            $p++;
                                                        @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                                <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer clearfix">
                                            <h3><strong class="text-primary">Totol Pesos</strong>  <strong id="ptotal">0.00</strong></h3>
                                        </div>
                                        <!-- /.box-footer -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Bolivares &nbsp;&nbsp;&nbsp;</strong>  <strong class="text-primary" id="totolb"> 0.00</strong></h3>


                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                            <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table no-margin">
                                                    <thead>
                                                        <tr>
                                                            <th>Denominacion</th>
                                                            <th>Cantidad</th>
                                                            <th>Valor</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $b = 0;
                                                        @endphp
                                                        @foreach ($denominacion_bolivar as $benod)
                                                        <tr>
                                                        <td>{{ $benod->denominacion }}</td>
                                                        <td><input name="bcantidad[{{$b}}]" id="bcantidad_{{$b}}" type="number" class="form-control enteros" value="">
                                                            <input name="BsubTotald[{{$b}}]" id="BsubTotald_{{$b}}" type="text" class="form-control"  value="">
                                                        </td>
                                                        <td>{{ $benod->valor }}</td>
                                                        <input name="bvalor[{{$b}}]"  id="bvalor_{{$b}}" type="hidden" class="form-control" value="{{ $benod->valor }}">
                                                        <input name="bdenominacion[{{$b}}]"  id="bdenominacion_{{$b}}" type="hidden" class="form-control" value="{{ $benod->denominacion }}">
                                                        <input name="btipo[{{$b}}]"  id="btipo_{{$b}}" type="hidden" class="form-control" value="{{ $benod->tipo }}">

                                                        </tr>
                                                        @php
                                                            $b++;
                                                        @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                            <!-- /.box-body -->
                                        <div class="box-footer clearfix">
                                            <h3><strong class="text-primary">Totol Bolivares</strong>  <strong id="btotal">0.00</strong></h3>
                                        </div>
                                           <!-- /.box-footer -->
                                    </div>
                                </div>

                                        <button type="submit">cerrar</button>

                        </form>

                        {{-- fin de la cabecera de box --}}
                    </div>
                    <!-- /.box-body -->
                    <!-- /.post -->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="ventas">
                    <!-- Ventas -->



                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane" id="conf">

                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>

  @push('sciptsMain')

  <script>
    var dato = 0;


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Comienso de funciones para multiplicar valor por candiad y crea un subtotal para dolares
    $(document).ready(function() {
      $("#dcantidad_0").change(function() {
          Dcantidad = $("#dcantidad_0").val();
          Dvalor = $("#dvalor_0").val();
          DsubTotald = Dcantidad*Dvalor;
          $("#DsubTotald_0").val(DsubTotald);
          SupTotalToTotal()
      });

      $("#dcantidad_1").change(function() {
          Dcantidad1 = $("#dcantidad_1").val();
          Dvalor1 = $("#dvalor_1").val();
          DsubTotald1 = Dcantidad1*Dvalor1;
          $("#DsubTotald_1").val(DsubTotald1);
          SupTotalToTotal()
      });

      $("#dcantidad_2").change(function() {
          Dcantidad2 = $("#dcantidad_2").val();
          Dvalor2 = $("#dvalor_2").val();
          DsubTotald2 = Dcantidad2*Dvalor2;
          $("#DsubTotald_2").val(DsubTotald2);
          SupTotalToTotal()
      });

      $("#dcantidad_3").change(function() {
          Dcantidad3 = $("#dcantidad_3").val();
          Dvalor3 = $("#dvalor_3").val();
          DsubTotald3 = Dcantidad3*Dvalor3;
          $("#DsubTotald_3").val(DsubTotald3);
          SupTotalToTotal()
      });

      $("#dcantidad_4").change(function() {
          Dcantidad4 = $("#dcantidad_4").val();
          Dvalor4 = $("#dvalor_4").val();
          DsubTotald4 = Dcantidad4*Dvalor4;
          $("#DsubTotald_4").val(DsubTotald4);
          SupTotalToTotal()
      });

      $("#dcantidad_5").change(function() {
          Dcantidad5 = $("#dcantidad_5").val();
          Dvalor5 = $("#dvalor_5").val();
          DsubTotald5 = Dcantidad5*Dvalor5;
          $("#DsubTotald_5").val(DsubTotald5);
          SupTotalToTotal()
      });

      $("#dcantidad_6").change(function() {
          Dcantidad6 = $("#dcantidad_6").val();
          Dvalor6 = $("#dvalor_6").val();
          DsubTotald6 = Dcantidad6*Dvalor6;
          $("#DsubTotald_6").val(DsubTotald6);
          SupTotalToTotal()
      });
    //Fin de funciones para multiplicar valor por candiad y crea un subtotal para dolares
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Comienso de funcion para sumar los subtotales de dolares
      function SupTotalToTotal(){
        DsubTotald = $("#DsubTotald_0").val();
        DsubTotald_1 = $("#DsubTotald_1").val();
        DsubTotald_2 = $("#DsubTotald_2").val();
        DsubTotald_3 = $("#DsubTotald_3").val();
        DsubTotald_4 = $("#DsubTotald_4").val();
        DsubTotald_5 = $("#DsubTotald_5").val();
        DsubTotald_6 = $("#DsubTotald_6").val();

        totalsuma = circumference(DsubTotald)+circumference(DsubTotald_1)+circumference(DsubTotald_2)+circumference(DsubTotald_3)+circumference(DsubTotald_4)+circumference(DsubTotald_5)+circumference(DsubTotald_6);

        $("#total_dolar").val(totalsuma.toFixed(2));
        $("#totold").html(formatMoney(totalsuma, 2, ',', '.'));
        $("#dtotal").html(formatMoney(totalsuma, 2, ',', '.'));

      };
    //Fin de funcion para sumar los subtotales de dolares
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Comienso de funciones para multiplicar valor por candiad y crea un subtotal para pesos
      $("#pcantidad_0").change(function() {
          Pcantidad = $("#pcantidad_0").val();
          Pvalor = $("#pvalor_0").val();
          PsubTotald = Pcantidad*Pvalor;
          $("#PsubTotald_0").val(PsubTotald);
          SupTotalToTotalp()
      });

      $("#pcantidad_1").change(function() {
          Pcantidad1 = $("#pcantidad_1").val();
          Pvalor1 = $("#pvalor_1").val();
          PsubTotald1 = Pcantidad1*Pvalor1;
          $("#PsubTotald_1").val(PsubTotald1);
          SupTotalToTotalp()
      });

      $("#pcantidad_2").change(function() {
          Pcantidad2 = $("#pcantidad_2").val();
          Pvalor2 = $("#pvalor_2").val();
          PsubTotald2 = Pcantidad2*Pvalor2;
          $("#PsubTotald_2").val(PsubTotald2);
          SupTotalToTotalp()
      });

      $("#pcantidad_3").change(function() {
          Pcantidad3 = $("#pcantidad_3").val();
          Pvalor3 = $("#pvalor_3").val();
          PsubTotald3 = Pcantidad3*Pvalor3;
          $("#PsubTotald_3").val(PsubTotald3);
          SupTotalToTotalp()
      });

      $("#pcantidad_4").change(function() {
          Pcantidad4 = $("#pcantidad_4").val();
          Pvalor4 = $("#pvalor_4").val();
          PsubTotald4 = Pcantidad4*Pvalor4;
          $("#PsubTotald_4").val(PsubTotald4);
          SupTotalToTotalp()
      });

      $("#pcantidad_5").change(function() {
          Pcantidad5 = $("#pcantidad_5").val();
          Pvalor5 = $("#pvalor_5").val();
          PsubTotald5 = Pcantidad5*Pvalor5;
          $("#PsubTotald_5").val(PsubTotald5);
          SupTotalToTotalp()
      });

      $("#pcantidad_6").change(function() {
          Pcantidad6 = $("#pcantidad_6").val();
          Pvalor6 = $("#pvalor_6").val();
          PsubTotald6 = Pcantidad6*Pvalor6;
          $("#PsubTotald_6").val(PsubTotald6);
          SupTotalToTotalp()
      });

      $("#pcantidad_7").change(function() {
          Pcantidad7 = $("#pcantidad_7").val();
          Pvalor7 = $("#pvalor_7").val();
          PsubTotald7 = Pcantidad7*Pvalor7;
          $("#PsubTotald_7").val(PsubTotald7);
          SupTotalToTotalp()
      });

      $("#pcantidad_8").change(function() {
          Pcantidad8 = $("#pcantidad_8").val();
          Pvalor8 = $("#pvalor_8").val();
          PsubTotald8 = Pcantidad8*Pvalor8;
          $("#PsubTotald_8").val(PsubTotald8);
          SupTotalToTotalp()
      });

      $("#pcantidad_9").change(function() {
          Pcantidad9 = $("#pcantidad_9").val();
          Pvalor9 = $("#pvalor_9").val();
          PsubTotald9 = Pcantidad9*Pvalor9;
          $("#PsubTotald_9").val(PsubTotald9);
          SupTotalToTotalp()
      });

      $("#pcantidad_10").change(function() {
          Pcantidad10 = $("#pcantidad_10").val();
          Pvalor10 = $("#pvalor_10").val();
          PsubTotald10 = Pcantidad10*Pvalor10;
          $("#PsubTotald_10").val(PsubTotald10);
          SupTotalToTotalp()
      });

      $("#pcantidad_11").change(function() {
          Pcantidad11 = $("#pcantidad_11").val();
          Pvalor11 = $("#pvalor_11").val();
          PsubTotald11 = Pcantidad11*Pvalor11;
          $("#PsubTotald_11").val(PsubTotald11);
          SupTotalToTotalp()
      });

    //Fin de funciones para multiplicar valor por candiad y crea un subtotal para pesos
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Comienso de funcion para sumar los subtotales de pesos
      function SupTotalToTotalp(){
        PsubTotald = $("#PsubTotald_0").val();
        PsubTotald_1 = $("#PsubTotald_1").val();
        PsubTotald_2 = $("#PsubTotald_2").val();
        PsubTotald_3 = $("#PsubTotald_3").val();
        PsubTotald_4 = $("#PsubTotald_4").val();
        PsubTotald_5 = $("#PsubTotald_5").val();
        PsubTotald_6 = $("#PsubTotald_6").val();
        PsubTotald_7 = $("#PsubTotald_7").val();
        PsubTotald_8 = $("#PsubTotald_8").val();
        PsubTotald_9 = $("#PsubTotald_9").val();
        PsubTotald_10 = $("#PsubTotald_10").val();
        PsubTotald_11 = $("#PsubTotald_11").val();

        totalsumap = circumference(PsubTotald)+circumference(PsubTotald_1)+circumference(PsubTotald_2)+circumference(PsubTotald_3)+circumference(PsubTotald_4)+circumference(PsubTotald_5)+circumference(PsubTotald_6)+circumference(PsubTotald_7)+circumference(PsubTotald_8)+circumference(PsubTotald_9)+circumference(PsubTotald_10)+circumference(PsubTotald_11);

        $("#total_peso").val(totalsumap.toFixed(2));
        $("#totolp").html(formatMoney(totalsumap, 2, ',', '.'));
        $("#ptotal").html(formatMoney(totalsumap, 2, ',', '.'));

      };

    //Fin de funcion para sumar los subtotales de pesos
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Comienso de funciones para multiplicar valor por candiad y crea un subtotal para bolivares
      $("#bcantidad_0").change(function() {
          Bcantidad = $("#bcantidad_0").val();
          Bvalor = $("#bvalor_0").val();
          BsubTotald = Bcantidad*Bvalor;
          $("#BsubTotald_0").val(BsubTotald);
          SupTotalToTotalb()
      });

      $("#bcantidad_1").change(function() {
          Bcantidad1 = $("#bcantidad_1").val();
          Bvalor1 = $("#bvalor_1").val();
          BsubTotald1 = Bcantidad1*Bvalor1;
          $("#BsubTotald_1").val(BsubTotald1);
          SupTotalToTotalb()
      });

      $("#bcantidad_2").change(function() {
          Bcantidad2 = $("#bcantidad_2").val();
          Bvalor2 = $("#bvalor_2").val();
          BsubTotald2 = Bcantidad2*Bvalor2;
          $("#BsubTotald_2").val(BsubTotald2);
          SupTotalToTotalb()
      });

      $("#bcantidad_3").change(function() {
          Bcantidad3 = $("#bcantidad_3").val();
          Bvalor3 = $("#bvalor_3").val();
          BsubTotald3 = Bcantidad3*Bvalor3;
          $("#BsubTotald_3").val(BsubTotald3);
          SupTotalToTotalb()
      });

      $("#bcantidad_4").change(function() {
          Bcantidad4 = $("#bcantidad_4").val();
          Bvalor4 = $("#bvalor_4").val();
          BsubTotald4 = Bcantidad4*Bvalor4;
          $("#BsubTotald_4").val(BsubTotald4);
          SupTotalToTotalb()
      });



    //Fin de funciones para multiplicar valor por candiad y crea un subtotal para bolivares
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Comienso de funcion para sumar los subtotales de bollivares
      function SupTotalToTotalb(){
        BsubTotald = $("#BsubTotald_0").val();
        BsubTotald_1 = $("#BsubTotald_1").val();
        BsubTotald_2 = $("#BsubTotald_2").val();
        BsubTotald_3 = $("#BsubTotald_3").val();
        BsubTotald_4 = $("#BsubTotald_4").val();

        totalsumab = circumference(BsubTotald)+circumference(BsubTotald_1)+circumference(BsubTotald_2)+circumference(BsubTotald_3)+circumference(BsubTotald_4);

        $("#total_bolivar").val(totalsumab.toFixed(2));
        $("#totolb").html(formatMoney(totalsumab, 2, ',', '.'));
        $("#btotal").html(formatMoney(totalsumab, 2, ',', '.'));

      };

    //Fin de funcion para sumar los subtotales de bolivares
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Comienso de funcion formatiar o parcear los datos a flotantes (Decimal)
        function circumference(r) {
            if (Number.isNaN(Number.parseFloat(r))) {
            return 0;
            }
            return parseFloat(r);
        }
    //Fin de funcion formatiar o parcear los datos a flotantes (Decimal)
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Comienso de funcion para formatear o parcear los datos a flotantes (Decimal) y formanto numero americano
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
            //formatMoney(precio_compraD * tasaD, 2, ',', '.') o formatMoney(precio_compraD, 2, ',', '.')
    //Fin de funcion para formatear o parcear los datos a flotantes (Decimal) y formanto numero americano
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
                    regexp = /.[0-9]{2}$/;
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

    });


  </script>
        <script>

            // $("#abrircaja").click(function() {
            //     $('#contventas').show();

            //     });

            $(document).ready(function() {
                // $('#contventas').hide();
                // listarcaja();
            });

        // var listarcaja = function(){
        //     $.ajax({
        //         type: 'get',
        //         url: '{{ url ('listarcaja') }}',
        //         success: function (data) {
        //             console.log(data);
        //             $('#listarcaja').empty().html(data);
        //         }
        //     });
        // };


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
                        "emptyTable": "No hay cajas abiertas...!",
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
            var cont = 0;
            var total = parseFloat(0.00);

            // var totalp=parseFloat(0.00);
            // var totaltp=parseFloat(0.00);
            // var totalm=parseFloat(0.00);
            // var totale=parseFloat(0.00);

            var total_d = parseFloat(0.00);
            var total_p = parseFloat(0.00);
            var total_tp = parseFloat(0.00);
            var total_m = parseFloat(0.00);
            var total_e = parseFloat(0.00);

            var precio_venta = parseFloat(0.00);
            var precio_compra = parseFloat(0.00);
            subtotal = [];

            subtotald = [];
            subtotalp = [];
            subtotaltp = [];
            subtotalm = [];
            subtotale = [];

            var tasaD = parseFloat($("#TasaDolar").val());
            var tasaP = parseFloat($("#TasaPeso").val());
            var tasaTP = parseFloat($("#tasaTransPunto").val());
            var tasaM = parseFloat($("#tasaMixto").val());
            var tasaE = parseFloat($("#tasaEfectivo").val());

            $("#guardar").hide();
            $("#gestionpago").hide();
            $("#jidarticulo").change(showValues);
            $("#jidarticulo").change(por);
            $('#bt_addD').hide();
            $('#bt_addP').hide();
            $('#bt_addTP').hide();
            $('#bt_addM').hide();
            $('#bt_addE').hide();


            $(document).ready(function() {
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
                            regexp = /.[0-9]{2}$/;
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
                    $("#gestionPago").html("<h4 class'bold'> Gestion de Pago en Dolar</h4>");
                    $("#PagoTtotal").html(total_d.toFixed(2)); //aqui
                    $("#RestaTtotal").html(total_d.toFixed(2)); //aqui
                    $("#total_venta").val(total_d.toFixed(2));
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
                    $("#gestionPago").html("<h4 class'bold'> Gestion de Pago en Peso</h4>");
                    $("#PagoTtotal").html(total_p.toFixed(2)); //aqui
                    $("#RestaTtotal").html(total_p.toFixed(2)); //aqui
                    $("#total_venta").val(total_p.toFixed(2));

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
                    $("#gestionPago").html(
                        "<h4 class'bold'> Gestion de Pago en Punto o Transferencia</h4>");
                    $("#PagoTtotal").html(total_tp.toFixed(2)); //aqui
                    $("#RestaTtotal").html(total_tp.toFixed(2)); //aqui
                    $("#total_venta").val(total_tp.toFixed(2));
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
                    $("#gestionPago").html("<h4 class'bold'> Gestion de Pago Mixto</h4>");
                    $("#PagoTtotal").html(total_m.toFixed(2)); //aqui
                    $("#RestaTtotal").html(total_m.toFixed(2)); //aqui
                    $("#total_venta").val(total_m.toFixed(2));
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
                    // $('#trE').hide("linear");


                    verify();
                    resta();
                });

                $("#bt_addE").click(function() {
                    $("#gestionPago").html("<h4 class'bold'> Gestion de Pago en Efectivo</h4>");
                    $("#PagoTtotal").html(total_e.toFixed(2)); //aqui
                    $("#RestaTtotal").html(total_e.toFixed(2)); //aqui
                    $("#total_venta").val(total_e.toFixed(2));
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
            });


            function showValues() {
                // alert('show');
                datosArticulo = document.getElementById('jidarticulo').value.split('_');
                // $("#jprecio_venta").val(datosArticulo[2]);
                $("#jprecio_compra").val(datosArticulo[2]);
                $("#jstock").val(datosArticulo[1]);
                // $("#jmarjen_venta_dolar").val(12);


            }

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

            function por() {
                var precio_compra = parseFloat($("#jprecio_compra").val());
                var porDolar = parseFloat($("#jmarjen_ganancia_dolar").val());
                var porPeso = parseFloat($("#jmarjen_ganancia_peso").val());
                var porTP = parseFloat($("#jmarjen_ganancia_trans_punto").val());
                var porM = parseFloat($("#jmarjen_ganancia_mixto").val());
                var porE = parseFloat($("#jmarjen_ganancia_Efectivo").val());


                var tasaD = parseFloat($("#TasaDolar").val());
                var tasaP = parseFloat($("#TasaPeso").val());
                var tasaTP = parseFloat($("#tasaTransPunto").val());
                var tasaM = parseFloat($("#tasaMixto").val());
                var tasaE = parseFloat($("#tasaEfectivo").val());
                // alert(tasaM);
                // alert(tasaE);


                var margenD = precio_compra * porDolar / 100;
                var margenP = precio_compra * porPeso / 100;
                var margenTP = precio_compra * porTP / 100;
                var margenM = precio_compra * porM / 100;
                var margenE = precio_compra * porE / 100;



                precio_compraD = precio_compra + margenD;
                precio_compraD = precio_compraD.toFixed(2);
                $("#jprecio_venta_dolar").val(precio_compraD);
                $("#jprecio_venta_d_dolar").val(precio_compraD);
                $("#jprecio_venta").val(precio_compraD * tasaD);
                $("#vprecio_venta_dolar").html("<h4>$. " + formatMoney(precio_compraD * tasaD, 2, ',', '.') + "</h4>");

                precio_compraP = precio_compra + margenP;
                $("#jprecio_venta_p_dolar").val(precio_compraP);
                precio_compraP = precio_compraP.toFixed(2);
                $("#jprecio_venta_peso").val(precio_compraP * tasaP);
                $("#vprecio_venta_peso").html("<h4>$. " + formatMoney(precio_compraP * tasaP, 2, ',', '.') + "</h4>");

                precio_compraTP = precio_compra + margenTP;
                $("#jprecio_venta_tp_dolar").val(precio_compraTP);
                precio_compraTP = precio_compraTP.toFixed(2);
                $("#jprecio_venta_trans_punto").val(precio_compraTP * tasaTP);
                $("#vprecio_venta_trans_punto").html("<h4>Bs. " + formatMoney(precio_compraTP * tasaTP, 2, ',', '.') +
                    "</h4>");

                precio_compraM = precio_compra + margenM;
                $("#jprecio_venta_m_dolar").val(precio_compraM);
                precio_compraM = precio_compraM.toFixed(2);
                $("#jprecio_venta_mixto").val(precio_compraM * tasaM);
                $("#vprecio_venta_mixto").html("<h4>Bs. " + formatMoney(precio_compraM * tasaM, 2, ',', '.') + "</h4>");

                precio_compraE = precio_compra + margenE;
                $("#jprecio_venta_e_dolar").val(precio_compraE);
                precio_compraE = precio_compraE.toFixed(2);
                $("#jprecio_venta_Efectivo").val(precio_compraE * tasaE);
                $("#vprecio_venta_Efectivo").html("<h4>Bs. " + formatMoney(precio_compraE * tasaE, 2, ',', '.') + "</h4>");



            }

            function add_article() {
                datosArticulo = document.getElementById('jidarticulo').value.split('_');


                idarticulo = datosArticulo[0];
                articulo = datosArticulo[3];

                // alert(articulo);
                cantidad = $("#jcantidad").val();
                descuento = $("#jdescuento").val();
                precio_compra = $("#jprecio_compra").val();
                precio_venta = $("#jprecio_venta").val();

                precio_venta_d = $("#jprecio_venta_d_dolar").val();
                precio_venta_p = $("#jprecio_venta_p_dolar").val();
                precio_venta_tp = $("#jprecio_venta_tp_dolar").val();
                precio_venta_m = $("#jprecio_venta_m_dolar").val();
                precio_venta_e = $("#jprecio_venta_e_dolar").val();

                verPreciod = $("#jprecio_venta_dolar").val();
                verPreciop = $("#jprecio_venta_peso").val();
                verPreciotp = $("#jprecio_venta_trans_punto").val();
                verPreciom = $("#jprecio_venta_mixto").val();
                verPrecioe = $("#jprecio_venta_Efectivo").val();





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
                        subtotal[cont] = (cantidad * precio_venta - descuento);

                        subtotald[cont] = (cantidad * precio_venta_d - descuento);
                        subtotalp[cont] = (cantidad * precio_venta_p - descuento);
                        subtotaltp[cont] = (cantidad * precio_venta_tp - descuento);
                        subtotalm[cont] = (cantidad * precio_venta_m - descuento);
                        subtotale[cont] = (cantidad * precio_venta_e);

                        total = total + subtotal[cont];

                        // totalp=total+subtotalp[cont];
                        // totaltp=total+subtotaltp[cont];
                        // totalm=total+subtotalm[cont];
                        // totale=total+subtotale[cont];

                        total_d = total_d + subtotald[cont];
                        total_p = total_p + subtotalp[cont];
                        total_tp = total_tp + subtotaltp[cont];
                        total_m = total_m + subtotalm[cont];
                        total_e = total_e + subtotale[cont];
                        // alert('nada');
                        if (descuento == "") {
                            descuento = 0;
                        }
                        var fila = '<tr class="selected" id="fila' + cont +
                            '"><td><button type="button" class="btn btn-warning btn-xs" onclick="eliminar(' + cont +
                            ');">X</button></td><td><input type="hidden" name="idarticulo[]" value="' + idarticulo + '">' +
                            articulo + '</td><td><input type="hidden" name="cantidad[]" value="' + cantidad + '">' +
                            cantidad +
                            '</td><td class="success"><input type="hidden" name="precio_venta[]" value="' + precio_venta +
                            '">' + precio_venta + '</td><td class="success">' + formatMoney(parseFloat(subtotal[cont])) +
                            '</td><td class="warning"><input type="hidden" name="precio_venta_p[]" value="' +
                            precio_venta_p +
                            '">' + formatMoney(verPreciop, 2, ',', '.') + '</td><td class="warning">' + formatMoney(
                                parseFloat(
                                    subtotalp[cont] * tasaP), 2, ',', '.') +
                            '</td><td  class="success"><input type="hidden" name="precio_venta_tp[]" value="' +
                            precio_venta_tp + '">' + formatMoney(verPreciotp, 2, ',', '.') + '</td><td class="success">' +
                            formatMoney(parseFloat(subtotaltp[cont] * tasaTP), 2, ',', '.') +
                            '</td><td class="warning"><input type="hidden" name="precio_venta_m[]" value="' +
                            precio_venta_m +
                            '">' + formatMoney(verPreciom, 2, ',', '.') + '</td><td class="warning">' + formatMoney(
                                parseFloat(
                                    subtotalm[cont] * tasaM), 2, ',', '.') +
                            '</td><td class="success"><input type="hidden" name="precio_venta_e[]" value="' +
                            precio_venta_e +
                            '">' + formatMoney(verPrecioe, 2, ',', '.') + '</td><td class="success">' + formatMoney(
                                parseFloat(
                                    subtotale[cont] * tasaE)) + '</td><td><input type="hidden" name="descuento[]" value="' +
                            parseFloat(descuento) + '">' + parseFloat(descuento) + '</td></tr>';
                        cont++

                        clear();
                        // $("#total").html("<h4>$. " + total.toFixed(2) + "</h4>");

                        $("#totald").html("<h4 class='text-bold text-primary'>$. " + formatMoney(total_d * tasaD, 2, ',',
                                '.') +
                            "</h4>");
                        $("#totalp").html("<h4 class='text-bold text-primary'>$. " + formatMoney(total_p * tasaP, 2, ',',
                                '.') +
                            "</h4>");
                        $("#totaltp").html("<h4 class='text-bold text-primary'>Bs. " + formatMoney(total_tp * tasaTP, 2,
                            ',',
                            '.') + "</h4>");
                        $("#totalm").html("<h4 class='text-bold text-primary'>Bs. " + formatMoney(total_m * tasaM, 2, ',',
                            '.') + "</h4>");
                        $("#totale").html("<h4 class='text-bold text-primary'>Bs. " + formatMoney(total_e * tasaE, 2, ',',
                            '.') + "</h4>");

                        $("#PagoTtotal").html(total.toFixed(2)); //aqui

                        // $("#total_venta").val(total.toFixed(2));

                        $("#total_ventad").val(total_d.toFixed(2));
                        $("#total_ventap").val(total_p.toFixed(2));
                        $("#total_ventatp").val(total_tp.toFixed(2));
                        $("#total_ventam").val(total_m.toFixed(2));
                        $("#total_ventae").val(total_e.toFixed(2));
                        // verify(); deplega el div gestion de pagos
                        mostrarBonotesPago();
                        $("#detalles").append(fila);
                        // alert('resta');
                        $("#DMontoDolar").keyup();
                        $("#DMontoPeso").keyup();
                        $("#DMontoBolivar").keyup();
                        $("#DMontoPunto").keyup();
                        $("#DMontoTrans").keyup();
                    } else {
                        alert('La cantidad a vender supera el stock...!');
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
            }

            function verify() {

                if (total > 0) {
                    $('#gestionpago').show("linear");
                } else {
                    $('#gestionpago').hide("linear");
                }
            }

            function mostrarBonotesPago() {
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
                total = total.toFixed(2) - subtotal[index];
                // alert(total);
                total_d = total_d.toFixed(2) - subtotald[index];
                // alert(total_d);
                total_p = total_p.toFixed(2) - subtotalp[index];
                // alert(total_p);
                total_tp = total_tp.toFixed(2) - subtotaltp[index];
                // alert(total_tp);
                total_m = total_m.toFixed(2) - subtotalm[index];
                // alert(total_m);
                total_e = total_e.toFixed(2) - subtotale[index];
                // alert(total_e);

                // formatMoney(total_d*tasaD,2,',','.')

                $("#total").html("$/. " + total.toFixed(2));
                $("#PagoTtotal").html(total.toFixed(2));
                // $("#total_venta").val(total.toFixed(2));
                // ddç


                $("#bt_addP").click();
                $("#bt_addTP").click();
                $("#bt_addM").click();
                $("#bt_addE").click();
                $("#bt_addD").click();


                $("#total_ventad").val(total_d.toFixed(2));
                $("#total_ventap").val(total_p.toFixed(2));
                $("#total_ventatp").val(total_tp.toFixed(2));
                $("#total_ventam").val(total_m.toFixed(2));
                $("#total_ventae").val(total_e.toFixed(2));

                $("#totald").html("<h4>$. " + formatMoney(total_d * tasaD, 2, ',', '.') + "</h4>");
                $("#totalp").html("<h4>$. " + formatMoney(total_p * tasaP, 2, ',', '.') + "</h4>");
                $("#totaltp").html("<h4>Bs. " + formatMoney(total_tp * tasaTP, 2, ',', '.') + "</h4>");
                $("#totalm").html("<h4>Bs. " + formatMoney(total_m * tasaM, 2, ',', '.') + "</h4>");
                $("#totale").html("<h4>Bs. " + formatMoney(total_e * tasaE, 2, ',', '.') + "</h4>");

                $("#fila" + index).remove();
                mostrarBonotesPago();
                // verify();
                resta()

            };

            // Gestion de pagos

            /* Restar dos números. */
            function resta() {
                // alert('resta');
                const RestaTotal = document.getElementById('RestaTtotal');
                const PagoTtotal = document.getElementById('PagoTtotal');
                const spTotal = document.getElementById('spTotal');
                const tp = document.getElementById('tp');
                const r = document.getElementById('r');
                const tap = document.getElementById('tap');



                var valor = PagoTtotal.innerHTML;
                var valor_restar = spTotal.innerHTML;
                var resta = valor - valor_restar;

                RestaTotal.innerHTML = resta.toFixed(2); //se llena el campo resta



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
                // alert(total);
                document.getElementById('spTotal').innerHTML = total_suma.toFixed(2);

            }



            $(document).ready(function() {
                $("#DMontoDolar").keyup(function() {
                    // alert('clic');
                    Mdolar = $("#DMontoDolar").val();
                    Tdolar = $("#TasaDolar").val();
                    Tpeso = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto = $("#TasaPunto").val();
                    Ttrans = $("#TasaTrans").val();

                    DsupTotal = Mdolar * Tdolar;
                    $("#DolarToDolar").val(DsupTotal.toFixed(2));
                    $("#DsubTotal").html(DsupTotal.toFixed(2));

                    sumar();
                    resta();
                    const Resta = document.getElementById('RestaTtotal');
                    var valor = Resta.innerHTML;
                    var RmultD = valor * Tdolar;
                    $("#RestaDolar").val(RmultD.toFixed(2));
                    var RmultP = valor * Tpeso;
                    $("#RestaPeso").val(RmultP.toFixed(2));
                    var RmultB = valor * Tbolivar;
                    $("#RestaBolivar").val(RmultB.toFixed(2));
                    var RmultPu = valor * Tpunto;
                    $("#RestaPunto").val(RmultPu.toFixed(2));
                    var RmultT = valor * Ttrans;
                    $("#RestaTrans").val(RmultT.toFixed(2));


                });

                $("#DMontoPeso").keyup(function() {
                    Mpeso = $("#DMontoPeso").val();
                    Tdolar = $("#TasaDolar").val();
                    Tpeso = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto = $("#TasaPunto").val();
                    Ttrans = $("#TasaTrans").val();

                    PsupTotal = Mpeso / Tpeso;
                    $("#PesoToDolar").val(PsupTotal.toFixed(2));
                    $("#PeSubTotal").html(PsupTotal.toFixed(2));
                    $("#RestaPeso").val();
                    sumar();
                    resta();
                    const Resta = document.getElementById('RestaTtotal');
                    var valor = Resta.innerHTML;
                    var RmultD = valor * Tdolar;
                    $("#RestaDolar").val(RmultD.toFixed(2));
                    var RmultP = valor * Tpeso;
                    $("#RestaPeso").val(RmultP.toFixed(2));
                    var RmultB = valor * Tbolivar;
                    $("#RestaBolivar").val(RmultB.toFixed(2));
                    var RmultPu = valor * Tpunto;
                    $("#RestaPunto").val(RmultPu.toFixed(2));
                    var RmultT = valor * Ttrans;
                    $("#RestaTrans").val(RmultT.toFixed(2));

                });

                $("#DMontoBolivar").keyup(function() {

                    Mbolivar = $("#DMontoBolivar").val();
                    Tdolar = $("#TasaDolar").val();
                    Tpeso = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto = $("#TasaPunto").val();
                    Ttrans = $("#TasaTrans").val();

                    peso = $("#RestaPeso").val();
                    // 10767280  alert(Mpeso);
                    BsupTotal = Mbolivar / Tbolivar;
                    $("#BolivarToDolar").val(BsupTotal.toFixed(2));
                    $("#BoSubTotal").html(BsupTotal.toFixed(2));
                    $("#RestaBolivar").val();
                    sumar();
                    resta();
                    const Resta = document.getElementById('RestaTtotal');
                    var valor = Resta.innerHTML;
                    var RmultD = valor * Tdolar;
                    $("#RestaDolar").val(RmultD.toFixed(2));
                    var RmultP = valor * Tpeso;
                    $("#RestaPeso").val(RmultP.toFixed(2));
                    var RmultB = valor * Tbolivar;
                    $("#RestaBolivar").val(RmultB.toFixed(2));
                    var RmultPu = valor * Tpunto;
                    $("#RestaPunto").val(RmultPu.toFixed(2));
                    var RmultT = valor * Ttrans;
                    $("#RestaTrans").val(RmultT.toFixed(2));

                });

                $("#DMontoPunto").keyup(function() {

                    MPunto = $("#DMontoPunto").val();
                    Tdolar = $("#TasaDolar").val();
                    Tpeso = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto = $("#TasaPunto").val();
                    Ttrans = $("#TasaTrans").val();

                    peso = $("#RestaPeso").val();
                    // 10767280  alert(Mpeso);
                    PusupTotal = MPunto / Tpunto;
                    $("#PuntoToDolar").val(PusupTotal.toFixed(2));
                    $("#PuSubTotal").html(PusupTotal.toFixed(2));
                    $("#RestaPunto").val();
                    sumar();
                    resta();
                    const Resta = document.getElementById('RestaTtotal');
                    var valor = Resta.innerHTML;
                    var RmultD = valor * Tdolar;
                    $("#RestaDolar").val(RmultD.toFixed(2));
                    var RmultP = valor * Tpeso;
                    $("#RestaPeso").val(RmultP.toFixed(2));
                    var RmultB = valor * Tbolivar;
                    $("#RestaBolivar").val(RmultB.toFixed(2));
                    var RmultPu = valor * Tpunto;
                    $("#RestaPunto").val(RmultPu.toFixed(2));
                    var RmultT = valor * Ttrans;
                    $("#RestaTrans").val(RmultT.toFixed(2));

                });

                $("#DMontoTrans").keyup(function() {

                    Mtrans = $("#DMontoTrans").val();
                    Tdolar = $("#TasaDolar").val();
                    Tpeso = $("#TasaPeso").val();
                    Tbolivar = $("#TasaBolivar").val();
                    Tpunto = $("#TasaPunto").val();
                    Ttrans = $("#TasaTrans").val();

                    peso = $("#RestaPeso").val();
                    // 10767280  alert(Mpeso);
                    TsupTotal = Mtrans / Ttrans;
                    $("#TransToDolar").val(TsupTotal.toFixed(2));
                    $("#TrSubTotal").html(TsupTotal.toFixed(2));
                    $("#RestaTrans").val();
                    sumar();
                    resta();
                    const Resta = document.getElementById('RestaTtotal');
                    var valor = Resta.innerHTML;
                    var RmultD = valor * Tdolar;
                    $("#RestaDolar").val(RmultD.toFixed(2));
                    var RmultP = valor * Tpeso;
                    $("#RestaPeso").val(RmultP.toFixed(2));
                    var RmultB = valor * Tbolivar;
                    $("#RestaBolivar").val(RmultB.toFixed(2));
                    var RmultPu = valor * Tpunto;
                    $("#RestaPunto").val(RmultPu.toFixed(2));
                    var RmultT = valor * Ttrans;
                    $("#RestaTrans").val(RmultT.toFixed(2));

                });



            });

        </script>
    @endpush
  @endsection
