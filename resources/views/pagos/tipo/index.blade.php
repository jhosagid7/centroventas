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
        <h3>Listado de Tipos de Pago <a href="{{URL::action('TipoPagoController@create')}}"><button class='btn btn-success'><span class='glyphicon glyphicon-plus'></span> Nuevo</button></a></h3>

    </div>
</div>
{{-- @include('pagos.tipo.buscar') --}}
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            @include('custom.message')
            <table id="arti" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
                    <th>Opciones</th>
                </thead>
                <tbody>

                    @foreach ($articulos as $art)

                    <tr>
                        <td>{{ $art->id }}</td>
                        <td>{{ $art->nombre }}</td>
                        <td>{{ $art->descripcion }}</td>
                        <td>{{ $art->categoria_pago->nombre }}</td>
                        <td>
                        <a href="{{URL::action('TipoPagoController@edit', $art->id)}}"><button class='btn btn-info btn-sm'><span class='glyphicon glyphicon-edit'></span></button></a>
                        <a href="" data-target="#modal-delete-{{$art->id}}" data-toggle="modal"><button class='btn btn-danger btn-sm'><i class='glyphicon glyphicon-trash'></i></button></a>
                    </td>
                    </tr>
                    @include('pagos.tipo.modal')
                    @endforeach

                </tbody>
                <tfoot>

                </tfoot>
            </table>
{{ $articulos->appends(request()->query())->links() }}
        </div>
        {{-- {{$articulos->render()}} --}}
    </div>
    {{-- {!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG('4', 'C39+',3,33,array(1,1,1), true) . '" alt="barcode"   />'!!} --}}

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

    <script language="javascript">

        function imprimirContenido(el){
            var restaurarPagina = document.body.innerHTML;
            var urlPagina = window.location.href;

    //        alert(urlPagina);
            $('#headerPagina').show();
            $('#firmaPagina').show();
            var imprimircontenido = document.getElementById(el).innerHTML;
            document.body.innerHTML = imprimircontenido;
            window.print();
            $('#headerPagina').hide();
            $('#firmaPagina').show();
            document.body.innerHTML = restaurarPagina;
            window.location= urlPagina;

        }
        $( document ).ready( function() {


        $("#print_button1").click(function(){
            alert('entro');
                    var mode = 'iframe'; // popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("div.contePrint").printArea( options );
                });
        });
    </script>
    <script>

var table = jQuery(document).ready(function() {
    jQuery('#arti').DataTable({
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
                    return "Listado de Artículos";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,5,6,7,8,9,10,11,12] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Exportar a Excel',
                    className:'btn btn-success',
                    filename: 'listadod_de_Artículos_excel'
                    },
                    {
                    extend:'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o fa-inverse"></i>',
                    title : function() {
                    return "Listado de Artículos";
                    },
                    alignment: "center",
                    customize : function(doc){
                    doc.styles.tableHeader.alignment = 'left'; //giustifica a sinistra titoli colonne
                    doc.content[1].table.widths = [20,60,120,40,40,40,40,100,100,100,100,120]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
                    },
                    exportOptions: {
                        columns: [0,1,2,3,5,6,7,8,9,10,11,12],
                        stripHtml: true,

                    } ,
                    // pageSize : 'A3',
                    orientation : 'landscape',//portrait landscape
                    pageSize : 'LEGAL',
                    titleAttr:'Exportar a PDF',
                    className:'btn btn-danger',
                    filename: 'listadod_de_Artículos_pdf'
                    },
                    {
                    extend:'print',
                    text: '<i class="fa fa-print fa-inverse"></i>',
                    title : function() {
                    return "Listado de Artículos";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,5,6,7,8,9,10,11,12] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Imprimir',
                    className:'btn btn-info',
                    filename: 'listadod_de_Artículos_print'
                    },
                ],

    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );




    } );


    //     $(document).ready(function() {
    //        var dataTable = $('#arti').dataTable({
    //         "language": {
    //                     "info": "_TOTAL_ registros",
    //                     "search": "Buscar",
    //                     "paginate": {
    //                         "next": "Siguiente",
    //                         "previous": "Anterior",
    //                     },
    //                     "lengthMenu": 'Mostrar <select >'+
    //                                 '<option value="5">5</option>'+
    //                                 '<option value="10">10</option>'+
    //                                 '<option value="-1">Todos</option>'+
    //                                 '</select> registros',
    //                     "loadingRecords": "Cargando...",
    //                     "processing": "Procesando...",
    //                     "emptyTable": "No hay datos",
    //                     "zeroRecords": "No hay coincidencias",
    //                     "infoEmpty": "",
    //                     "infoFiltered": ""
    //                 },
    //                 "iDisplayLength" : 5,
    //        });
    //        $("#buscarTexto").keyup(function() {
    //            dataTable.fnFilter(this.value);
    //        });
    //    });
    //    $(document).ready(function() {
    //         $('#arti').DataTable({
    //             language: { ... },
    //             // para usar los botones
    //             responsive: "true",
    //             Dom: 'Bfrtilp',
    //             Buttons:[
    //                 {
    //                 extend:'excelHtml5',
    //                 text: '<li class="fas fas-file-excel"></li>',
    //                 titleAttr:'Exportar a Excel',
    //                 className:'btn btn-success'
    //                 },
    //                 {
    //                 extend:'excelHtml5',
    //                 text: '<li class="fas fas-file-pdf"></li>',
    //                 titleAttr:'Exportar a PDF',
    //                 className:'btn btn-danger'
    //                 },
    //                 {
    //                 extend:'excelHtml5',
    //                 text: '<li class="fas fas-file-print"></li>',
    //                 titleAttr:'Imprimir',
    //                 className:'btn btn-info'
    //                 },
    //             ]

    //         });
    //     });


    </script>
    @endpush

@endsection
