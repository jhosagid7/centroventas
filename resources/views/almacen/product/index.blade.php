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
<div class="col-lg-12 margin-tb">
<div class="pull-right">
<a class="btn btn-success mb-2" id="new-user" data-toggle="modal">New User</a>
</div>
</div>
</div>

<table class="table table-striped table-responsive table-bordered table-condensed table-hover data-table" >
<thead>
<tr id="">
<th width="5%">No</th>
<th >Id</th>
<th >Categoria_id</th>
<th >Codigo</th>
<th >Nombre</th>
<th >Stock</th>
<th >Precio_costo</th>
<th >Unidades</th>
<th >Vender_al</th>
<th >Estado</th>
<th width="20%">Action</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>

<!-- Add and Edit customer modal -->
<div class="modal fade" id="crud-modal" aria-hidden="true" >
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="userCrudModal"></h4>
</div>
<div class="modal-body">
<form name="userForm" action="{{ route('products.store') }}" method="POST">
<input type="hidden" name="user_id" id="user_id" >
@csrf
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Name:</strong>
<input type="text" name="name" id="name" class="form-control" placeholder="Name" onchange="validate()" >
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Email:</strong>
<input type="text" name="email" id="email" class="form-control" placeholder="Email" onchange="validate()">
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Codigo:</strong>
<input type="text" name="codigo" id="codigo" class="form-control" placeholder="Codigo" onchange="validate()">
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 text-center">
<button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button>
<a href="{{ route('products.index') }}" class="btn btn-danger">Cancel</a>
</div>
</div>
</form>
</div>
</div>
</div>
</div>

<!-- Show user modal -->
<div class="modal fade" id="crud-modal-show" aria-hidden="true" >
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="userCrudModal-show"></h4>
</div>
<div class="modal-body">
<div class="row">
<div class="col-xs-2 col-sm-2 col-md-2"></div>
<div class="col-xs-10 col-sm-10 col-md-10 ">

<table class="table-responsive ">
<tr height="50px"><td><strong>Name:</strong></td><td id="sname"></td></tr>
<tr height="50px"><td><strong>Email:</strong></td><td id="semail"></td></tr>

<tr><td></td><td style="text-align: right "><a href="{{ route('products.index') }}" class="btn btn-danger">OK</a> </td></tr>
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

$(document).ready(function () {

var table = $('.data-table').DataTable({
processing: true,
serverSide: true,
iDisplayLength : 5,
"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
ajax: "{{ route('products.index') }}",
columns: [
{data: 'DT_RowIndex', name: 'DT_RowIndex'},
{data: 'id', name: 'id'},
{data: 'categoria_id', name: 'categoria_id.nombre'},
{data: 'codigo', name: 'codigo'},
{data: 'nombre', name: 'nombre'},
{data: 'stock', name: 'stock'},
{data: 'precio_costo', name: 'precio_costo'},
{data: 'unidades', name: 'unidades'},
{data: 'vender_al', name: 'vender_al'},
{data: 'estado', name: 'estado'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* When click New customer button */
$('#new-user').click(function () {
$('#btn-save').val("create-user");
$('#user').trigger("reset");
$('#userCrudModal').html("Add New User");
$('#crud-modal').modal('show');
});

/* Edit customer */
$('body').on('click', '#edit-user', function () {
var user_id = $(this).data('id');
$.get('products/'+user_id+'/edit', function (data) {
$('#userCrudModal').html("Edit User");
$('#btn-update').val("Update");
$('#btn-save').prop('disabled',false);
$('#crud-modal').modal('show');
$('#user_id').val(data.id);
$('#name').val(data.name);
$('#email').val(data.email);

})
});
/* Show customer */
$('body').on('click', '#show-user', function () {
var user_id = $(this).data('id');
$.get('products/'+user_id, function (data) {

$('#sname').html(data.name);
$('#semail').html(data.email);

})
$('#userCrudModal-show').html("User Details");
$('#crud-modal-show').modal('show');
});

/* Delete customer */
$('body').on('click', '#delete-user', function () {
var user_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
confirm("Are You sure want to delete !");

$.ajax({
type: "DELETE",
url: "http://localhost/centroventas/public/products/"+user_id,
data: {
"id": user_id,
"_token": token,
},
success: function (data) {

//$('#msg').html('Customer entry deleted successfully');
//$("#customer_id_" + user_id).remove();
table.ajax.reload();
},
error: function (data) {
console.log('Error:', data);
}
});
});

});

    </script>
    @endpush

@endsection
