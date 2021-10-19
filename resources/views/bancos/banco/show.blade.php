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
                    <div class="table-responsive">
                        @include('custom.message')
                        <table id="arti" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
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
                                    <td>
                                        @if ($saldosMov->debe > 0)
                                            {{ $saldosMov->debe ?? '' }}
                                        @else

                                        @endif

                                    </td>
                                    <td>
                                        @if ($saldosMov->haber > 0)
                                            {{ $saldosMov->haber ?? '' }}
                                        @else

                                        @endif

                                    </td>
                                    <td>
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
