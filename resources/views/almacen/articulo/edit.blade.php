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
            <h3>Editar el Artículo: {{$articulo->nombre}}</h3>
            @include('custom.message')
        </div>
    </div>

            {{-- {!! Form::model($articulo,['route'=>['articulo.update', $articulo->idarticulo], 'method'=>'PATCH', 'files'=>'true']) !!}
            {{ Form::token() }} --}}
    <form action="{{ route('articulo.update', $articulo->id)}}" enctype="multipart/form-data" method="POST" autocomplete="off" role="buscar">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="">Categoría</label>
                <select required name="categoria_id" id="categoria_id" class="form-control select2">
                    @foreach($categorias as $cat)
                    @if($cat->id==$articulo->categoria_id)
                    <option value="{{$cat->id}}" selected>{{$cat->nombre}}</option>
                    @else
                    <option value="{{$cat->id}}">{{$cat->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input id="nombre" type="text" name="nombre" required value="{{$articulo->nombre}}" class="form-control mayuscula">
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input id="descripcion" type="text" name="descripcion" required value="{{$articulo->descripcion}}" class="form-control mayuscula">
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" required value="{{$articulo->codigo}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
                <label for="stock">Unidades</label>
                <input readonly type="text" name="unidades" required value="{{$articulo->unidades}}" class="form-control enteros" placeholder="unidades...">
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
                <label for="vender_al">Producto para Vender al</label>
                <select readonly required   class="form-control select2" name="vender_al" id="vender_al">

                    @if($articulo->vender_al)
                    <option value="{{$articulo->vender_al}}" selected>{{$articulo->vender_al}}</option>

                    @endif

                </select>

            </div>
            <div style="margin-left: 20px" class="checkbox">
                <input name="isKilo" type="checkbox"
                @if ($articulo->isKilo =="1")
                        checked
                    @elseif (old('isKilo')=="1")
                        checked
                    @endif
                  >
                  <b>Venta por Kilogramos</b>
                </label>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="precio_costo">Precio de costo</label>
                <input type="text" name="precio_costo" required value="{{ floatval($articulo->precio_costo) ?? ''}}" class="form-control decimal">
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="porEspecial">Porcentaje</label>
                <input type="text" name="porEspecial" value="{{old('porEspecial')}} {{$articulo->porEspecial}}" class="form-control decimal" placeholder="Porcentaje especial...">
                <div class="checkbox">
                    <label>
                      <input name="isDolar" type="checkbox"
                      @if ($articulo->isDolar =="1")
                            checked
                        @elseif (old('isDolar')=="1")
                            checked
                        @endif
                      >
                      Dolar&nbsp;
                    </label>
                    <label>
                        <input name="isPeso" type="checkbox"
                        @if ($articulo->isPeso =="1")
                              checked
                          @elseif (old('isPeso')=="1")
                              checked
                          @endif
                        >
                        Peso&nbsp;
                      </label>
                      <label>
                        <input name="isTransPunto" type="checkbox"
                      @if ($articulo->isTransPunto =="1")
                            checked
                        @elseif (old('isTransPunto')=="1")
                            checked
                        @endif
                      >
                        Trans/Punto&nbsp;
                      </label>
                      <label>
                        <input name="isMixto" type="checkbox"
                      @if ($articulo->isMixto =="1")
                            checked
                        @elseif (old('isMixto')=="1")
                            checked
                        @endif
                      >
                        Mixto&nbsp;
                      </label>
                      <label>
                        <input name="isEfectivo" type="checkbox"
                      @if ($articulo->isEfectivo =="1")
                            checked
                        @elseif (old('isEfectivo')=="1")
                            checked
                        @endif
                      >
                        Efectivo&nbsp;
                      </label>
                  </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" class="form-control">
            @if(($articulo->imagen) !="")
                <img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}" alt="{{$articulo->nombre}}" height="100px" width="100px">
            @endif
            </div>
        </div>

    </div>
    <div class="box-footer">
        <div class="form-group margin">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn btn-danger" href="{{route('articulo.index')}}">{{__('Back')}}</a>
        </div>
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

$(document).ready(function () {
    $("#nombre").keyup(function () {
        var value = $(this).val();
        $("#descripcion").val(value);
    });
});
$(document).ready(function() {

    $(function() {
            $('.enteros').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    $('.decimal').on('keypress', function(e) {
        // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
        var field = $(this);
        key = e.keyCode ? e.keyCode : e.which;

        if (key == 8) return true;
            if (key > 47 && key < 58) {
                if (field.val() === "") return true;
                    var existePto = (/[.]/).test(field.val());
            if (existePto === false) {
                regexp = /.[0-9]{10}$/;
            } else {
                regexp = /.[0-9]{9}$/;
            }

            return !(regexp.test(field.val()));
        }
        if (key == 46) {
            if (field.val() === "") return false;
                regexp = /^[0-9]+$/;
                return regexp.test(field.val());
        }
            return false;
    });

});



</script>
@endpush
@endsection
