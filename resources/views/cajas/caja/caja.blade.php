<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$caja->id ?? '' }}">

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

      {{-- <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div> --}}
      </div>
      <div class="box-body">
    {{-- cabecera de box --}}

<div class="row">
    <div class="col-lg-6">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>


        <form action="{{ route('caja.update', $caja->id ?? '' )}}" enctype="multipart/form-data" method="POST" autocomplete="off">
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
                <input name="idusuario" type="hidden" value="{{Auth::user()->id}}">
                <input name="url" type="hidden" value="{{URL::previous()}}">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group col-md-3">
                        <h3><button class="btn btn-danger" type="submit"><span class='glyphicon glyphicon-save'></span> Cerrar</button></h3>
                    </div>
                    <div class="form-group col-md-3">
                        <h3><a  id="cerrarModal" class="btn btn-success" href="#"><span class='glyphicon glyphicon-step-backward'></span> <span class="button" data-dismiss="modal" aria-label="Close">cancel</span></a></h3>
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
                        <input name="DsubTotald[{{$i}}]" id="DsubTotald_{{$i}}" type="hidden" class="form-control"  value="">
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
                        <input name="PsubTotald[{{$p}}]" id="PsubTotald_{{$p}}" type="hidden" class="form-control"  value="">
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
                                <input name="BsubTotald[{{$b}}]" id="BsubTotald_{{$b}}" type="hidden" class="form-control"  value="">
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



        </form>

{{-- fin de la cabecera de box --}}
</div>
<!-- /.box-body -->
<div class="box-footer">
{{-- Footer --}}
</div>
<!-- /.box-footer-->
</div>
<!-- /.box -->
</div>
@push('sciptsMain')
  <script>

$("#cerrarModal").click(function() {
    $('#caja').modal('hide')
      });
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
@endpush
