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
        <h3>Listado de Articulos Vendidos</h3>

    </div>
</div>
@include('reportes.ventas.buscar')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            @include('custom.message')
            <table id="cate" class="table table-striped table-bordered table-condensed table-hover table-ms">
                <thead>
                    <th>Id</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Costo/Unid</th>
                    <th>Venta/Unid</th>
                    <th>Cant</th>
                    <th>Costo/Total</th>
                    <th>% M/Ganan</th>
                    <th>Venta/Total</th>
                    <th>Utilidad</th>
                    <th>Desc</th>
                    <th>Fecha</th>

                </thead>
                <tbody>
                    @php
                        $margen = 0;
                        $costo = 0;
                        $venta = 0;
                        $utilidad = 0;
                        $productos = 0;
                        $descuentos = 0;
                        $num = 0;
                    @endphp
                    @foreach ($articulos as $art)
                     {{-- {{$art}} --}}

                    @php
                    $por = @(($art->precio_venta_total - $art->precio_costo_total)/$art->precio_costo_total*100);
                    if($por > 0){
                        // $margen+=@(($art->precio_venta_total - $art->precio_costo_total)/$art->precio_costo_total*100);

                        $num++;
                    }
                    $costo += $art->precio_costo_total;
                    $venta += $art->precio_venta_total;
                    $utilidad += $art->precio_venta_total - $art->precio_costo_total;
                    $utilidad_unit = $art->precio_venta_total - $art->precio_costo_total;
                    $productos += $art->cantidad;
                    $descuentos += $art->descuento;
                    $margen_unit = number_format(@(($art->precio_venta_total - $art->precio_costo_total)/$art->precio_costo_total*100),2,'.',',');

                    if($utilidad_unit == $art->precio_venta_total){

                        $margen_unit = 100;
                    }
                    $margen+=$margen_unit;

                    // if($utilidad_unit != '0.000' || $utilidad_unit != '0.00'){
                    //     if($art->precio_costo_unidad != '0.000' || $art->precio_costo_unidad != '0.00' || $art->precio_costo_unidad != '0.0'){

                    //         $margen_unit = number_format(@(($art->precio_venta_total - $art->precio_costo_total)/$art->precio_costo_total*100),2,'.',',');
                    //     }else{
                    //         $fer = 'soy mayor' . ' ' . $pcost;
                    //     }

                    // }else{
                    //     $pcost = 'preciocosto en 0';
                    //     $fer = 'soy menor';
                    // }

                    @endphp
                    <tr>
                        <td>{{ $art->id ?? '' }}</td>
                        <td>{{ $art->codigo ?? '' }}</td>
                        <td>{{ $art->nombre ?? '' }}</td>
                        <td>{{ floatval($art->precio_costo_unidad) ?? '' }}</td>
                        <td>{{ floatval($art->precio_venta_unidad) ?? '' }}</td>
                        <td>{{ $art->cantidad ?? '' }}</td>
                        <td>{{ number_format($art->precio_costo_total,3,'.',',') ?? '' }}</td>
                        <td>{{ $margen_unit ?? '0.00' }} %</td>
                        <td>{{ number_format($art->precio_venta_total,3,'.',',')  ?? '' }}</td>
                        <td>{{ number_format($art->precio_venta_total - $art->precio_costo_total,3,'.',',') ?? '' }}</td>
                        <td>{{ floatval($art->descuento) ?? '' }}</td>
                        <td>{{ $art->created_at ?? '' }}</td>

                    </tr>
                    {{-- @include('almacen.categoria.modal') --}}
                    @endforeach
                    {{-- @include('almacen.categoria.nuevo_modal') --}}
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Totales: </th>
                        <th>{{ $productos ?? '' }}</th>
                        <th>{{ number_format($costo,3,'.',',') ?? ''}}</th>
                        <th>
                            @if ($margen)
                            {{ number_format($margen/$num,2,'.',',') ?? '' }} %
                            @else
                            {{ $margen = 0.00 ?? ''}} %
                            @endif


                        </th>
                        <th>{{ number_format($venta,3,'.',',')  ?? '' }}</th>
                        <th>{{ number_format($utilidad,3,'.',',') ?? ''}}</th>
                        <th>{{ number_format($descuentos,3,'.',',') ?? ''}}</th>
                        <th></th>

                    </tr>
                </tfoot>
            </table>
            {{ $articulos->appends(request()->query())->links() }}
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
    dom: '<"row"<"col-sm-6 no-print"Bl><"col-sm-6 no-print"f>>' +
    '<"row"<"col-sm-12"<"table-responsive"tr>>>' +
    '<"row"<"col-sm-5 no-print"i><"col-sm-7 no-print"p>>',//'lBfrtip',
    fixedHeader: {
    header: true

  },
    buttons:[
                    {
                    extend:'excelHtml5',
                    text: '<i class="fa fa-file-excel-o fa-inverse no-print"></i>',
                    footer: true,
                    title : function() {
                    return "Reporte de Articulos Vendidos {{ config('app.name', 'VillaSoft Hotel') }}";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Exportar a Excel',
                    className:'btn btn-success',
                    filename: 'Reporte_de_Articulos_Vendidos'
                    },
                    {
                    extend:'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o fa-inverse no-print"></i>',
                    footer: true,

                    // messageBottom: 'null',
                    title : function() {
                    return "Reporte de Articulos Vendidos {{ config('app.name', 'VillaSoft Hotel') }}";
                    },
                    alignment: "center",
                    customize : function(doc){
                    doc.styles.tableHeader.alignment = 'left'; //giustifica a sinistra titoli colonne
                    doc.content[1].table.widths = [20,60,160,40,40,40,40,50,40,40,40,100]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
                    },
                    exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11] } ,
                    pageSize : 'A4',
                    orientation : 'landscape',//portrait landscape
                    // pageSize : 'LEGAL',
                    titleAttr:'Exportar a PDF',
                    className:'btn btn-danger',
                    filename: 'Reporte_de_Articulos_Vendidos'
                    },
                    {
                    extend:'print',
                    text: '<i class="fa fa-print fa-inverse no-print"></i>',
                    footer: true,
                    title : function() {
                    return "Reporte de Articulos Vendidos {{ config('app.name', 'VillaSoft Hotel') }}";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Imprimir',
                    className:'btn btn-info',
                    filename: 'Reporte_de_Articulos_Vendidos'
                    },



                ],

    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );

    // table.buttons().container()
    //     .appendTo( '#example_wrapper .col-sm-6:eq(0)' );


    } );

    </script>
    @endpush

@endsection
