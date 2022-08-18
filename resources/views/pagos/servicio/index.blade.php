@extends ('layouts.admin3')
@section('contenido')

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
        <h3>Listado de Servicios pagados  {{ config('app.name', 'VillaSoft') }} <a href="{{URL::action('ServicioController@create')}}"><button class='btn btn-success'><span class='glyphicon glyphicon-plus'></span> Pagar un servicio</button></a></h3>

    </div>

</div>
@include('pagos.servicio.buscar')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            @include('custom.message')
            <table id="ingre" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>ID</th>
                    <th>Categoria.</th>
                    <th>Servicio a pagar</th>
                    <th>Rason social</th>
                    <th>Cedúla/Rif Origen</th>
                    <th>Monto</th>
                    <th>Observaciones</th>
                    <th>Operador</th>
                    <th>Fecha</th>
                    <th>Opciones</th>
                </thead>
                <tbody>
                    @foreach ($servicios as $serv)
                    <tr>
                        <td>{{ $serv->id ?? ' ' }}</td>
                        <td>{{ $serv->categoria_pago->nombre ?? ' ' }}</td>
                        <td>{{ $serv->tipo_pago->nombre ?? ' ' }}</td>
                        <td>{{ $serv->nombre ?? ' ' }}</td>
                        <td>{{ $serv->num_documento ?? ' ' }}</td>
                        <td>{{ $serv->deuda ?? ' ' }}</td>
                        <td>{{ $serv->observaciones ?? ' ' }}</td>
                        <td>{{ $serv->user->name ?? ' '}}</td>
                        <td>{{ $serv->created_at ?? ' ' }}</td>
                        <td>
                        <a href="{{URL::action('ServicioController@show', $serv->id)}}"><button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-edit'></span></button></a>
                        </td>
                    </tr>
                    {{-- @include('almacen.transferencia.modal') --}}
                    @endforeach
                </tbody>
            </table>
            {{ $servicios->appends(request()->query())->links() }}
        </div>
        {{-- {{$ingresos->render()}} --}}
    </div>
</div>

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
       var table = jQuery(document).ready(function() {
    jQuery('#ingre').DataTable({
    order: [[0, 'desc']],
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
                    return "Listado de Transferencias";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Exportar a Excel',
                    className:'btn btn-success',
                    filename: 'listadod_de_Transferencias_excel'
                    },
                    {
                    extend:'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o fa-inverse"></i>',
                    title : function() {
                    return "Listado de Transferencias";
                    },
                    alignment: "center",
                    customize : function(doc){
                    doc.styles.tableHeader.alignment = 'left'; //giustifica a sinistra titoli colonne
                    doc.content[1].table.widths = [20,100, 180,40,40,40,40,180,40,40,40,40,150,60]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
                    },
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13],
                        stripHtml: true,

                    } ,
                    // pageSize : 'A3',
                    orientation : 'landscape',//portrait landscape
                    pageSize : 'A3',//LETTER A4
                    titleAttr:'Exportar a PDF',
                    className:'btn btn-danger',
                    filename: 'listadod_de_Transferencias_pdf'
                    },
                    {
                    extend:'print',
                    text: '<i class="fa fa-print fa-inverse"></i>',
                    title : function() {
                    return "Listado de Transferencias";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Imprimir',
                    className:'btn btn-info',
                    filename: 'listadod_de_Transferencias_print'
                    },
                ],

    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );




    } );
    </script>
    @endpush
@endsection
