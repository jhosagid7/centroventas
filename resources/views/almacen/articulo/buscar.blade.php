

    <div class="row margin-bottom">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="page-header">
                <form action="{{ route('articulo.index')}}" method="GET" autocomplete="off" class="form-inline pull-right" role="buscar">
                    @csrf


                    <div class="input-group">

                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        <input name="fecha" type="text" class="form-control pull-right" id="daterange-btn">
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <select name="venderal" id="venderal">
                                <option value="0">Seleccione</option>
                                <option value="Mayor">Al Mayor</option>
                                <option value="Detal">Al Detal</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-barcode"></i>
                            </div>
                            <input type="text" class='form-control' id="codigo" name="codigo" placeholder="codigo..." value="{{ old('descripcion') }}">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user-o"></i>
                            </div>
                            <input type="text" class='form-control' id="name" name="name" placeholder="Nombre..." value="{{ old('name') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><i class='glyphicon glyphicon-search'></i> Buscar</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



