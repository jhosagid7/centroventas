

    <div class="row margin-bottom">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="page-header">
                <form action="{{ route('transferencia.index')}}" method="GET" autocomplete="off" class="form-inline pull-right" role="buscar">
                    @csrf


                    <div class="input-group">

                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        <input name="fecha" type="text" class="form-control pull-right" id="daterange-btn">
                        <input name="fecha2" type="text" class="form-control pull-right hidden" id="fecha2" placeholder="fecha2">
                        <input name="fechaInicio" type="text" class="form-control pull-right hidden" id="fechaInicio" value="{{ $fechaInicio }}" placeholder="fechaInicio">
                        <input name="fechaFin" type="text" class="form-control pull-right hidden" id="fechaFin" value="{{ $fechaFin }}" placeholder="fechaFin">
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <select name="accion" id="accion">
                                <option value="0">Seleccione</option>
                                <option value="Mayor a Detal">Mayor a Detal</option>
                                <option value="Detal a Mayor">Detal a Mayor</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user-o"></i>
                            </div>
                            <input type="text" class='form-control' id="nombre" name="nombre" placeholder="Nombre..." value="{{ old('name') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><i class='glyphicon glyphicon-search'></i> Buscar</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



