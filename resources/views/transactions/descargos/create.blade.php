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
            <h3>Nuevo Descargo</h3><a class="btn btn-danger" href="{{ url()->previous() }}">{{__('Regresar')}}</a>
            @include('custom.message')
        </div>
    </div>


<form action="{{route('descargo.store')}}" method="POST">
    @csrf
    <input id="total_compra" type="hidden" name="total" value="">
    <div class="row">
        {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
                    @foreach ($personas as $persona)
                <option value="{{$persona->id}}">{{$persona->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="tipo_descargo">Tipo Descargo</label>
                <select name="tipo_descargo" class="form-control">
                    <option value="Normal">Normal</option>
                    <option value="Autoconsumo">Autoconsumo</option>
                    <option value="Retiro">Retiro</option>

                </select>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="deposito">Almacen</label>
                <select name="deposito" class="form-control">
                    <option value="1">Almacen Centro</option>

                </select>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="num_documento">N° Documento</label>
                <input type="text" readonly name="num_documento" class="form-control" value="{{old('num_documento')}}{{$num_documento}}" placeholder="N° Documento...">
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="tipo_operacion">Tipo Operacion</label>
                <input type="text" name="tipo_operacion" readonly required class="form-control" value="{{old('tipo_operacion') ?? 'Descargo'}}" placeholder="Tipo Operacion...">
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="autorizado_por">Autorizado por</label>
                <input type="text" name="autorizado_por" id="autorizado_por"  class="form-control" value="{{old('autorizado_por') ?? ''}}" placeholder="Autorizado por...">
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="proposito">Proposito</label>
                <input type="text" name="proposito" id="proposito"  class="form-control" value="{{old('proposito') ?? ''}}" placeholder="Proposito...">
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="detalle">Detalle</label>
                <input type="text" name="detalle" id="detalle"  class="form-control" value="{{old('detalle') ?? ''}}" placeholder="Detalle...">
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
                                {{-- <option value="0">Seleccione Producto</option> --}}
                            <option value="{{$articulo->id}}_{{ $articulo->precio_costo }}_{{ $articulo->nombre }}">{{$articulo->nombre}}_{{$articulo->codigo}}</option>
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
                    <div class="row col-xs-12">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="detalle">Observación</label>
                                <textarea class="form-control" name="jobservacion" id="jobservacion" cols="30" rows="3" placeholder="Observacion..."></textarea>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <table id="detalles" class="table table-striped table-borderd table-condensed table-hover">
                            <thead style="background-color: #A9D0F5">
                                <th>Opciones</th>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Precio Compra</th>
                                <th>Observación</th>
                                <th>Subtotal</th>
                            </thead>
                            <tfoot>
                                <th>TOTAL</th>
                                <th></th>
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


        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="guardar">
            <div class="form-group">

                <button class="btn btn-primary" type="submit">Guardar</button>

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
    });

    var cont=0;
    var total=parseFloat(0.00);
    var precio_compra=parseFloat(0.00);
    var precio_venta=parseFloat(0.00);


    $("#jidarticulo").change(showValues);
    $("#autorizado_po").change('');
    $("#proposito").change('');
    $("#detalle").change('');

    subtotal=[];
    $("#guardar").hide();

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


        articulo = datosArticulo[2];
        //         precio_costo = datosArticulo[1];

        idarticulo=datosArticulo[0];
        // articulo=$("#jidarticulo option:selected").text();
        cantidad=$("#jcantidad").val();
        precio_compra=$("#jprecio_compra").val();
        precio_venta=$("#jprecio_venta").val();
        observacion=$("#jobservacion").val();

        if(idarticulo!="" && cantidad!="" && cantidad>0 && precio_compra!="" && precio_venta!=""){
            subtotal[cont]=(cantidad*precio_compra);
            total=total+subtotal[cont];

            var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input readonly type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly type="number" name="precio_compra[]" value="'+precio_compra+'"></td><td><textarea name="observacion[]" cols="30" rows="3" >'+observacion+'</textarea></td><td>'+parseFloat(subtotal[cont])+'</td></tr>';
            cont++

            clear();
            $("#total_compra").val(total);
            $("#total").html("$. " + total);
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
        $("#jobservacion").val("");
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
        $("#total").html("$/. " + total);
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
@endpush

@endsection
