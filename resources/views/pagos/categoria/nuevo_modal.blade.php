<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-nuevo">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidder="true">X</span>
                    </button>
                    <h3 class="modal-title">Nueva Categoría para Pagos de Servicios</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">

                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            {!! Form::open(array('route' => 'categoria.store','method'=>'POST', 'autocomplete'=>'off' )) !!}
                            {{ Form::token() }}

                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" class="form-control" placeholder="Nombre...">
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <input type="text" name="descripcion" class="form-control" placeholder="Descripcion...">
                            </div>

                            <div class="form-group">


                            </div>


                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary" type="submit">Guardar</button>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    {{ Form::Close()}}
</div>
