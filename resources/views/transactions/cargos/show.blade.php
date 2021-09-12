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
                <small class="pull-right">
                    Fecha: {{date('d-m-Y')}} <br>
                    Hora: {{date('h:m:s A')}}

                </small>
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
                    <label for="almacen">Responsable</label>
                    <p>{{$cargos->user->name}}</p>
                    {{-- <input type="text" readonly name="almacen" class="form-control" value="{{old('almacen')}}{{$cargos->deposito}}" placeholder="Almacen..."> --}}
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="num_documento">N° Documento</label>
                    <p>{{$cargos->num_documento}}</p>
                    {{-- <input type="text" readonly name="num_documento" class="form-control" value="{{old('num_documento')}}{{$cargos->num_documento}}" placeholder="N° Documento..."> --}}
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <p>{{$cargos->created_at}}</p>
                    {{-- <input type="text" name="tipo_operacion" readonly  class="form-control" value="{{old('tipo_operacion')}}{{$cargos->tipo_operacion}}" placeholder="Tipo Operacion..."> --}}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="autorizado_por">Autorizado por</label>
                    <p>{{$cargos->autorizado_por}}</p>
                    {{-- <input type="text" name="autorizado_por" id="autorizado_por"  class="form-control" value="{{old('autorizado_por') ?? ''}}{{$cargos->autorizado_por}}" placeholder="Autorizado por..."> --}}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="proposito">Proposito</label>
                    <p>{{$cargos->proposito}}</p>
                    {{-- <input type="text" name="proposito" id="proposito"  class="form-control" value="{{old('proposito') ?? ''}}{{$cargos->proposito}}" placeholder="Proposito..."> --}}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="detalle">Detalle</label>
                    <p>{{$cargos->detalle}}</p>
                    {{-- <input type="text" name="detalle" id="detalle"  class="form-control" value="{{old('detalle') ?? ''}}{{$cargos->detalle}}" placeholder="Detalle..."> --}}
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
                                <th>Observación</th>
                                <th>Subtotal</th>
                            </thead>
                            <tfoot>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>

                            <th><h4 id="total"><b>$. {{$cargos->total_operacion ?? ''}}</b></h4></th>
                            </tfoot>
                            <tbody>
                                @foreach ($cargos->articulo_transactions as $carg)
                                    <tr>
                                    <td>{{$carg->articulo->nombre ?? ''}}</td>
                                    <td>{{$carg->cantidad ?? ''}}</td>
                                    <td>{{$carg->precio_costo_unidad ?? ''}}</td>
                                    <td>{{$carg->observacion ?? ''}}</td>
                                    <td>{{$carg->cantidad*$carg->precio_costo_unidad}}</td>

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
    {{-- <a class="btn btn-danger no-print" href="{{ url()->previous() }}">{{__('Regresar')}}</a> --}}
    <a class="btn btn-danger no-print" href="{{route('cargo.index')}}">{{__('Back')}}</a>
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
