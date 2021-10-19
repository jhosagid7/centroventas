@extends ('layouts.admin3')
@section('contenido')



<div class="row">
    <div class="col-lg-6">

        @include('custom.message')
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="nav-tabs-custom margin">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#caja" data-toggle="tab">Cuentas</a></li>
            {{-- <li><a href="#ventas" data-toggle="tab">Ventas</a></li>
            <li><a href="#tasa" data-toggle="tab">Configurar tasa</a></li> --}}
        </ul>
        <div class="tab-content">
            {{-- <a href="{{URL::action('CajaController@show', $caja->id)}}"><button class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-edit'> Cerrar caja</span></button></a> --}}

            <div class="active tab-pane" id="caja">
                <!-- Main content -->
                <section class="content">
                    <!-- Info boxes -->
                    <div class="row">
                        @foreach ($cuentas as $cuenta)
                        @php
                             $saldos = "App\SaldosMovimiento"::where('cuenta_id', $cuenta->id)->latest('id')->first();
                        @endphp
                        <a href="{{URL::action('BancoController@show', $cuenta->id)}}" data-toggle="modal" data-target=""  class="small small-box-footer text-success">

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green-gradient"><i class="fa fa-address-card"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">{{$cuenta->nombre_cuenta ?? ''}}</span>
                                        <span class="info-box-number">{{$cuenta->simbolo ?? ''}}.{{$saldos->saldo ?? '0.00'}}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                        </a>
                        @endforeach



                        <!-- fix for small devices only -->
                    </div>
                    <!-- /.row -->





                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info">

                                <!-- /.box-header -->
                                <!-- Main row -->
                                <div class="row">
                                    <!-- Left col -->
                                    <div class="col-md-8">
                                        <div class="box-body">

                                            <!-- TABLE: LATEST ORDERS -->

                                            <!-- /.box -->
                                        </div>
                                        <!-- ./box-body -->

                                    </div>
                                    <!-- /.box -->

                                    <!-- /.box -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>


                </section>
                <!-- /.content -->
            </div>



            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- /.nav-tabs-custom -->
</div>
@push('sciptsMain')
    <script>





    </script>
    @endpush

@endsection
