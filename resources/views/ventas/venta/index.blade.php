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
        @can('haveaccess', 'venta.create')
        <h3>Ventas Realizadas <a href="{{URL::action('VentaController@create')}}"><button class='btn btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva</button></a></h3>
        @endcan
        {{-- @include('compras.proveedor.buscar') --}}
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        {{-- <canvas id="myChart" width="400" height="400"></canvas> --}}
    </div>
</div>
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            @include('custom.message')
            <table id="ven" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Comprobante</th>
                    {{-- <th>Impuesto</th> --}}
                    <th>Total Venta</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->fecha_hora }}</td>
                        <td>{{ $venta->persona->nombre }}</td>
                        <td>{{ $venta->tipo_comprobante . ': ' . $venta->serie_comprobante . '-' . $venta->num_comprobante }}</td>
                        {{-- <td>{{ $venta->impuesto }}</td> --}}
                        <td>{{ $venta->total_venta }}</td>
                        <td>{{ $venta->estado }}</td>
                        <td>
                        <a href="{{URL::action('VentaController@show', $venta->id)}}"><button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-edit'></span></button></a>
                        <a href="" data-target="#modal-delete-{{$venta->id}}" data-toggle="modal"><button class='btn btn-danger btn-sm'><i class='glyphicon glyphicon-trash'></i></button></a>
                        </td>
                    </tr>
                    @include('ventas.venta.modal')
                    @endforeach
                </tbody>
            </table>
            {{ $ventas->appends(request()->query())->links() }}
        </div>

    </div>
</div>

@push('sciptsMain')
    <script>
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// var ctx = document.getElementById('myChart').getContext('2d');
// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
//         datasets: [{
//             label: '# of Votes',
//             data: [12, 19, 3, 5, 2, 3],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero: true
//                 }
//             }]
//         }
//     }
// });



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

var table = jQuery(document).ready(function() {
    $('#ven').DataTable({
        order: [[ 0, 'desc' ]],
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
        // orderable: true
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
                    return "Listado de Ventas";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,4,5] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Exportar a Excel',
                    className:'btn btn-success',
                    filename: 'listadod_de_Ventas_excel'
                    },
                    {
                    extend:'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o fa-inverse"></i>',
                    title : function() {
                    return "Listado de Ventas";
                    },
                    alignment: "center",
                    customize : function(doc){
                    doc.styles.tableHeader.alignment = 'left'; //giustifica a sinistra titoli colonne
                    doc.content[1].table.widths = [20,100,100,100,100,60]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
                    },
                    exportOptions: {
                        columns: [0,1,2,3,4,5],
                        stripHtml: true,

                    } ,
                    // pageSize : 'A3',
                    orientation : 'portrait',//portrait landscape
                    pageSize : 'LEGAL',//LETTER
                    titleAttr:'Exportar a PDF',
                    className:'btn btn-danger',
                    filename: 'listadod_de_Ventas_pdf'
                    },
                    {
                    extend:'print',
                    text: '<i class="fa fa-print fa-inverse"></i>',
                    title : function() {
                    return "Listado de Ventas";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,4,5] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Imprimir',
                    className:'btn btn-info',
                    filename: 'listadod_de_Ventas_print'
                    },
                ],

        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );




    } );

    </script>
    @endpush
@endsection
