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
        {{-- <h3>Listado de Categorias <a href="" data-target="#modal-nuevo" data-toggle="modal"><button class='btn btn-success'><span class='glyphicon glyphicon-plus'></span>Nuevo</button></a></h3> --}}
        <h3>Listado de Categorías <a href="{{URL::action('CategoriaController@create')}}"><button class='btn btn-success btn-sm'><span class='glyphicon glyphicon-plus'></span> Nuevo</button></a></h3>

    </div>
</div>
@include('almacen.categoria.buscar')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            @include('custom.message')
            <table id="cate" class="table table-striped table-bordered table-condensed table-hover table-ms">
                <thead>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Opciones</th>
                </thead>
                <tbody>
                    @foreach ($categorias as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td>{{ $cat->nombre }}</td>
                        <td>{{ $cat->descripcion }}</td>
                        <td>
                        <a href="{{URL::action('CategoriaController@edit', $cat->id)}}"><button class='btn btn-info btn-sm'><span class='glyphicon glyphicon-edit'></span></button></a>
                        <a href="" data-target="#modal-delete-{{$cat->id}}" data-toggle="modal"><button class='btn btn-danger btn-sm'><i class='glyphicon glyphicon-trash'></i></button></a>
                        </td>
                    </tr>
                    @include('almacen.categoria.modal')
                    @endforeach
                    {{-- @include('almacen.categoria.nuevo_modal') --}}
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Opciones</th>

                    </tr>
                </tfoot>
            </table>
        </div>
        {{-- {{$categorias->render()}} --}}
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


 // #myInput is a <input type="text"> element

 var table = jQuery(document).ready(function() {
    jQuery('#cate').DataTable({
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
                    footer: false,
                    title : function() {
                    return "Listado de Categorías";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Exportar a Excel',
                    className:'btn btn-success',
                    filename: 'listadod_de_categorías_excel'
                    },
                    {
                    extend:'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o fa-inverse"></i>',
                    footer: false,
                    title : function() {
                    return "Listado de Categorías";
                    },
                    alignment: "center",
                    customize : function(doc){
                    doc.styles.tableHeader.alignment = 'left'; //giustifica a sinistra titoli colonne
                    doc.content[1].table.widths = [50,200,250]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
                    },
                    exportOptions: { columns: [0,1,2] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',//portrai tlandscape
                    pageSize : 'LEGAL',
                    titleAttr:'Exportar a PDF',
                    className:'btn btn-danger',
                    filename: 'listadod_de_categorías_pdf'
                    },
                    {
                    extend:'print',
                    text: '<i class="fa fa-print fa-inverse"></i>',
                    footer: false,
                    title : function() {
                    return "Listado de Categorías";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Imprimir',
                    className:'btn btn-info',
                    filename: 'listadod_de_categorías_print'
                    },



                ],

    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );

    table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(0)' );


    } );
    //     $(document).ready(function() {
    //        var dataTable = $('#cate').dataTable({
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
    //                 "order": [[0, "desc"]],
    //        });
    //        $("#buscarTexto").keyup(function() {
    //            dataTable.fnFilter(this.value);
    //        });
    //    });


    </script>
    @endpush

@endsection
