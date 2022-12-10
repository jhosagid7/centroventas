@extends ('layouts.admin3')
@section('contenido')





    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border  no-print">
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

            <a class="btn btn-success" href="{{route('reporte-calculo')}}">{{__('Nueva Busqueda')}}</a>
            @endif
            <a class="btn btn-warning" href="{{route('reporte-calculo')}}">{{__('Ir a calculo')}}</a>
            <a onClick="imprimir('imprimir')" target="_blank" class="btn btn-primary  hidden-print">
                <i class="fa fa-print"></i>
                Imprimir
            </a>
            {{-- <button onclick="imprimir()">Imprimir pantalla</button> --}}

        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->
    <!-- Main content -->
<section id="imprimir" class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i>  {{ config('app.name', 'VillaSoft Hotel') }}
        <small class="pull-right">Fecha: {{date('d-m-y')}}<br>Hora: {{date('H:m A')}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <h3 class="box-title">@isset($title)
        {{$title}}
        @else
        {!!"Sistema"!!}
    @endisset</h3>
    <!-- info row -->
   

                            
    <!-- /.row -->
    <div class="row">

    </div>

<div class="row ">
    
        <div class="margin"><h4><strong>{{$usuario[0] ?? ''}} </strong></h4> </div>
        <div class="margin">Total Ventas: {{$total_total_venta ?? ''}}</div>
        <div class="margin">Comision (1 %): {{$total_UnoPorCien ?? '' }}</div>
        <div class="margin">Cominsion (0.60 %): {{$total_CeroSesentaPorCien ?? '' }}</div>
        <div class="margin">Total Cominision: {{$total_UnoPorCien + $total_CeroSesentaPorCien ?? '' }}</div>
        <div class="panel panel-primary">
            <div class="col-xs-12 table-responsive">

                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr class="warning {{$detallado ?? ''}} ">
                            <th>fecha</th>
                            <th>Total venta</th>
                            <th>Uno por ciento</th>
                            <th>Cero sesenta por ciento</th>
                            <th>Cero cuarenta por ciento</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        
                        @for ($i = 0; $i < count($total_dia); $i++)
                        <tr class="<?php echo $success = $meta_alcanzada[$i] == 'Si' ? 'success' : ''; ?>" >
                            <td>{{$total_dia[$i] ?? '' }}</td>
                            <td>{{$total_venta[$i] ?? '' }}</td>
                            <td>{{$UnoPorCien[$i] ?? '' }}</td>
                            <td>{{$CeroSesentaPorCien[$i] ?? '' }}</td>
                            <td>{{$CeroCuarentaPorCien[$i] ?? '' }}</td>
                        </tr>
                        @endfor
                            
                       
                        
                    </tbody>
                    <tfoot>
                        <tr class="warning">
                            <th>Totales:</th>
                            <th>{{$total_total_venta ?? '' }}</th>
                            <th>{{$total_UnoPorCien ?? '' }}</th>
                            <th>{{$total_CeroSesentaPorCien ?? '' }}</th>
                            <th>{{$total_CeroCuarentaPorCien ?? '' }}</th>
                        </tr>
                    </tfoot>
                </table>

                
               
            </div>

        </div>
      <!-- /.col -->
    </div>


</section></section>
  <!-- /.content -->
  <div class="clearfix"></div>
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
                "iDisplayLength" : 5,
       });
       $("#buscarTexto").keyup(function() {
           dataTable.fnFilter(this.value);
       });
   });
</script>

<script language="javascript">

    function imprimirContenido(el){
        // $('#guion').show();
        var restaurarPagina = document.body.innerHTML;
        // var urlPagina = window.location.href;

//        alert(urlPagina);
        // $('#headerPagina').show();
        // $('#firmaPagina').show();
        var imprimircontenido = document.getElementById(el).innerHTML;
        document.body.innerHTML = imprimircontenido;
        window.print();
        // $('#headerPagina').hide();
        // $('#firmaPagina').hide();
        document.body.innerHTML = restaurarPagina;
        // $('#guion').show();
        // window.location= urlPagina;

    }
//     $( document ).ready( function() {
// $("#print_button1").click(function(){
//     alert('entro');
//             var mode = 'iframe'; // popup
//             var close = mode == "popup";
//             var options = { mode : mode, popClose : close};
//             $("div.contePrint").printArea( options );
//         });
// });

function imprimir() {
            window.print();
        }
</script>
@endpush
@endsection
