@extends ('layouts.admin3')
@section('contenido')


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border no-print">
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
            <div class="row">

                <!-- /.box-body -->
                <div class="box-footer no-print">
                    @if (1 == 1)

                    <a href="" data-target="#modal-pago" data-toggle="modal"><button id="contado" class='btn btn-success'><i class='fa fa-money'> <b>Transferencia</b> </i></button></a>
                    @endif
                    <a class="btn btn-warning text-bold" href="{{route('banco.index')}}">{{__('Ir a Banco')}}</a>
                    <a onClick="imprimir('imprimir')" target="_blank" class="btn btn-primary  hidden-print text-bold">
                        <i class="fa fa-print"></i>
                        Imprimir
                    </a>
                    {{-- <button onclick="imprimir()">Imprimir pantalla</button> --}}

                </div>
                <!-- /.box-footer-->
            </div>
            @include('bancos.banco.credito')
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
                    <div style="background-color: rgb(198, 225, 243);" class="text-black " class="table-responsive">
                        @include('custom.message')
                        <table id="arti" class="table table-striped table-bordered table-condensed table-hover">
                            <thead style="background-color: rgb(64, 170, 241);" class="text-black ">
                                <th>Nº</th>
                                <th>Fecha</th>
                                <th>Operador</th>
                                <th>Descripcion de la Operación</th>
                                <th>Código</th>
                                <th>Denominación</th>
                                <th>Debe</th>
                                <th>Haber</th>
                                <th>Saldo</th>

                            </thead>
                            <tbody>
                                @php
                                    $total_costo = 0;
                                @endphp
                                @foreach ($saldosMovimientos as $saldosMov)

                                @php
                                $total_costo += 0;
                                // $total_costo += $art->precio_costo;
                                @endphp




                                <tr>
                                    <td>{{ $saldosMov->correlativo }}</td>
                                    <td>{{ $saldosMov->created_at }}</td>
                                    <td>{{ $saldosMov->Transaccion->operador }}</td>
                                    <td>{{ $saldosMov->Transaccion->descripcion_op }}</td>
                                    <td>{{ $saldosMov->Transaccion->codigo }}</td>
                                    <td>{{ $saldosMov->Transaccion->denominacion }}</td>
                                    <td class="text-info">
                                        @if ($saldosMov->debe > 0)
                                            {{ $saldosMov->debe ?? '' }}
                                        @else

                                        @endif

                                    </td>
                                    <td class="text-red">
                                        @if ($saldosMov->haber > 0)
                                            -{{ $saldosMov->haber ?? '' }}
                                        @else

                                        @endif

                                    </td>
                                    <td class="text-primary">
                                        @if ($saldosMov->saldo > 0)
                                            {{ $saldosMov->saldo ?? '' }}
                                        @else

                                        @endif

                                    </td>
                                </tr>
                                {{-- @include('almacen.articulo.modal') --}}
                                @endforeach

                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
            {{-- {{ $saldosMovimientos->appends(request()->query())->links() }} --}}
                    </div>
                    {{-- {{$articulos->render()}} --}}
                </div>
                {{-- {!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG('4', 'C39+',3,33,array(1,1,1), true) . '" alt="barcode"   />'!!} --}}

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
</div>
<!-- /.box-footer-->
</div>
<!-- /.box -->
</div>


</section>
@push('sciptsMain')

<script>
            function numDecimal(valor){
                let result = Number(valor).toFixed(3);

                return result;
            }


    $(document).ready(function() {

        function numDecimal(valor){
            let result = Number(valor).toFixed(4);

            return result;
        }

        function clean(){
            $("#Tdestino").val('');
            $('#monto_transferir_ver').html('0.00');
            $("#tasa_destino_ver").html('0.00');
            $('#montoDestino').html('0.00');
            $('#monto_transferir').val('0.00');
        }

        $("#contado").click(function(){
            $("#montoOrigen").val('');
            $("#monto_debitar").val('0.00');
            clean();
        });

        $("#Bdestino").on("change", function () {
            document.getElementById("montoOrigen").focus();
            clean()
            calcular();
        });

        function calcular(){
            let montoOrigen = $("#montoOrigen").val();
            let Tdestino = $("#Tdestino").val();
            $("#monto_debitar").val(numDecimal(montoOrigen));


            BcOrigen = document.getElementById('bancoOrigen').value;
            BcOrigen = BcOrigen.split(":");

            Bcdestino = document.getElementById('Bdestino').value;
            Bcdestino = Bcdestino.split(":");

            if(BcOrigen[1] == undefined){
                $("#cuenta_origen_ver").html('');
                alert('Debe seleccionar cuenta de origen')
                document.getElementById("bancoOrigen").focus();
            }else{
                $("#cuenta_origen_ver").html('Banco ' + BcOrigen[1]);
            }
            if(Bcdestino[1] == undefined){
                $("#cuenta_destino_ver").html('');
                alert('Debe seleccionar cuenta de destino')
                document.getElementById("Bdestino").focus();
            }else{
                $("#cuenta_destino_ver").html('Banco ' + Bcdestino[1]);
            }


            // Dolar
            if(BcOrigen[1] == 'Dolar' && Bcdestino[1] == 'Peso'){
                DolarPeso(montoOrigen, Tdestino)
            }

            if(BcOrigen[1] == 'Dolar' && Bcdestino[1] == 'Efectivo'){
                DolarBolivar(montoOrigen, Tdestino)
            }

            if(BcOrigen[1] == 'Dolar' && Bcdestino[1] == 'Transferencia_Punto'){
                DolarPunto(montoOrigen, Tdestino)
            }

            // Peso
            if(BcOrigen[1] == 'Peso' && Bcdestino[1] == 'Dolar'){
                PesoDolar(montoOrigen, Tdestino)
            }

            if(BcOrigen[1] == 'Peso' && Bcdestino[1] == 'Efectivo'){
                PesoBolivar(montoOrigen, Tdestino)
            }

            if(BcOrigen[1] == 'Peso' && Bcdestino[1] == 'Transferencia_Punto'){
                PesoPunto(montoOrigen, Tdestino)
            }

            // Bolivar
            if(BcOrigen[1] == 'Bolivar' && Bcdestino[1] == 'Dolar'){
                BolivarDolar(montoOrigen, Tdestino)
            }

            if(BcOrigen[1] == 'Bolivar' && Bcdestino[1] == 'Peso'){
                BolivarPeso(montoOrigen, Tdestino)
            }

            if(BcOrigen[1] == 'Bolivar' && Bcdestino[1] == 'Transferencia_Punto'){
                BolivarPunto(montoOrigen, Tdestino)
            }

            // Punto
            if(BcOrigen[1] == 'Punto' && Bcdestino[1] == 'Dolar'){
                BolivarDolar(montoOrigen, Tdestino)
            }

            if(BcOrigen[1] == 'Punto' && Bcdestino[1] == 'Peso'){
                BolivarPeso(montoOrigen, Tdestino)
            }

            if(BcOrigen[1] == 'Punto' && Bcdestino[1] == 'Efectivo'){
                BolivarPunto(montoOrigen, Tdestino)
            }
        }

        $("#pagar").click(function(){
            event.preventDefault();
            let monto = $('#monto_transferir').val();
            if(monto > 0){
                $("#form1").submit();
            }else{
                alert('No se puede hacer una transaccion sin un monto a trasferir')
            }


        });
        $("#montoOrigen").keyup(function(){
            $("#monto_debitar_ver").html($(this).val());
            $("#monto_debitar").val($(this).val());
            calcular();
        });
        $("#Tdestino").keyup(function(){
            $("#tasa_destino_ver").html($(this).val());
            $("#tasa_destino").val($(this).val());
            calcular();
        });

        function DolarPeso(origen, dest){
            console.log('Monto Dolar * tasa Peso = resultado en peso');
                if(origen > 0 && dest > 0){
                    let mostrar = origen * dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }
        function DolarBolivar(origen, dest){
            console.log('Monto dolar * tasa Bolivar = resultado en bolivar')
                if(origen > 0 && dest > 0){
                    let mostrar = origen * dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }
        function DolarPunto(origen, dest){
            console.log('Monto dolar * tasa transferencia_punto = resultado en transferencia_punto')
                if(origen > 0 && dest > 0){
                    let mostrar = origen * dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }

        function PesoDolar(origen, dest){
            console.log('Monto peso / tasa Peso = resultado en dolar');
                if(origen > 0 && dest > 0){
                    let mostrar = origen / dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }
        function PesoBolivar(origen, dest){
            console.log('Monto peso / tasa Bolivar = resultado en Transferencia_Punto')
                if(origen > 0 && dest > 0){
                    let mostrar = origen / dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }
        function PesoPunto(origen, dest){
            console.log('Monto peso / tasa Bolivar = resultado en bolivar')
                if(origen > 0 && dest > 0){
                    let mostrar = origen / dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }

        function BolivarDolar(origen, dest){
            console.log('Monto bolivar / tasa Bolivar = resultado en dolar');
                if(origen > 0 && dest > 0){
                    let mostrar = origen / dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }
        function BolivarPeso(origen, dest){
            console.log('Monto Bolivar * tasa peso ejp:800 = resultado en bolivar')
                if(origen > 0 && dest > 0){
                    let mostrar = origen * dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }
        function BolivarPunto(origen, dest){
            console.log('Monto bolivar * 1 = resultado en punto')
                if(origen > 0 && dest > 0){
                    let mostrar = origen * dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }
        function PuntoDolar(origen, dest){
            console.log('Monto Punto / tasa Bolivar = resultado en dolar');
                if(origen > 0 && dest > 0){
                    let mostrar = origen / dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }
        function PuntoPeso(origen, dest){
            console.log('Monto Punto * tasa peso ejp:800 = resultado en bolivar')
                if(origen > 0 && dest > 0){
                    let mostrar = origen * dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }
        function PuntoBolivar(origen, dest){
            console.log('Monto Punto * 1 = resultado en bolivar')
                if(origen > 0 && dest > 0){
                    let mostrar = origen * dest;
                    console.log('Mostrar: ' + numDecimal(mostrar));
                    $('#montoDestino').html(numDecimal(mostrar));
                    $('#monto_transferir_ver').html(numDecimal(mostrar));
                    $('#monto_transferir').val(numDecimal(mostrar));
                }
        }


    });
    </script>

<script language="javascript">
    function imprimir() {
            window.print();
        }


 </script>
<script>

    $(document).ready(function() {
       var dataTable = $('#arti').dataTable({
        "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior",
                    },
                    "lengthMenu": 'Mostrar <select >'+
                                '<option value="5">5</option>'+
                                '<option value="10">10</option>'+
                                '<option value="-1">Todos</option>'+
                                '</select> registros',
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "emptyTable": "No hay datos",
                    "zeroRecords": "No hay coincidencias",
                    "infoEmpty": "",
                    "infoFiltered": ""
                },
                "order": [
                        [0, "desc"]
                    ],
                "iDisplayLength" : 25,
       });
       $("#buscarTexto").keyup(function() {
           dataTable.fnFilter(this.value);
       });
   });


</script>
@endpush
@endsection
