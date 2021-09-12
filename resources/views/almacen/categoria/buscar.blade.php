

    <div class="row margin-bottom">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="page-header">
                <form action="{{ route('categoria.index')}}" method="GET" autocomplete="off" class="form-inline pull-right" role="buscar">
                    @csrf


                    <div class="input-group">

                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input name="fecha" type="text" class="form-control pull-right" id="daterange-btn">
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <select name="condition" id="condition">
                                <option value="0">Seleccione</option>
                                <option value="Activa">Activa</option>
                                <option value="Eliminada">Eliminada</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </div>
                            <input type="text" class='form-control' id="descripcion" name="descripcion" placeholder="Descripcion..." value="{{ old('descripcion') }}">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user-o"></i>
                            </div>
                            <input type="text" class='form-control' id="nombre" name="nombre" placeholder="Nombre..." value="{{ old('nombre') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><i class='glyphicon glyphicon-search'></i> Buscar</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



