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
        {{-- cabecera de box --}}
        <section id="imprimir" class="invoice">
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
            <h3 class="box-title">@isset($title)
                {{$title}}
                @else
                {!!"Sistema"!!}
            @endisset</h3>
            <div class="row invoice-info">
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <h4><strong>Datos:</strong></h4>
                    <address>

                        <div class="table-responsive">
                            <table class="table">
                              <tr>
                                <th style="width:30%">Operador:</th>
                              <td>{{$user->name}}</td>
                              </tr>
                              <tr>
                                <th>
                                    Fecha ultima caja:


                                </th>
                                <td> {{$fecha_ultima_caja->updated_at ?? ''}}</td>
                              </tr>
                              <tr>
                                <th>Consulta:</th>
                                <td>Valor total en articulos</td>
                              </tr>

                            </table>
                          </div>

                    </address>
                  </div>
                <!-- /.col -->
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <h4><strong>Datos Articulos:</strong></h4>
                    <address>

                        <div class="table-responsive">
                            <table class="table">
                              <tr>
                                <th style="width:40%">Cant/Al Mayor:</th>
                                <td>{{ $mayor[0]->totalStockMayor }}</td>
                              </tr>
                              <tr>
                                <th>
                                    Cant/Al Detal:

                                </th>
                                <td>{{ $detal[0]->totalStockDetal }}</td>
                              </tr>
                              <tr>
                                <th>Total Unids:</th>
                                <td>{{ $mayor[0]->totalUnidadesMayor+$detal[0]->totalUnidadesDetal }}</td>
                              </tr>

                            </table>
                          </div>

                    </address>
                  </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h4><strong>Totales:</strong></h4>
                  <address>

                      <div class="table-responsive">
                          <table class="table">
                            <tr>
                              <th style="width:50%">Total Mayor:</th>
                              <td>$ {{ number_format($mayor[0]->totalMayor, 3,',','.') ?? '0,000' }}</td>
                            </tr>
                            <tr>
                              <th>
                                  Total Detal:
                              </th>
                              <td>$ {{ number_format($detal[0]->totalDetal, 3,',','.') ?? '0.000' }}</td>
                            </tr>
                            <tr>
                              <th>Total General:</th>

                            <td>
                                <h3>$ {{ number_format($totalInversion[0]->precio_costo_total,3,',','.') ?? '0.000' }}</h3></td>
                            </tr>

                          </table>
                        </div>

                  </address>
                </div>
                <!-- /.col -->
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

<script language="javascript">

//     function imprimirContenido(el){
//         // $('#guion').show();
//         var restaurarPagina = document.body.innerHTML;
//         var urlPagina = window.location.href;

// //        alert(urlPagina);
//         // $('#headerPagina').show();
//         // $('#firmaPagina').show();
//         var imprimircontenido = document.getElementById(el).innerHTML;
//         document.body.innerHTML = imprimircontenido;
//         window.print();
//         // $('#headerPagina').hide();
//         // $('#firmaPagina').hide();
//         document.body.innerHTML = restaurarPagina;
//         // $('#guion').show();
//         window.location= urlPagina;

//     }
// //     $( document ).ready( function() {
// // $("#print_button1").click(function(){
// //     alert('entro');
// //             var mode = 'iframe'; // popup
// //             var close = mode == "popup";
// //             var options = { mode : mode, popClose : close};
// //             $("div.contePrint").printArea( options );
// //         });
// // });
// </script>
@endpush
@endsection
