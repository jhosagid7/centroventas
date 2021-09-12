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
        <div class="col-lg-6">
            <h3>Nueva Categoría</h3>
            @include('custom.message')


            <form action="{{ route('categoria.store')}}" method="POST" autocomplete="off">

            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input required type="text" name="nombre" class="form-control form-control-sm mayusculas" placeholder="Nombre...">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <input required type="text" name="descripcion" class="form-control form-control-sm mayusculas" placeholder="Descripcion...">
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a class="btn btn-danger" href="{{route('categoria.index')}}">{{__('Back')}}</a>
            </div>

            </form>
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
$(document).ready(function() {
// Funcion JavaScript para la conversion a mayusculas
$(function() {
            $('.mayusculas').on('input', function() {
                this.value = this.value.toUpperCase();
            });
        });

});



</script>
@endpush
@endsection
