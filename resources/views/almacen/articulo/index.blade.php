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
          
<div class="row">
@include('almacen.articulo.buscar')

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    
        <h3>Listado de Artículos <a href="{{ URL::action('ArticuloController@create') }}"><button class='btn btn-success'><span class='glyphicon glyphicon-plus'></span> Nuevo</button></a></h3>
        <input id="buscarTexto" name="buscarTexto" type="hidden" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table id="arti" class="data-table table table-striped table-responsive table-bordered table-condensed table-hover">
                <thead>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Stock</th>
                    <th>Unidades</th>
                    <th>Tipo venta</th>
                    <th>Precio costo</th>
                    <th>Area</th>
                    <!-- <th>Precio Dolar</th> -->
                    <th>Acciones</th>
                    
                </thead>
                
                <tfoot>

                </tfoot>
            </table>
        
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

$(document).ready(function() {
    var table = $('#arti').DataTable({
    serverSide: true,
    ajax: "{{ url('api/producto')}}",
    columns: [
    {data: "id"},
    {data: "nombre", "defaultContent": ""},
    {data: "stock", "defaultContent": ""},
    {data: "unidades", "defaultContent": ""},
    {data: "vender_al", "defaultContent": ""},
    {data: "precio_costo"},
    {data: "area.area", "defaultContent": "<i>No establecido...</i>"},
    {data: "btn"}
    ],
    order: [[0, 'desc']],
    responsive: true,
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
    orderable: false,

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

        exportOptions: { columns: [0,1,2,3,5,6,7] } ,
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
        doc.content[1].table.widths = [30,120,50,40,40,40,120,120]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
        },
        exportOptions: {
            columns: [0,1,2,3,5,6],
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

        exportOptions: { columns: [0,1,2,3,5,6,7] } ,
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

    // $('button').click(function () {
    //     var data = table.$('input, select').serialize();
    //     alert('The following data would have been submitted to the server: \n\n' + data.substr(0, 120) + '...');
    //     return false;
    // });


    

    /* When click New customer button */
    $('#new-user').click(function () {
        $('#btn-save').val("create-user");
        $('#user').trigger("reset");
        $('#userCrudModal').html("Add New User");
        $('#crud-modal').modal('show');
    });

    var APP_URL = {!! json_encode(url('/')) !!};
    console.log(APP_URL);
    
    /* Delete customer */
    $('body').on('click', '#delete-articulo', function () {
        var articulo_id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        confirm("Esta seguro de eliminar el articulo... !");

        $.ajax({
        type: "DELETE",
        // url: `/products/${articulo_id}`,"http://localhost/centroventas/public/products/"+user_id
        // url: `http://localhost/centroventas/public/products/${articulo_id}`,
        url: "{{ url('products/') }}/"+articulo_id,
        data: {
        "id": articulo_id,
        "_token": token,
        },
        success: function (data) {
            // table.ajax.url( '{{ url("api/producto")}}' ).load();
            table.ajax.reload();
            alert('successfully')
        // $('#msg').html('Customer entry deleted successfully');
        // $("#customer_id_" + articulo_id).remove();
        
        },
        error: function (data) {
            alert('Error', data)
        console.log('Error:', data);
        }
        });
    });
    
} );
    </script>
    @endpush

@endsection
