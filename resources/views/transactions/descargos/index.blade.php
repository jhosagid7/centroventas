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
    <div class="box-footer no-print">

        <a href="{{URL::action('DescargoController@create')}}"><button class='btn btn-success btn-sm'><span class='glyphicon glyphicon-plus'></span> Nuevo descargo</button></a>


        {{-- <a class="btn btn-warning" href="{{route('caja.index')}}">{{__('Ir a cajas')}}</a> --}}

        {{-- <button onclick="imprimir()">Imprimir pantalla</button> --}}

    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        {{-- <h3>Listado de Categorias <a href="" data-target="#modal-nuevo" data-toggle="modal"><button class='btn btn-success'><span class='glyphicon glyphicon-plus'></span>Nuevo</button></a></h3> --}}
        <h3>Listado de Descargos




        </h3>
        @include('transactions.descargos.buscar')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            @include('custom.message')
            <table id="cate" class="table table-striped table-bordered table-condensed table-hover table-ms">
                <thead>
                    <tr>
                        {{-- <th>Id</th> --}}
                        <th>Código</th>
                        <th>Tipo Op</th>
                        <th>Tipo Descargo</th>
                        <th>Autorizado por Dolar</th>
                        <th>Responsable</th>
                        <th>Total/Op</th>
                        <th>Tipo Estado</th>
                        <th>Fecha</th>

                        <th>opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cargos as $cargo)
                    <tr>
                        {{-- <td>{{ $cargo->id }}</td> --}}
                        <td>{{ $cargo->num_documento }}</td>
                        <td>{{ $cargo->tipo_operacion }}</td>
                        <td>{{ $cargo->tipo_descargo }}</td>
                        <td>{{ $cargo->autorizado_por }}</td>
                        <td>{{ $cargo->user->name }}</td>
                        <td>{{ $cargo->total_operacion }}</td>
                        <td>{{ $cargo->estado }}</td>
                        <td>{{ $cargo->created_at }}</td>

                        <td>
                        <a href="{{URL::action('DescargoController@show', $cargo->id)}}"><button class='btn btn-info btn-sm'><span class='glyphicon glyphicon-edit'></span></button></a>
                            @if ($cargo->estado == 'Cancelado')
                            <button class='btn btn-danger btn-sm disabled'><i class='glyphicon glyphicon-trash'></i></button>
                            @else
                            <a href="" data-target="#modal-delete-{{$cargo->id}}" data-toggle="modal"><button class='btn btn-danger btn-sm'><i class='glyphicon glyphicon-trash'></i></button></a>
                            @endif





                        </td>
                    </tr>

                    @include('transactions.descargos.modal')

                    @endforeach

                </tbody>
            </table>


        </div>

        {{-- {{$categorias->render()}} --}}
    </div>
</div>

{{-- fin de la cabecera de box --}}
</div>
<!-- /.box-body -->
<div class="box-footer">
    @if(isset($mostrarNuvaVenta)  && $mostrarNuvaVenta === 0)
    <a class="btn btn-success" href="{{route('venta.create')}}">{{__('Ir a ventas')}}</a>
    @endif
</div>
<!-- /.box-footer-->
</div>
<!-- /.box -->
@push('sciptsMain')
    <script>
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
                    return "Listado de Descargos {{ config('app.name', 'VillaSoft') }}";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,4,5,6,7] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Exportar a Excel',
                    className:'btn btn-success',
                    filename: 'listadod_de_Descargos_excel'
                    },
                    {
                    extend:'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o fa-inverse"></i>',
                    title : function() {
                    return "Listado de Descargos {{ config('app.name', 'VillaSoft') }}";
                    },
                    alignment: "center",
                    customize : function(doc){
                    doc.styles.tableHeader.alignment = 'left'; //giustifica a sinistra titoli colonne
                    doc.content[1].table.widths = [40,100,50,150,150,60,80,20]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
                    },
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7],
                        stripHtml: true,

                    } ,
                    // pageSize : 'A3',
                    orientation : 'landscape',//portrait landscape
                    pageSize : 'letter',
                    titleAttr:'Exportar a PDF',
                    className:'btn btn-danger',
                    filename: 'listadod_de_Descargos_pdf'
                    },
                    {
                    extend:'print',
                    text: '<i class="fa fa-print fa-inverse"></i>',
                    title : function() {
                    return "Listado de Descargos {{ config('app.name', 'VillaSoft') }}";
                    },
                    alignment: "center",

                    exportOptions: { columns: [0,1,2,3,4,5,6,7] } ,
                    // pageSize : 'A0',
                    orientation : 'portrait',
                    pageSize : 'LEGAL',
                    titleAttr:'Imprimir',
                    className:'btn btn-info',
                    filename: 'listadod_de_Descargos_print'
                    },
                ],

    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );




    } );
    </script>
    @endpush

@endsection
