@extends ('layouts.admin3')
@section('contenido')

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

    <div class="row">
        <div class="col-lg-6">
            <h3>Nuevo Ingreso</h3><a class="btn btn-danger" href="{{ url()->previous() }}">{{__('Regresar')}}</a>
            @include('custom.message')
        </div>
    </div>


<form action="{{route('ingreso.store')}}" method="POST">
    @csrf
    <input id="total_compra" type="hidden" name="total" value="">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
                    @foreach ($personas as $persona)
                <option value="{{$persona->id}}">{{$persona->nombre}}</option>
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
                <input type="text" name="serie_comprobante" class="form-control" value="{{old('serie_comprobante')}}" placeholder="Control Comprobante...">
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="num_comprobante">Número Comprobante</label>
                <input type="text" name="num_comprobante" required class="form-control" value="{{old('num_comprobante')}}" placeholder="Número Comprobante...">
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="articulo">Artículo</label>
                            <select name="jidarticulo" id="jidarticulo" class="form-control selectpicker" data-live-search="true">
                                @foreach ($articulos as $articulo)
                            <option value="{{$articulo->id}}_{{ $articulo->precio_costo }}">{{$articulo->articulo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="jcantidad" id="jcantidad"  class="form-control enteros" placeholder="Cantidad...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form group">
                            <label for="precio_compra">Precio Compra</label>
                            <input type="number" name="jprecio_compra" id="jprecio_compra"  class="form-control decimal" placeholder="Precio compra...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form group">
                            <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <table id="detalles" class="table table-striped table-borderd table-condensed table-hover">
                            <thead style="background-color: #A9D0F5">
                                <th>Opciones</th>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Precio Compra</th>
                                <th>Subtotal</th>
                            </thead>
                            <tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><h4 id="total">$. 0.00</h4></th>
                            </tfoot>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            @include('ventas.creditos.credito')
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="guardar">
            <div class="form-group">
                <a href="" data-target="#modal-pago" data-toggle="modal"><button id="contado" class='btn btn-primary'><i class='fa fa-money'> Pagar</i></button></a>
                <button id="credito" class="btn btn-warning" type="submit">Credito</button>

            </div>

        </div>
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

@push('sciptsMain')
<script>

    $(document).ready(function(){
        focusMethod();
        $("#bt_add").click(function(){
            add_article();
        });

        $("#credito").click(function(){
            alert("credito")
            $('#credt').val(1);
            $('#contd').val(0);
            // alert('credito');
        });
        $("#contado").click(function(){
            alert("contado")
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

                function DMontoDolarRep(){

                        MdolarSaldo      = $("#saldo_banco_dolar").val();
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

                        TpuntoToDolarSis = MpuntoSistema / Tpunto;


                        PTsupTotal = Mpunto / Tbolivar;
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
        });
    </script>
@endpush

@endsection
