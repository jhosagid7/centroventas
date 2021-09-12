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
        <div class="col-lg-6">
            <h3>Editar Categoría: {{$categoria->nombre}}</h3>
            @include('custom.message')



            <form action="{{ route('categoria.update', $categoria->id)}}" enctype="multipart/form-data" method="POST" autocomplete="off" role="buscar">
                @csrf
                @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input required type="text" name="nombre" class="form-control form-control-sm mayuscula" value="{{ $categoria->nombre }}" placeholder="Nombre...">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <input required type="text" name="descripcion" class="form-control form-control-sm mayuscula" value="{{ $categoria->descripcion }}" placeholder="Descripcion...">
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

@endsection
