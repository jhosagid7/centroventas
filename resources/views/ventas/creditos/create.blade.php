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
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3>Listado de Facturas por cobrar de <b>{{ $creditos[0]->persona->nombre ?? '' }}</b></h3>
        {{-- @include('compras.ingreso.buscar') --}}
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            @include('custom.message')
            <table id="ingre" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Operador</th>
                    <th>Cliente</th>
                    <th>Comprobante</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Estado pago</th>
                    <th>Status</th>
                    <th>Opciones</th>
                </thead>
                <tbody>
                    @foreach ($creditos as $ing)
                    <?php $deuda_cliente = "App\DetalleCreditoVenta"::where('venta_id',$ing->id)->orderBy('created_at', 'desc')->first();
                    // echo $deuda_cliente['resta'];
                    ?>
                    <tr>
                        <td>{{ $ing->id ?? '' }}</td>
                        <td>{{ $ing->fecha_hora }}</td>
                        <td>{{ $ing->caja->user->name ?? '' }}</td>
                        <td>{{ $ing->persona->nombre ?? '' }}</td>
                        <td>{{ $ing->tipo_comprobante . ': ' . $ing->serie_comprobante . '-' . $ing->num_comprobante ?? '' }}</td>
                        <td>{{ floatval($deuda_cliente['resta']) ?? '' }}</td>
                        <td>{{ $ing->estado ?? '' }}</td>
                        <td>{{ $ing->tipo_pago_condicion ?? '' }}</td>
                        <td>{{ $ing->estado_credito ?? '' }}</td>
                        <td>
                        <a href="{{URL::action('DetalleCreditoVentaController@show', $ing->id)}}"><button class='btn btn-success btn-sm'><span class='fa fa-money'></span></button></a>
                        {{-- <a href="" data-target="#modal-delete-{{$ing->id}}" data-toggle="modal"><button class='btn btn-primary btn-sm'><span class='fa fa-eye'></span></button></a> --}}
                        {{-- <a href="" data-target="#modal-delete-{{$ing->id}}" data-toggle="modal"><button class='btn btn-danger btn-sm'><i class='glyphicon glyphicon-trash'></i></button></a> --}}
                        </td>
                    </tr>
                    {{-- @include('ventas.creditos.modal') --}}
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- {{$ingresos->render()}} --}}
    </div>
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
@push('sciptsMain')
    <script>
       var table = jQuery(document).ready(function() {
    jQuery('#ingre').DataTable({
    rowReorder: {
    selector: 'td:nth-child(2)'
    },
    responsive: true,
    language: {
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
    iDisplayLength : 5,
    paging: true,
    processing: true,
    columnDefs: [{
    targets: 'no-sort',
    orderable: false
    }],
    dom: '<"row"<"col-sm-6"Bl><"col-sm-6"f>>' +
    '<"row"<"col-sm-12"<"table-responsive"tr>>>' +
    '<"row"<"col-sm-5"i><"col-sm-7"p>>',//'lBfrtip',
    fixedHeader: {
    header: true
  },
    buttons:[
                    {
                    extend:'excelHtml5',
                    text: '<i class="fa fa-file-excel-o fa-inverse"></i>',
                    title : function() {
                    return "Listado de Ingresos";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,4,5,6] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Exportar a Excel',
                    className:'btn btn-success',
                    filename: 'listadod_de_Ingresos_excel'
                    },
                    {
                    extend:'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o fa-inverse"></i>',
                    title : function() {
                    return "Listado de Ingresos";
                    },
                    alignment: "center",
                    customize : function(doc){
                    doc.styles.tableHeader.alignment = 'left'; //giustifica a sinistra titoli colonne
                    doc.content[1].table.widths = [20,100,100,100,100,60]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
                    },
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6],
                        stripHtml: true,

                    } ,
                    // pageSize : 'A3',
                    orientation : 'portrait',//portrait landscape
                    pageSize : 'LETTER',
                    titleAttr:'Exportar a PDF',
                    className:'btn btn-danger',
                    filename: 'listadod_de_Ingresos_pdf'
                    },
                    {
                    extend:'print',
                    text: '<i class="fa fa-print fa-inverse"></i>',
                    title : function() {
                    return "Listado de Ingresos";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,4,5,6] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Imprimir',
                    className:'btn btn-info',
                    filename: 'listadod_de_Ingresos_print'
                    },
                ],

    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );




    } );
    </script>
    @endpush
@endsection
