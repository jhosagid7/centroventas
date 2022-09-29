@extends ('layouts.admin3') @section('contenido')
@push('css')

<style>
    .ui-autocomplete {
      max-height: 300px;
      overflow-y: auto;
      /* prevent horizontal scrollbar */
      overflow-x: hidden;
    }
    /* IE 6 doesn't support max-height
     * we use height instead, but this forces the menu to always be this tall
     */
    * html .ui-autocomplete {
      height: 300px;
    }
    </style>
@endpush
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
        <h3>Nuevo Artículo</h3>
        @include('custom.message')
    </div>
</div>
<form action="{{ route('articulo.store')}}" enctype="multipart/form-data" method="POST" autocomplete="off">

@csrf

<div class="row">

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="">Categoría</label>
            <select required name="categoria_id" id="categoria_id" class="form-control select2">
                    @foreach($categorias as $cat)
                        <option value="{{$cat->id}}">{{$cat->nombre}}</option>
                    @endforeach
                </select>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input id="nombre" type="text" name="nombre" required value="{{old('nombre')}}" class="form-control mayuscula" placeholder="Nombre...">
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input id="descripcion" type="text" name="descripcion" required value="{{old('descripcion')}}" class="form-control mayuscula" placeholder="Descripción del articulo...">
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="codigo">Código</label>
            <input id="codigo" type="text" name="codigo" value="{{old('codigo')}}" class="form-control " placeholder="Codigo de articulo...">
        </div>
    </div>

    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 hidden">
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="text" name="stock" required value="0" class="form-control enteros" placeholder="Stock de articulo...">
        </div>
    </div> --}}

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
            <label for="stock">Unidades</label>
            <input type="text" name="unidades" required value="1" class="form-control enteros" placeholder="unidades...">
        </div>

    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
            <label for="vender_al">Producto para Vender al</label>
            <select required   class="form-control select2" name="vender_al" id="vender_al">
                <option value=""></option>
                <option selected value="Detal">Detal</option>
                <option value="Mayor">Mayor</option>
            </select>
        </div>
        <div class="checkbox">

            <label>
                <input name="isKilo" type="checkbox">
                <b>Vender por Kilo</b>
              </label>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="porEspecial">Porcentaje</label>
            <input type="text" name="porEspecial" value="{{old('porEspecial')}}" class="form-control decimal" placeholder="Porcentaje especial...">
            <div class="checkbox">
                <label>
                  <input name="isDolar" type="checkbox">
                  Dolar&nbsp;
                </label>
                <label>
                    <input name="isPeso" type="checkbox">
                    Peso&nbsp;
                  </label>
                  <label>
                    <input name="isTransPunto" type="checkbox">
                    Trans/Punto&nbsp;
                  </label>
                  <label>
                    <input name="isMixto" type="checkbox">
                    Mixto&nbsp;
                  </label>
                  <label>
                    <input name="isEfectivo" type="checkbox">
                    Efectivo&nbsp;
                  </label>
              </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="imagen">Imagen</label>
            <input id="prueba" type="text">
            <input type="file" name="imagen" class="form-control" accept="image/*">
        </div>
    </div>

</div>
</div>
<!-- /.box-body -->
<div class="box-footer">
    <div class="form-group margin">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-danger" href="{{route('articulo.index')}}">{{__('Back')}}</a>
    </div>
</div>
<!-- /.box-footer-->
</form>

{{-- fin de la cabecera de box --}}

</div>


    </section>
<!-- /.box -->

@push('sciptsMain')

<script>
    $('#nombre').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "{{ route('search.articulos') }}",
                dataType: 'json',
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data)
                    console.log('respuesta ', data.item);

                }
            });

        },
        minLength: 1,
        select: function( event, ui ) {
            // alert(ui.item.label);
            $('#codigo').val(ui.item.codigo)
            // return false;
        }
    });

</script>
  <script>


$(document).ready(function () {
    $("#nombre").keyup(function () {
        var value = $(this).val();
        $("#descripcion").val(value);
    });

    $("#nombre").blur(function () {
        $("#nombre").keyup();
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
