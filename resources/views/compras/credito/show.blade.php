@extends ('layouts.admin3')
@section('contenido')
<!-- Default box -->
<!-- Content Header (Page header) -->
    {{-- <section class="content-header">
      <h1>
        <!--Blank page-->
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section> --}}

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

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
        {{-- cabecera de box --}}
        <section id="imprimir" class="invoice">
            <!-- title row -->
            <div class="row">
              <div class="col-xs-12">
                <h2 class="page-header">
                  <i class="fa fa-globe"></i> {{ config('app.name', 'VillaSoft') }}
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
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="operador">Operador</label>
                    <p>{{ $creditos->name ?? ''}}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="proveedor">Proveedor</label>
                    <p>{{ $creditos->nombre ?? ''}}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">N° Factura/ID</label>
                    <p>{{ $creditos->id ?? ''}}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Tipo Pago</label>
                    <p>{{ $creditos->tipo_pago ?? ''}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="tipo_comprobante">Número Comprobante</label>
                    <p>{{ $creditos->num_comprobante ?? ''}}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Control Comprobante</label>
                    <p>{{ $creditos->serie_comprobante ?? ''}}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="proveedor">Fecha</label>
                    <p>{{ $creditos->fecha_hora ?? '' }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="proveedor">Estado Pago</label>
                    <p>{{ $creditos->status ?? '' }}</p>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <table id="detalles" class="table table-striped table-borderd table-condensed table-hover">
                            <thead style="background-color: #A9D0F5">
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Precio Compra</th>
                                <th>Subtotal</th>
                            </thead>
                            <tfoot>
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php $deuda_cliente = "App\DetalleCreditoIngreso"::where('ingreso_id',$creditos->id)->orderBy('created_at', 'desc')->first();
                                // echo $deuda_cliente['resta'];
                                ?>
                                <input name="total_pago" id="total_pago" type="hidden" value="{{ floatval($deuda_cliente['resta']) }}">
                            <th><h4 id="total"><b>$. {{ floatval($deuda_cliente['resta']) }}</b></h4></th></b></h4></th>
                            </tfoot>
                            <tbody>
                                @foreach ($creditos->articulo_ingresos as $Articulo_Ingreso)
                                    <tr>
                                    <td>{{$Articulo_Ingreso->articulo->nombre ?? ''}}</td>
                                    <td>{{$Articulo_Ingreso->cantidad ?? ''}}</td>
                                    <td>{{ floatval($Articulo_Ingreso->precio_costo_unidad) ?? ''}}</td>
                                    <td>{{ floatval($Articulo_Ingreso->cantidad*$Articulo_Ingreso->precio_costo_unidad) ?? '' }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>



        </div>
    </div>

{{-- fin de la cabecera de box --}}
</div>
<!-- /.box-body -->
<div class="box-footer">
    <a class="btn btn-danger no-print" href="{{ url()->previous() }}">{{__('Regresar')}}</a>
    <a onClick="imprimir('imprimir')" target="_blank" class="btn btn-primary  hidden-print">
        <i class="fa fa-print"></i>
        Imprimir
    </a>
    <a href="" data-target="#modal-pago" data-toggle="modal"><button id="contado" class='btn btn-success'><i class='fa fa-money'> <b>Pagar</b> </i></button></a>
</div>
<!-- /.box-footer-->
</div>
<!-- /.box -->
</div>
@include('compras.credito.credito')

</section>
@push('sciptsMain')

<script>

    $(document).ready(function(){

        // focusMethod();
        $("#bt_add").click(function(){
            add_article();
        });

        $("#credito").click(function(){
            // alert("credito")
            $('#credt').val(1);
            $('#contd').val(0);
            // alert('credito');
        });
        $("#contado").click(function(){
            var total = $("#total_pago").val();
            // console.log('total pago: ' + total);
            $("#deuda_real").val(numDecimal(total));
            $("#total_compra").val(numDecimal(total));
            $("#total").html("$. " + numDecimal(total));
            $("#total_sistema_reg_input").val(numDecimal(total));
            $("#total_sistema_reg").html(numDecimal(numDecimal(total)));
            // var precio_compra = $("#precio_compra").html();
            // console.log(precio_compra);
            // alert("contado")
            $('#contd').val(1);
            $('#credt').val(0);
            // alert('credito');
        });
        // $("#pagar").click(function(){
        //     alert("pagar")
        //     let op_registrado = $('#total_operador_reg_input').val();
        //     alert(op_registrado)
        //     alert(numDecimal(total))


        //     if(op_registrado == numDecimal(total)){
        //         alert("sussess:")
        //         event.preventDefault();
        //         $( "#pagar" ).submit();
        //     }else{
        //         alert("ERRER: El pago debe ser exacto. Por favor verifique el monto registrado...¡")
        //         event.preventDefault();
        //     }

        // });
    });

    var cont=0;
    var total=parseFloat(0.00);
    var precio_compra=parseFloat(0.00);
    var precio_venta=parseFloat(0.00);
    subtotal=[];
    $("#guardar").hide();
    $("#jidarticulo").change(showValues);

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

            function showValues() {
                // alert('show');
                datosArticulo = document.getElementById('jidarticulo').value.split('_');
                // $("#jprecio_venta").val(datosArticulo[2]);
                $("#jprecio_compra").val(datosArticulo[1]);
                // $("#jstock").val(datosArticulo[2]);


                // $("#jmarjen_venta_dolar").val(12);


            }


    function add_article(){
        datosArticulo = document.getElementById('jidarticulo').value.split('_');
        idarticulo=datosArticulo[0];
        articulo=$("#jidarticulo option:selected").text();
        cantidad=$("#jcantidad").val();
        precio_compra=$("#jprecio_compra").val();
        precio_venta=$("#jprecio_venta").val();

        if(idarticulo!="" && cantidad!="" && cantidad>0 && precio_compra!="" && precio_venta!=""){
            subtotal[cont]=(cantidad*precio_compra);
            total=total+subtotal[cont];

            var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input readonly type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly type="number" name="precio_compra[]" value="'+precio_compra+'"></td><td>'+parseFloat(subtotal[cont])+'</td></tr>';
            cont++

            clear();
            $("#total_compra").val(numDecimal(total));
            $("#total").html("$. " + numDecimal(total));
            $("#total_sistema_reg_input").val(numDecimal(total));
            $("#total_sistema_reg").html(numDecimal(numDecimal(total)));
            verify();
            $("#detalles").append(fila);
        }else{
            alert("Error al ingresar el producto, revise los datos del articulo");
        }
    };

    function clear(){
        $("#jcantidad").val("");
        $("#jprecio_compra").val("");
        $("#jprecio_venta").val("");
        focusMethod();
    }

    function verify(){
        if(total>0){
            $("#guardar").show();
        }else{
            $("#guardar").hide();
        }
    }
    function eliminar(index){
        total=total-subtotal[index];
        $("#total").html("$/. " + numDecimal(total));
        $("#total_compra").val('');
        $("#fila" + index).remove();
        verify();
    };
</script>
<script>
    $(document).ready(function() {
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
    });

</script>
<script>


    var tsri      = $("#total_sistema_reg_input").val();
    $("#total_sistema_reg").html(numDecimal(tsri));

        /* Sumar dos números. */
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

         /* Restar dos números. */
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

$("#descuento").keyup(function() {
        let descuento = $("#descuento").val();
        let aumento = $("#aumento").val();
        aumento = parseFloat(aumento);
        let total_sistema_reg_input = $("#total_sistema_reg_input").val();
        let total_sistema_reg = $("#total_sistema_reg").html();

        descuento = parseFloat(descuento);
        total_sistema_reg_input = parseFloat(total_sistema_reg_input);
        total_sistema_reg = parseFloat(total_sistema_reg);

        if(descuento > 0) {
            $("#aumento").val('');
            $('#total_aumento_reg').html(numDecimal(0.00));
            $('#total_aumento_reg_input').val(numDecimal(0.00));
            $('#total_descuento_reg').html(numDecimal(descuento));
            $('#total_descuento_reg_input').val(numDecimal(descuento));

            $("#total_sistema_reg_input").val(numDecimal(total_sistema_reg - descuento));
            $("#total_pago_sistema_reg").html(numDecimal(total_sistema_reg - descuento));
        }else{
            $('#total_descuento_reg').html(numDecimal(0.00));
            $('#total_descuento_reg_input').val(numDecimal(0.00));
            $("#total_sistema_reg_input").val(numDecimal(total_sistema_reg));
            $("#total_pago_sistema_reg").html(numDecimal(total_sistema_reg));
        }
        sumar();

            resta();
    });

    $("#aumento").keyup(function() {

        let aumento = $("#aumento").val();
        let total_sistema_reg_input = $("#total_sistema_reg_input").val();
        let total_sistema_reg = $("#total_sistema_reg").html();

        total_sistema_reg = parseFloat(total_sistema_reg);
        aumento = parseFloat(aumento);
        total_sistema_reg_input = parseFloat(total_sistema_reg_input);

        if(aumento > 0) {
            $("#descuento").val('');
            $('#total_descuento_reg').html(numDecimal(0.00));
            $('#total_descuento_reg_input').val(numDecimal(0.00));
            total_descuento_reg_input
            $('#total_aumento_reg').html(numDecimal(aumento));
            $('#total_aumento_reg_input').val(numDecimal(aumento));

            $("#total_sistema_reg_input").val(numDecimal(total_sistema_reg + aumento));
            $("#total_pago_sistema_reg").html(numDecimal(total_sistema_reg + aumento));
        }else{
            $('#total_aumento_reg').html(numDecimal(0.00));
            $('#total_aumento_reg_input').val(numDecimal(0.00));
            $("#total_sistema_reg_input").val(numDecimal(total_sistema_reg));
            $("#total_pago_sistema_reg").html(numDecimal(total_sistema_reg));
        }
        sumar();

            resta();
    });

    function DMontoDolarRep(){

            MdolarSaldo      = $("#saldo_banco_dolar").val();
            Mdolar      = $("#cantidad_dolar_rep").val();
            MdolarSistema       = $("#dolar_sistema").val();


            Tdolar      = $("#TasaDolar").val();

            Tpeso       = $("#TasaPeso").val();
            Tbolivar    = $("#TasaBolivar").val();
            Tpunto      = $("#TasaPunto").val();
            Ttrans      = $("#TasaTrans").val();

            let tasa_dolar_rep = $("#tasa_dolar_rep").val();
            let tasa_peso_rep = $("#tasa_peso_rep").val();
            let tasa_punto_rep = $("#tasa_punto_rep").val();
            let tasa_trans_rep = $("#tasa_trans_rep").val();
            let tasa_efectivo_rep = $("#tasa_efectivo_rep").val();

            if (tasa_dolar_rep > 0){
                Tdolar = tasa_dolar_rep;
            }
            if (tasa_peso_rep > 0){
                Tpeso = tasa_peso_rep;
            }
            if (tasa_punto_rep > 0){
                Tpunto = tasa_punto_rep;
            }
            if (tasa_trans_rep > 0){
                Ttrans = tasa_trans_rep
            }
            if (tasa_efectivo_rep > 0){
                Tbolivar = tasa_efectivo_rep;
            }



            TdolarToDolarSis = MdolarSistema / Tdolar;

            DsupTotal = Mdolar * Tdolar;

            DsupTotalDolar = DsupTotal * Tdolar;
            $("#dif_moneda_dolar_to_tasa_input").val(numDecimal(DsupTotalDolar));
            $("#saldo_banco_dolar_debitado").html(numDecimal(DsupTotalDolar));
            $("#dif_moneda_dolar_to_tasa").html(numDecimal(DsupTotalDolar - MdolarSistema));
            $("#total_dolar_dif").val(numDecimal(DsupTotalDolar - MdolarSistema));
            $("#total_dolar").val(DsupTotalDolar);
            $("#dif_moneda_dolar_to_dolar_input").val(numDecimal(DsupTotal));
            $("#dif_moneda_dolar_to_dolar").html(numDecimal(DsupTotal - TdolarToDolarSis));
            $("#saldo_banco_dolar_resta").html(numDecimal(MdolarSaldo - DsupTotal));

            sumar();

            resta();

        }

        function DMontoPesoRep(){

            MpesoSaldo      = $("#saldo_banco_peso").val();
            Mpeso       = $("#cantidad_peso_rep").val();
            MpesoSistema       = $("#peso_sistema").val();
            Tdolar      = $("#TasaDolar").val();
            Tpeso       = $("#TasaPeso").val();
            Tbolivar    = $("#TasaBolivar").val();
            Tpunto      = $("#TasaPunto").val();
            Ttrans      = $("#TasaTrans").val();

            let tasa_dolar_rep = $("#tasa_dolar_rep").val();
            let tasa_peso_rep = $("#tasa_peso_rep").val();
            let tasa_punto_rep = $("#tasa_punto_rep").val();
            let tasa_trans_rep = $("#tasa_trans_rep").val();
            let tasa_efectivo_rep = $("#tasa_efectivo_rep").val();

            if (tasa_dolar_rep > 0){
                Tdolar = tasa_dolar_rep;
            }
            if (tasa_peso_rep > 0){
                Tpeso = tasa_peso_rep;
            }
            if (tasa_punto_rep > 0){
                Tpunto = tasa_punto_rep;
            }
            if (tasa_trans_rep > 0){
                Ttrans = tasa_trans_rep
            }
            if (tasa_efectivo_rep > 0){
                Tbolivar = tasa_efectivo_rep;
            }

            TpesoToDolarSis = MpesoSistema / Tpeso;

            PsupTotal = Mpeso / Tpeso;
            PsupTotalDolar = PsupTotal * Tpeso;
            $("#dif_moneda_peso_to_tasa_input").val(numDecimal(PsupTotalDolar));
            $("#saldo_banco_peso_debitado").html(numDecimal(PsupTotalDolar));
            $("#dif_moneda_peso_to_tasa").html(numDecimal(PsupTotalDolar - MpesoSistema));
            $("#total_peso_dif").val(numDecimal(PsupTotalDolar - MpesoSistema));
            $("#total_peso").val(numDecimal(PsupTotalDolar));
            $("#dif_moneda_peso_to_dolar_input").val(numDecimal(PsupTotal));
            $("#dif_moneda_peso_to_dolar").html(numDecimal(PsupTotal - TpesoToDolarSis));
            $("#saldo_banco_peso_resta").html(numDecimal(MpesoSaldo - PsupTotalDolar));
            console.log(MpesoSaldo + ' ' + PsupTotal + ' ' + numDecimal(MpesoSaldo - PsupTotalDolar))
            sumar();
            resta();

        }

        function DMontoBolivarRep(){
            MbolivarSaldo      = $("#saldo_banco_bolivar").val();
            Mbolivar = $("#cantidad_efectivo_rep").val();
            MbolivarSistema       = $("#efectivo_sistema").val();
            Tdolar   = $("#TasaDolar").val();
            Tpeso    = $("#TasaPeso").val();
            Tbolivar = $("#TasaBolivar").val();
            Tpunto   = $("#TasaPunto").val();
            Ttrans   = $("#TasaTrans").val();

            let tasa_dolar_rep = $("#tasa_dolar_rep").val();
            let tasa_peso_rep = $("#tasa_peso_rep").val();
            let tasa_punto_rep = $("#tasa_punto_rep").val();
            let tasa_trans_rep = $("#tasa_trans_rep").val();
            let tasa_efectivo_rep = $("#tasa_efectivo_rep").val();

            if (tasa_dolar_rep > 0){
                Tdolar = tasa_dolar_rep;
            }
            if (tasa_peso_rep > 0){
                Tpeso = tasa_peso_rep;
            }
            if (tasa_punto_rep > 0){
                Tpunto = tasa_punto_rep;
            }
            if (tasa_trans_rep > 0){
                Ttrans = tasa_trans_rep
            }
            if (tasa_efectivo_rep > 0){
                Tbolivar = tasa_efectivo_rep;
            }

            TbolivarToDolarSis = MbolivarSistema / Tbolivar;


            BsupTotal = Mbolivar / Tbolivar;
            BsupTotalDolar = BsupTotal * Tbolivar;
            $("#dif_moneda_efectivo_to_tasa_input").val(numDecimal(BsupTotalDolar));
            $("#saldo_banco_bolivar_debitado").html(numDecimal(BsupTotalDolar));
            $("#saldo_banco_bolivar_debitado").val(numDecimal(BsupTotalDolar));
            $("#dif_moneda_efectivo_to_tasa").html(numDecimal(BsupTotalDolar - MbolivarSistema));
            $("#total_bolivar_dif").val(numDecimal(BsupTotalDolar - MbolivarSistema));
            $("#total_bolivar").val(numDecimal(BsupTotalDolar));
            $("#dif_moneda_efectivo_to_dolar_input").val(numDecimal(BsupTotal));
            $("#dif_moneda_efectivo_to_dolar").html(numDecimal(BsupTotal - TbolivarToDolarSis));
            $("#saldo_banco_efectivo_resta").html(numDecimal(MbolivarSaldo - BsupTotalDolar));

            sumar();
            resta();

        }

        function DMontoPuntoRep(){
            MpuntoSaldo      = $("#saldo_banco_punto").val();
            Mpunto = $("#cantidad_punto_rep").val();
            MpuntoSistema       = $("#punto_sistema").val();
            Tdolar   = $("#TasaDolar").val();
            Tpeso    = $("#TasaPeso").val();
            Tbolivar = $("#TasaBolivar").val();
            Tpunto   = $("#TasaPunto").val();
            Ttrans   = $("#TasaTrans").val();

            let tasa_dolar_rep = $("#tasa_dolar_rep").val();
            let tasa_peso_rep = $("#tasa_peso_rep").val();
            let tasa_punto_rep = $("#tasa_punto_rep").val();
            let tasa_trans_rep = $("#tasa_trans_rep").val();
            let tasa_efectivo_rep = $("#tasa_efectivo_rep").val();

            if (tasa_dolar_rep > 0){
                Tdolar = tasa_dolar_rep;
            }
            if (tasa_peso_rep > 0){
                Tpeso = tasa_peso_rep;
            }
            if (tasa_punto_rep > 0){
                Tpunto = tasa_punto_rep;
            }
            if (tasa_trans_rep > 0){
                Ttrans = tasa_trans_rep
            }
            if (tasa_efectivo_rep > 0){
                Tbolivar = tasa_efectivo_rep;
            }

            TpuntoToDolarSis = MpuntoSistema / Tpunto;


            PTsupTotal = Mpunto / Tpunto;
            PTsupTotalDolar = PTsupTotal * Tpunto;
            $("#dif_moneda_punto_to_tasa_input").val(numDecimal(PTsupTotalDolar));
            $("#saldo_banco_punto_debitado").html(numDecimal(PTsupTotalDolar));
            $("#dif_moneda_punto_to_tasa").html(numDecimal(PTsupTotalDolar - MpuntoSistema));
            $("#total_punto_dif").val(numDecimal(PTsupTotalDolar - MpuntoSistema));
            $("#total_punto").val(numDecimal(PTsupTotalDolar));
            $("#dif_moneda_punto_to_dolar_input").val(numDecimal(PTsupTotal));
            $("#dif_moneda_punto_to_dolar").html(numDecimal(PTsupTotal - TpuntoToDolarSis));
            $("#saldo_banco_punto_resta").html(numDecimal(MpuntoSaldo - PTsupTotalDolar));
            sumar();
            resta();

        }

        function DMontoTransRep(){
            MtransSaldo      = $("#saldo_banco_transferencia").val();
            Mtrans = $("#cantidad_trans_rep").val();
            MtransSistema       = $("#trans_sistema").val();
            Tdolar   = $("#TasaDolar").val();
            Tpeso    = $("#TasaPeso").val();
            Tbolivar = $("#TasaBolivar").val();
            Tpunto   = $("#TasaPunto").val();
            Ttrans   = $("#TasaTrans").val();

            let tasa_dolar_rep = $("#tasa_dolar_rep").val();
            let tasa_peso_rep = $("#tasa_peso_rep").val();
            let tasa_punto_rep = $("#tasa_punto_rep").val();
            let tasa_trans_rep = $("#tasa_trans_rep").val();
            let tasa_efectivo_rep = $("#tasa_efectivo_rep").val();

            if (tasa_dolar_rep > 0){
                Tdolar = tasa_dolar_rep;
            }
            if (tasa_peso_rep > 0){
                Tpeso = tasa_peso_rep;
            }
            if (tasa_punto_rep > 0){
                Tpunto = tasa_punto_rep;
            }
            if (tasa_trans_rep > 0){
                Ttrans = tasa_trans_rep
            }
            if (tasa_efectivo_rep > 0){
                Tbolivar = tasa_efectivo_rep;
            }

            TtransToDolarSis = MtransSistema / Ttrans;


            TsupTotal = Mtrans / Ttrans;
            TsupTotalDolar = TsupTotal * Ttrans;
            $("#dif_moneda_trans_to_tasa_input").val(numDecimal(TsupTotalDolar));
            $("#saldo_banco_transferencia_debitado").html(numDecimal(TsupTotalDolar));
            $("#dif_moneda_trans_to_tasa").html(numDecimal(TsupTotalDolar - MtransSistema));
            $("#total_trans_dif").val(numDecimal(TsupTotalDolar - MtransSistema));
            $("#total_trans").val(numDecimal(TsupTotalDolar));
            $("#dif_moneda_trans_to_dolar_input").val(numDecimal(TsupTotal));
            $("#dif_moneda_trans_to_dolar").html(numDecimal(TsupTotal - TtransToDolarSis));
            $("#saldo_banco_trans_resta").html(numDecimal(MtransSaldo - TsupTotalDolar));
            console.log(MtransSaldo + ' ' + TsupTotalDolar + ' ' + numDecimal(MtransSaldo - TsupTotalDolar))
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
    $("#tasa_dolar_rep").keyup(function() {

        DMontoDolarRep();
    });

    $("#tasa_peso_rep").keyup(function() {

        DMontoPesoRep();
    });

    $("#tasa_efectivo_rep").keyup(function() {

        DMontoBolivarRep();
    });

    $("#tasa_punto_rep").keyup(function() {

        DMontoPuntoRep();
    });

    $("#tasa_trans_rep").keyup(function() {

        DMontoTransRep();
    });
});
    </script>
@endpush
@endsection
