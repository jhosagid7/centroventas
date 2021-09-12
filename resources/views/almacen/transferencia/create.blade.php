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
            <h3>Nueva Transferencia</h3><a class="btn btn-danger" href="{{ url()->previous() }}">{{__('Regresar')}}</a>
            @include('custom.message')
        </div>
    </div>


<form action="{{route('transferencia.store')}}" method="POST">
    @csrf
    <div class="row margin">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="accion">Acción a realizar</label>
                    <select required   class="form-control select2" name="accion" id="accion">
                        <option value=""></option>
                        <option value="Detal a Mayor">Pasar Productos de Detal a Mayor</option>
                        <option value="Mayor a Detal">Pasar Productos de Mayor a Detal</option>
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
                <label for="origen">Origen de producto</label>
                <select name="origen" id="origen" class="form-control select2"></select>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="origenStock">Stock actual</label>
                <input type="hidden" id="origenNombre" name="origenNombre" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                <input readonly type="text" id="origenStock" name="origenStock" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
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
                <label for="verStock">Nuevo stock</label>
                <input readonly type="text" id="verStock" name="verStock" class="form-control" value="{{old('origenStock')}}" placeholder="Stock actual">
            </div>
        </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="destino">Destino de producto</label>
                <select name="destino" id="destino" class="form-control select2" ></select>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="destinoStock">Stock actual</label>
                <input type="hidden" id="destinoNombre" name="destinoNombre" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                <input readonly type="text" id="destinoStock" name="destinoStock" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                {{-- <input type="text" id="verStockDestino" name="verStockDestino" class="form-control" value="{{old('origenStock')}}" placeholder="Stock"> --}}
                <input type="hidden" id="destinoUnidades" name="destinoUnidades" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                <input type="hidden" id="destinoVender_al" name="destinoVender_al" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                <input type="hidden" id="destino_id" name="destino_id" class="form-control" value="{{old('origenStock')}}" placeholder="Stock">
                {{-- <select name="selectDestino" id="selectDestino" class="form-control select2" ></select> --}}

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="verStockDestino">Nuevo stock</label>
                <input readonly type="text" id="verStockDestino" name="verStockDestino" class="form-control" value="{{old('origenStock')}}" placeholder="Stock Nuevo">
            </div>
        </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="selctOrigen">Cantidad a descargar</label>
                <select name="selctOrigen" id="selctOrigen" class="form-control " ></select>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 margin">
            <div class="form group">
                <button type="button" id="bt_add" class="btn bg-navy-active color-palette form-control margin">Confirmar cambios</button>
            </div>
        </div>
        </div>

        <div id="info" class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="callout  bg-navy-active color-palette">
                                <h4>Advertiencia!</h4>

                                <p>Usted ha seleccionado Pasar Productos de <b id="accionTipo">Accion</b>. Tomando como Producto de Origen
                                     <b id="accionProductoOrigen">Producto</b>, el cual tiene un Stock Actual de <b id="stkActOrigen">Stock Actual</b>.
                                     Después de esta transacción el valor del Stock quedará en <b id="stkNueOrigen">Stock Nuevo</b>.
                                     Y como Producto de Destino. Usted escogió <b id="accionProductoDestino">Producto</b>, el cual tiene un Stock Actual de <b id="stkActDestino">Stock Actual</b>.
                                     Después de esta transacción el valor del Stock quedará en <b id="stkNueDestino">Stock Nuevo</b>.</p>
                                    <h4>Nota:</h4><p>Entienda que estos cambios no se pueden Revertir. Por eso le recomendamos Revisar toda la operación antes de guardar los cambios. Si considera que está
                                         correcto puede proceder a guardar los cambios. De lo contrario puede realizar las modificaciones pertinentes.
                                    </p>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>




{{-- fin de la cabecera de box --}}
</div>
<!-- /.box-body -->
<div class="box-footer">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="guardar">
        <div class="form-group">

            <button class="btn btn-primary" type="submit">Guardar</button>

        </div>

    </div>
</div>
<!-- /.box-footer-->
</form>
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




    $(document).ready(function(){

        $("#origen").change(showValues);
        $("#destino").change(showValuesd);

        $('#destino').on('change', function(){

            $("#guardar").hide();
            $("#info").hide();
            $("#bt_add").hide("linear");
        });

        $('#accion').on('change', function(){

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
            accion = accion.split(' a ');
            accion = accion[0];
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

            $('#tipo').val(accion);
            // alert(accion);
            // var url = 'origen';
            var tipo = accion[0];
            if ($.trim(accion != '')) {
                $.ajax({
                    type: 'get',
                    url: '{{ url ("origen") }}',
                    data: "accion=" + accion,
                    success: function (origens) {




                        if (origens.length) {
                            $('#origen').append("<option value='0'>Selecciones Producto a Descargar</option>");
                            // alert(origens[0].nombre);
                            for(var i = 0; i < origens.length; i++){
                            $('#origen').append('<option value="'+ origens[i].nombre +'_'+origens[i].stock+'_'+origens[i].unidades+'_'+origens[i].vender_al+'_'+origens[i].id+'">'+ origens[i].nombre +'-'+ origens[i].codigo +'</option>');
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
            if ($.trim(articulo != '')) {
                $.ajax({
                    type: 'get',
                    url: '{{ url ("destino") }}',
                    data: "articulo=" + articulo + "&tipo=" + tipo + "&nombre=" + nombreArticuloBuscar,
                    success: function (destinos) {
// console.log(destinos);
                        $('#destino').empty();
                        if ($('#origen').val() == '0') {
                            $('#destino').empty();

                        } else {

                            if (destinos.length) {
                            $('#destino').append("<option value='Selecciones Producto a Cargar'>Selecciones Producto a Cargar</option>");
                            // alert(origens[0].nombre);
                            for(var i = 0; i < destinos.length; i++){
                            $('#destino').append('<option value="'+ destinos[i].nombre +'_'+destinos[i].stock+'_'+destinos[i].unidades+'_'+destinos[i].vender_al+'_'+destinos[i].id+'">'+ destinos[i].nombre +'-'+ destinos[i].codigo +'</option>');
                            }
                        }
                        }

                    }
                });

            }
        });
    });









    function showValues() {

                datosArticulo = document.getElementById('origen').value.split('_');



                $("#origenNombre").val(datosArticulo[0]);
                $("#origenStock").val(datosArticulo[1]);
                $("#origenUnidades").val(datosArticulo[2]);
                $("#origenVender_al").val(datosArticulo[3]);
                $("#origen_id").val(datosArticulo[4]);

                var origenNombre = $("#origenNombre").val();
                var origenStock = $("#origenStock").val();
                var origenUnidades = $("#origenUnidades").val();
                var origenVender_al = $("#origenVender_al").val();

                $("#verStock").val(origenStock);

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
</script>
@endpush

@endsection
