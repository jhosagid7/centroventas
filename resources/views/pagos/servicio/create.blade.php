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

    <div class="row">
        <div class="col-lg-6">
            <h3>Gestionar pago de gastos operativos</h3><a class="btn btn-danger" href="{{ url()->previous() }}">{{__('Regresar')}}</a>
            @include('custom.message')
        </div>
    </div>


<form action="{{route('transferencia.store')}}" method="POST">
    @csrf
    <div class="row margin">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="accion">Seleccione tipo de servicio</label>
                    <select required   class="form-control select2" name="accion" id="accion">
                        <option value=""></option>
                        @foreach ($categorias as $cat)
                        <option value="{{$cat->id}}">{{$cat->nombre}}</option>
                        @endforeach

                    </select>
                    <input id="tipo" name="tipo" type="hidden">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Operador</label>
                <input readonly type="text" name="operador" class="form-control" value="{{old('operador')}}{{ $User ?? '' }}" placeholder="Operador...">
                </div>
            </div>
        </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="origen"></label>
                <select name="origen" id="origen" class="form-control select2"></select>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="origenStock">Tipo de Servicio</label>
                <input type="hidden" id="origenNombre" name="origenNombre" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                <input readonly type="hidden" id="origenStock" name="origenStock" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                <input readonly type="text" id="servicio_selected" name="servicio_selected" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                {{-- <input type="text" id="verStock" name="verStock" class="form-control" value="{{old('origenStock')}}" placeholder="Stock"> --}}
                <input type="hidden" id="origenUnidades" name="origenUnidades" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                <input type="hidden" id="origenVender_al" name="origenVender_al" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                <input type="hidden" id="origenSelecct" name="origenSelecct" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                <input type="hidden" id="origen_id" name="origen_id" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                {{-- <select name="selctOrigen" id="selctOrigen" class="form-control " ></select> --}}
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="verStock">Servicio a pagar</label>
                <input readonly type="text" id="verStock" name="verStock"  class="form-control" value="{{old('origenStock')}}" placeholder="Stock actual">
                <input type="hidden" id="verStock_id" name="verStock_id"  class="form-control" value="{{old('origenStock')}}" placeholder="Stock actual">
            </div>
        </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Nombre/Razon social</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}" placeholder="Nombre/Razon social...">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Cedúla/Rif</label>
                    <input type="text" name="num_documento" id="num_documento" class="form-control" value="{{old('num_documento')}}" placeholder="Cedúla/Rif...">
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Deuda</label>
                    <input type="text" name="total_pago" id="total_pago" class="form-control" value="{{old('nombre')}}" placeholder="Deuda...">
                </div>
            </div>



        </div>



    </div>


    {{-- <input name="total_pago" id="total_pago" type="hidden" value=""> --}}

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
</form>
@include('pagos.servicio.credito')
</div>
<!-- /.box -->

@push('sciptsMain')
<script>
    $(document).ready(function(){
        $("#guardar").hide();
        $("#info").hide();
        $("#bt_add").hide("linear");


        $("#bt_add").click(function(){
            $("#guardar").show("linear");
            $("#info").show("linear");
        });
    });

    $(document).on('change', '#accion', function(event) {
        // aler('si');
            $('#si').val($("#accion option:selected").text());
        });


    $(document).ready(function(){

        $("#origen").change(showValues);
        $("#destino").change(showValuesd);

        $('#destino').on('change', function(){

            $("#guardar").hide();
            $("#info").hide();
            $("#bt_add").hide("linear");
        });

        $('#accion').on('change', function(){
            $('#servicio_selected').val($("#accion option:selected").text());

            $("#bt_add").hide("linear");
            $("#info").hide();
            $("#guardar").hide();
            var accionTipo = $(this).val();
            $("#accionTipo").html(accionTipo); //aqui

            $('#verStock').val('');
            $('#verStockDestino').val('');
            $('#selctOrigen').empty();
            $('#destino').empty();
            $("#bt_add").hide("linear");
            var accion = $(this).val();
            // accion = accion.split(' a ');
            // accion = accion[0];
            $('#origen').empty();
            $('#destino').empty();
            $('#origenNombre').val('');
            $('#origenStock').val('');
            $('#origenUnidades').val('');
            $('#origenVender_al').val('');
            $('#destinoNombre').val('');
            $('#destinoStock').val('');
            $('#destinoUnidades').val('');
            $('#destinoVender_al').val('');
            $('#tipo_id_acre').val(accion);

            $('#tipo').val(accion);
            // alert(accion);
            // var url = 'origen';
            var tipo = accion;
            if ($.trim(accion != '')) {
                $.ajax({
                    type: 'get',
                    url: '{{ url ("servicios") }}',
                    data: "accion=" + accion,
                    success: function (origens) {




                        if (origens.length) {
                            $('#origen').append("<option value='0'>Seleccione Servicio</option>");
                            // alert(origens[0].nombre);
                            for(var i = 0; i < origens.length; i++){
                            $('#origen').append('<option value="'+ origens[i].nombre + '_' + origens[i].id + '">'+ origens[i].nombre +'</option>');
                            }
                        }
                    }
                });

            }
        });



        $('#origen').on('change', function(){
            $("#bt_add").hide("linear");
            $("#info").hide();
            $("#guardar").hide();

            accionProductoOrigen = document.getElementById('origen').value.split('_');
            // alert(accionProductoOrigen[0]);
            var nombreArticuloBuscar = accionProductoOrigen[0];
            // alert(nombreArticuloBuscar);
            $('#accionProductoOrigen').html(accionProductoOrigen[0]);
            $('#stkActOrigen').html(accionProductoOrigen[1]);
            var articulo = $(this).val();
            // alert(articulo);
            var tipo = $('#tipo').val();
            $('#verStock').val('');
            $('#verStockDestino').val('');
            $('#selctOrigen').empty();
            $('#selctDestino').empty();
            $('#destino').empty();
            $('#origenVender_al').val('');
            $('#destinoNombre').val('');
            $('#destinoStock').val('');
            $('#destinoUnidades').val('');
            $('#destinoVender_al').val('');
            $("#bt_add").hide("linear");

            showValues();

            $('#destino').empty();
//             if ($.trim(articulo != '')) {
//                 $.ajax({
//                     type: 'get',
//                     url: '{{ url ("destino") }}',
//                     data: "articulo=" + articulo + "&tipo=" + tipo + "&nombre=" + nombreArticuloBuscar,
//                     success: function (destinos) {
// // console.log(destinos);
//                         $('#destino').empty();
//                         if ($('#origen').val() == '0') {
//                             $('#destino').empty();

//                         } else {

//                             if (destinos.length) {
//                             $('#destino').append("<option value='Selecciones Producto a Cargar'>Selecciones Producto a Cargar</option>");
//                             // alert(origens[0].nombre);
//                             for(var i = 0; i < destinos.length; i++){
//                             $('#destino').append('<option value="'+ destinos[i].nombre +'_'+destinos[i].stock+'_'+destinos[i].unidades+'_'+destinos[i].vender_al+'_'+destinos[i].id+'">'+ destinos[i].nombre +'-'+ destinos[i].codigo +'</option>');
//                             }
//                         }
//                         }

//                     }
//                 });

//             }
        });
    });




//     $(document).on('change', '#origen', function(event) {
//      $('#origenStock').val($("#origen option:selected").text());
// });




    function showValues() {

                datosArticulo = document.getElementById('origen').value.split('_');



                $("#origenNombre").val(datosArticulo[0]);
                // $("#origenStock").val("#origen option:selected");
                $("#origenUnidades").val(datosArticulo[2]);
                $("#origenVender_al").val(datosArticulo[3]);
                $("#origen_id").val(datosArticulo[4]);

                var origenNombre = $("#origenNombre").val();
                var origenStock = $("#origenStock").val();
                var origenUnidades = $("#origenUnidades").val();
                var origenVender_al = $("#origenVender_al").val();

                $("#verStock").val(datosArticulo[0]);
                $("#verStock_id").val(datosArticulo[1]);

               tipoMostrar = $("#tipo").val();
                // alert(origenStock);
                if (tipoMostrar == 'Mayor') {

                    $('#selctOrigen').append("<option value='0'>0</option>");
                    var count = 1;
                        for(var i = 0; i < origenStock; i++){
                            $('#selctOrigen').append('<option value="'+ count +'">'+ count * origenUnidades +'</option>');
                            count++
                        }

                }
            }

            $('#selctOrigen').on('change', function(){

                if ($(this).val() == '0') {
                            $("#bt_add").hide("linear");
                            $("#info").hide();
                            $("#guardar").hide();

                        } else {
                            $("#bt_add").show("linear");
                        }
                var tipos = $("#tipo").val();


                if (tipos == 'Mayor') {
                    var selectO = $(this).val();
                    var stockAct = $("#origenStock").val();
                    var stockActD = $("#destinoStock").val();
                    var uniStock = $("#origenUnidades").val();

                    resultDestino = parseInt(stockActD) + parseInt(selectO * uniStock);
                    result = stockAct - selectO;

                    $("#origenSelecct").val(resultDestino);

                    $("#stkNueOrigen").html(result);
                    $("#verStock").val(result);
                    $("#verStockDestino").val(resultDestino);
                    $("#stkNueDestino").html(resultDestino);

                    console.log(stockActD);
                    console.log(selectO);
                    console.log(uniStock);
                    console.log(resultDestino);
                    console.log(tipos);
                } else {
                    var selectO = $(this).val();
                    var stockAct = $("#origenStock").val();
                    var stockActD = $("#destinoStock").val();
                    var uniStock = $("#origenUnidades").val();
                    var uniDestin = $("#destinoUnidades").val();


                    $("#verStockDestino").val(parseInt(stockActD));

                    resultDestino2 = parseInt(selectO);

                    resulTotal = parseInt(resultDestino2) / parseInt(uniDestin);

                    $("#origenSelecct").val(resulTotal);
                    resulTotal += parseInt(stockActD);

                    result = stockAct - selectO;

                    $("#verStock").val(result);
                    $("#stkNueOrigen").html(result);
                    $("#verStockDestino").val(resulTotal);
                    $("#stkNueDestino").html(resulTotal);

                    console.log(stockActD);
                    console.log(selectO);
                    console.log(uniStock);
                    console.log(resultDestino2);
                    console.log(tipos);
                    console.log(uniDestin);
                }



            });

            function showValuesd() {

                datosArticulo = document.getElementById('destino').value.split('_');

                $('#accionProductoDestino').html(datosArticulo[0]);
                $('#stkActDestino').html(datosArticulo[1]);

                $("#destinoNombre").val(datosArticulo[0]);
                $("#destinoStock").val(datosArticulo[1]);
                $("#destinoUnidades").val(datosArticulo[2]);
                $("#destinoVender_al").val(datosArticulo[3]);
                $("#destino_id").val(datosArticulo[4]);

                var origenStock = $("#origenStock").val();
                var destinoNombre = $("#destinoNombre").val();
                var destinoStock = $("#destinoStock").val();
                var destinoUnidades = $("#destinoUnidades").val();
                var destinoVender_al = $("#destinoVender_al").val();



                $('#selctOrigen').empty();
                showValues();

                // resltDestino = stockActDestino + (selectO*)

                // $("#verStock").val(resltDestino);

               tipoMostrar = $("#tipo").val();
                // alert(origenStock);
                if (tipoMostrar == 'Detal') {
                    // showValuesd();
                    // destinoUnidades = $("#destinoUnidades").val();
                //     console.log(parseInt(origenStock));
                // console.log(parseInt(destinoUnidades));
                // console.log(parseInt(origenStock / destinoUnidades));

                    $('#selctOrigen').append("<option value='0'>0</option>");
                    var count = 1;
                        for(var i = 0; i < parseInt(origenStock / destinoUnidades); i++){
                            $('#selctOrigen').append('<option value="'+ count*destinoUnidades +'">'+ count +'</option>');
                            count++
                        }

                }


            }

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
    // alert('contado')
    var total = $("#total_pago").val();
    // console.log('total pago: ' + total);
    $("#total_compra").val(numDecimal(total));
    $("#total").html("$. " + numDecimal(total));
    $("#total_sistema_reg_input").val(numDecimal(total));
    $("#total_sistema_reg").html(numDecimal(numDecimal(total)));

    let servicio_selected = $("#servicio_selected").val();
    let verStock = $("#verStock").val();
    let verStock_id = $("#verStock_id").val();
    let nombre = $("#nombre").val();
    let num_documento = $("#num_documento").val();


    $("#nombre_acre").val(nombre);
    $("#documento_acre").val(num_documento);
    $("#tipo_acre").val(servicio_selected);

    $("#servicio_id_acre").val(verStock_id);
    $("#servicio_acre").val(verStock);
    $("#deuda_acre").val(numDecimal(numDecimal(numDecimal(total))));


    // var precio_compra = $("#precio_compra").html();
    // console.log(precio_compra);
    // alert("contado")
    $('#contd').val(1);
    $('#credt').val(0);
    // alert('credito');
    });
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
    });

focusMethod = function getFocus() {
        document.getElementById("jidarticulo").focus();
        $("#jidarticulo").val('default');
        $("#jidarticulo").selectpicker("refresh");
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
            let result = Number(valor).toFixed(3);

            return result;
        }

 /* Restar dos números. */
 function resta() {

            let reg_sistama = $("#total_sistema_reg_input").val();
            let reg_operador = $("#total_operador_reg_input").val();
            let result = reg_operador - reg_sistama;

            $("#total_dif_input").val(numDecimal(result));
            $("#total_dif").html(numDecimal(result));
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
