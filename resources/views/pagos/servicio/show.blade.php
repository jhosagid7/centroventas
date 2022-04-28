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
                  <i class="fa fa-globe"></i>  {{ config('app.name', 'VillaSoft') }}
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
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="operador">Operador</label>
                    <p>{{ $servicio->user->name ?? ''}}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="proveedor">Razon social</label>
                    <p>{{ $servicio->nombre ?? ''}}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="proveedor">Fecha</label>
                    <p>{{ $servicio->created_at ?? '' }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="tipo_comprobante">Tipo servicio </label>
                    <p>{{$servicio->categoria_pago->nombre ?? ''}} - {{$servicio->tipo_pago->nombre ?? ''}}</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Rif/CI</label>
                    <p>{{ $servicio->num_documento ?? ''}}</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Total pagado</label>
                    <p>{{ $servicio->deuda ?? ''}}</p>
                </div>
            </div>
        </div>
        @if ($servicio->observaciones)
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="tipo_comprobante">Observaciones </label>
                    <p>{{$servicio->observaciones ?? ''}}</p>
                </div>
            </div>
        </div>
        @endif


    </div>

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <table id="detalles" class="table table-striped table-borderd table-condensed table-hover">
                            <thead style="background-color: #A9D0F5">
                                <th>ID</th>
                                <th>Divisa</th>
                                <th>Tasa sistema.</th>
                                <th>Tasa pagada</th>
                                <th>Monto divisa.</th>
                                <th>Monto dolar</th>
                            </thead>
                            <tfoot>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><h3>Total pagado:</h3></th>
                                <th><h3 class="box-title text-bold text-block">${{ number_format(floatval($pagos_servicios_suma),2,',','.') ?? ' 0,00' }}</h3></th>


                            {{-- <th><h4 id="total"><b>$. {{$servicio->total ?? ''}}</b></h4></th> --}}
                            </tfoot>
                            <tbody>

                                @foreach ($pagos_servicios as $pagos_servicio)
                                <tr>
                                    <td>{{$pagos_servicio->id ?? ''}}</td>
                                    <td>{{$pagos_servicio->Divisa ?? ''}}</td>
                                    <td>{{$pagos_servicio->TasaTiket ?? ''}}</td>
                                    <td>{{$pagos_servicio->TasaRecived ?? ''}}</td>
                                    <td>{{$pagos_servicio->MontoDivisa ?? ''}}</td>
                                    <td>{{$pagos_servicio->MontoDolar ?? ''}}</td>
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
    <a onClick="imprimirContenido('imprimir')" target="_blank" class="btn btn-primary  hidden-print">
        <i class="fa fa-print"></i>
        Imprimir
    </a>
</div>
<!-- /.box-footer-->
</div>
<!-- /.box -->
</section>
@push('sciptsMain')

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
</script>
@endpush

@endsection
